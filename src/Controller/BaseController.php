<?php
// src/Controller/BaseController.php
namespace App\Controller;

use App\Entity\Rubrique;
use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $rubriqueRepository;
    private $articleRepository;

    public function __construct(
            RubriqueRepository $rubriqueRepository,
            ArticleRepository $articleRepository
        )
    {
        $this->rubriqueRepository = $rubriqueRepository;
        $this->articleRepository = $articleRepository;
    } 

    /**
    * @Route("/")
    */
    public function index(): Response
    {
        $rubriques = $this->rubriqueRepository->findAll();
        $articles = [];
        foreach ($rubriques as $rubrique) {
            $articles[ $rubrique->getNom() ] = $this->articleRepository->findBy(array('rubrique' => $rubrique, 'a_la_une' => 0));
        }
        $articleALaUne = $this->articleRepository->findBy(array('a_la_une' => 1), array('datePoste' => 'DESC'), 15);

        return $this->render('homepage.html.twig', [
            'rubriques' => $rubriques,
            'articlesList' => $articles,
            'articleALaUne' => $articleALaUne
        ]);
    }
}
