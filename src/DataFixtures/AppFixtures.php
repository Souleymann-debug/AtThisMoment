<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    // Créer plusieurs utilisateur et pour chaque article un certin nbre de like 

    // $manager->persist($utilisateur);

    // $utilisateur[] = $utilisateur;

    // for ($i = 0; $i<20; $i++){
    //     $utilisateur = new Utilisateur();
    //     $utilisateur->setEmail($faker->email)
    //     ->setPassword($this->encoder->encodePassword($utilisateur, 'password'));

    //     $manager->persist($utilisateur);
    //         $utilisateur[] = $utilisateur;


    // }

    //créer plusieur utilisateurs

  
}
