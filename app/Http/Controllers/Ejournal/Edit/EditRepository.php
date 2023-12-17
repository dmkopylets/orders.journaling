<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Model\Ejournal\Dicts\Adjuster;
use App\Model\Ejournal\Dicts\Branch;
use App\Model\Ejournal\Dicts\BrigadeEngineer;
use App\Model\Ejournal\Dicts\BrigadeMember;
use App\Model\Ejournal\Dicts\Line;
use App\Model\Ejournal\Dicts\Substation;
use App\Model\Ejournal\Dicts\TypicalTask;
use App\Model\Ejournal\Dicts\Unit;
use App\Model\Ejournal\Dicts\Warden;
use App\Model\Ejournal\Dicts\WorksSpec;
use App\Model\Ejournal\Meashure;
use App\Model\Ejournal\Order;
use App\Model\Ejournal\OrderRecordDTO;
use App\Model\Ejournal\Preparation;
use App\Model\User\Entity\BranchInfo;
use DateTime;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class EditRepository
{
    public function getSubstationTypeId($substationId)
    {
        return Substation::find($substationId)->type_id;
    }

    public function getSubstationsList(int $branchId, int $substationTypeId): array
    {
        return Substation::
        select('id', 'body', 'type_id')
            ->where('branch_id', $branchId)
            ->where('type_id', $substationTypeId)
            ->orderBy('type_id', 'asc')
            ->orderBy('body', 'asc')
            ->get()
            ->toArray();
    }

    public function getLinesList(int $branchId, int $substationId): array
    {
        return Line::
        select('line_id')
            ->where('branch_id', $branchId)
            ->where('substation_id', $substationId)
            ->orderBy('line_id', 'asc')
            ->get()
            ->toArray();
    }

    public function fetchOrdersList($substationlistid, $wardenlistid)
    {
        return DB::table('orders AS o')
            ->leftjoin('dict_wardens AS w', 'o.warden_id', '=', 'w.id')
            ->leftjoin('dict_substations AS s', 'o.substation_id', '=', 's.id')
            ->select('o.id as id', 'o.order_date as order_date', 'w.body as warden', 's.body as substation', 'o.tasks as tasks')
            ->whereIn('o.substation_id', $substationlistid)
            ->whereIn('o.warden_id', $wardenlistid)
            ->orderBy('o.id', 'desc')
            ->paginate(8);
    }

    public function fetchBrigadeMembers($idCollection): array
    {
        $result = [];
        if ($idCollection !== "") {
            $result = BrigadeMember::
            select('id', 'body', 'group')
                ->whereIn('id', explode(",", $idCollection))
                ->get()
                ->toArray();
        }
        return $result;
    }

    public function getAllPossibleTeamMembersArray(int $branchId): array
    {
        return BrigadeMember::
        select('id', 'body', 'group')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    public function fetchBrigadeEngineer($idCollection): array
    {
        $result = [];
        if ($idCollection !== "") {
            $result = BrigadeEngineer::
            select('id', 'body', 'group', 'specialization')
                ->whereIn('id', explode(",", $idCollection))
                ->get()
                ->toArray();
        }
        return $result;
    }

    public function getAllPossibleTeamEngineerArray(int $branchId): array
    {
        return BrigadeEngineer::
        select('id', 'body', 'group', 'specialization')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    public function readOrderFromDB(int $orderId, string $editMode): OrderRecordDTO
    {
        $order = Order::find($orderId);
        $dto = new OrderRecordDTO();
        $dto->id = $order->id;
        $dto->branchId = $order->branch_id;
        $dto->unitId = $order->unit_id;
        $dto->wardenId = $order->warden_id;
        $dto->adjusterId = $order->adjuster_id;
        $dto->brigadeMembersIds = $order->brigade_m;
        $dto->brigadeEngineerIds = $order->brigade_e;
        $dto->worksSpecsId = $order->works_spec_id;
        $dto->substationId = $order->substation_id;
        $dto->lineId = $order->line_id;
        $dto->objects = $order->objects;
        $dto->tasks = $order->tasks;
        $dto->workBegin = $order->w_begin;
        $dto->workEnd = $order->w_end;
        $dto->separateInstructions = $order->sep_instrs;
        $dto->orderDate = $order->order_date;
        $dto->orderCreator = $order->order_creator;
        $dto->orderLongTo = $order->order_longto;
        $dto->orderLonger = $order->order_longer;
        $dto->underVoltage = $order->under_voltage;
        $dto->editMode = $editMode;
        return $dto;
    }

    public static function toModel(OrderRecordDTO $dto): Order
    {
        $order = new Order();
        $order->branch_id = $dto->branchId;
        $order->unit_id = $dto->unitId;
        $order->warden_id = $dto->wardenId;
        $order->adjuster_id = $dto->adjusterId;
        $order->brigade_m = $dto->brigadeMembersIds;
        $order->brigade_e = $dto->brigadeEngineerIds;
        $order->works_spec_id = $dto->worksSpecsId;
        $order->substation_id = $dto->substationId;
        $order->line_id = $dto->lineId;
        $order->objects = $dto->objects;
        $order->tasks = $dto->tasks;
        $order->w_begin = $dto->workBegin;
        $order->w_end = $dto->workEnd;
        $order->sep_instrs = $dto->separateInstructions;
        $order->order_date = $dto->orderDate;
        $order->order_creator = $dto->orderCreator;
        $order->order_longto = $dto->orderLongTo;
        $order->order_longer = $dto->orderLonger;
        $order->under_voltage = $dto->underVoltage;
        return $order;
    }

    public function initOrderRecord(int $branchId): OrderRecordDTO
    {
        $dto = new OrderRecordDTO();
        $dto->id = 0;
        $dto->branchId = $branchId;
        $dto->unitId = 1;
        $dto->wardenId = 0;
        $dto->adjusterId = 0;
        $dto->brigadeMembersIds = '';
        $dto->brigadeEngineerIds = '';
        $dto->worksSpecsId = 1;
        $dto->substationId = 1;
        $dto->lineId = 0;
        $dto->objects = '';
        $dto->tasks = '';
        $dto->workBegin = '';
        $dto->workEnd = '';
        $dto->separateInstructions = '';
        $dto->orderDate = '';
        $dto->orderCreator = '';
        $dto->orderLongTo = '';
        $dto->orderLonger = '';
        $dto->underVoltage = '';
        $dto->editMode = '';
        return $dto;
    }

    public function getOrderRecord(): OrderRecordDTO
    {
        return session('orderRecord');
    }

    public function setOrderRecord(OrderRecordDTO $orderRecord): void
    {
        session(['orderRecord' => $orderRecord]);
    }

    public function getMode(): string
    {
        $this->mode = session('mode');
        return $this->mode;
    }

    public function setMode(string $mode): void
    {
        session(['mode' => $mode]);
        $this->mode = $mode;
    }

    public function getMeashuresArray(): array
    {
        return $this->meashures;
    }

    public function setMeashures(array $meashures): void
    {
        $this->meashures = $meashures;
    }

    public function getMeashuresFromDB(int $orderId)
    {
        return Meashure::
        select('id', 'licensor', 'lic_date')
            ->where('order_id', $orderId)
            ->get();
    }

    public function getMeashuresMaxId($orderId)
    {
        return Meashure::select('id')->where('order_id', $orderId)->get()->max('id');
    }

    public function getUnits(int $branchId)
    {
        return Unit::
        select('id', 'body')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get();
    }

    public function getWardens(int $branchId)
    {
        return Warden::
        select('id', 'body', 'group')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get();
    }

    public function getAdjusters(int $branchId)
    {
        return Adjuster::
        select('id', 'body', 'group')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get();
    }

    public function getPreparationsFromDB($orderId): array
    {
        return Preparation::
        select('id', 'target_obj as preparationTargetObj', 'body as preparationBody')
            ->where('order_id', $orderId)
            ->get()
            ->toArray();
    }

    public function getPreparationMaxId($orderId): int
    {
        $found = Preparation::
        select('id')
            ->where('order_id', $orderId)
            ->get()
            ->max('id');
        return is_null($found) ? 0 : $found;
    }

    public function getPreparationsArray(): array
    {
        return session('preparations');
    }

    public function setPreparationsArray($array): void
    {
        session(['preparations' => $array]);
    }

    public function getTypicalTasksListArray(int $worksSpecsId): array
    {
        return TypicalTask::
        select('id', 'body')
            ->where('works_specs_id', $worksSpecsId)
            ->orderBy('body')
            ->get()
            ->toArray();
    }

    public function getWorksSpecs()
    {
        return WorksSpec::select('id', 'body')->orderBy('id')->get()->toArray();
    }

    public function getBrigadeText(OrderRecordDTO $orderRecord): string
    {
        $teamList = '';
        $brigadeText = $this->fetchBrigadeMembers($orderRecord->brigadeMembersIds);
        if ($orderRecord->brigadeEngineerIds !== '') $engineersText = $this->fetchBrigadeEngineer($orderRecord->brigadeEngineerIds);
        if ($brigadeText != '') {
            foreach ($brigadeText as $txtPart1) {
                $teamList = $teamList . $txtPart1['body'] . ' ' . $txtPart1['group'] . ', ';
            }
        }
        if (isset($engineersText)) {
            foreach ($engineersText as $txtPart2) {
                $teamList = $teamList . $txtPart2['specialization'] . ' ' . $txtPart2['body'] . ' ' . $txtPart2['group'] . ', ';
            }
        }
        return $teamList;
    }

    public function findBranch($id): BranchInfo
    {
        $result = new BranchInfo();
        $tmp = Branch::find($id);
        $result->id = $tmp->id;
        $result->body = $tmp->body;
        return $result;
    }

    public function getOrderLongedDateFormated(?string $orderLonged): array
    {
        $text['date'] = '________';
        $text['time'] = '_____';
        if (!is_bool($orderLonged === true)) {
            $text['date'] =  date_format(DateTime::createFromFormat('Y-m-d H:i:s', $orderLonged), 'd.m.Y');
            $text['time'] = date_format(DateTime::createFromFormat('Y-m-d H:i:s', $orderLonged), 'H год. i хв.');
        }
        return $text;
    }
}
