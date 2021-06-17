<?php
// src/Controller/BaseController.php
namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Rubrique;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\RubriqueRepository;
use App\Service\RubriqueHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $rubriqueRepository;
    private $articleRepository;
    private $rubriqueHelper;
    private $commentRepository;

    public function __construct(
            RubriqueRepository $rubriqueRepository,
            ArticleRepository $articleRepository,
            RubriqueHelper $rubriqueHelper,
            CommentaireRepository $commentRepository
        )
    {
        $this->rubriqueRepository = $rubriqueRepository;
        $this->articleRepository = $articleRepository;
        $this->rubriqueHelper = $rubriqueHelper;
        $this->commentRepository = $commentRepository;
    } 

    /**
    * @Route("/", name="home")
    */
    public function index(): Response
    {
        // article A la une à mettre dans un slider
        $articleALaUne = $this->articleRepository->findBy(array('a_la_une' => 1), array('datePoste' => 'DESC'), 12);
        // articles des autre rubriques non afficher dans le slider
        $articles = [];
        foreach ($this->rubriqueHelper->getRubriques() as $rubrique) {
            $articles[ $rubrique->getNom() .','.$rubrique->getSlug() ] = $this->articleRepository->findBy(array('rubrique' => $rubrique, 'a_la_une' => 0));
        }

        return $this->render('homepage.html.twig', [
            'rubriques' => $this->rubriqueHelper->getRubriques(),
            'articleALaUne' => $articleALaUne,
            'articlesList' => $articles
        ]);
    }

    /** 
     * @Route("/rubrique/{slug}", name="rubrique")
     */
    public function rubrique(string $slug): Response
    {
        $rubrique = $this->rubriqueHelper->getRubriqueBySlug($slug);
        $articles = $this->articleRepository->findBy(array('rubrique' => $rubrique));

        return $this->render('rubrique.html.twig', [
            'rubriques' => $this->rubriqueHelper->getRubriques(),
            'rubrique' => $rubrique->getnom(),
            'articles' => $articles,
        ]);
    }

    /** 
     * @Route("/{rubrique}/article/{id}", name="article_detail")
     */
    public function article(int $id, Request $request): Response
    {
        $article = $this->articleRepository->findOneBy(array('id' => $id));
        $comments = $this->commentRepository->findBy(["article" => $article]);

        $comment  = new Commentaire() ;
        $form = $this->createForm(CommentaireType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setDateComment(new \DateTime('now'));
            $comment->setArticle($article);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('article_detail',[
                'rubrique' => $article->getRubrique()->getSlug(), 
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/article-detail.html.twig', [
            'rubriques' => $this->rubriqueHelper->getRubriques(),
            'article' => $article,
            "comments" => $comments,
            "form" => $form->createView()
        ]);
    }

    /** 
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request){
        $query = $request->query->get('query');
        $articles = $this->articleRepository->findContentLike($query);

        return $this->render('search.html.twig', [
            'rubriques' => $this->rubriqueHelper->getRubriques(),
            'query' => $query,
            'articles' => $articles
        ]);
     }
}