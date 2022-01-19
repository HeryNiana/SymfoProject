<?php

namespace App\Entity;

use App\Repository\DatedayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatedayRepository::class)
 */
class Dateday
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
    private $daytoday;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaytoday(): ?string
    {
        return $this->daytoday;
    }

    public function setDaytoday(string $daytoday): self
    {
        $this->daytoday = $daytoday;

        return $this;
    }
}
