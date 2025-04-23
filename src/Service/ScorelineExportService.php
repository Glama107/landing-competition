<?php
namespace App\Service;

use App\Service\ScorelineService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScorelineExportService
{
    private $scorelineService;

    public function __construct(ScorelineService $scorelineService)
    {
        $this->scorelineService = $scorelineService;
    }

    /**
     * Génère le fichier Excel avec le classement au bon format.
     */
    public function generateExcelExport(): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $headers = ['#', 'Juge', 'Pilote', 'Appareil', 'Libre', 'Sans volets', 'Flaps utilisés', 'Sans moteur', 'Total', 'Remarques'];
        $sheet->fromArray($headers, null, 'A1');

        // Récupération des données
        $scoresWithRanks = $this->scorelineService->getScoresWithRanks();

        $row = 2;
        foreach ($scoresWithRanks as $entry) {
            $scoreline = $entry['scoreline'];

            // Gestion du remplacement de note si applicable
            $firstnote = $scoreline->getFirstnote();
            $secondscore = $scoreline->getSecondscore();
            $thirdnote = $scoreline->getThirdnote();
            $judge = $scoreline->getJudge()?->getName();
            $flapsUsed = 'N/A';
            if ($scoreline->isFlapsUsed() || $scoreline->isFlapsUsedReplacing()) {
                $flapsUsed = '+ 250';
            } else {
                $flapsUsed = 'Non';
            }
            $comments = $scoreline->getComments();

            if ($scoreline->getSavingnote() !== null && $scoreline->getReplacingnote() !== null) {
                $replacing = $scoreline->getReplacingnote();
                // Ne remplacer que si la savingnote est supérieure
                if ($scoreline->getSavingnote() > ${['', 'firstnote', 'secondscore', 'thirdnote'][$replacing]}) {
                    ${['', 'firstnote', 'secondscore', 'thirdnote'][$replacing]} = $scoreline->getSavingnote();
                }
            }

            $sheet->fromArray([
                $entry['rank'],
                $judge,
                $scoreline->getCompetitor()?->getName(), // Ou autre property du Competitor (à ajuster)
                $scoreline->getAircraft()?->getRegistration(),   // Ou autre property du Aircraft (à ajuster)
                $firstnote,
                $secondscore,
                $flapsUsed,
                $thirdnote,
                $entry['totalScore'],
                $comments
            ], null, 'A' . $row);

            $row++;
        }

        // Sortie du fichier : StreamedResponse recommandé (pas de fichier temporaire)
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $filename = 'classement.xlsx';
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', "attachment;filename=\"{$filename}\"");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
