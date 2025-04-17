<?php

namespace App\Controller;

use App\Service\ScorelineExportService;
use App\Service\ScorelineService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AircraftRepository;
use App\Repository\CompetitorRepository;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(
        AircraftRepository $aircraftRepository,
        CompetitorRepository $competitorRepository,
        ScorelineService $scorelineService
    ): Response {
        return $this->render('dashboard.html.twig', [
            'aircrafts' => $aircraftRepository->findAll(),
            'competitors' => $competitorRepository->findAll(),
            'scoresWithRanks' => $scorelineService->getScoresWithRanks(),
        ]);
    }

    #[Route('/export-excel', name: 'app_export_excel')]
    public function exportExcel(ScorelineExportService $scorelineExportService): Response
    {
        return $scorelineExportService->generateExcelExport();
    }
}
