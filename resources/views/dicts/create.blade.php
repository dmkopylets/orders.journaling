@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/table-fixed-header.css')}}" />

<div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0"> <!-- центоровка по вертикалі -->
<div class="container jumbotron">
<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('dicts/'.$dictName) }}">Створюємо новий запис</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('dicts/'.$dictName) }}">Повернутися до ВСІХ {{$zagolovok}}</a></li>
    </ul>
</nav>

{{ Form::open(array('url' =>  URL::to('dicts/'.$dictName))) }}
<table class="table  id="dict-table">
    <!-- Ш А П К А  -->
    <thead>
      <tr>
       <!-- прорисовуємо циклом всі назви інших полів, назви яких передані сюди масивом $add_th з контролера конкретної моделі (таблиці) довідника -->
        @foreach ($add_th as  $i => $value)
          <th class="col-xs-2">
            {{ Form::label('th_'.$add_td[$i], $add_th[$i]) }}               
          </th>
        @endforeach
        </tr>
    </thead>    
          
    <tr>    
        @foreach ($add_td as  $i => $value)
          <td class="col-xs-2">
            {{ Form::text($add_td[$i], '', array('class' => 'form-control')) }}
          </td>
        @endforeach
    </tr>
</table> 
{{ Form::submit('Зберегти зміни', array('class' => 'btn btn-primary')) }}                          
{{ Form::close() }}    
   
</div>
</div>