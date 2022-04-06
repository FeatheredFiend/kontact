<?php

namespace App\Entity;

use App\Repository\DiseaseSymptomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiseaseSymptomRepository::class)
 */
class DiseaseSymptom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Disease::class, inversedBy="diseaseSymptoms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $disease;

    /**
     * @ORM\ManyToOne(targetEntity=Symptom::class, inversedBy="diseaseSymptoms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $symptom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisease(): ?Disease
    {
        return $this->disease;
    }

    public function setDisease(?Disease $disease): self
    {
        $this->disease = $disease;

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
