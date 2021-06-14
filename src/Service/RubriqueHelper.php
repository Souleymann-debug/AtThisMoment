<?php
// src/Service/RubriqueHelper.php
namespace App\Service;

use App\Entity\Rubrique;
use App\Repository\RubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;

class RubriqueHelper
{

    private $rubriqueRepository;

    public function __construct(RubriqueRepository $rubriqueRepository)
    {
        $this->rubriqueRepository = $rubriqueRepository;
    } 

    public function getRubriques(): array
    {
        $rubriques = $this->rubriqueRepository->findAll();

        return $rubriques;
    }

    public function getRubriqueBySlug(string $slug): Rubrique
    {
        $rubrique = $this->rubriqueRepository->findOneBy(array('slug' => $slug));
        return $rubrique;
    }
}
