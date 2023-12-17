@extends('layouts.app')
@section('content')
    @include('orders.edit.hidenFields')  <!-- підключаємо приховані поля вводу для обміну з js  -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}"/>
    <link rel="stylesheet"
          href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}"/><!-- для календариків з годинником -->
    <div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0">
        <div class="container jumbotron mt-3" style="padding-top: 10; margin-top:0;  margin-bottom:5px;">

            {{ Form::open() }}
            @csrf
            @method('post')

            <div class="input-group"
                 style="padding-top: 0; margin-top:0; margin-bottom: 10px; display: flex; text-align:left; ">
                <span class="input-group-text">Окремі вказівки</span>
                <textarea class="form-control  @error('separateInstructionsText') is-invalid @enderror" rows="2" id="separateInstructionsText"
                          name="separateInstructionsText"
                          aria-label="separateInstructionsText"
                          style="display: block; white-space: normal; text-align: left; text-align-last: left;">@if ($orderRecord->editMode !== 'create'){{$orderRecord->separateInstructions}}
                    @endif
         </textarea>
                @error('sep_instrs') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="row" style="margin-left:2pt; margin-right:2pt;">
                <div class="input-group flex-nowrap">
                    <div class="form-group-order-created">
                        <div class='input-group date3' id='gr_dt_order_created' data-target-input="nearest"
                             style="margin-bottom: 5px;">
                            <span class="input-group-text" id="inputGroup-order-1creator">Наряд видав:&nbsp</span>
                            <input type="text" class="form-control datetimepicker-input"
                                   id="datetime_order_created" name="datetime_order_created">
                            <div class="input-group-append" data-target="#datetime_order_created"
                                 data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text datetimepickerClear3"
                                     style="padding-top: 0; margin-top:0; margin-right: 20px;">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <span class="input-group-text" id="inputGroup-order-1creator" style="font-style: italic;">Прізвище, ініціали :</span>
                        </div>
                    </div>
                    <input class="form-control" type="text" name="inp_order_creator"
                           value="@if ($orderRecord->editMode !== 'create') {{$orderRecord->orderCreator}} @endif">
                </div>
            </div>

            <div class="row" style="margin-left:2pt; margin-right:2pt;">
                <div class="input-group flex-nowrap">
                    <div class="form-group-order-longed">
                        <div class='input-group date4' id='gr_dt_order_longed' data-target-input="nearest">
                            <span class="input-group-text" id="inputGroup-order-1longer">Наряд продовжив до:&nbsp</span>
                            <input type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker"
                                   data-target="#datetime_order_longed"
                                   id="datetime_order_longed" name="datetime_order_longed">
                            <div class="input-group-append" data-target="#datetime_order_longed"
                                 data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text datetimepickerClear4"
                                     style="padding-top: 0; margin-top:0; margin-right: 20px;">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <span class="input-group-text" id="inputGroup-order-1longer" style="font-style: italic;">Прізвище, ініціали :</span>
                        </div>
                    </div>
                    <input type="text" class="form-control" style="margin-bottom:30pt;" name="inp_order_longer"
                           value="@if ($orderRecord->editMode !== 'create') {{$orderRecord->orderLonger}}  @endif">
                </div>
            </div>

            <div class="row" style="margin-left:2pt; margin-right:2pt;">
                <!--  кнопки переходу "назад-вперед" з методом POST -->
                <div style="margin-right:600pt;">
                    <button type="submit"
                            class="fa-hover btn btn-warning"
                            formaction="{{url('orders/' . $orderRecord->id . '/reEditPart2')}}"
                            formmethod="post">
                        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> назад
                    </button>
                </div>

                <div style="float: right; margin-right: 10px;">
                    <button type="submit"
                            class="fa-hover btn btn-info" style="float: right;"
                            formaction="{{url('orders/' . $orderRecord->id . '/editPart4')}}"
                            formmethod="post">
                        далі <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
                </div>
            </div>

            {{ Form::close() }}
        </div> <!-- end conteiner  -->
    </div>

    @include('orders.edit.editPart3_js')
@endsection
