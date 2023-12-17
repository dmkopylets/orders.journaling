<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Model\Ejournal\Dicts\BrigadeEngineer;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DictBrigadeEngineersController extends DictBaseController
{
    public function index(Request $request)
    {
        $branch_id = $this->currentUser->userBranch->id;
        $searchMybody = '%' . $request->input('searchMybody') . '%';
        $searchMygroup = '%' . $request->input('searchMygroup') . '%';
        $searchMyspecialization = '%' . $request->input('searchMyspecialization') . '%';

        $records = BrigadeEngineer::
        where('branch_id', $branch_id)->
        where('body', 'like', $searchMybody)->
        where('group', 'like', $searchMygroup)->
        where('specialization', 'like', $searchMyspecialization)->
        orderBy('body')->get();
        return view('dicts.index',
            ['branchName' => $this->currentUser->userBranch->name,
                'records' => $records,
                'zagolovok' => 'механіки-стропальщики',
                'modelName' => 'App\Model\Ejournal\Dicts\BrigadeEngineer',
                'dictName' => 'BrigadeEngineers',
                'add_th' => array('спеціалізація', 'П.І.Б.', 'група'),
                'add_td' => array('specialization', 'body', 'group'),
                'th_width' => array(100, 100, 50)]);
    }


    /**
     * Show the form for creating a new resource.
     * !!! CREATE
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dicts.create',
            ['zagolovok' => 'машиністів-стропальщиків',
                'modelName' => 'App\Model\Ejournal\Dicts\BrigadeEngineer',
                'dictName' => 'BrigadeEngineers',
                'add_th' => array('спеціалізація', 'П.І.Б.', 'група'),
                'add_td' => array('specialization', 'body', 'group')]);
    }

    /**
     * !! Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new BrigadeEngineer;
        $record->branch_id = $$this->currentUser->userBranch->id;
        $record->id = BrigadeEngineer::max('id') + 1;
        $record->specialization = $request->input('specialization');
        $record->body = $request->input('body');
        $record->group = $request->input('group');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано машиніста-стропальщика ' . $record->body);
        return Redirect::to('dicts/BrigadeEngineers');
    }


    /**
     * Show the form for editing the specified resource.
     * !! EDIT
     * @param \App\Model\Ejournal\Dicts\BrigadeEngineer $BrigadeEngineer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = BrigadeEngineer::find($id);
        return view('dicts.edit',
            ['record' => $record,
                'zagolovok' => 'машиністів-стропальщиків',
                'dictName' => 'BrigadeEngineers',
                'modelName' => 'App\Model\Ejournal\Dicts\BrigadeEngineer',
                'add_th' => array('спеціалізація', 'П.І.Б.', 'група'),
                'add_td' => array('specialization', 'body', 'group')]);
    }

    /**
     * !! Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Ejournal\Dicts\BrigadeEngineer $BrigadeEngineer
     * @return \Illuminate\Http\Response
     * originalstring -  public function update(Request $request, BrigadeEngineer $BrigadeEngineer)
     */
    public function update(Request $request, $record_id)
    {
        $record = BrigadeEngineer::find($record_id);
        $record->specialization = $request->input('specialization');
        $record->body = $request->input('body');
        $record->group = $request->input('group');
        $record->save();

        // redirect
        Session::flash('message', 'Запис № ' . $record_id . ' успішно змінено!');
        return Redirect::to('dicts/BrigadeEngineers');
    }

    /**
     * !! Remove the specified resource from storage.
     *
     * @param \App\Model\Ejournal\Dicts\BrigadeEngineer $BrigadeEngineer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrigadeEngineer $BrigadeEngineer)
    {
        $record = BrigadeEngineer::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено машиніста-стропальщика ' . $msgtxt);
        return Redirect::to('dicts/BrigadeEngineers');
    }
}
