<?php

namespace App\Controller\Api;

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
    /**
     * @OA\Get(
     *     path="/dict/branch",
     *     summary="Get a list of branches",
     *     @OA\Response(
     *         response=200,
     *         description="List of branches",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="body", type="string"),
     *                 @OA\Property(property="prefix", type="string")
     *             )
     *         )
     *     )
     * )
     */
    #[Route(name: 'dict_branch_index', methods:['get'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $branches = $entityManager
            ->getRepository(DictBranch::class)
            ->createQueryBuilder('b')
            ->select('b.id, b.body, b.prefix')
            ->getQuery()
            ->getArrayResult();
        $data = $serializer->serialize($branches, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @OA\Post(
     *     path="/dict/branch/create",
     *     summary="Create a new branch",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="body", type="string", description="Body of the branch"),
     *             @OA\Property(property="prefix", type="string", description="Prefix to name for branch members")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="body", type="prefix")
     *         )
     *     )
     * )
     */
    #[Route('/create', name: 'dict_branch_create', methods:['post'])]
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

    /**
     * @OA\Get(
     *     path="/dict/branch/{id}",
     *     summary="Get branch details by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the branch",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="prefix", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Branch not found")
     * )
     */
    #[Route('/{id}', name: 'dict_branch_show', methods:['get'])]
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

    /**
     * @OA\Put(
     *     path="/dict/branch/{id}",
     *     summary="Update branch by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the branch to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="body", type="string", description="New title for the branch"),
     *             @OA\Property(property="prefix", type="string", description="New prefix for the branch members")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="prefix", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Branch not found")
     * )
     */
    #[Route('/{id}', name: 'dict_branch_update', methods:['put', 'patch'])]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $branch = $entityManager->getRepository(DictBranch::class)->find($id);
        if (!$branch) {
            return $this->json('No branch found for id ' . $id, 404);
        }

        $branch->setBody($request->request->get('body'));
        $branch->setPrefix($request->request->get('prefix'));
        $entityManager->flush();

        $data =  [
            'id' => $branch->getId(),
            'body' => $branch->getBody(),
            'prefix' => $branch->getPrefix(),
        ];

        return $this->json($data);
    }

    /**
     * @OA\Delete(
     *     path="/dict/branch/{id}",
     *     summary="Delete branch by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the branch to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Branch not found")
     * )
     */
    #[Route('/{id}', name: 'dict_branch_delete', methods:['delete'])]
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
