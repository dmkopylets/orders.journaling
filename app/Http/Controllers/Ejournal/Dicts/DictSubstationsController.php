<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Http\Controllers\Ejournal\BaseController;
use App\Model\Ejournal\Dicts\Branch;
use App\Model\Ejournal\Dicts\Substation;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DictSubstationsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *!!! INDEX
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchMybody = '%' . $request->input('searchMybody') . '%';
        $branch_id = $this->currentUser->userBranch->id;
        $branch = Branch::find($branch_id);
        $records = $branch->substations()
            ->select('dict_substations.id AS id', 'dict_substations.body AS body', 'dict_station_types.body AS type')
            ->leftJoin('dict_station_types', 'dict_station_types.id', '=', 'dict_substations.type_id')
            ->where('dict_substations.body', 'like', $searchMybody)
            ->orderBy('dict_substations.type_id', 'asc')
            ->orderBy('dict_substations.body', 'asc')
            ->get();
        return view('dicts.index', [
            'branchName' => $branch->body,
            'records' => $records,
            'zagolovok' => 'підстанції',
            'dictName' => 'Substations',
            'add_th' => array('0,4-10 кВ', 'підстанція'),
            'add_td' => array('type', 'body'),
            'th_width' => array(100, 200)
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *  !!! CREATE
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dicts.create', [
            'zagolovok' => 'підстанцій',
            'dictName' => 'Substations',
            'add_th' => array('0,4-10 кВ', 'підстанція'),
            'add_td' => array('type', 'body')
        ]);
    }

    /**
     * !!! STORE a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new Substation;
        $record->id = Substation::max('id') + 1;
        $record->body = $request->input('body');
        $record->type = $request->input('type');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано!');
        return Redirect::to('dicts/Substations');
    }


    /**
     * Show the form for editing the specified resource.
     *  !! EDIT
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Substation::find($id);
        return view('dicts.edit', [
            'record' => $record, 'zagolovok' => 'підстанцій',
            'dictName' => 'Substations',
            'add_th' => array('0,4-10 кВ', 'підстанція'),
            'add_td' => array('type', 'body')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ejournal\Dicts\Substantion $substation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $record_id)
    {
        $rules = array(
            'body' => 'required',
            'type' => 'required'
        );
        // далі має бути якась валідація
        // store
        $record = Substation::find($record_id);
        $record->body = $request->input('body');
        $record->type = $request->input('type');
        $record->save();

        // redirect
        Session::flash('message', 'Запис успішно змінено!');
        return Redirect::to('dicts/Substation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ejournal\Dicts\Substantion $substation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Substation::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено підстанцію ' . $msgtxt);
        return Redirect::to('dicts/Substations');
    }
}
