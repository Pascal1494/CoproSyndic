<?php

namespace App\Entity;

use App\Repository\BatimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentRepository::class)]
class Batiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $nbEtages = null;

    #[ORM\Column]
    private ?bool $aAscenseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $refAscenseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'batiments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Copropriete $copropriete = null;

    /**
     * @var Collection<int, Lot>
     */
    #[ORM\OneToMany(targetEntity: Lot::class, mappedBy: 'batiment', orphanRemoval: true)]
    private Collection $lots;

    public function __construct()
    {
        $this->lots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbEtages(): ?int
    {
        return $this->nbEtages;
    }

    public function setNbEtages(int $nbEtages): static
    {
        $this->nbEtages = $nbEtages;

        return $this;
    }

    public function isAAscenseur(): ?bool
    {
        return $this->aAscenseur;
    }

    public function setAAscenseur(bool $aAscenseur): static
    {
        $this->aAscenseur = $aAscenseur;

        return $this;
    }

    public function getRefAscenseur(): ?string
    {
        return $this->refAscenseur;
    }

    public function setRefAscenseur(?string $refAscenseur): static
    {
        $this->refAscenseur = $refAscenseur;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCopropriete(): ?Copropriete
    {
        return $this->copropriete;
    }

    public function setCopropriete(?Copropriete $copropriete): static
    {
        $this->copropriete = $copropriete;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): static
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
            $lot->setBatiment($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): static
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getBatiment() === $this) {
                $lot->setBatiment(null);
            }
        }

        return $this;
    }
}
