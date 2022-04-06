<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ActionLog::class, mappedBy="user")
     */
    private $actionLogs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $decommissioned;

    /**
     * @ORM\OneToMany(targetEntity=Decommissioned::class, mappedBy="user")
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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


    public function __toString() {
        return $this->name;
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
            $actionLog->setUser($this);
        }

        return $this;
    }

    public function removeActionLog(ActionLog $actionLog): self
    {
        if ($this->actionLogs->removeElement($actionLog)) {
            // set the owning side to null (unless already changed)
            if ($actionLog->getUser() === $this) {
                $actionLog->setUser(null);
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
            $decommissioned->setUser($this);
        }

        return $this;
    }

    public function removeDecommissioned(Decommissioned $decommissioned): self
    {
        if ($this->decommissioneds->removeElement($decommissioned)) {
            // set the owning side to null (unless already changed)
            if ($decommissioned->getUser() === $this) {
                $decommissioned->setUser(null);
            }
        }

        return $this;
    }

}