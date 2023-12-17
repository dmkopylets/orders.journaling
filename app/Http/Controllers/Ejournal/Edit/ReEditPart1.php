<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

class ReEditPart1
{
    public function reEditPart1()
    {
        $orderRecord = session('orderRecord');
        $repo = new EditRepository();
        $editPart1Controller = new EditPart1Controller($repo, $repo->findBranch($orderRecord->branchId));
        return $editPart1Controller->editPart1($orderRecord);
    }
}
