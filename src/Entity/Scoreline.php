<?php

namespace App\Entity;

use App\Repository\ScorelineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScorelineRepository::class)]
class Scoreline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'scorelines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competitor $competitor = null;

    #[ORM\ManyToOne(inversedBy: 'scorelines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aircraft $aircraft = null;

    #[ORM\Column(nullable: true)]
    private ?int $firstnote = null;

    #[ORM\Column(nullable: true)]
    private ?int $secondscore = null;

    #[ORM\Column(nullable: true)]
    private ?int $thirdnote = null;

    #[ORM\Column(nullable: true)]
    private ?int $savingnote = null;

    #[ORM\Column(nullable: true)]
    private ?int $replacingnote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitor(): ?Competitor
    {
        return $this->competitor;
    }

    public function setCompetitor(?Competitor $competitor): static
    {
        $this->competitor = $competitor;

        return $this;
    }

    public function getAircraft(): ?Aircraft
    {
        return $this->aircraft;
    }

    public function setAircraft(?Aircraft $aircraft): static
    {
        $this->aircraft = $aircraft;

        return $this;
    }

    public function getFirstnote(): ?int
    {
        return $this->firstnote;
    }

    public function setFirstnote(?int $firstnote): static
    {
        $this->firstnote = $firstnote;

        return $this;
    }

    public function getSecondscore(): ?int
    {
        return $this->secondscore;
    }

    public function setSecondscore(?int $secondscore): static
    {
        $this->secondscore = $secondscore;

        return $this;
    }

    public function getThirdnote(): ?int
    {
        return $this->thirdnote;
    }

    public function setThirdnote(?int $thirdnote): static
    {
        $this->thirdnote = $thirdnote;

        return $this;
    }

    public function getSavingnote(): ?int
    {
        return $this->savingnote;
    }

    public function setSavingnote(?int $savingnote): static
    {
        $this->savingnote = $savingnote;

        return $this;
    }

    public function getReplacingnote(): ?int
    {
        return $this->replacingnote;
    }

    public function setReplacingnote(?int $replacingnote): static
    {
        $this->replacingnote = $replacingnote;

        return $this;
    }

    /**
     * Calcule la somme des scores en prenant en compte le remplacement.
     */
    public function calculateTotalScore(): int
    {
        $scores = [
            1 => $this->firstnote,
            2 => $this->secondscore,
            3 => $this->thirdnote,
        ];
        if ($this->savingnote !== null && $this->replacingnote !== null) {
            if (array_key_exists($this->replacingnote, $scores)) {
                if ($this->savingnote > $scores[$this->replacingnote]) {
                    $scores[$this->replacingnote] = $this->savingnote;
                }
            }
        }
        return array_sum($scores);
    }

    /**
     * Retourne le détail du remplacement de la note, s'il y en a un.
     */
    public function getReplacedNote(): ?array
    {
        $scores = [
            1 => ['label' => 'firstnote', 'value' => $this->firstnote],
            2 => ['label' => 'secondscore', 'value' => $this->secondscore],
            3 => ['label' => 'thirdnote', 'value' => $this->thirdnote],
        ];

        if ($this->savingnote !== null && $this->replacingnote !== null) {
            if (array_key_exists($this->replacingnote, $scores)) {
                $original = $scores[$this->replacingnote];
                if ($this->savingnote > $original['value']) {
                    return [
                        'originalNoteLabel' => $original['label'],
                        'originalNoteValue' => $original['value'],
                        'savingNoteValue' => $this->savingnote,
                    ];
                }
            }
        }
        return null;
    }
}
