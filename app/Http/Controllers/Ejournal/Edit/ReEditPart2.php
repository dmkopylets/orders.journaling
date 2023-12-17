<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use Illuminate\Http\Request;

class ReEditPart2
{
    public function reEditPart2($orderId, Request $request)
    {
        $repo = new EditRepository();
        $orderRecord = $repo->getOrderRecord();
        //$orderRecord->editMode = 'reedit';
        $preparations = $repo->getPreparationsArray();
        $maxIdPreparation = 0;
        $countRowPreparations = 0;

        if (!empty($preparations)) {
            $maxIdPreparation = max(array_column($preparations, 'id'));
            $countRowPreparations = count($preparations);
        }

        $orderRecord->separateInstructions = trim($request->get('sep_instrs_txt'));
        $orderRecord->orderDate = date("Y-m-d H:i", strtotime(trim($request->datetime_order_created)));
        $orderRecord->orderCreator = trim($request->inp_order_creator);
        $orderRecord->orderLongTo = date("Y-m-d H:i", strtotime(trim($request->datetime_order_longed)));
        $orderRecord->orderLonger = trim($request->inp_order_longer);
        $orderRecord->underVoltage = trim($request->get('under_voltage'));
        $repo->setOrderRecord($orderRecord);

        return view('orders.edit.editPart2', [
            'title' => ($orderRecord->id == 0) ? 'новий наряд' : 'клонуємо наряд № ' . $orderRecord->id,
            'mode' => $orderRecord->editMode,
            'substations' => $repo->getSubstationsList($orderRecord->branchId, $repo->getSubstationTypeId($orderRecord->substationId)),
            'maxIdPreparation' => $maxIdPreparation,
            'countRowPreparations' => $countRowPreparations,
            'preparations' => $preparations,
            'orderRecord' => $orderRecord,
            'editRepository' => $repo,
        ]);
    }
}
