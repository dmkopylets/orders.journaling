<?php

namespace App\Http\Controllers\Ejournal\Edit;

use App\Http\Controllers\Ejournal\BaseController as BaseController;
use Illuminate\Http\Request;

class ReEditPart4 extends BaseController
{

    public function reEditPart4(Request $request)
    {
        $orderRecord = session('orderRecord');
        $orderRecord->editMode = 'reedit';
        $countRowsMeashures = 0;
        $maxIdMeashure = 0;
        $meashures = session('meashures');
        if (!empty($meashures)) {
            $maxIdMeashure = max(array_column($meashures, 'id'));
            $countRowsMeashures = count($meashures);
        }

        $orderRecord->underVoltage = trim($request->get('under_voltage'));
        session(['orderRecord' => $orderRecord]);

        return view('orders.edit.editPart4', [
            'mode' => 'reedit',
            'title' => ($orderRecord->id == 0) ? 'новий наряд' : 'клонуємо наряд № ' . $orderRecord->id,
            'meashures' => $meashures,
            'maxIdMeashure' => $maxIdMeashure,
            'countRowsMeashures' => $countRowsMeashures,
            'orderRecord' => session('orderRecord')
        ]);
    }
}
