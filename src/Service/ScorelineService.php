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

        usort($scoresWithRanks, fn($a, $b) => $b['totalScore'] <=> $a['totalScore']);

        $rank = 0;
        $prevScore = null;
        $realIndex = 0;

        foreach ($scoresWithRanks as &$entry) {
            $realIndex++;

            if ($prevScore === null || $entry['totalScore'] < $prevScore) {
                $rank = $realIndex;
            }


            $entry['rank'] = $rank;
            $prevScore = $entry['totalScore'];
        }
        unset($entry);

        return $scoresWithRanks;
    }

}
