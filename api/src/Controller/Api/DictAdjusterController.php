<?php

namespace App\Controller\Api;

use App\Entity\DictAdjuster;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/dict/adjuster')]
class DictAdjusterController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/dict/ajuster",
     *     summary="Get a list of adjusters",
     *     @OA\Response(
     *         response=200,
     *         description="List of adjusteres",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="body", type="string"),
     *                 @OA\Property(property="in_group", type="string"),
     *                 @OA\Property(property="branch_id", type="integer")
     *
     *             )
     *         )
     *     )
     * )
     */
    #[Route(name: 'dict_adjuster_index', methods:['get'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $adjusters = $entityManager
            ->getRepository(DictAdjuster::class)
            ->createQueryBuilder('a')
            ->select('a.id, a.body, a.in_group, a.branch_id')
            ->getQuery()
            ->getArrayResult();
        $data = $serializer->serialize($adjusters, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @OA\Post(
     *     path="/dict/adjuster/create",
     *     summary="Create a new adjuster",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="body", type="string", description="Body of the adjuster"),
     *             @OA\Property(property="in_group", type="string", description="Group of the adjuster"),
     *             @OA\Property(property="branch_id", type="string", description="Adjuster is a member of Branch"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="in_group", type="string"),
     *             @OA\Property(property="branch_id", type="integer")
     *         )
     *     )
     * )
     */
    #[Route('/create', name: 'dict_adjuster_create', methods:['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $adjuster = new DictAdjuster();
        $adjuster->setBody($request->request->get('body'));

        $entityManager->persist($adjuster);
        $entityManager->flush();

        $data =  [
            'id' => $adjuster->getId(),
            'body' => $adjuster->getBody(),
            'in_group' => $adjuster->getInGroup(),
            'branch_id' => $adjuster->getBranch()->getId(),
        ];

        return $this->json($data);
    }

    /**
     * @OA\Get(
     *     path="/dict/adjuster/{id}",
     *     summary="Get adjuster details by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the adjuster",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="in_group", type="string"),
     *             @OA\Property(property="branch_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Adjuster not found")
     * )
     */
    #[Route('/{id}', name: 'dict_adjuster_show', methods:['get'])]
    public function show(EntityManagerInterface $entityManager, int $id, SerializerInterface $serializer): Response
    {
        $adjuster = $entityManager->getRepository(DictAdjuster::class)->find($id);
        if (!$adjuster) {
            return $this->json('No adjuster found for id ' . $id, 404);
        }

        $data =  [
            'id' => $adjuster->getId(),
            'body' => $adjuster->getBody(),
            'in_group' => $adjuster->getInGroup(),
            'branch_id' => $adjuster->getBranch()->getId(),
        ];
        $data = $serializer->serialize($data, 'json');
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @OA\Put(
     *     path="/dict/adjuster/{id}",
     *     summary="Update adjuster by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the adjuster to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="body", type="string", description="New title for the adjuster"),
     *             @OA\Property(property="in_group", type="string", description="New goup for the adjuster"),
     *             @OA\Property(property="branch_id", type="string", description="New branch_id for the adjuster")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Branch updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="in_group", type="string"),
     *             @OA\Property(property="branch_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Branch not found")
     * )
     */
    #[Route('/{id}', name: 'dict_adjuster_update', methods:['put', 'patch'])]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $adjuster = $entityManager->getRepository(DictAdjuster::class)->find($id);
        if (!$adjuster) {
            return $this->json('No adjuster found for id ' . $id, 404);
        }

        $adjuster->setBody($request->request->get('body'));
        $adjuster->setInGroup($request->request->get('in_group'));
        $adjuster->setBranch($request->request->get('branch'));
        $entityManager->flush();

        $data =  [
            'id' => $adjuster->getId(),
            'body' => $adjuster->getBody(),
            'in_group' => $adjuster->getInGroup(),
            'branch_id' => $adjuster->getBranch()->getId()
        ];

        return $this->json($data);
    }

    /**
     * @OA\Delete(
     *     path="/dict/adjuster/{id}",
     *     summary="Delete adjuster by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the adjuster to delete",
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
    #[Route('/{id}', name: 'dict_adjuster_delete', methods:['delete'])]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $adjuster = $entityManager->getRepository(DictAdjuster::class)->find($id);

        if (!$adjuster) {
            return $this->json('No adjuster found for id ' . $id, 404);
        }

        $entityManager->remove($adjuster);
        $entityManager->flush();

        return $this->json('Deleted a adjuster successfully with id ' . $id);
    }
}
