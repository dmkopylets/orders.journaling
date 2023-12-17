<?php

namespace App\Http\Controllers\Ejournal\Edit;

use App\Http\Requests\EditOrderPart2Request;
use App\Model\Ejournal\OrderRecordDTO;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditPart2Preparation extends Component
{
    public bool $updatePreparation = false;
    public array $orderRecord = [];
    public array $preparations = [];
    public int $maxIdPreparation = 0;
    public int $rowKey = 0; // індекс рядка (одномірного масива) у бегатомірному масиві $preparation
    public int $substationId = 0;
    public array $substations = [];
    public int $preparationId = 0;
    public string $preparationTargetObj = '';
    public string $preparationBody = '';
    public int $countRowPreparations = 0;
    protected $listeners = [
        'destroyPreparation' => 'destroy',
        //  'editPreparation'=>'edit',
        //  'updatePreparation'=>'update'
    ];
    private EditOrderPart2Request $request;

    public function __construct()
    {
        parent::__construct();
        $this->request = new EditOrderPart2Request();
    }

    public function mount(array $substations, array $preparations, int $maxIdPreparation, int $countRowPreparations, OrderRecordDTO $orderRecordDTO)
    {
        $this->reset();
        $this->orderRecord = $orderRecordDTO->toArray();
        $this->substationId = $orderRecordDTO->substationId;
        $this->substations = $substations;
        $this->preparations = $preparations;
        $this->maxIdPreparation = $maxIdPreparation;
        $this->countRowPreparations = $countRowPreparations;
    }

    public function render()
    {
        return view('orders.edit.editPart2_Preparation', [
            'substations' => $this->substations,
            'substationId' => $this->substationId,
            'preparations' => $this->preparations,
            'countRowPreparations' => $this->countRowPreparations,
            'maxIdPreparation' => $this->maxIdPreparation,
            'updatePreparation' => $this->updatePreparation,
            'orderRecord' => $this->orderRecord,
        ]);
    }

    public function resetFields()
    {
        $this->preparationTargetObj = '';
        $this->preparationBody = '';
    }

    public function preparationStore()
    {
        $validatedData = $this->validate($this->request->rules(), $this->request->messages());
        try {
            $this->maxIdPreparation++;
            $this->preparations[] = [
                'id' => $this->maxIdPreparation,
                'preparationTargetObj' => $validatedData['preparationTargetObj'],
                'preparationBody' => $validatedData['preparationBody']
            ];
            session(['preparations' => $this->preparations]);
            session()->flash('success', 'Препарація створена успішно!!');
            $this->resetFields();
        } catch (\Exception $e) {
            $this->resetFields();
        } finally {
            $this->countRowPreparations = count($this->preparations);
            $this->maxIdPreparation = max(array_column($this->preparations, 'id'));
            return view('orders.edit.editPart2_Preparation', [
                'substations' => $this->substations,
                'substationId' => $this->substationId,
                'preparations' => $this->preparations,
                'countRowPreparations' => $this->countRowPreparations,
                'maxIdPreparation' => $this->maxIdPreparation,
            ]);
        }
        $this->cancel();
    }

    public function editPreparation($id)
    {
        $this->preparationId = $id;
        $this->rowKey = array_search($id, array_column($this->preparations, 'id'));
        $this->preparationTargetObj = $this->preparations[$this->rowKey]['preparationTargetObj'];
        $this->preparationBody = $this->preparations[$this->rowKey]['preparationBody'];
        $this->updatePreparation = true;
    }

    public function cancel()
    {
        $this->updatePreparation = false;
        $this->resetFields();
    }

    public function preparationUpdate()
    {
        $this->validate($this->request->rules(), $this->request->messages());
        try {
            $this->preparations[$this->rowKey] = [
                'id' => $this->preparationId,
                'preparationTargetObj' => $this->preparationTargetObj,
                'preparationBody' => $this->preparationBody,
            ];
            session(['preparations' => $this->preparations]);
            session()->flash('success', 'Препарація змінена успішно!!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Під час оновлення Препарації сталася помилка!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            $key = array_search($id, array_column($this->preparations, 'id'));
            unset($this->preparations[$key]);
            $this->preparations = array_values($this->preparations); // переіндексація масива
            session(['preparations' => $this->preparations]);
            session()->flash('success', "Препарація видалена успішно!!!!");
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', "Під час видалення Препарації сталася помилка!!");
        } finally {
            $this->countRowPreparations = count($this->preparations);
            $this->maxIdPreparation = max(array_column($this->preparations, 'id'));
            return view('orders.edit.editPart2_Preparation', [
                'substations' => $this->substations,
                'substationId' => $this->substationId,
                'preparations' => $this->preparations,
                'countRowPreparations' => $this->countRowPreparations,
                'maxIdPreparation' => $this->maxIdPreparation,
            ]);
        }
        $this->cancel();
    }
}
