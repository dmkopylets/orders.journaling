@extends('layouts.app')
@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif


<div class="container">
    <h2><strong>Електронний Журнал нарядів ({{$branch->body}})</strong></h2>
    <div class="flex-center position-ref full-height">
        <form class="grid_with_search">
            <div class="col-md-12">
                <table class="table table-fixed table-striped table-bordered" id="orders-table"  style="margin: 10px 0 10px 0;">
                    <thead>
                    <tr>
                        <th scope="col" width="50px">#</th>
                        <th scope="col" width="120px">створено</th>
                        <th scope="col" width="130px"><input type="text" name="searchWarden" id="searchWarden" class="form-control" value="<?php echo isset($_REQUEST['searchWarden'])?$_REQUEST['searchWarden']:''?>" placeholder="керівник"></th>
                        <th scope="col" width="130px"><input type="text" name="searchTerm"   id="searchTerm" class="form-control" value="<?php echo isset($_REQUEST['searchTerm'])?$_REQUEST['searchTerm']:''?>" placeholder="підстанція"></th>
                        <th scope="col">завдання</th>
                        <th scope="col" width="202px">
                        <div>
                            <button href="#" type="submit" name="search" value="search" id="search" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Пошук</button>
                        </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody style="height: 600px;">
                    @foreach($records as $record)
                        <th scope="row" width="50px">{{$record->id}}</th>
                        <td width="120px">{{$record->order_date}}</td>
                        <td width="130px">{{$record->warden}}</td>
                        <td width="130px">{{$record->substation}}</td>
                        <td>{{$record->tasks}}</td>
                        <td width="190px">
                            <a class="btn btn-danger btn-sm" href="{{asset('/').'orders/'.$record->id.'/clone'}}"><i class="fa fa-pencil fa-fw"></i>клон</a>
                            &nbsp&nbsp
                            <a class="btn btn-info btn-sm"  href="{{asset('/').'orders/'.$record->id.'/pdf'}}"><i class="fa fa-eye fa-lg" ></i>&nbsp;друк</a>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $records->links() }}
        </form>
</div>
</div>
@include('layouts.bootstrapjs')
@endsection
