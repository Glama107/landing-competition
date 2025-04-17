<?php

namespace App\Service;

use App\Repository\ScorelineRepository;

class ScorelineService
{
    private $scorelineRepository;

    public function __construct(ScorelineRepository $scorelineRepository)
    {
        $this->scorelineRepository = $scorelineRepository;
    }

    /**
     * Retourne le classement avec les scores, positions et notes remplacées.
     */
    public function getScoresWithRanks(): array
    {
        $scorelines = $this->scorelineRepository->findAll();
        $scoresWithRanks = [];

        foreach ($scorelines as $scoreline) {
            $scoresWithRanks[] = ['scoreline' => $scoreline, 'totalScore' => $scoreline->calculateTotalScore(), 'replacedNote' => $scoreline->getReplacedNote(),];
        }

// Tri par score décroissant
        usort($scoresWithRanks, fn($a, $b) => $b['totalScore'] <=> $a['totalScore']);

// Ajout des rangs
        foreach ($scoresWithRanks as $index => &$entry) {
            $entry['rank'] = $index + 1;
        }
        unset($entry);

        return $scoresWithRanks;
    }
}
