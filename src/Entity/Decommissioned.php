<?php

namespace App\Entity;

use App\Repository\DecommissionedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DecommissionedRepository::class)
 */
class Decommissioned
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=DataTable::class, inversedBy="decommissioneds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $datatable;

    /**
     * @ORM\Column(type="integer")
     */
    private $rownumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $decommissioneddate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="decommissioneds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatatable(): ?DataTable
    {
        return $this->datatable;
    }

    public function setDatatable(?DataTable $datatable): self
    {
        $this->datatable = $datatable;

        return $this;
    }

    public function getRownumber(): ?int
    {
        return $this->rownumber;
    }

    public function setRownumber(int $rownumber): self
    {
        $this->rownumber = $rownumber;

        return $this;
    }

    public function getDecommissioneddate(): ?\DateTimeInterface
    {
        return $this->decommissioneddate;
    }

    public function setDecommissioneddate(\DateTimeInterface $decommissioneddate): self
    {
        $this->decommissioneddate = $decommissioneddate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString() {
        return (string) $this->getId();
    }
}
