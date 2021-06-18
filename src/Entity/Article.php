<?php

namespace App\Entity;

use App\Entity\Utilisateur;
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
     * @ORM\Column(type="text", length=65535)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;
    
    /**
     * @ORM\Column(type="boolean")
     */ 
    private $valide;

    /**
     * @ORM\Column(type="datetime")
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

    /**
     * @ORM\ManyToOne(targetEntity=Rubrique::class)
     */
    private $rubrique;

    /**
     * @ORM\Column(type="boolean")
     */
    private $a_la_une;
    
    /**
     * @ORM\OneToMany(targetEntity=Postlike::class, mappedBy="article")
     */
    private $likes;
    

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

    public function getRubrique(): ?Rubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?Rubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    public function getALaUne(): ?bool
    {
        return $this->a_la_une;
    }

    public function setALaUne(bool $a_la_une): self
    {
        $this->a_la_une = $a_la_une;

        return $this;
    }
   
    /**
     * Get the value of utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set the value of utilisateur
     */
    public function setUtilisateur($utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get the value of likes
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set the value of likes
     */
    public function setLikes($likes): self
    {
        $this->likes = $likes;

        return $this;
    }

     /**
     * Permet de savoir si cet article est liké pas un utilisateur
     * @param Utilisateur $utilisateur
     * @return boolean
     */


    //Methode dans l'article pour savoir que l'utilisateur à aimer l'article ou pas 

    public function isLikedByUser(Utilisateur $utilisateur) : bool {
        // demander à mon article est ce que tt les likes que tu a un qui appartient à un utilisateur
        foreach($this->likes as $like){
            if ($this->getUtilisateur() === $utilisateur)
            return true;
        }
        return false;
    }
}
