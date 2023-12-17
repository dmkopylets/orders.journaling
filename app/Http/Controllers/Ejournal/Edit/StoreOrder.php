<?php

namespace App\Http\Controllers\Ejournal\Edit;

use App\Model\Ejournal\OrderRecordDTO;
use App\Model\User\Entity\BranchInfo;
use Illuminate\Http\Request;
use Redirect;

class StoreOrder
{
    public function __construct(EditRepository $repo, BranchInfo $branch)
    {
        $this->branch = $branch;
        $this->repo = $repo;
    }
    public function store(OrderRecordDTO $orderRecord, Request $request)
    {
        $orderRecord->underVoltage = trim($request->get('under_voltage_txt'));
        $request->flash();
        $newOrder = $this->repo->toModel($orderRecord);
        $newOrder->save();

        $preparations = $this->repo->getPreparationsArray();
        if (count($preparations) > 0) {
            foreach ($preparations as $prRow) {
                $newOrder->preparations()->create([
                    'order_id' => $newOrder->id,
                    'target_obj' => $prRow['preparationTargetObj'],
                    'body' => $prRow['preparationBody']
                ]);
            }
        }

        $meashures = session('meashures');
        if (count($meashures) > 0) {
            foreach ($meashures as $msRow) {
                $newOrder->meashures()->create([
                    'order_id' => $newOrder->id,
                    'licensor' => $msRow['licensor'],
                    'lic_date' => $msRow['datetimeLicense']
                ]);
            }
        }

        return Redirect::to('orders')->with('success', 'Наряд № ' . $newOrder->id . ' додано!');
    }
}
