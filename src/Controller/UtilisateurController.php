<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UtilisateurController extends AbstractController{
    /**
     * @Route("/utilisateur/new", name="utilisateur-new")
     */
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response {
        $utilisateur  = new Utilisateur($userPasswordHasher) ;

        $form = $this->createForm(utilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
        }

        return $this->render("utilisateur/new.html.twig",[
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/login", name="utilisateur-login")
     */
    public function login(AuthenticationUtils $au){
        $lastUsername = $au->getLastUsername();
        $errors = $au->getLastAuthenticationError();
        return $this->render("utilisateur/login.html.twig",[
            "last_username"=>$lastUsername,
            "errors"=> $errors,
        ]);
    }
}