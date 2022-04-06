<?php

namespace App\Entity;

use App\Repository\InfectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfectionRepository::class)
 */
class Infection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="infections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Disease::class, inversedBy="infections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $disease;

    /**
     * @ORM\ManyToOne(targetEntity=TestHistory::class, inversedBy="infections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infectiontest;

    /**
     * @ORM\Column(type="date")
     */
    private $infectiondate;

    /**
     * @ORM\ManyToOne(targetEntity=TestHistory::class, inversedBy="infections")
     */
    private $recoveredtest;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $recovereddate;

    /**
     * @ORM\OneToMany(targetEntity=InfectionSymptom::class, mappedBy="infection")
     */
    private $infectedSymptoms;

    /**
     * @ORM\OneToMany(targetEntity=InfectedLocation::class, mappedBy="infection")
     */
    private $infectedLocations;

    public function __construct()
    {
        $this->infectedSymptoms = new ArrayCollection();
        $this->infectedLocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
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

    public function getInfectiontest(): ?TestHistory
    {
        return $this->infectiontest;
    }

    public function setInfectiontest(?TestHistory $infectiontest): self
    {
        $this->infectiontest = $infectiontest;

        return $this;
    }

    public function getInfectiondate(): ?\DateTimeInterface
    {
        return $this->infectiondate;
    }

    public function setInfectiondate(\DateTimeInterface $infectiondate): self
    {
        $this->infectiondate = $infectiondate;

        return $this;
    }

    public function getRecoveredtest(): ?TestHistory
    {
        return $this->recoveredtest;
    }

    public function setRecoveredtest(?TestHistory $recoveredtest): self
    {
        $this->recoveredtest = $recoveredtest;

        return $this;
    }

    public function getRecovereddate(): ?\DateTimeInterface
    {
        return $this->recovereddate;
    }

    public function setRecovereddate(?\DateTimeInterface $recovereddate): self
    {
        $this->recovereddate = $recovereddate;

        return $this;
    }

    /**
     * @return Collection|InfectionSymptom[]
     */
    public function getInfectedSymptoms(): Collection
    {
        return $this->infectedSymptoms;
    }

    public function addInfectedSymptom(InfectionSymptom $infectedSymptom): self
    {
        if (!$this->infectedSymptoms->contains($infectedSymptom)) {
            $this->infectedSymptoms[] = $infectedSymptom;
            $infectedSymptom->setInfection($this);
        }

        return $this;
    }

    public function removeInfectedSymptom(InfectionSymptom $infectedSymptom): self
    {
        if ($this->infectedSymptoms->removeElement($infectedSymptom)) {
            // set the owning side to null (unless already changed)
            if ($infectedSymptom->getInfection() === $this) {
                $infectedSymptom->setInfection(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return (string) $this->getId();
    }

    /**
     * @return Collection|InfectedLocation[]
     */
    public function getInfectedLocation(): Collection
    {
        return $this->infectedLocations;
    }

    public function addInfectedLocation(InfectedLocation $infectedLocation): self
    {
        if (!$this->infectedLocations->contains($infectedLocation)) {
            $this->infectedLocations[] = $infectedLocation;
            $infectedLocation->setInfection($this);
        }

        return $this;
    }

    public function removeInfectedLocation(InfectedLocation $infectedLocation): self
    {
        if ($this->infectedLocations->removeElement($infectedLocation)) {
            // set the owning side to null (unless already changed)
            if ($infectedLocation->getInfection() === $this) {
                $infectedLocation->setInfection(null);
            }
        }

        return $this;
    }
}
