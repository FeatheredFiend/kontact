<?php

namespace App\Entity;

use App\Repository\TestHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestHistoryRepository::class)
 */
class TestHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TestCategory::class, inversedBy="testHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $testcategory;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="testHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="date")
     */
    private $testdate;

    /**
     * @ORM\ManyToOne(targetEntity=TestLocation::class, inversedBy="testHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $testlocation;

    /**
     * @ORM\ManyToOne(targetEntity=Laboratory::class, inversedBy="testHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $laboratory;

    /**
     * @ORM\OneToMany(targetEntity=TestResult::class, mappedBy="testhistory")
     */
    private $testResults;

    /**
     * @ORM\OneToMany(targetEntity=Infection::class, mappedBy="infectiontest")
     */
    private $infections;

    public function __construct()
    {
        $this->testResults = new ArrayCollection();
        $this->infections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestcategory(): ?TestCategory
    {
        return $this->testcategory;
    }

    public function setTestcategory(?TestCategory $testcategory): self
    {
        $this->testcategory = $testcategory;

        return $this;
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

    public function getTestdate(): ?\DateTimeInterface
    {
        return $this->testdate;
    }

    public function setTestdate(\DateTimeInterface $testdate): self
    {
        $this->testdate = $testdate;

        return $this;
    }

    public function getTestlocation(): ?TestLocation
    {
        return $this->testlocation;
    }

    public function setTestlocation(?TestLocation $testlocation): self
    {
        $this->testlocation = $testlocation;

        return $this;
    }

    public function getLaboratory(): ?Laboratory
    {
        return $this->laboratory;
    }

    public function setLaboratory(?Laboratory $laboratory): self
    {
        $this->laboratory = $laboratory;

        return $this;
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
            $testResult->setTesthistory($this);
        }

        return $this;
    }

    public function removeTestResult(TestResult $testResult): self
    {
        if ($this->testResults->removeElement($testResult)) {
            // set the owning side to null (unless already changed)
            if ($testResult->getTesthistory() === $this) {
                $testResult->setTesthistory(null);
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
            $infection->setInfectiontest($this);
        }

        return $this;
    }

    public function removeInfection(Infection $infection): self
    {
        if ($this->infections->removeElement($infection)) {
            // set the owning side to null (unless already changed)
            if ($infection->getInfectiontest() === $this) {
                $infection->setInfectiontest(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return (string) $this->getId();
    }
}
