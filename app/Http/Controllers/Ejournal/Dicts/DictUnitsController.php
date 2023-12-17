<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Model\Ejournal\Dicts\Unit;
use Illuminate\Http\Request;
use Redirect;
use Session;


class DictUnitsController extends DictBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch_id = $this->currentUser->userBranch->id;
        $searchMybody = '%' . $request->input('searchMybody') . '%';
        $records = Unit::
        select('dict_units.id AS id', 'dict_units.body AS body', 'dict_branches.body AS branch_name')->
        leftJoin('dict_branches', 'dict_branches.id', '=', 'dict_units.branch_id')->
        where('dict_units.branch_id', $branch_id)->
        where('dict_units.body', 'like', $searchMybody)->
        orderBy('dict_units.id')->get();
        return view('dicts.index',
            ['branchName' => $this->currentUser->userBranch->body,
                'records' => $records,
                'zagolovok' => 'дільниць філії',
                'modelName' => 'App\Model\Ejournal\Dicts\Unit',
                'dictName' => 'Units',
                'add_th' => array('дільниця'),          // 'add_th'=>array('філія','дільниця'),      // для адмін режиму (всі філії)
                'add_td' => array('body'),              // 'add_td'=>array('branch_name','body')]);
                'th_width' => array(205)]);
    }

    /**
     * Show the form for creating a new resource.
     * !!! CREATE
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dicts.create', [
            'zagolovok' => 'дільниць філії',
            'dictName' => 'Units',
            'add_th' => array('дільниця'),
            'add_td' => array('body')
        ]);
    }

    /**
     * !! Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new Unit;
        $record->branch_id = $this->currentUser->userBranch->id;
        $record->id = Unit::max('id') + 1;
        $record->body = $request->input('body');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано. Нова дільниця ' . $record->body);
        return Redirect::to('dicts/Units');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Unit::find($id);
        return view('dicts.edit', [
            'record' => $record,
            'zagolovok' => 'дільниць філії',
            'dictName' => 'Units',
            'add_th' => array('дільниця'),
            'add_td' => array('body')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $unit
     * @return \Illuminate\Http\Response
     */
    public function update($record_id, Request $request)
    {
        $record = Unit::find($record_id);
        $record->body = $request->input('body');
        $record->save();

        // redirect
        Session::flash('message', 'Запис № ' . $record_id . ' успішно змінено!');
        return Redirect::to('dicts/Units');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Unit::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено дільницю ' . $msgtxt);
        return Redirect::to('dicts/Units');
    }
}
