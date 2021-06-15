<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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
            $file = $article->getImage();
           // $filename = md5(uniqid()).'.'.$file->guessExtension();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        }

        return $this->render("article/new.html.twig",[
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/", name="article-readAll")
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
    public function readOne(Article $article){
        return $this->render("article/readOne.html.twig",[
            "article"=>$article,
        ]);
    }
}