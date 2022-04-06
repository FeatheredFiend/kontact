<?php

namespace App\Entity;

use App\Repository\InfectionSymptomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfectionSymptomRepository::class)
 */
class InfectionSymptom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Infection::class, inversedBy="infectedSymptoms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infection;

    /**
     * @ORM\ManyToOne(targetEntity=Symptom::class, inversedBy="infectionSymptoms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $symptom;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSymptom(): ?Symptom
    {
        return $this->symptom;
    }

    public function setSymptom(?Symptom $symptom): self
    {
        $this->symptom = $symptom;

        return $this;
    }
    public function __toString() {
        return (string) $this->getId();
    }
}
