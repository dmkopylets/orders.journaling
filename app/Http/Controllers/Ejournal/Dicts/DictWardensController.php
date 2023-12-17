<?php

namespace App\Http\Controllers\Ejournal\Dicts;

use App\Http\Controllers\Ejournal\BaseController;
use App\Model\Ejournal\Dicts\Warden;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DictWardensController extends BaseController
{
    /**
     * Display a listing of the resource.
     *   !!! INDEX
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $this->currentUser->userBranch;
        $branch_id = $branch->id;
        $searchMybody =  '%'.$request->input('searchMybody').'%';
        $searchMygroup =  '%'.$request->input('searchMygroup').'%';
        $records = Warden::
            where('branch_id',$branch_id)->
            where('group','like',$searchMygroup)->
            where('body','like',$searchMybody)->
            orderBy('body')->get();
        return view('dicts.index', [
            'branchName'=>$branch->body,
            'records'=>$records,
            'zagolovok'=>'керівників',
            'dictName'=>'Wardens',
            'modelName'=> 'App\Model\Ejournal\Dicts\Warden',
            'add_th'=>array('керівник','група'),
            'add_td'=>array('body','group'),
            'th_width'=>array(305,70)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *   !!! CREATE
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dicts.create', [
            'zagolovok'=>'керівників',
            'modelName'=> 'App\Model\Ejournal\Dicts\Warden',
            'dictName'=>'Wardens',
            'add_th'=>array('П.І.Б.','група'),
            'add_td'=>array('body','group')]);
    }

    /**
     * !! Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new Warden;
        $record->branch_id = \App\Model\Ejournal\Dicts\Branch::dataFromLoginPrefix()->id;

        //$record->id = Warden::find($id)->increment('read_count');
        $record->id = Warden::max('id')+1;
        $record->body = $request->input('body');
        $record->group = $request->input('group');
        $record->save();
        // redirect
        Session::flash('message', 'Запис успішно додано керівника : <i>'.$record->body.'</i>');
        return Redirect::to('dicts/Wardens');
    }

     /**
     * Show the form for editing the specified resource.
     * !! EDIT
     * @param  \App\Model\Ejournal\Dicts\Warden $warden
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Warden::find($id);
        return view('dicts.edit', ['record'=>$record,'zagolovok'=>'керівників','dictName'=>'Wardens','modelName'=> 'App\Model\Ejournal\Dicts\Warden','add_th'=>array('П.І.Б.','група'),'add_td'=>array('body','group')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ejournal\Dicts\Warden  $warden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $record_id)
    {
    $record = Warden::find($record_id);
    $record->body       = $request->input('body');
    $record->group      = $request->input('group');
    $record->save();

    // redirect
    Session::flash('message', 'Запис № '.$record_id.' успішно змінено!');
    return Redirect::to('dicts/Wardens');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ejournal\Dicts\Warden  $warden
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Warden::find($id);
        $msgtxt = $record->body;
        $record->delete();

        // redirect
        Session::flash('message', 'Успішно видалено керівника: '.$msgtxt);
        return Redirect::to('dicts/Wardens');
    }
}
