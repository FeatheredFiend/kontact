<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * 
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ORM\Table(name="address", 
 *    uniqueConstraints={
 *        @UniqueConstraint(name="address_unique", 
 *            columns={"addressline1", "addressline2", "addressline3", "addressline4", "addressline5","addressline6"})
 *    }
 * )
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * @ORM\Column(type="string", length=50)
     */
    private $addressline1;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressline2;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressline3;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressline4;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressline5;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $addressline6;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="address")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=TestLocation::class, mappedBy="address")
     */
    private $testLocations;

    /**
     * @ORM\OneToMany(targetEntity=Laboratory::class, mappedBy="address")
     */
    private $laboratories;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->testLocations = new ArrayCollection();
        $this->laboratories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressline1(): ?string
    {
        return $this->addressline1;
    }

    public function setAddressline1(string $addressline1): self
    {
        $this->addressline1 = $addressline1;

        return $this;
    }

    public function getAddressline2(): ?string
    {
        return $this->addressline2;
    }

    public function setAddressline2(string $addressline2): self
    {
        $this->addressline2 = $addressline2;

        return $this;
    }

    public function getAddressline3(): ?string
    {
        return $this->addressline3;
    }

    public function setAddressline3(string $addressline3): self
    {
        $this->addressline3 = $addressline3;

        return $this;
    }

    public function getAddressline4(): ?string
    {
        return $this->addressline4;
    }

    public function setAddressline4(string $addressline4): self
    {
        $this->addressline4 = $addressline4;

        return $this;
    }


    public function getAddressline5(): ?string
    {
        return $this->addressline5;
    }

    public function setAddressline5(string $addressline5): self
    {
        $this->addressline5 = $addressline5;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setAddress($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getAddress() === $this) {
                $client->setAddress(null);
            }
        }

        return $this;
    }

    
    public function __toString() {
        return $this->addressline1;
    }

    /**
     * @return Collection|TestLocation[]
     */
    public function getTestLocations(): Collection
    {
        return $this->testLocations;
    }

    public function addTestLocation(TestLocation $testLocation): self
    {
        if (!$this->testLocations->contains($testLocation)) {
            $this->testLocations[] = $testLocation;
            $testLocation->setAddress($this);
        }

        return $this;
    }

    public function removeTestLocation(TestLocation $testLocation): self
    {
        if ($this->testLocations->removeElement($testLocation)) {
            // set the owning side to null (unless already changed)
            if ($testLocation->getAddress() === $this) {
                $testLocation->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Laboratory[]
     */
    public function getLaboratories(): Collection
    {
        return $this->laboratories;
    }

    public function addLaboratory(Laboratory $laboratory): self
    {
        if (!$this->laboratories->contains($laboratory)) {
            $this->laboratories[] = $laboratory;
            $laboratory->setAddress($this);
        }

        return $this;
    }

    public function removeLaboratory(Laboratory $laboratory): self
    {
        if ($this->laboratories->removeElement($laboratory)) {
            // set the owning side to null (unless already changed)
            if ($laboratory->getAddress() === $this) {
                $laboratory->setAddress(null);
            }
        }

        return $this;
    }

    public function getAddressline6(): ?string
    {
        return $this->addressline6;
    }

    public function setAddressline6(string $addressline6): self
    {
        $this->addressline6 = $addressline6;

        return $this;
    }
}
