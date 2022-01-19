<?php
namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 * @UniqueEntity(
 * fields={"codech"}, 
 * message= "Le code chambre que vous avez entré est déjà utilisé  "
 * )
 */
class Chambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="10",maxMessage="Le code de la chambre est trop long")
     */
    private $codech;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="5",minMessage="Veuillez-vérifier le prix que vous avez entré")
     */
    private $prixjournalier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie1::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie1_id;

    /**
     * @ORM\ManyToOne(targetEntity=FemmeChambre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $femmeid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $capacite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stateMenage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $HeureMenage;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodech(): ?string
    {
        return $this->codech;
    }

    public function setCodech(string $codech): self
    {
        $this->codech = $codech;

        return $this;
    }

    public function getPrixjournalier(): ?int
    {
        return $this->prixjournalier;
    }

    public function setPrixjournalier(int $prixjournalier): self
    {
        $this->prixjournalier = $prixjournalier;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }


    public function getCategorie1Id(): ?Categorie1
    {
        return $this->categorie1_id;
    }

    public function setCategorie1Id(?Categorie1 $categorie1_id): self
    {
        $this->categorie1_id = $categorie1_id;

        return $this;
    }

    public function getFemmeid(): ?FemmeChambre
    {
        return $this->femmeid;
    }

    public function setFemmeid(?FemmeChambre $femmeid): self
    {
        $this->femmeid = $femmeid;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getStateMenage(): ?string
    {
        return $this->stateMenage;
    }

    public function setStateMenage(string $stateMenage): self
    {
        $this->stateMenage = $stateMenage;

        return $this;
    }

    public function getHeureMenage(): ?string
    {
        return $this->HeureMenage;
    }

    public function setHeureMenage(?string $HeureMenage): self
    {
        $this->HeureMenage = $HeureMenage;

        return $this;
    }


}
