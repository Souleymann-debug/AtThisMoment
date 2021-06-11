<?php

namespace App\Controller;

use App\Entity\utilisateur;
use App\Form\utilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController{
    /**
     * @Route("/utilisateur/new", name="utilisateur")
     */
    public function new(Request $request): Response {
        $utilisateur  = new utilisateur() ;

        $form = $this->createForm(utilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($utilisateur);
        }

        return $this->render("utilisateur/new.html.twig",[
            'form' => $form->createView()
        ]);
    }
}