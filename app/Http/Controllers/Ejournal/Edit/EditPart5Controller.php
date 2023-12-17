<?php

namespace App\Http\Controllers\Ejournal\Edit;

use App\Model\Ejournal\OrderRecordDTO;

class EditPart5Controller
{

    public function editpart5(OrderRecordDTO $orderRecord)
    {
        return view('orders.edit.editPart5', [
            'title' => '№ ' . $orderRecord->id . ' завершення',
            'orderRecord' => $orderRecord,
        ]);
    }
}
