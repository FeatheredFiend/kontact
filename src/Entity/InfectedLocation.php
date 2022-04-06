<?php

namespace App\Entity;

use App\Repository\InfectedLocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfectedLocationRepository::class)
 */
class InfectedLocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContactHistory::class, inversedBy="infectedLocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contacthistory;

    /**
     * @ORM\ManyToOne(targetEntity=Infection::class, inversedBy="infectedLocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContacthistory(): ?ContactHistory
    {
        return $this->contacthistory;
    }

    public function setContacthistory(?ContactHistory $contacthistory): self
    {
        $this->contacthistory = $contacthistory;

        return $this;
    }

    public function getInfection(): ?Infection
    {
        return $this->infection;
    }

    public function setInfection(?Infection $infection): self
    {
        $this->infection = $infection;

        return $this;
    }
}
