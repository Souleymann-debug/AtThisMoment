<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleController extends AbstractController{
    /**
     * @Route("/article/new", name="article")
     */
    public function new(Request $request,SluggerInterface $slugger): Response {
        $article  = new Article() ;

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

    /**
     * @Route("/article/update/{id}", name="article-update")
     */
    public function update(Request $req, Article $article){
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render("article/update.html.twig",[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article-delete")
     */
    public function delete(Article $article){

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("article-readAll");
    }
}