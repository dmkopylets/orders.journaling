@extends('layouts.app')
@livewireStyles
@section('content')
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}"/>
    <link rel="stylesheet"
          href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}"/><!-- для календариків з годинником -->
    <div class="container">
        <div class="jumbotron mt-3" style="padding-top: 0; margin-top:0;">
            {{ Form::model('Order', array('url' => array('orders/'.$orderRecord->id.'/editPart2'), 'method' => 'POST')) }}
            @csrf
            @method('POST')
            @include('orders.edit.hidenFields')  <!-- підключаємо приховані поля вводу для обміну з js  -->
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="text-lg-left">
                <div class="row">
                    <div class="col-md-3"><p class="lead" style="font-size: 12pt;">підприємство</p></div>
                    <div class="col-md-6"><h3 style="font-size: 14pt;">АТ "ANYENERGO" {{'mode='.$orderRecord->editMode}}</h3></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><p class="lead" style="font-size: 12pt;">підрозділ</p></div>
                    <div class="col-md-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <label style="font-size: 14pt;" for="district">{{$branch->body}}</label>&nbsp<label>,
                                    дільниця:</label>&nbsp
                            </div>
                            <select style="width:80px; height: 12pt; font-size: 10pt;  vertical-align:bottom;"
                                    id="district" name="district" required>
                                @foreach($units as $unit)
                                    <option
                                        @if (($orderRecord->editMode !=='create') and ($unit->id === $orderRecord->unitId))
                                            {{' selected = "true" '}}
                                        @endif
                                        VALUE="{{$unit->id}}">{{$unit->body}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-lg-center" style="padding-top:0; margin-top:0;">
                <h1 style="font-size: 16pt;">НАРЯД-ДОПУСК</h1>
                <p class="lead">(Для виконання робіт в електроустановках)</p>
            </div>

            <div class="row">
                @include('orders.edit.editPart1_RightPanel')  <!-- Права Панелька з чекбоксами вибору членів бригади  -->

                <!-- Ліва частина "робоча частина"  -->
                <div class="col-md-8 order-md-1">
                    @include('orders.edit.editPart1_BrigadeBody')            <!-- "хто робитиме"  -->
                    <!-- "що і де робити"  // вибір select-ами ктп...
                    визов "фрейма" edit.f4_direction-task виконується через livewire-контролер direction-task = DirectionTask -->
                    @livewire('edit-part1-direction-task', [
                    'orderRecord' => $orderRecord,
                    ])
                </div>
            </div>

            <hr class="mb-4">  <!-- просто розділова горизонтальн рисочка через всю форму -->
            @include('orders.edit.editPart1_Calendares')
            <hr class="mb-4">  <!-- просто розділова горизонтальн рисочка через всю форму -->

            <button
                class="btn btn-primary btn-lg btn-block"
                type="submit"
                method = "POST"
            >Далі Заходи щодо підготовки робочих місць =>
            </button>
            {{ Form::close() }}
        </div>
    </div>

    @include('orders.edit.editPart1_js')
    @livewireScripts
@endsection

