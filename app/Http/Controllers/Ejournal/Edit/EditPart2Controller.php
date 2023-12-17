<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Model\Ejournal\OrderRecordDTO;
use App\Model\User\Entity\BranchInfo;
use App\Http\Requests\EditOrderPart1Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EditPart2Controller
{
    protected BranchInfo $branchInfo;
    private EditRepository $repo;

    public function __construct(EditRepository $repo, BranchInfo $branchInfo)
    {
        $this->repo = $repo;
        $this->branchInfo = $branchInfo;
        session()->forget('error');
    }

    public function editpart2(OrderRecordDTO $orderRecord, EditOrderPart1Request $request): View
    {
        $orderRecord->worksSpecsId = (int)$request->input('directions');
        $orderRecord->substationId = (int)$request->input('substationDialer');
        $orderRecord->lineId = (int)$request->input('selectLine');
        $orderRecord->unitId = (int)$request->input('district');
        $orderRecord->wardenId = (int)$request->input('warden');
        $orderRecord->adjusterId = (int)$request->input('adjuster');
        $orderRecord->workBegin = date("Y-m-d H:i", strtotime($request->input('datetime_work_begin')));
        $orderRecord->workEnd = date("Y-m-d H:i", strtotime($request->input('datetime_work_end')));
        $orderRecord->brigadeEngineerIds = (string)$request->input('write_to_db_engineers');

        $v = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($v->fails()) {
            $orderRecord->brigadeMembersIds = (string)$request->input('write_to_db_brigade');
            $editPart1Controller = new EditPart1Controller($this->repo, $this->branchInfo);
            return $editPart1Controller->editPart1($orderRecord);
        } else {
            $validatedData = $request->validated();
            $preparations = [];
            $countRowPreparations = 0;
            $maxIdPreparation = 0;
            $orderRecord->brigadeMembersIds = $validatedData["write_to_db_brigade"];
            $workslist = trim($validatedData["workslist"]);
            $pos = strpos($workslist, ' виконати '); // розділяємо текст на частини: об'єкти та робота з поля введення workslist по слову  ' виконати '
            $orderRecord->objects = substr($workslist, 0, $pos);
            $orderRecord->tasks = substr($workslist, $pos + 1);

            if ($orderRecord->editMode == 'reedit') {  // якщо reedit, основні дані для цієї форми берем не з бази, а з session
                $preparations = session('preparations');
                if (!empty($preparations)) {
                    $maxIdPreparation = max(array_column($preparations, 'id'));
                    $countRowPreparations = count($preparations);
                }
            }
            if ($orderRecord->editMode == 'clone') {
                $maxIdPreparation = $this->repo->getPreparationMaxId($orderRecord->id);
                if ($maxIdPreparation > 0) {
                    $preparations = $this->repo->getPreparationsFromDB($orderRecord->id);
                    $countRowPreparations = count($preparations);
                }
            }
            $this->repo->setOrderRecord($orderRecord);
            $substationTypeId = $this->repo->getSubstationTypeId($orderRecord->substationId);
            session()->forget('error');
            return view('orders.edit.editPart2', [
                'title' => ($orderRecord->id == 0) ? 'новий наряд' : 'клонуємо наряд № ' . $orderRecord->id,
                'substations' => $this->repo->getSubstationsList($orderRecord->branchId, $substationTypeId),
                'preparations' => $preparations,
                'maxIdPreparation' => $maxIdPreparation,
                'countRowPreparations' => $countRowPreparations,
                'orderRecord' => $orderRecord,
            ]);
        }
    }
}
