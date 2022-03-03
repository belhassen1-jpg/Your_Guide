<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * * @Assert\NotBlank
     * @Assert\Length(
     * max = 10,
     * min = 10,
     * maxMessage=" Le libelle d'une categorie doit comporter au plus {{ limit }} caracteres "
     * )
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="categorie")
     */
    private $reclamation;

    public function __construct()
    {
        $this->reclamation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamation(): Collection
    {
        return $this->reclamation;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamation->contains($reclamation)) {
            $this->reclamation[] = $reclamation;
            $reclamation->setCategorie($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamation->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getCategorie() === $this) {
                $reclamation->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return(string)$this->getLibelle();
    }
   
}
