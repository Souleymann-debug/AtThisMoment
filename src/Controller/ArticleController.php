<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{
    /**
     * @Route("/article/new", name="article")
     */

    public function new(ArticleRepository $repo, PaginatorInterface $paginatorInterface , Request $request): Response {
        $article  =  $paginatorInterface->paginate(
            $repo->findAllWithPagination(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($article);
        }

        return $this->render("article/new.html.twig",[
            'form' => $form->createView()
        ]);
    }
}