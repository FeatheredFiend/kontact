<?php

namespace App\Entity;

use App\Repository\TestCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestCategoryRepository::class)
 */
class TestCategory
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
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=TestHistory::class, mappedBy="testcategory")
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $testHistory->setTestcategory($this);
        }

        return $this;
    }

    public function removeTestHistory(TestHistory $testHistory): self
    {
        if ($this->testHistories->removeElement($testHistory)) {
            // set the owning side to null (unless already changed)
            if ($testHistory->getTestcategory() === $this) {
                $testHistory->setTestcategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
