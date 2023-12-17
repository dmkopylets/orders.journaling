<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Http\Controllers\Ejournal\BaseController;
use App\Model\User\Entity\BranchInfo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CreateOrder
{
    private EditRepository $repo;
    private BranchInfo $branchInfo;
    public function __construct()
    {
        $baseController = new BaseController();
        $this->branchInfo = $baseController->getBranchInfo();
        $this->repo = new EditRepository();
    }
    public function createOrder(Request $request): View
    {
        $orderRecord = $this->repo->initOrderRecord($this->branchInfo->id);
        $orderRecord->worksSpecsId = (int)$request->input('direction');
        $orderRecord->editMode = 'create';
        session(['orderRecord' => $orderRecord]);
        $editPart1Controller = new EditPart1Controller($this->repo, $this->branchInfo);
        return $editPart1Controller->editPart1($orderRecord);
    }
}
