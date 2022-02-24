<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\component\Validator\Constraints as Assert;
#use Symfony\component\Validator\Constraints\Length;


/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom_act", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Champs Vide")
     */
    private $nom_act;

    /**
     * @ORM\Column(name="desc_act", type="string", length=255)
     *
     */
    private $desc_act;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="activites")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAct(): ?string
    {
        return $this->nom_act;
    }

    public function setNomAct(string $nom_act): self
    {
        $this->nom_act = $nom_act;

        return $this;
    }

    public function getDescAct(): ?string
    {
        return $this->desc_act;
    }

    public function setDescAct(string $desc_act): self
    {
        $this->desc_act = $desc_act;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

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
}
