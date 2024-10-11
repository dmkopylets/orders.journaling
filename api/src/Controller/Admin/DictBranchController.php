<?php

namespace App\Controller\Admin;

use App\Entity\DictBranch;
use App\Form\DictBranchType;
use App\Repository\DictBranchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/dict/branch')]
final class DictBranchController extends AbstractController
{
    #[Route(name: 'admin_dict_branch_index', methods: ['GET'])]
    public function index(DictBranchRepository $branchRepository, Request $request): Response
    {
        $queryBuilder = $branchRepository->createQueryBuilder('b');
        $page = $request->query->getInt('page', 1);
        $pageSize = 5;
        $paginator = new Paginator(
            $queryBuilder->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize)
        );
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $pageSize);

        return $this->render('dicts/branch/index.html.twig', [
            'branches' => $paginator,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/create', name: 'admin_dict_branch_create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $branch = new DictBranch();
        $form = $this->createForm(DictBranchType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($branch);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_branch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dicts/branch/new.html.twig', [
            'branch' => $branch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_branch_show', methods: ['GET'])]
    public function show(DictBranch $branch): Response
    {
        return $this->render('dicts/branch/show.html.twig', [
            'branch' => $branch,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_dict_branch_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DictBranch $branch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DictBranchType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_dict_branch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dicts/branch/edit.html.twig', [
            'branch' => $branch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_dict_branch_delete', methods: ['POST'])]
    public function delete(Request $request, DictBranch $branch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$branch->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($branch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dict_branch_index', [], Response::HTTP_SEE_OTHER);
    }
}
