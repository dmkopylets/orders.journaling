@extends('layouts.app')
@section('content')
    <div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0">
        <div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0">
            <div class="container jumbotron">
                <h2><strong>Оберіть специфіку робіт</strong></h2>
                <div class="content">
                    {{ Form::model('Order', array('url' => array('orders/createOrder'), 'method' => 'POST')) }}
                        @csrf
                        @method('get')
                        <div class="direction-task">
                            <hr class="mb-8">
                            <div class=".col-md-4 .col-md-4">
                                <div class="row">
                                    @foreach($workspecs as $workspec)
                                        &nbsp
                                        <div class="form-check form-check-inline .col-md-1">
                                            <input class="form-check-input worksSpecs" type="radio" name="direction"
                                                   value="{{$workspec['id']}}">
                                            <label class="form-check-label"
                                                   for="inlineRadio{{$workspec['id']}}">{{$workspec['body']}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr class="mb-8">
                        </div>
                        <input class="btn btn-primary" style="float: right; margin-right: 10px;" type="submit" value="Далі">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.bootstrapjs')
@endsection


