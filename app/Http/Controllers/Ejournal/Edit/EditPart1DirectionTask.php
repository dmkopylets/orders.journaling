<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Edit;

use App\Http\Controllers\Ejournal\OrdersController;
use App\Model\Ejournal\OrderRecordDTO;
use Livewire\Component;

class EditPart1DirectionTask extends Component
{
    public array $changedOrderRecord = [];
    public array $lines = [];
    public array $substations = [];
    public array $taskslist = [];
    public array $workspecs = [];
    public int $choosedSubstation = 0;
    private string $workslist = '';
    public int $branchId = 0;
    public int $worksSpecsId = 2;
    public int $substationTypeId = 1;
    private EditRepository $repo;
    public int $lineId = 1;
    private string $mode = '';

    public function __construct()
    {
        parent::__construct();
        $this->repo = new EditRepository();
    }

    public function mount(OrderRecordDTO $orderRecord)
    {
        $this->reset();
        $this->changedOrderRecord = $orderRecord->toArray();
        $this->workspecs = $this->repo->getWorksSpecs();
        $this->worksSpecsId = $this->changedOrderRecord['worksSpecsId'];
        $this->choosedSubstation = $this->changedOrderRecord['substationId'];
        $this->substationTypeId = ($this->worksSpecsId === 3) ? 2 : 1; // тільки для "10-ток" буде зміна типу підстанцій (і тому й переліку в dict_substations), а так "завжди =0,4"
        $this->branchId = $orderRecord->branchId;
        $this->workslist = $orderRecord->objects . ' виконати ' . $orderRecord->tasks;
        $this->taskslist = $this->repo->getTypicalTasksListArray($this->worksSpecsId);// список робіт визначених, в функціях mount або choose_direction
        $this->substations = $this->repo->getSubstationsList($this->branchId, $this->substationTypeId);
        if ($orderRecord->editMode !== 'create') {
            $this->lineId = $orderRecord->lineId;
            $this->lines = $this->repo->getLinesList($this->branchId, $orderRecord->substationId);
        }
    }

    public function directDialer($choice)
    {
        $this->worksSpecsId = (int)$choice;
        $this->changedOrderRecord['worksSpecsId'] = (int)$choice;
        $this->reset('substationTypeId');
        $this->reset('substations');
        $this->substationTypeId = ($this->worksSpecsId === 3) ? 2 : 1;

        $this->taskslist = $this->repo->getTypicalTasksListArray($this->worksSpecsId); // список робіт визначених, в функціях mount або choose_direction
        $this->reset('substations');
        $this->substations = $this->repo->getSubstationsList($this->branchId, $this->substationTypeId);
        $this->lines = $this->repo->getLinesList($this->changedOrderRecord['branchId'], $this->changedOrderRecord['substationId']);
    }

    public function substationDialer($choice)
    {
        $this->reset('choosedSubstation');
        $this->choosedSubstation = $choice;
        $this->reset('lines');
        $this->lines = $this->repo->getLinesList($this->branchId, $choice);
    }

    public function render()
    {
        $this->taskslist = $this->repo->getTypicalTasksListArray($this->worksSpecsId); // список робіт визначених, в функціях mount або choose_direction
        $this->substations = $this->repo->getSubstationsList($this->branchId, $this->substationTypeId);
        $this->lines = $this->repo->getLinesList($this->changedOrderRecord['branchId'], $this->changedOrderRecord['substationId']);
        $this->changedOrderRecord['worksSpecsId'] = $this->worksSpecsId;

        return view('orders.edit.EditPart1_DirectionTask', [
            'lines' => $this->lines,
            'workspecs' => $this->workspecs,
            'worksSpecsId' => $this->worksSpecsId,
            'taskslist' => $this->taskslist,
            'substations' => $this->substations,
            'choosedSubstation' => $this->choosedSubstation,
            'substationTypeId' => $this->substationTypeId,
            'mode' => $this->mode,
            'workslist' => $this->workslist,
            'changedOrderRecord' => $this->changedOrderRecord,
        ]);
    }
}
