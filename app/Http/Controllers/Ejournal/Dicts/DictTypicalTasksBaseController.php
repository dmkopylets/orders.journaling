<?php

declare(strict_types=1);

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Model\Ejournal\Dicts\TypicalTask;
use App\Model\Ejournal\Dicts\WorksSpec;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DictTypicalTasksBaseController extends DictBaseController
{
    public function index(Request $request)
    {
        $searchMySpec = '%' . $request->input('searchMySpec') . '%';
        $searchMyBody = '%' . $request->input('searchMybody') . '%';
        $works_specs_list = WorksSpec::where('body', 'like', $searchMySpec)->pluck('id');
        $records = TypicalTask::
        select('dict_typicaltasks.id AS id', 'dict_typicaltasks.body AS body', 'dict_typicaltasks.works_specs_id AS works_specs_id', 's.body AS works_specs')
            ->leftJoin('dict_works_specs AS s', 's.id', '=', 'dict_typicaltasks.works_specs_id')
            ->whereIn('dict_typicaltasks.works_specs_id', $works_specs_list)
            ->where('dict_typicaltasks.body', 'like', $searchMyBody)
            ->orderBy('dict_typicaltasks.works_specs_id')
            ->orderBy('dict_typicaltasks.body')->get();
        return view('dicts.index', [
            'branchName' => $this->currentUser->userBranch->name,
            'records' => $records,
            'zagolovok' => 'завдання',
            'dictName' => 'Tasks',
            'add_th' => array('спеціалізація', '...виконати:'),
            'add_td' => array('works_specs', 'body'),
            'th_width' => array(100, 300)
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
            'zagolovok' => 'типових робіт',
            'dictName' => 'Tasks',
            'add_th' => array('спеціалізація', 'що зробити:'),
            'add_td' => array('works_specs', 'body')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new TypicalTask;
        $record->branch_id = $this->currentUser->userBranch->id;
        $record->id = TypicalTask::max('id') + 1;
        $record->works_spec = $request->input('works_specs');
        $record->body = $request->input('body');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано:  ' . $record->body);
        return Redirect::to('dicts/Tasks');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Ejournal\Dicts\TypicalTask $typicaltask
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = TypicalTask::
        select('dict_typicaltasks.id AS id', 'dict_typicaltasks.body AS body', 'dict_typicaltasks.works_specs_id AS works_specs_id', 's.body AS works_specs')
            ->leftJoin('dict_works_specs AS s', 's.id', '=', 'dict_typicaltasks.works_specs_id')
            ->orderBy('dict_typicaltasks.works_specs_id')
            ->orderBy('dict_typicaltasks.body')->find($id);
        return view('dicts.edit', [
            'record' => $record,
            'zagolovok' => 'типових робіт',
            'dictName' => 'Tasks',
            'add_th' => array('спеціалізація', 'що виконати'),
            'add_td' => array('works_specs', 'body')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Ejournal\Dicts\TypicalTask $typicaltask
     * @return \Illuminate\Http\Response
     */
    public function update($record_id, Request $request)
    {
        $record = TypicalTask::find($record_id);
        $record->works_spec = $request->input('works_specs');
        $record->body = $request->input('body');
        $record->save();

        // redirect
        Session::flash('message', 'Запис № ' . $record_id . ' успішно змінено!');
        return Redirect::to('dicts/Tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Ejournal\Dicts\TypicalTask $typicaltask
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = TypicalTask::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено: ' . $msgtxt);
        return Redirect::to('dicts/Tasks');
    }
}
