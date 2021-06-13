<?php
// src/Controller/BaseController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
    * @Route("/")
    */
    public function index(): Response
    {
        $menu = [];
        $articleByCategory = [];
        // ...

        return $this->render('homepage.html.twig', [
            'menu' => $menu,
            'articleByCategory' => $articleByCategory
        ]);
    }
}
