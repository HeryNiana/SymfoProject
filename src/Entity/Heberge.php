<?php

namespace App\Entity;

use App\Repository\HebergeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HebergeRepository::class)
 */
class Heberge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $numcli;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $numchambre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="3",maxMessage="Attention, donnée invalide")
     */
    private $nbjours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $compagne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $montant;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateentre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datesortie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcli(): ?Cliente
    {
        return $this->numcli;
    }

    public function setNumcli(?Cliente $numcli): self
    {
        $this->numcli = $numcli;

        return $this;
    }

    public function getNumchambre(): ?Chambre
    {
        return $this->numchambre;
    }

    public function setNumchambre(?Chambre $numchambre): self
    {
        $this->numchambre = $numchambre;

        return $this;
    }


    public function getNbjours(): ?string
    {
        return $this->nbjours;
    }

    public function setNbjours(string $nbjours): self
    {
        $this->nbjours = $nbjours;

        return $this;
    }

    public function getCompagne(): ?string
    {
        return $this->compagne;
    }

    public function setCompagne(string $compagne): self
    {
        $this->compagne = $compagne;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }


    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPayement(): ?string
    {
        return $this->payement;
    }

    public function setPayement(string $payement): self
    {
        $this->payement = $payement;

        return $this;
    }

    public function getDateentre(): ?\DateTimeInterface
    {
        return $this->dateentre;
    }

    public function setDateentre(\DateTimeInterface $dateentre): self
    {
        $this->dateentre = $dateentre;

        return $this;
    }

    public function getDatesortie(): ?\DateTimeInterface
    {
        return $this->datesortie;
    }

    public function setDatesortie(\DateTimeInterface $datesortie): self
    {
        $this->datesortie = $datesortie;

        return $this;
    }
}
