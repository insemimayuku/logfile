<?php

namespace App\Entity;

use App\Repository\StorageCorpsRepository;
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
    private ?\DateTimeInterface $dateCreated = null;

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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
