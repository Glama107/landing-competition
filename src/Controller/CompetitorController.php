<?php

namespace App\Controller;

use App\Entity\Competitor;
use App\Form\CompetitorType;
use App\Repository\CompetitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/competitor')]
final class CompetitorController extends AbstractController
{
    #[Route(name: 'app_competitor_index', methods: ['GET'])]
    public function index(CompetitorRepository $competitorRepository): Response
    {
        return $this->render('competitor/index.html.twig', [
            'competitors' => $competitorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_competitor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competitor = new Competitor();
        $form = $this->createForm(CompetitorType::class, $competitor);
        $competitor->setCreatedBy($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($competitor);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competitor/form.html.twig', [
            'competitor' => $competitor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_competitor_show', methods: ['GET'])]
    public function show(Competitor $competitor): Response
    {
        return $this->render('competitor/show.html.twig', [
            'competitor' => $competitor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_competitor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competitor $competitor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompetitorType::class, $competitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competitor/form.html.twig', [
            'competitor' => $competitor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_competitor_delete', methods: ['POST'])]
    public function delete(Request $request, Competitor $competitor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competitor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($competitor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
