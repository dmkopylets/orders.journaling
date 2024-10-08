<?php

namespace App\Controller\Admin;

use App\Entity\DictAdjuster;
use App\Form\DictAdjusterType;
use App\Repository\DictAdjusterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/dict/adjuster')]
final class DictAdjusterController extends AbstractController
{
    #[Route(name: 'admin_dict_adjuster_index', methods: ['GET'])]
    public function index(DictAdjusterRepository $dictAdjusterRepository): Response
    {
        return $this->render('adjuster/index.html.twig', [
            'dict_adjusters' => $dictAdjusterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_dict_adjuster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dictAdjuster = new DictAdjuster();
        $form = $this->createForm(DictAdjusterType::class, $dictAdjuster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dictAdjuster);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adjuster/new.html.twig', [
            'adjuster' => $dictAdjuster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_adjuster_show', methods: ['GET'])]
    public function show(DictAdjuster $dictAdjuster): Response
    {
        return $this->render('adjuster/show.html.twig', [
            'adjuster' => $dictAdjuster,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_dict_adjuster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DictAdjuster $dictAdjuster, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DictAdjusterType::class, $dictAdjuster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adjuster/edit.html.twig', [
            'adjuster' => $dictAdjuster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_adjuster_delete', methods: ['POST'])]
    public function delete(Request $request, DictAdjuster $dictAdjuster, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dictAdjuster->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dictAdjuster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
    }
}
