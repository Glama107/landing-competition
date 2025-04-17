<?php

namespace App\Entity;

use App\Repository\AircraftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
class Aircraft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $registration = null;

    /**
     * @var Collection<int, Scoreline>
     */
    #[ORM\OneToMany(targetEntity: Scoreline::class, mappedBy: 'aircraft')]
    private Collection $scorelines;

    public function __construct()
    {
        $this->scorelines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): static
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * @return Collection<int, Scoreline>
     */
    public function getScorelines(): Collection
    {
        return $this->scorelines;
    }

    public function addScoreline(Scoreline $scoreline): static
    {
        if (!$this->scorelines->contains($scoreline)) {
            $this->scorelines->add($scoreline);
            $scoreline->setAircraft($this);
        }

        return $this;
    }

    public function removeScoreline(Scoreline $scoreline): static
    {
        if ($this->scorelines->removeElement($scoreline)) {
            // set the owning side to null (unless already changed)
            if ($scoreline->getAircraft() === $this) {
                $scoreline->setAircraft(null);
            }
        }

        return $this;
    }
}
