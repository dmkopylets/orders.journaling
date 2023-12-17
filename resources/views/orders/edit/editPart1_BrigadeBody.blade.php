 <div class="row">
        <div class="col-md-3">
            <p class="lead" style="font-size: 10pt;">Керівнику робіт (наглядачу)</p>
        </div>
        <div class="col-md-6 col-lg-9">
            <select class="custom-select d-block w-100" id="warden" name="warden" required>
                @foreach($wardens as $warden)
                    @if ($orderRecord->editMode!=='create')
                      <option  <?php  if ($warden->id === $orderRecord->wardenId) {echo ' selected="true"';} ?> VALUE="{{$warden->id}}"> {{$warden->body.', '.$warden->group}}</option>
                    @else
                      <option VALUE="{{$warden->id}}">{{$warden->body.', '.$warden->group}}</option>
                    @endif
                @endforeach
            </select>
            <span class="text-muted"><i>(прізвище, ініціали, група з електробезпеки)</i></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <p class="lead" style="font-size: 10pt;">допускачу</p>
        </div>
        <div class="col-md-6 col-lg-9">
            <select class="custom-select d-block w-100" id="adjuster" name="adjuster" required>
                @foreach($adjusters as $adjuster)
                  @if ($orderRecord->editMode!=='create')
                    <option <?php if ($adjuster->id === $orderRecord->adjusterId) {echo ' selected="true"';} ?> VALUE="{{$adjuster->id}}">{{$adjuster->body.', '.$adjuster->group}}</option>
                  @else
                    <option VALUE="{{$adjuster->id}}">{{$adjuster->body.', '.$adjuster->group}}</option>
                  @endif
                @endforeach
            </select>
            <span class="text-muted"><i>(прізвище, ініціали, група з електробезпеки)</i></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="brigade_members"  style="font-size: 10pt;">з членами бригади: </label>
        </div>
        <div class="col-md-6 col-lg-9">
            <textarea class="form-control" id="brigade_members" name="brigade_members" rows="5"> @if ($orderRecord->editMode!=='create') {{trim($teamList)}} @endif </textarea>
            <span class="text-muted"><i>(прізвище, ініціали, група з електробезпеки)</i></span>
        </div>
    </div>



