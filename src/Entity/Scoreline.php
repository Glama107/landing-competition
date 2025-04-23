<?php

namespace App\Entity;

use App\Repository\ScorelineRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\ManyToOne(inversedBy: 'scorelines')]
    private ?Judge $judge = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOfPassage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFlapsUsed = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFlapsUsedReplacing = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comments = null;

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

    public function getSecondscoreWithBonus(): int
    {
        // On récupère la valeur de secondscore (0 si null)
        $score = $this->secondscore ?? 0;
        if ($this->isFlapsUsed == 1) { // Test strict sur true
            $score += 250;
        }
        return $score;
    }

    public function getSavingnoteWithBonus(): ?int
    {
        $note = $this->savingnote;
        dump($this->isFlapsUsed, $this->secondscore);

        if ($note !== null && $this->isFlapsUsedReplacing == 1) {
            $note += 250;
        }
        return $note;
    }


    /**
     * Calcule la somme des scores en prenant en compte le remplacement.
     */
    public function calculateTotalScore(): int
    {
        $scores = [
            1 => $this->firstnote ?? 0,
            2 => $this->getSecondscoreWithBonus(),
            3 => $this->thirdnote ?? 0,
        ];
        $savingnoteWithBonus = $this->getSavingnoteWithBonus();
        if ($savingnoteWithBonus !== null && $this->replacingnote !== null) {
            if (array_key_exists($this->replacingnote, $scores)) {
                if ($savingnoteWithBonus < $scores[$this->replacingnote]) {
                    $scores[$this->replacingnote] = $savingnoteWithBonus;
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
            1 => ['label' => 'firstnote', 'value' => $this->firstnote ?? 0],
            2 => ['label' => 'secondscore', 'value' => $this->getSecondscoreWithBonus()],
            3 => ['label' => 'thirdnote', 'value' => $this->thirdnote ?? 0],
        ];

        $savingnoteWithBonus = $this->getSavingnoteWithBonus();
        if ($savingnoteWithBonus !== null && $this->replacingnote !== null) {
            if (array_key_exists($this->replacingnote, $scores)) {
                $original = $scores[$this->replacingnote];
                if ($savingnoteWithBonus < $original['value']) {
                    return [
                        'originalNoteLabel' => $original['label'],
                        'originalNoteValue' => $original['value'],
                        'savingNoteValue' => $savingnoteWithBonus,
                    ];
                }
            }
        }
        return null;
    }

    public function getJudge(): ?Judge
    {
        return $this->judge;
    }

    public function setJudge(?Judge $judge): static
    {
        $this->judge = $judge;

        return $this;
    }

    public function getTimeOfPassage(): ?\DateTimeInterface
    {
        return $this->timeOfPassage;
    }

    public function setTimeOfPassage(?\DateTimeInterface $timeOfPassage): static
    {
        $this->timeOfPassage = $timeOfPassage;

        return $this;
    }

    public function isFlapsUsed(): ?bool
    {
        return $this->isFlapsUsed;
    }

    public function setIsFlapsUsed(?bool $isFlapsUsed): static
    {
        $this->isFlapsUsed = $isFlapsUsed;

        return $this;
    }

    public function isFlapsUsedReplacing(): ?bool
    {
        return $this->isFlapsUsedReplacing;
    }

    public function setIsFlapsUsedReplacing(?bool $isFlapsUsedReplacing): static
    {
        $this->isFlapsUsedReplacing = $isFlapsUsedReplacing;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }
}
