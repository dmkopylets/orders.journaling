<?php

namespace App\Controller;

use App\Entity\DictBranch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/dict/branch')]
class DictBranchController extends AbstractController
{
    #[Route(name: 'dict_branch_index', methods:['get'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $branches = $entityManager
            ->getRepository(DictBranch::class)
//            ->findAllWithSelectedFields()
            ->createQueryBuilder('b')
            ->select('b.id, b.body, b.prefix')
            ->getQuery()
            ->getArrayResult();
        $data = $serializer->serialize($branches, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/branches', name: 'branch_create', methods:['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $branch = new DictBranch();
        $branch->setBody($request->request->get('body'));

        $entityManager->persist($branch);
        $entityManager->flush();

        $data =  [
            'id' => $branch->getId(),
            'body' => $branch->getBody(),
        ];

        return $this->json($data);
    }


    #[Route('/branches/{id}', name: 'branch_show', methods:['get'])]
    public function show(EntityManagerInterface $entityManager, int $id, SerializerInterface $serializer): Response
    {
        $branch = $entityManager->getRepository(DictBranch::class)->find($id);
        if (!$branch) {
            return $this->json('No branch found for id ' . $id, 404);
        }

        $data =  [
            'id' => $branch->getId(),
            'body' => $branch->getBody(),
            'prefix' => $branch->getPrefix(),
        ];
        $data = $serializer->serialize($data, 'json');
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/branches/{id}', name: 'branch_update', methods:['put', 'patch'])]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $branch = $entityManager->getRepository(DictBranch::class)->find($id);
        if (!$branch) {
            return $this->json('No branch found for id ' . $id, 404);
        }

        $branch->setName($request->request->get('title'));
        $entityManager->flush();

        $data =  [
            'id' => $branch->getId(),
            'title' => $branch->getName(),
        ];

        return $this->json($data);
    }

    #[Route('/branches/{id}', name: 'branch_delete', methods:['delete'])]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $branch = $entityManager->getRepository(DictBranch::class)->find($id);

        if (!$branch) {
            return $this->json('No branch found for id ' . $id, 404);
        }

        $entityManager->remove($branch);
        $entityManager->flush();

        return $this->json('Deleted a branch successfully with id ' . $id);
    }
}
