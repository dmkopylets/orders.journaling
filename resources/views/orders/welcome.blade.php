@extends('layouts.app')
@section('content')


<div class="relative flex items-top justify-center min-h-screen  sm:items-center sm:pt-0">
    <div class="container jumbotron">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-success">{{ $userName }}, вітаннячки! {{$userLogin}}

                    <div class="d-inline-block" >
                        <a  style="color:rgb(38, 0, 255); text-decoration: none; font-style:italic;">
                             {{ __('('.$userBranch->body.')')}}</a>
                     </div>
                </strong>

                <h1>Зараз Ви в "Електронному Журналі нарядів"</h1>
                <p class="mb-1 text-muted"><br> </p>
                <a class="btn btn-lg btn-primary" href="{{asset('orders/precreate')}}" role="button">Створити новий наряд &raquo;</a>
                <br/>
                <p class="mb-1 text-muted"><br> </p>
                    <br>
                    <div class="alert alert-success" role="alert">
                          <a href="{{asset('/').'orders/'}}"> Перегляд Журналу нарядів </a>
                    </div>
            </div>
                <div class="col-auto d-none d-lg-block" style="position:relative; margin: 10px;"  width=170px; height=220px >
                         <img src="{{asset('img/demotiv.jpg')}}" class="card-img-right"  style="margin: 25px;"  width="154px" height="200px"  focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/>

               </div>
        </div>
       </div>
    </div>
   <script type="text/javascript" src="{{asset('js/jquery.min.js')}}" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
   <script type="text/javascript" src="{{ asset('js/bootstrap.min.js')}}" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
@endsection
