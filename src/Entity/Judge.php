<?php

namespace App\Entity;

use App\Repository\JudgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JudgeRepository::class)]
class Judge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Scoreline>
     */
    #[ORM\OneToMany(targetEntity: Scoreline::class, mappedBy: 'judge')]
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
            $scoreline->setJudge($this);
        }

        return $this;
    }

    public function removeScoreline(Scoreline $scoreline): static
    {
        if ($this->scorelines->removeElement($scoreline)) {
            // set the owning side to null (unless already changed)
            if ($scoreline->getJudge() === $this) {
                $scoreline->setJudge(null);
            }
        }

        return $this;
    }
}
