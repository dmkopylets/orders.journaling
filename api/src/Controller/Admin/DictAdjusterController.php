<?php

namespace App\Controller\Admin;

use App\Entity\DictAdjuster;
use App\Form\DictAdjusterType;
use App\Repository\DictAdjusterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/dict/adjuster')]
final class DictAdjusterController extends AbstractController
{
    #[Route(name: 'admin_dict_adjuster_index', methods: ['GET'])]
    public function index(DictAdjusterRepository $adjusterRepository, Request $request): Response
    {
        $queryBuilder = $adjusterRepository->createQueryBuilder('a');
        $page = $request->query->getInt('page', 1);
        $pageSize = 5;
        $paginator = new Paginator(
            $queryBuilder->getQuery()
                ->setFirstResult($pageSize * ($page - 1))
                ->setMaxResults($pageSize)
        );
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $pageSize);
        return $this->render('admin/dicts/adjuster/index.html.twig', [
            'adjusters' => $paginator,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/new', name: 'admin_dict_adjuster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adjuster = new DictAdjuster();
        $form = $this->createForm(DictAdjusterType::class, $adjuster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adjuster);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dicts/adjuster/new.html.twig', [
            'adjuster' => $adjuster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_adjuster_show', methods: ['GET'])]
    public function show(DictAdjuster $adjuster): Response
    {
        return $this->render('admin/dicts/adjuster/show.html.twig', [
            'adjuster' => $adjuster,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_dict_adjuster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DictAdjuster $adjuster, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DictAdjusterType::class, $adjuster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dicts/adjuster/edit.html.twig', [
            'adjuster' => $adjuster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_adjuster_delete', methods: ['POST'])]
    public function delete(Request $request, DictAdjuster $adjuster, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adjuster->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adjuster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dict_adjuster_index', [], Response::HTTP_SEE_OTHER);
    }
}
