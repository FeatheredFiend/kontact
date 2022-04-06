<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields="healthservice", message="Healthservice ID is already assigned.")
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @Assert\Type(type="App\Entity\Address")
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="clients", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailaddress;

    /**
     * @ORM\Column(type="string", length=255, unique=true))
     */
    private $healthservice;

    /**
     * @ORM\OneToMany(targetEntity=TestHistory::class, mappedBy="client")
     */
    private $testHistories;

    /**
     * @ORM\OneToMany(targetEntity=Infection::class, mappedBy="client")
     */
    private $infections;

    /**
     * @ORM\OneToMany(targetEntity=ContactHistory::class, mappedBy="client")
     */
    private $contactHistories;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $decommissioned;

    public function __construct()
    {
        $this->testHistories = new ArrayCollection();
        $this->infections = new ArrayCollection();
        $this->contactHistories = new ArrayCollection();
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

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

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

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getEmailaddress(): ?string
    {
        return $this->emailaddress;
    }

    public function setEmailaddress(string $emailaddress): self
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    public function getHealthservice(): ?string
    {
        return $this->healthservice;
    }

    public function setHealthservice(string $healthservice): self
    {
        $this->healthservice = $healthservice;

        return $this;
    }

    public function __toString() {
        return $this->name;
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
            $testHistory->setClient($this);
        }

        return $this;
    }

    public function removeTestHistory(TestHistory $testHistory): self
    {
        if ($this->testHistories->removeElement($testHistory)) {
            // set the owning side to null (unless already changed)
            if ($testHistory->getClient() === $this) {
                $testHistory->setClient(null);
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
            $infection->setClient($this);
        }

        return $this;
    }

    public function removeInfection(Infection $infection): self
    {
        if ($this->infections->removeElement($infection)) {
            // set the owning side to null (unless already changed)
            if ($infection->getClient() === $this) {
                $infection->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactHistory[]
     */
    public function getContactHistories(): Collection
    {
        return $this->contactHistories;
    }

    public function addContactHistory(ContactHistory $contactHistory): self
    {
        if (!$this->contactHistories->contains($contactHistory)) {
            $this->contactHistories[] = $contactHistory;
            $contactHistory->setClient($this);
        }

        return $this;
    }

    public function removeContactHistory(ContactHistory $contactHistory): self
    {
        if ($this->contactHistories->removeElement($contactHistory)) {
            // set the owning side to null (unless already changed)
            if ($contactHistory->getClient() === $this) {
                $contactHistory->setClient(null);
            }
        }

        return $this;
    }

    public function getDecommissioned(): ?bool
    {
        return $this->decommissioned;
    }

    public function setDecommissioned(?bool $decommissioned): self
    {
        $this->decommissioned = $decommissioned;

        return $this;
    }



}
