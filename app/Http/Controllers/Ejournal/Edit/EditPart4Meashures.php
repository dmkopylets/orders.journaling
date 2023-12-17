<?php
namespace App\Http\Controllers\Ejournal\Edit;
use App\Http\Requests\EditOrderPart4Request;
use Livewire\Component;

class EditPart4Meashures extends Component
{
    public $updateMeashure = false;
    public $rowkey;     // індекс рядка (одномірного масива) у масиві $meashure
    public $meashure_id; // номер рядка для для запису в таблицю бази даних в поле id (не номер в масиві !  )
    public $branchId, $meashures, $maxIdMeashure, $countRowsMeashures, $licensor, $datetimeLicense, $mode;
    protected $listeners = [
        'destroyMeashure'=>'destroy',
        ];
    private  EditOrderPart4Request $request;

    public function __construct()
    {
        parent::__construct();
        $this->request = new EditOrderPart4Request();
    }

    public function mount($meashures, $maxIdMeashure, $countRowsMeashures, $orderRecord)
    {
        $this->reset();
        $this->branchId = $orderRecord->branchId;
        $this->mode = $orderRecord->editMode;
        $this->meashures = $meashures;
        $this->maxIdMeashure =$maxIdMeashure;
        $this->countRowsMeashures = $countRowsMeashures;
    }

    public function render()
    {
        return view('orders.edit.editPart4_Meashures',[
           'meashures'=>$this->meashures,
           'mode'=>$this->mode,
           'countRowsMeashures'=>$this->countRowsMeashures,
           'maxIdMeashure'=>$this->maxIdMeashure,
           'updateMeashure'=>$this->updateMeashure,
            ]);
    }

    public function resetFields(){
        $this->licensor = '';
        $this->datetimeLicense = '';
    }

    public function meashureStore()
    {
        // додаяється лише один рядочок
        // Validate Form Request
        $validated = $this->validate($this->request->rules(), $this->request->messages());
        try{
            $this->maxIdMeashure++;
            $this->meashures[]=[
                'id'      =>$this->maxIdMeashure,
                'licensor'=>$validated['licensor'],
                'datetimeLicense'=>date("Y-m-d H:i", strtotime($validated['datetimeLicense'])),
            ];
            var_dump($this->meashures);
            die();
            $this->countRowsMeashures = count($this->meashures);
            session(['meashures'  => $this->meashures]);
            session()->flash('success','рядок створено успішно!!');
            $this->resetFields();
        }catch(\Exception $e){
            $this->resetFields();
        }finally{
            $this->countRowsMeashures = count($this->meashures);
            $this->maxIdMeashure = max(array_column($this->meashures,'id'));
            return view('orders.edit.editPart4_Meashures',[
                'countRowsMeashures'=>$this->countRowsMeashures,
                'maxIdMeashure'=>$this->maxIdMeashure,
                'meashures'=>$this->meashures,
                 ]);
        }
        $this->cancel();
    }

    public function editMeashure($id){
        $this->meashure_id = $id; // номер рядка для таблиці бази даних (не номер в масиві!) буде використано в meashureUpdate()
        $this->rowkey = array_search($id, array_column($this->meashures, 'id'));
        $this->licensor =  $this->meashures[$this->rowkey]['licensor'];
        $this->datetimeLicense =  $this->meashures[$this->rowkey]['datetimeLicense'];
        $this->updateMeashure = true;
    }

    public function cancel()
    {
        $this->updateMeashure = false;
        $this->resetFields();
    }

    public function meashureUpdate(){
        $this->validate();
        try{
            $this->meashures[$this->rowkey]=[
                     'id'=>$this->meashure_id,
                     'licensor'=>$this->licensor,
                     'datetimeLicense'=>$this->datetimeLicense];
            session(['meashures'  => $this->meashures]);
            session()->flash('success','рядок змінено успішно!!');
            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Під час оновлення рядка сталася помилка!!');
            $this->cancel();
        }
    }

    public function destroy($id){
        try{
            $key = array_search($id, array_column($this->meashures, 'id'));
            unset($this->meashures[$key]);
            $this->meashures=array_values($this->meashures);  // переіндексація масива
            session(['meashures'  => $this->meashures]);
            session()->flash('success',"рядок видалено успішно!!!!");
            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error',"Під час видалення рядка сталася помилка!!");
        }
        finally{
            $this->countRowsMeashures = count($this->meashures);
            $this->maxIdMeashure = max(array_column($this->meashures,'id'));
            return view('orders.edit.f7Meashures',[
                'meashures'=>$this->meashures,
                'countRowsMeashures'=>$this->countRowsMeashures,
                'maxIdMeashure'=>$this->maxIdMeashure,
                 ]);
        }
        $this->cancel();
    }
}
