<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Postlike;
use App\Form\ArticleType;
use App\Repository\PostlikeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{
    /**
     * @Route("/article/new", name="article")
     */
    public function new(Request $request): Response {
        $article  = new Article() ;

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($article);
        }

        return $this->render("article/new.html.twig",[
            'form' => $form->createView()
        ]);
    }

    // ajouter une fct like

    /**
     * permet de liker ou unliker un article 
     * 
     * @Route("/article/{id}/like", name="article_like")
     */
    public function like(Article $article, ObjectManager $manager, PostlikeRepository $postlikeRepository) :
     Response {
         $utilisateur= $this->getUtilisateur();

         if(!$utilisateur) return $this->json([
             'code'=> 403,
             'message' =>"tu n'es pas autorisé"
         ], 403);
         return $this->json(['code'=> 200, 'message' => 'Ca marche bien'],200);

    }
}