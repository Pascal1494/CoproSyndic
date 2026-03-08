<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LotRepository::class)]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numero = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $etage = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $porte = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Batiment $batiment = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $proprietaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): static
    {
        $this->etage = $etage;

        return $this;
    }

    public function getPorte(): ?string
    {
        return $this->porte;
    }

    public function setPorte(?string $porte): static
    {
        $this->porte = $porte;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBatiment(): ?Batiment
    {
        return $this->batiment;
    }

    public function setBatiment(?Batiment $batiment): static
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getProprietaire(): ?user
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?user $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }
}
