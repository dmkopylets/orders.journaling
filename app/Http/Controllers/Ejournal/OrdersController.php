<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal;

use App\Http\Controllers\Ejournal\BaseController as BaseController;
use App\Http\Controllers\Ejournal\Edit\EditRepository;
use App\Http\Requests\EditOrderPart1Request;
use App\Model\Ejournal\Dicts\Substation;
use App\Model\Ejournal\Dicts\Warden;
use App\Model\Ejournal\OrderRecordDTO;
use App\Model\User\Entity\BranchInfo;
use App\Model\User\Entity\UserRepository;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    public UserRepository $userRepository;
    public EditRepository $editRepository;
    public OrderRecordDTO $orderRecord;
    public array $preparations = [];
    public array $meashures = [];
    protected BranchInfo $branch;
    private Edit\EditPart1Controller $editPart1;
    private Edit\EditPart2Controller $editPart2;
    private Edit\EditPart3Controller $editPart3;
    private Edit\EditPart4Controller $editPart4;
    private Edit\EditPart5Controller $editPart5;
    private Edit\StoreOrder $storeOrder;

    public function __construct()
    {
        parent::__construct();
        $this->branch = $this->currentUser->userBranch;
        $this->editRepository = new EditRepository();
        $this->editPart2 = new Edit\EditPart2Controller($this->editRepository, $this->branch);
        $this->editPart3 = new Edit\EditPart3Controller();
        $this->editPart4 = new Edit\EditPart4Controller($this->editRepository);
        $this->editPart5 = new Edit\EditPart5Controller();
        $this->storeOrder = new Edit\StoreOrder($this->editRepository, $this->branch);
        $this->orderRecord = $this->editRepository->initOrderRecord($this->branch->id);
    }

    public function welcome()
    {
        return view('orders.welcome', [
            'userBranch' => $this->currentUser->userBranch,
            'userLogin' => $this->currentUser->userLogin,
            'userName' => $this->currentUser->userName
        ]);
    }

    /**  INDEX **
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $searchWarden = '%' . $request->input('searchWarden') . '%';
        $searchTerm = '%' . $request->input('searchTerm') . '%';

        if ($this->branch->id == 0) {   // if user from main office or admin ("noBranch")
            $wardenListId = Warden::where('body', 'like', $searchWarden)->pluck('id');
            $substationListId = Substation::where('body', 'like', $searchTerm)->pluck('id');
        } else {
            $wardenListId = Warden::
            where('body', 'like', $searchWarden)
                ->where('branch_id', $this->branch->id)
                ->pluck('id');
            $substationListId = Substation::
            where('body', 'like', $searchTerm)
                ->where('branch_id', $this->branch->id)
                ->pluck('id');
        }
        $records = $this->editRepository->fetchOrdersList($substationListId, $wardenListId);

        // чистимо Session
        session()->forget('orderRecord');
        session()->forget('preparations');
        session()->forget('meashures');

        return view('orders.index', ['records' => $records, 'branch' => $this->currentUser->userBranch]);
    }

    /**
     *   !! визначаємо напрямок робіт для  створюваного НОВОГО наряду
     */
    public function preCreate()
    {
        return view('orders.precreate', [
            'workspecs' => $this->editRepository->getWorksSpecs(),
        ]);
    }

    public function clone(int $orderId): \Illuminate\View\View
    {
        $editPart1Controller = new Edit\EditPart1Controller($this->editRepository, $this->branch);
        return $editPart1Controller->editpart1($this->editRepository->readOrderFromDB($orderId, 'clone'));
    }

    public function editPart2(EditOrderPart1Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return $this->editPart2->editpart2($this->editRepository->getOrderRecord(), $request);
    }

    public function editPart3(Request $request)
    {
        return $this->editPart3->editpart3($this->editRepository->getOrderRecord(), $request);
    }

    public function editPart4(Request $request)
    {
        return $this->editPart4->editpart4($this->editRepository->getOrderRecord(), $request);
    }

    public function editPart5()
    {
        return $this->editPart5->editpart5($this->editRepository->getOrderRecord());
    }

    public function store(Request $request)
    {
        return $this->storeOrder->store($this->editRepository->getOrderRecord(), $request);
    }
}
