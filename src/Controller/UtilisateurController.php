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
        $utilisateur->setIsadmin(0);

        $form = $this->createForm(utilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute("utilisateur-login");
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

    /**
     * @Route("/utilisateur/readAll", name="utilisateur-readAll")
     */
    public function readAll(){
        $rep = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $rep->findAll();
        return $this->render("utilisateur/readAll.html.twig",[
            "utilisateurs"=>$utilisateurs,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){

    }

    /**
     * @Route("/utilisateur/welcome", name="utilisateur-welcome")
     */
    public function readOne(){
        return $this->render("utilisateur/welcome.html.twig");
    }

    /**
     * @Route("/utilisateur/update/{id}", name="utilisateur-update")
     */
    public function update(Request $req, Utilisateur $utilisateur){
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("utilisateur-readAll");
        }
        return $this->render("utilisateur/update.html.twig",[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/delete/{id}", name="utilisateur-delete")
     */
    public function delete(Utilisateur $utilisateur){

        $em = $this->getDoctrine()->getManager();
        $em->remove($utilisateur);
        $em->flush();
        return $this->redirectToRoute("utilisateur-readAll");
    }

}