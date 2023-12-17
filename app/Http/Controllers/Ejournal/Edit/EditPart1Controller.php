<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Model\Ejournal\OrderRecordDTO;
use App\Model\User\Entity\BranchInfo;
use Illuminate\View\View;

class EditPart1Controller
{
    protected BranchInfo $branch;
    private EditRepository $repo;

    public function __construct(EditRepository $repo, BranchInfo $branch)
    {
        $this->repo = $repo;
        $this->branch = $branch;
    }

    public function editPart1(OrderRecordDTO $orderRecord): View
    {
        $this->repo->setOrderRecord($orderRecord);
        return view('orders.edit.editPart1', [
            'title' => ($orderRecord->id == 0) ? 'новий наряд' : 'клонуємо наряд № ' . $orderRecord->id,
            'branch' => $this->branch,
            'allPossibleTeamMembers' => $this->repo->getAllPossibleTeamMembersArray($orderRecord->branchId),
            'allPossibleTeamEngineer' => $this->repo->getAllPossibleTeamEngineerArray($orderRecord->branchId),
            'units' => $this->repo->getUnits($orderRecord->branchId),
            'wardens' => $this->repo->getWardens($orderRecord->branchId),
            'adjusters' => $this->repo->getAdjusters($orderRecord->branchId),
            'countBrigade' => count(explode(",", $orderRecord->brigadeMembersIds)) + count(explode(",", $orderRecord->brigadeEngineerIds)),
            'worksSpecsId' => $orderRecord->worksSpecsId,
            'teamList' => $this->repo->getBrigadeText($orderRecord),
            'orderRecord' => $orderRecord,
        ]);
    }
}
