<?php

namespace App\Entity;

use App\Repository\TestResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestResultRepository::class)
 */
class TestResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TestHistory::class, inversedBy="testResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $testhistory;

    /**
     * @ORM\ManyToOne(targetEntity=Disease::class, inversedBy="testResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $disease;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recordedvalue;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTesthistory(): ?TestHistory
    {
        return $this->testhistory;
    }

    public function setTesthistory(?TestHistory $testhistory): self
    {
        $this->testhistory = $testhistory;

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

    public function getRecordedvalue(): ?string
    {
        return $this->recordedvalue;
    }

    public function setRecordedvalue(string $recordedvalue): self
    {
        $this->recordedvalue = $recordedvalue;

        return $this;
    }
    public function __toString() {
        return (string) $this->getId();
    }
}
