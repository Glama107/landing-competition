<?php

namespace App\Controller;

use App\Entity\Scoreline;
use App\Form\ScorelineType;
use App\Repository\ScorelineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/scoreline')]
final class ScorelineController extends AbstractController
{
    #[Route(name: 'app_scoreline_index', methods: ['GET'])]
    public function index(ScorelineRepository $scorelineRepository): Response
    {
        return $this->render('scoreline/index.html.twig', [
            'scorelines' => $scorelineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scoreline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scoreline = new Scoreline();
        $form = $this->createForm(ScorelineType::class, $scoreline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scoreline);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scoreline/new.html.twig', [
            'scoreline' => $scoreline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scoreline_show', methods: ['GET'])]
    public function show(Scoreline $scoreline): Response
    {
        return $this->render('scoreline/show.html.twig', [
            'scoreline' => $scoreline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scoreline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scoreline $scoreline, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScorelineType::class, $scoreline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scoreline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scoreline/edit.html.twig', [
            'scoreline' => $scoreline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scoreline_delete', methods: ['POST'])]
    public function delete(Request $request, Scoreline $scoreline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scoreline->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scoreline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scoreline_index', [], Response::HTTP_SEE_OTHER);
    }
}
