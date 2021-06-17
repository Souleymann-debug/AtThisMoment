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
         $commentaire->setDateComment(new \DateTime('now'));

         $form = $this->createForm(CommentaireType::class,$commentaire);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
        }


        return $this->render("article/index.html.twig",[
            'form' => $form->createView(),"commentaire" => $commentaire
        ]);


     }

     /**
      * @Route("/sup_commentaire/{id}", name ="sup-commentaire")
      */
      public function delete(Commentaire $commentaire): Response{
          $em = $this->getDoctrine()->getManager();
          $em->remove($commentaire);
          $em->flush();
          return $this->redirectToRoute("commentaire");
      }

     //Nouvelle Controleur recuperer au format jason notre commentaires

     /**
      * @Route("/commentaires", name="lire_commentaire")
      */
      public function getAll(): Response {
            $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
            


          $arrayOfComments = [];

          foreach ($commentaires as $commentaire){  
            $arrayOfComments[] = $commentaire->toArray();
          }
          return $this->json($arrayOfComments);
      }

      /**
       * @Route("/ajax", name="ajax")
       */
       public function ajax(){
           return $this->render("ajax.html.twig");
       }

}