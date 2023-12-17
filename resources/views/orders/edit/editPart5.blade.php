@extends('layouts.app')
@section('content')
    @include('orders.edit.hidenFields')  <!-- підключаємо приховані поля вводу для обміну з js  -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}"/>
    {{ Form::open() }}
    @csrf
    @method('post')

    <div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0">
        <div class="input-group"
             style="padding-top: 0; margin-top:0; margin-bottom: 10px; display: flex; text-align:left; ">

            <button type="submit"
                    class="fa-hover btn btn-warning input-group-text  ml-auto  align-self-center "
                    style="align-items: flex-end;"
                    formaction="{{url('orders/' . $orderRecord->id . '/reEditPart4')}}"
                    formmethod="post">
                <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> назад
            </button>

            <div class="container jumbotron mt-3"
                 style="padding-top: 2; margin-left:13px; margin-top:0;  margin-bottom:5px;">


                <div class="bblock">Робочі місця підготовлені.</div>
                <div class="input-group"
                     style="padding-top: 0; margin-top:0; margin-bottom: 10px; display: flex; text-align:left; ">
                    <span class="input-group-text">Під напругою залишились:</span>
                    <textarea class="form-control" rows="2" name="under_voltage_txt" aria-label="under_voltage_txt"
                              style="display: block; white-space: normal; text-align: left; text-align-last: left;">
                     @if ($orderRecord->editMode !== 'create')
                            {{$orderRecord->underVoltage}}
                        @endif
                  </textarea>
                </div>


                <hr class="mb-4">  <!-- просто розділова горизонтальн рисочка через всю форму -->

                <div style="float: center; margin-right: 1px;">
                    <button type="submit"
                            class="fa-hover btn btn-info btn-lg btn-block" style="float: right;"
                            formaction="{{route('orders.store')}}"
                            formmethod="post">
                        <i class="fa fa-save fa-fw" aria-hidden="true"></i> Зберегти ВСЕ!!!
                    </button>
                </div>

            </div> <!-- end conteiner  -->
        </div>
    </div>
    {{ Form::close() }}

@endsection
