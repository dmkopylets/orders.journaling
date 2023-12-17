<?php

declare(strict_types=1);

namespace App\Model\Ejournal;

class OrderRecordDTO
{
    public int $id;
    public int $branchId;
    public int $unitId;
    public int $wardenId;
    public int $adjusterId;
    public string $brigadeMembersIds;
    public string $brigadeEngineerIds;
    public int $worksSpecsId;
    public int $substationId;
    public int $lineId;
    public string $objects;
    public string $tasks;
    public string $workBegin;
    public string $workEnd;
    public ?string $separateInstructions;
    public string $orderDate;
    public string $orderCreator;
    public ?string $orderLongTo;
    public ?string $orderLonger;
    public ?string $underVoltage;
    public ?string $editMode;

    public function toArray(): array
    {
        $array['id'] = $this->id;
        $array['branchId'] = $this->branchId;
        $array['unitId'] = $this->unitId;
        $array['wardenId'] = $this->wardenId;
        $array['adjusterId'] = $this->adjusterId;
        $array['brigadeMembersIds'] = $this->brigadeMembersIds;
        $array['brigadeEngineerIds'] = $this->brigadeEngineerIds;
        $array['worksSpecsId'] = $this->worksSpecsId;
        $array['substationId'] = $this->substationId;
        $array['lineId'] = $this->lineId;
        $array['objects'] = $this->objects;
        $array['tasks'] = $this->tasks;
        $array['workBegin'] = $this->workBegin;
        $array['workEnd'] = $this->workEnd;
        $array['separateInstructions'] = $this->separateInstructions;
        $array['$orderDate'] = $this->orderDate;
        $array['orderCreator'] = $this->orderCreator;
        $array['orderLongTo'] = $this->orderLongTo;
        $array['orderLonger'] = $this->orderLonger;
        $array['underVoltage'] = $this->underVoltage;
        $array['editMode'] = $this->editMode;
    return $array;
    }
    public function fromArray($array): OrderRecordDTO
    {
        $this->id = $array['id'];
        $this->branchId = $array['branchId'];
        $this->unitId = $array['unitId'];
        $this->wardenId = $array['wardenId'];
        $this->adjusterId = $array['adjusterId'];
        $this->brigadeMembersIds = $array['brigadeMembersIds'];
        $this->brigadeEngineerIds = $array['brigadeEngineerIds'];
        $this->worksSpecsId = $array['worksSpecsId'];
        $this->substationId = $array['substationId'];
        $this->lineId = $array['lineId'];
        $this->objects = $array['objects'];
        $this->tasks = $array['tasks'];
        $this->workBegin = $array['workBegin'];
        $this->workEnd = $array['workEnd'];
        $this->separateInstructions = $array['separateInstructions'];
        $this->orderDate = $array['$orderDate'];
        $this->orderCreator = $array['orderCreator'];
        $this->orderLongTo = $array['orderLongTo'];
        $this->orderLonger = $array['orderLonger'];
        $this->underVoltage = $array['underVoltage'];
        $this->editMode = $array['editMode'];
        return $this;
    }
}
