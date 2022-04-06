<?php

namespace App\Entity;

use App\Repository\SymptomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymptomRepository::class)
 */
class Symptom
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
     * @ORM\OneToMany(targetEntity=DiseaseSymptom::class, mappedBy="symptom")
     */
    private $diseaseSymptoms;

    /**
     * @ORM\OneToMany(targetEntity=InfectionSymptom::class, mappedBy="symptom")
     */
    private $infectionSymptoms;

    public function __construct()
    {
        $this->diseaseSymptoms = new ArrayCollection();
        $this->infectionSymptoms = new ArrayCollection();
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
            $diseaseSymptom->setSymptom($this);
        }

        return $this;
    }

    public function removeDiseaseSymptom(DiseaseSymptom $diseaseSymptom): self
    {
        if ($this->diseaseSymptoms->removeElement($diseaseSymptom)) {
            // set the owning side to null (unless already changed)
            if ($diseaseSymptom->getSymptom() === $this) {
                $diseaseSymptom->setSymptom(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection|InfectionSymptom[]
     */
    public function getInfectionSymptom(): Collection
    {
        return $this->infectionSymptoms;
    }

    public function addInfectionSymptom(InfectionSymptom $infectionSymptom): self
    {
        if (!$this->infectionSymptoms->contains($infectionSymptom)) {
            $this->infectionSymptoms[] = $infectionSymptom;
            $infectionSymptom->setSymptom($this);
        }

        return $this;
    }

    public function removeInfectionSymptom(InfectionSymptom $infectionSymptom): self
    {
        if ($this->infectionSymptoms->removeElement($infectionSymptom)) {
            // set the owning side to null (unless already changed)
            if ($infectionSymptom->getSymptom() === $this) {
                $infectionSymptom->setSymptom(null);
            }
        }

        return $this;
    }

}
