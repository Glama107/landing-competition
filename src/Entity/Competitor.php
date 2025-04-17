<?php

namespace App\Entity;

use App\Repository\CompetitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetitorRepository::class)]
class Competitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'competitors')]
    private ?User $createdBy = null;

    /**
     * @var Collection<int, Scoreline>
     */
    #[ORM\OneToMany(targetEntity: Scoreline::class, mappedBy: 'competitor')]
    private Collection $scorelines;

    public function __construct()
    {
        $this->scorelines = new ArrayCollection();
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

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
            $scoreline->setCompetitor($this);
        }

        return $this;
    }

    public function removeScoreline(Scoreline $scoreline): static
    {
        if ($this->scorelines->removeElement($scoreline)) {
            // set the owning side to null (unless already changed)
            if ($scoreline->getCompetitor() === $this) {
                $scoreline->setCompetitor(null);
            }
        }

        return $this;
    }
}
