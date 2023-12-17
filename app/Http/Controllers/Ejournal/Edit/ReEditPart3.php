<?php

namespace App\Http\Controllers\Ejournal\Edit;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class ReEditPart3
{
    public function reEditPart3(Request $request)
    {
        $orderRecord = session('orderRecord');
        $orderRecord->separateInstructions = trim($request->get('sep_instrs_txt'));
        $orderRecord->orderDate = date("Y-m-d H:i", strtotime(trim($request->datetime_order_created)));
        $orderRecord->orderCreator = trim($request->inp_order_creator);
        $orderRecord->editMode = 'reedit';
        $orderRecord->orderLonger = '';
        if (!isNull($request->datetime_order_longed)) {
            $orderRecord->orderLongTo = date("Y-m-d H:i", strtotime(trim($request->datetime_order_longed)));
            $orderRecord->orderLonger = trim($request->inp_order_longer);
        }
        session(['orderRecord' => $orderRecord]);
        return view('orders.edit.editPart3', [
            'title' => ($orderRecord->id == 0) ? 'новий наряд' : 'клонуємо наряд № ' . $orderRecord->id,
            'orderRecord' =>  $orderRecord
        ]);
    }
}
