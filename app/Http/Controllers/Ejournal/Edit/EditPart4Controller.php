<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Http\Controllers\Ejournal\BaseController;
use App\Model\Ejournal\OrderRecordDTO;
use Illuminate\Http\Request;


class EditPart4Controller extends BaseController
{
    private EditRepository $repo;

    public function __construct(EditRepository $repo)
    {
        parent::__construct();
        $this->repo = $repo;
    }

    public function editpart4(OrderRecordDTO $orderRecord, Request $request)
    {
        $orderRecord->separateInstructions = trim((string)$request->get('separateInstructionsText'));
        $orderRecord->orderDate = date("Y-m-d H:i", strtotime(trim($request->datetime_order_created)));
        $orderRecord->orderCreator = trim((string)$request->inp_order_creator);

        $orderRecord->orderLonger = '';
        $orderRecord->orderLongTo = null;
        if (!is_null($request->datetime_order_longed)) {
            $orderRecord->orderLongTo = date("Y-m-d H:i", strtotime(trim($request->datetime_order_longed)));
            $orderRecord->orderLonger = trim($request->inp_order_longer);
        }

        session(['orderRecord' => $orderRecord]);


        /* займемося ровсетом meashures - набором рядочків таблиці meashures (підготовчих заходів), що мають прив`язку до номеру клонованого наряду  */
        $countRowsMeashures = 0;
        $maxIdMeashure = 0;
        $this->meashures = array();
        if ($orderRecord->editMode === 'reedit') {  // якщо reedit, дані берем не з бази, а з session
            $this->meashures = session('meashures');
            if (!empty($this->meashures)) {
                $maxIdMeashure = max(array_column($this->meashures, 'id'));
                $countRowsMeashures = count($this->meashures);
            }
        }
        if ($orderRecord->editMode === 'clone') {
            $maxIdMeashureTmp = $this->repo->getMeashuresMaxId($orderRecord->id);
            if ($maxIdMeashureTmp > 0) {
                $this->meashures = $this->repo->getMeashuresFromDB($orderRecord->id)->toArray();
                $maxIdMeashure = max(array_column($this->meashures, 'id'));
                $countRowsMeashures = count($this->meashures);
            }
        }

        session(['meashures' => $this->meashures]);

        return view('orders.edit.editPart4', [
            'title' => '№ ' . $orderRecord->id . ' підготовка2',
            'maxIdMeashure' => $maxIdMeashure,
            'countRowsMeashures' => $countRowsMeashures,
            'orderRecord' => $orderRecord,
            'meashures' => $this->meashures
        ]);
    }
}
