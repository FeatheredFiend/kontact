<?php

namespace App\Entity;

use App\Repository\DiseaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiseaseRepository::class)
 */
class Disease
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=DiseaseSymptom::class, mappedBy="disease")
     */
    private $diseaseSymptoms;

    /**
     * @ORM\OneToMany(targetEntity=TestResult::class, mappedBy="disease")
     */
    private $testResults;

    /**
     * @ORM\OneToMany(targetEntity=Infection::class, mappedBy="disease")
     */
    private $infections;

    public function __construct()
    {
        $this->diseaseSymptoms = new ArrayCollection();
        $this->testResults = new ArrayCollection();
        $this->infections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|DiseaseSymptom[]
     */
    public function getDiseaseSymptoms(): Collection
    {
        return $this->diseaseSymptoms;
    }

    public function addDiseaseSymptom(DiseaseSymptom $diseaseSymptom): self
    {
        if (!$this->diseaseSymptoms->contains($diseaseSymptom)) {
            $this->diseaseSymptoms[] = $diseaseSymptom;
            $diseaseSymptom->setDisease($this);
        }

        return $this;
    }

    public function removeDiseaseSymptom(DiseaseSymptom $diseaseSymptom): self
    {
        if ($this->diseaseSymptoms->removeElement($diseaseSymptom)) {
            // set the owning side to null (unless already changed)
            if ($diseaseSymptom->getDisease() === $this) {
                $diseaseSymptom->setDisease(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|TestResult[]
     */
    public function getTestResult(): Collection
    {
        return $this->testResults;
    }

    public function addTestResult(TestResult $testResult): self
    {
        if (!$this->testResults->contains($testResult)) {
            $this->testResults[] = $testResult;
            $testResult->setDisease($this);
        }

        return $this;
    }

    public function removeTestResult(TestResult $testResult): self
    {
        if ($this->testResults->removeElement($testResult)) {
            // set the owning side to null (unless already changed)
            if ($testResult->getDisease() === $this) {
                $testResult->setDisease(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Infection[]
     */
    public function getInfections(): Collection
    {
        return $this->infections;
    }

    public function addInfection(Infection $infection): self
    {
        if (!$this->infections->contains($infection)) {
            $this->infections[] = $infection;
            $infection->setDisease($this);
        }

        return $this;
    }

    public function removeInfection(Infection $infection): self
    {
        if ($this->infections->removeElement($infection)) {
            // set the owning side to null (unless already changed)
            if ($infection->getDisease() === $this) {
                $infection->setDisease(null);
            }
        }

        return $this;
    }

}
