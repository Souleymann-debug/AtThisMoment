<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
     public function new(Request $request): Response {
         $commentaire = new Commentaire();

         $form = $this->createForm(CommentaireType::class,$commentaire);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
        }


         return $this->render("commentaire/index.html.twig",[
            'form' => $form->createView(),"commentaire" => $commentaire

         ]);


     }

}