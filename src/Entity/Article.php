<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rubrique;

    /**
     * @ORM\Column(type="boolean")
     */ 
    private $valide;

    /**
     * @ORM\Column(type="date")
     */
    private $datePoste;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="articles")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="article")
     */
    private $comments;

    public function __construct() {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string{
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getDatePoste(): ?\DateTimeInterface
    {
        return $this->datePoste;
    }

    public function setDatePoste(\DateTimeInterface $datePoste): self
    {
        $this->datePoste = $datePoste;

        return $this;
    }

    /**
     * Get the value of comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     */
    public function setComments($comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * Get the value of rubrique
     */ 
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /**
     * Set the value of rubrique
     *
     * @return  self
     */ 
    public function setRubrique($rubrique)
    {
        $this->rubrique = $rubrique;
        return $this;
    }
}
