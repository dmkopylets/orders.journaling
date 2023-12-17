<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Http\Controllers\Ejournal\BaseController;
use App\Model\Ejournal\Dicts\Adjuster;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DictAdjustersController extends DictBaseController
{
    /**
     * Display a listing of the resource.
     *     !!! INDEX
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $this->currentUser->userBranch;
        $branch_id = $branch->id;
        $searchMybody = '%' . $request->input('searchMybody') . '%';
        $searchMygroup = '%' . $request->input('searchMygroup') . '%';
        $records = Adjuster::
        where('branch_id', $branch_id)->
        where('group', 'like', $searchMygroup)->
        where('body', 'like', $searchMybody)->
        orderBy('body')->get();
        return view('dicts.index',
            ['branchName' => $branch->body,
                'records' => $records,
                'zagolovok' => 'допускачів',
                'dictName' => 'Adjusters',
                'modelName' => 'App\Model\Ejournal\Dicts\Adjuster',
                'add_th' => array('допускач', 'група'),
                'add_td' => array('body', 'group'),
                'th_width' => array(305, 70)]);
    }


    /**
     * Show the form for creating a new resource.
     *   !!! CREATE
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dicts.create', ['zagolovok' => 'допускачів', 'modelName' => 'App\Model\Ejournal\Dicts\Adjuster', 'dictName' => 'Adjusters', 'add_th' => array('допускач', 'група'), 'add_td' => array('body', 'group')]);
    }

    /**
     * !!! STORE a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new Adjuster;
        $record->branch_id = \App\Model\Ejournal\Dicts\Branch::dataFromLoginPrefix()->id;
        $record->id = Adjuster::max('id') + 1;
        $record->body = $request->input('body');
        $record->group = $request->input('group');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано допускача ' . $record->body);
        return Redirect::to('dicts/Adjusters');
    }


    /**
     * Show the form for editing the specified resource.
     * !! EDIT
     * @param \App\Models\eNaryd\Dicts\Adjuster $adjusters
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Adjuster::find($id);
        return view('dicts.edit', ['record' => $record, 'zagolovok' => 'допускачів', 'dictName' => 'Adjusters', 'modelName' => 'App\Model\Ejournal\Dicts\Adjuster', 'add_th' => array('допускач', 'група'), 'add_td' => array('body', 'group')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\eNaryd\Dicts\Adjuster $adjusters
     * @return \Illuminate\Http\Response
     * !!!! public function update(Request $request, Adjuster $adjuster)
     */
    public function update(Request $request, $record_id)
    {
        $record = Adjuster::find($record_id);
        $record->body = $request->input('body');
        $record->group = $request->input('group');
        $record->save();

        // redirect
        Session::flash('message', 'Запис № ' . $record_id . ' успішно змінено!');
        return Redirect::to('dicts/Adjusters');
    }


    /**
     * !!! Remove the specified resource from storage.
     *
     * @param \App\Models\eNaryd\Dicts\Adjuster $adjusters
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Adjuster::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено допускача ' . $msgtxt);
        return Redirect::to('dicts/Adjusters');
    }
}
