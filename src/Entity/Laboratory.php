<?php

namespace App\Entity;

use App\Repository\LaboratoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LaboratoryRepository::class)
 */
class Laboratory
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
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="laboratories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=TestHistory::class, mappedBy="laboratory")
     */
    private $testHistories;

    public function __construct()
    {
        $this->testHistories = new ArrayCollection();
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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|TestHistory[]
     */
    public function getTestHistories(): Collection
    {
        return $this->testHistories;
    }

    public function addTestHistory(TestHistory $testHistory): self
    {
        if (!$this->testHistories->contains($testHistory)) {
            $this->testHistories[] = $testHistory;
            $testHistory->setLaboratory($this);
        }

        return $this;
    }

    public function removeTestHistory(TestHistory $testHistory): self
    {
        if ($this->testHistories->removeElement($testHistory)) {
            // set the owning side to null (unless already changed)
            if ($testHistory->getLaboratory() === $this) {
                $testHistory->setLaboratory(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return (string) $this->getName();
    }
}
