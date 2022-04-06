<?php

namespace App\Entity;

use App\Repository\DataTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataTableRepository::class)
 */
class DataTable
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
     * @ORM\OneToMany(targetEntity=ActionLog::class, mappedBy="datatable")
     */
    private $actionLogs;

    /**
     * @ORM\OneToMany(targetEntity=Decommissioned::class, mappedBy="datatable")
     */
    private $decommissioneds;

    public function __construct()
    {
        $this->actionLogs = new ArrayCollection();
        $this->decommissioneds = new ArrayCollection();
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
     * @return Collection|ActionLog[]
     */
    public function getActionLogs(): Collection
    {
        return $this->actionLogs;
    }

    public function addActionLog(ActionLog $actionLog): self
    {
        if (!$this->actionLogs->contains($actionLog)) {
            $this->actionLogs[] = $actionLog;
            $actionLog->setDatatable($this);
        }

        return $this;
    }

    public function removeActionLog(ActionLog $actionLog): self
    {
        if ($this->actionLogs->removeElement($actionLog)) {
            // set the owning side to null (unless already changed)
            if ($actionLog->getDatatable() === $this) {
                $actionLog->setDatatable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Decommissioned[]
     */
    public function getDecommissioneds(): Collection
    {
        return $this->decommissioneds;
    }

    public function addDecommissioned(Decommissioned $decommissioned): self
    {
        if (!$this->decommissioneds->contains($decommissioned)) {
            $this->decommissioneds[] = $decommissioned;
            $decommissioned->setDatatable($this);
        }

        return $this;
    }

    public function removeDecommissioned(Decommissioned $decommissioned): self
    {
        if ($this->decommissioneds->removeElement($decommissioned)) {
            // set the owning side to null (unless already changed)
            if ($decommissioned->getDatatable() === $this) {
                $decommissioned->setDatatable(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
