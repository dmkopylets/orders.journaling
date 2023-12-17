<div class="col-md-3 order-md-2 mb-3">
    <h4 class="d-flex justify-content-between align-items-lg-center mb-3">
        <span class="text-success">Бригада</span>
        @if ($orderRecord->editMode!=='create')
            <span class="badge badge-secondary badge-pill" id="countBrigade">{{$countBrigade}}</span>
        @else
            <span class="badge badge-secondary badge-pill" id="countBrigade">0</span>
        @endif
    </h4>
    <ul class="list-group mb-3" style="padding-left:20px">
        @foreach($allPossibleTeamMembers as $teamMember)
            <li class="list-group-item-brmem d-flex justify-content-between lh-condensed">
                <div>
                    @if ($orderRecord->editMode!=='create')
                        <input class="form-check-input" type="checkbox" style="padding-left:10px"
                               <?php if (in_array($teamMember['id'], explode(",", $orderRecord->brigadeMembersIds))) {
                                   echo ' checked ';
                               } ?>  id="teamMember{{$teamMember['id']}}" onclick="brig_engr_checked()">
                    @else
                        <input class="form-check-input" type="checkbox" style="padding-left:10px"
                               id="teamMember{{$teamMember['id']}}" onclick="brig_engr_checked()">
                    @endif
                    <label class="form-check-label" style="font-size: 12px;padding-left:10px"
                           for="teamMember{{$teamMember['id']}}">{{$teamMember['body']}}</label>
                </div>
            </li>
        @endforeach
        <!--  машиністи-стропальщики  -->
        @foreach($allPossibleTeamEngineer as $engineer)
            <li class="list-group-item-enineers d-flex justify-content-between lh-condensed">
                <div>
                    @if ($orderRecord->editMode!=='create')
                        <input class="form-check-input" type="checkbox"
                               <?php if (in_array($engineer['id'], explode(",", $orderRecord->brigadeEngineerIds))) {
                                   echo ' checked ';
                               } ?>  id="engineer{{$engineer['id']}}" onclick="brig_engr_checked()">
                    @else
                        <input class="form-check-input" type="checkbox" id="engineer{{$engineer['id']}}"
                               onclick="brig_engr_checked()">
                    @endif
                    <label class="form-check-label" style="font-size: 12px; color: #ef7f1a"
                           for="engineer{{$engineer['id']}}">{{$engineer['body'].' '.$engineer['specialization']}}</label>
                </div>
            </li>
        @endforeach
    </ul>
</div>

