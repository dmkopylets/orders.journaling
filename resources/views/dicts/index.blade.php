<?php
$nom_naryad='дов. '.$zagolovok;
?>
@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/table-fixed-header.css')}}" />
<h2><strong>Електронний Журнал нарядів ({{$branchName}})</strong></h2>
<div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0"> <!-- центоровка по вертикалі -->
<div class="container">
<!-- Тут будуть "вискакувати всі повідомлення -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

  <div class="flex-center position-ref full-height">
    <div class="content">
       <form class="dictviewer1">
            <table class="table table-fixed table-striped" id="dict-table">
              <!-- Ш А П К А  -->
              <thead>
                <tr>
                    <th width="15px">#</th>

                  <!-- прорисовуємо циклом назви всіх полів, назви яких передані сюди масивом $add_th з контролера конкретної моделі (таблиці) довідника -->
                   @foreach ($add_th as  $i => $value)
                   <th class="col-xs-2" width="{{$th_width[$i]*0.75}}px">
                       <input type="text" name="searchMy{{$add_td[$i]}}" id="searchMy{{$add_td[$i]}}" class="form-control"
                        value="<?php echo isset($_REQUEST['searchMy'.$add_td[$i]])?$_REQUEST['searchMy'.$add_td[$i]]:''?>"
                        placeholder={{$add_th[$i]}}>
                   </th>
                   @endforeach
                    <th class="col-xs-2" width="275px">
                          <div style="float: right; margin-right: 5px;">
                            <!--  Отут, практично викликається перезавантаження цієї ж в'юшки, але з заповненими полями фільтрування пошуку  -->
                            <button href="#" type="submit" name="search" value="search" id="search" class="btn btn-small btn-outline-primary" >  <i class="fa fa-fw fa-search"></i> Пошук</button>
                            <a href="{{ URL::to('dicts/'.$dictName.'/create') }}" class="btn btn-small btn-outline-info" ><i class="fa fa-plus" aria-hidden="true"></i> новий запис</a>
                        </div>
                    </th>
                </tr>
              </thead>
              <!-- Д А Н І  -->
              <tbody>
                @foreach($records as $record)
                    <tr>
                        <th  width="55px">{{$record->id}} </th>
                        <!-- прорисовуємо циклом всі поля, назви яких передані сюди масивом $add_td з контролера конкретного довідника (маршрута, моделі, таблиці)  -->
                            @foreach ($add_td as $i => $value)
                                <td  width="{{$th_width[$i]*1.6}}px">{{$record->$value}} </td>
                            @endforeach
                       <td class="col-xs-2 flex">
                        <div style="float: right; margin-right: 2px;">
                           <a href="{{asset('/').'dicts/'.$dictName.'/'.$record->id.'/edit'}}" class="btn btn-outline-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> правка</a>&nbsp&nbsp
                           <a href="{{asset('/').'dicts/'.$dictName.'/'.$record->id.'/destroy'}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i> видалити</a>
                        </div>
                       </td>
                    </tr>
                @endforeach
            </tbody>
         </table>

   </form>
</div>
</div>
</div>
</div>
</body>

   <!-- Bootstrap core JavaScript-->
   <!-- Placed at the end of the document so the pages load faster -->
   <script src="{{asset('js/jquery.min.js')}}" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
   <script>window.jQuery || document.write('<script src="{{ asset('js\/jquery.min.js')}}"><\/script>')</script>
<script src="{{ asset('js/bootstrap.min.js')}}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

   <script>
     //$('#create').on('click', function (e) {
     //your awesome code here
     // })



       // Example starter JavaScript for disabling form submissions if there are invalid fields
       (function() {
           'use strict';

           window.addEventListener('load', function() {
               // Fetch all the forms we want to apply custom Bootstrap validation styles to
               var forms = document.getElementsByClassName('needs-validation');

               // Loop over them and prevent submission
               var validation = Array.prototype.filter.call(forms, function(form) {
                   form.addEventListener('submit', function(event) {
                       if (form.checkValidity() === false) {
                           event.preventDefault();
                           event.stopPropagation();
                       }
                       form.classList.add('was-validated');
                   }, false);
               });
           }, false);
       })();


   </script>

@endsection
