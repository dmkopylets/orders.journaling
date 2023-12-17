
<nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Журнал нарядів</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{asset('/')}}">На старт<span class="sr-only">(current)</span></a>
      </li>


        <!--if ($mode=='show')
          <li class="nav-item">
          <a class="nav-link" href=" asset('orders').'/'.$naryad->id.'/pdf' " tabindex="-1" >Друк (pdf)</a>
        </li>
        endif -->

      <li class="nav-item dropup">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Довіднички</a>
        <div class="dropdown-menu" aria-labelledby="dropdown10">
            <a class="dropdown-item" href="{{asset('dicts/Branches')}}">Філії</a>
            <a class="dropdown-item" href="{{asset('dicts/Units')}}">Дільниці філії</a>
            <a class="dropdown-item" href="{{asset('dicts/Wardens')}}">Керівники</a>
            <a class="dropdown-item" href="{{asset('dicts/Adjusters')}}">Допускачі</a>
            <a class="dropdown-item" href="{{asset('dicts/BrigadeMembers')}}">члени бригади</a>
            <a class="dropdown-item" href="{{asset('dicts/BrigadeEngineers')}}">машиністи-стропальщики</a>
            <a class="dropdown-item" href="{{asset('dicts/Substations')}}">підстанції</a>
            <a class="dropdown-item" href="{{asset('dicts/Lines')}}">лінії</a>
            <a class="dropdown-item" href="{{asset('dicts/Tasks')}}">типові Завдання</a>
        </div>
      </li>
    </ul>
  </div>

  <strong>
    <div class="d-inline-block" style="float: right; margin-right: 30px;">
        <a class="btn btn-small btn-outline-info" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        style="color:rgb(182, 38, 12); text-decoration: none; font-style:italic;">
             {{ __('Вийти ') }} <i class="fa fa-sign-out" aria-hidden="true"></i></a>

         <form id="logout-form" action="#" method="POST" style="display: none;">
             @csrf
         </form>
     </div>
    </strong>

</nav>





