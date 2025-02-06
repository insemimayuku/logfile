<?php

namespace App\Entity;

use App\Repository\StorageCorpsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StorageCorpsRepository::class)]
class StorageCorps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $sizeAllow = null;

    #[ORM\Column]
    private ?float $sizeUse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateCreated = null;

    #[ORM\Column(length: 64)]
    private ?string $path = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'storage')]
    private Collection $users;

    public function __construct()
    {
        $this->setDateCreated(new \DateTime());
        $this->users = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSizeAllow(): ?float
    {
        return $this->sizeAllow;
    }

    public function setSizeAllow(float $sizeAllow): static
    {
        $this->sizeAllow = $sizeAllow;

        return $this;
    }

    public function getSizeUse(): ?float
    {
        return $this->sizeUse;
    }

    public function setSizeUse(float $sizeUse): static
    {
        $this->sizeUse = $sizeUse;

        return $this;
    }

    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setStorage($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStorage() === $this) {
                $user->setStorage(null);
            }
        }

        return $this;
    }
}
