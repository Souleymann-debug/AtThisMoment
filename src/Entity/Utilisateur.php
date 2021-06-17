<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface, \Serializable{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isadmin;
    

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="utilisateur")
     */
    private $articles ;

    private $passwordHacher;

    /**
     * @ORM\OneToMany(targetEntity=Postlike::class, mappedBy="utilisateur")
     */
    private $likes;

    public function __construct(UserPasswordHasher $passHacher) {
        $this->articles = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->passwordHacher = $passHacher;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getNom(): ?string{
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string{
        return $this->prenom;
    }

    public function getUsername(){
        return $this->prenom.' '.$this->nom;
    }

    public function setPrenom(string $prenom): self{
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface{
        return $this->date_naiss;
    }

    public function setDateNaiss(\DateTimeInterface $date_naiss): self{
        $this->date_naiss = $date_naiss;

        return $this;
    }

    public function getEmail(): ?string{
        return $this->email;
    }

    public function setEmail(string $email): self{
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string{
        return $this->motdepasse;
    }

    public function setPassword(string $motdepasse): self{
        $this->password = $this->passwordHacher->hashPassword($this,$motdepasse) ;

        return $this;
    }

    public function getIsadmin(): ?bool {
        return $this->isadmin;
    }

    public function setIsadmin(bool $isadmin): self{
        $this->isadmin = $isadmin;

        return $this;
    }

    public function getRoles(){
        return ['ROLE_ADMIN'];
    }

    public function getSalt(){
        return null;
    }

    public function getUserIdentifier(){
        return $this->email;
    }

    public function eraseCredentials(){
    }

    public function serialize(){
        return serialize([
            $this->id,
            $this->nom,
            $this->prenom,
            $this->date_naiss,
            $this->email,
            $this->motdepasse,
            $this->isadmin,
        ]);
    }

    public function unserialize($serialized){
        list(
            $this->id,
            $this->nom,
            $this->prenom,
            $this->date_naiss,
            $this->email,
            $this->motdepasse,
            $this->isadmin,
        ) = unserialize($serialized,["allowed_classes"=>false]);
    }
    
    /**
     * @return Collection|Postlike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Postlike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUtilisateur($this);
        }

        return $this;
    }

    public function removeLike(Postlike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUtilisateur() === $this) {
                $like->setUtilisateur(null);
            }
        }

        return $this;
    }
}
