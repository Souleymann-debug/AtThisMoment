<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Postlike;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\PostlikeRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleController extends AbstractController{
    /**
     * @Route("/article/new", name="new_article")
     */
    public function new(Request $request,SluggerInterface $slugger): Response {
        $article  = new Article() ;
        $article->setDatePoste(new DateTime('now'));

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get("image")->getData();
            
            if ($file) {
                $originalFileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $article->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render("article/new.html.twig",[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    // ajouter une fct like

    /**
     * permet de liker ou unliker un article 
     * 
     * @Route("/article/{id}/like", name="article_like")
     */
    // public function like(Article $article, ObjectManager $manager, PostlikeRepository $postlikeRepository) :
    //  Response {
    //      $utilisateur= $this->getUtilisateur();

    //      if(!$utilisateur) return $this->json([
    //          'code'=> 403,
    //          'message' =>"tu n'es pas autorisé"
    //      ], 403);
    //      return $this->json(['code'=> 200, 'message' => 'Ca marche bien'],200);

    // }
    
    /**
     * @Route("/all", name="article-readAll")
     */
    public function readAll(){
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $articles = $rep->findAll();
        return $this->render("article/index.html.twig",[
            "articles"=>$articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article-readOne")
     */
    public function readOne(Article $article, Request $request){
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        $comments = $repository->findBy(["article" => $article]);
        $comment  = new Commentaire() ;
        

        $form = $this->createForm(CommentaireType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setDateComment(new \DateTime('now'));
            $comment->setArticle($article);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('article-readOne',['id'=>$article->getId()]);
        }
        return $this->render("article/readOne.html.twig",[
            "article"=>$article,
            "comments" => $comments,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/article/update/{id}", name="article-update")
     */
    public function update(Request $req, Article $article){
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("article_detail", [
                'rubrique' => $article->getRubrique()->getSlug(),
                'id' => $article->getId()
            ]);
        }
        return $this->render("article/update.html.twig",[
            "form" => $form->createView(),
            "article" => $article
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article-delete")
     */
    public function delete(Article $article){

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("home");
    }
}