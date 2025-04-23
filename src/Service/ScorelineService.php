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
            $scoresWithRanks[] = [
                'scoreline' => $scoreline,
                'totalScore' => $scoreline->calculateTotalScore(),
                'replacedNote' => $scoreline->getReplacedNote(),
            ];
        }

        usort($scoresWithRanks, fn($a, $b) => $a['totalScore'] <=> $b['totalScore']);

        $rank = 0;
        $prevScore = null;
        $sameRankCount = 0;

        foreach ($scoresWithRanks as $i => &$entry) {
            if ($prevScore === null || $entry['totalScore'] !== $prevScore) {
                $rank = $i + 1;
            }
            $entry['rank'] = $rank;
            $prevScore = $entry['totalScore'];
        }
        unset($entry);


        return $scoresWithRanks;
    }

}
