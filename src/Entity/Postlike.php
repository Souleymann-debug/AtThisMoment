<?php

namespace App\Entity;

use App\Repository\PostlikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostlikeRepository::class)
 */
class Postlike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="likes")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="likes")
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get the value of article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     */
    public function setArticle($article): self
    {
        $this->article = $article;

        return $this;
    }
}
