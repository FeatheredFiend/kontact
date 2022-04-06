<?php

namespace App\Entity;

use App\Repository\ContactHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactHistoryRepository::class)
 */
class ContactHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="contactHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="datetime")
     */
    private $contactdatetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=InfectedLocation::class, mappedBy="contacthistory")
     */
    private $infectedLocations;

    public function __construct()
    {
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

    public function getContactdatetime(): ?\DateTimeInterface
    {
        return $this->contactdatetime;
    }

    public function setContactdatetime(\DateTimeInterface $contactdatetime): self
    {
        $this->contactdatetime = $contactdatetime;

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
            $infectedLocation->setContacthistory($this);
        }

        return $this;
    }

    public function removeInfectedLocation(InfectedLocation $infectedLocation): self
    {
        if ($this->infectedLocations->removeElement($infectedLocation)) {
            // set the owning side to null (unless already changed)
            if ($infectedLocation->getContacthistory() === $this) {
                $infectedLocation->setContacthistory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return (string) $this->id;
    }

}
