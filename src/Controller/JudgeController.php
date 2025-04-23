<?php

namespace App\Controller;

use App\Entity\Judge;
use App\Form\JudgeType;
use App\Repository\JudgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/judge')]
final class JudgeController extends AbstractController
{
    #[Route(name: 'app_judge_index', methods: ['GET'])]
    public function index(JudgeRepository $judgeRepository): Response
    {
        return $this->render('judge/index.html.twig', [
            'judges' => $judgeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_judge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $judge = new Judge();
        $form = $this->createForm(JudgeType::class, $judge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($judge);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('judge/form.html.twig', [
            'judge' => $judge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_judge_show', methods: ['GET'])]
    public function show(Judge $judge): Response
    {
        return $this->render('judge/show.html.twig', [
            'judge' => $judge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_judge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Judge $judge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JudgeType::class, $judge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('judge/form.html.twig', [
            'judge' => $judge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_judge_delete', methods: ['POST'])]
    public function delete(Request $request, Judge $judge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$judge->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($judge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
