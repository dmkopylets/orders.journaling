<div class="edit-part2-preparation">
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    <h4 class="mb-3" style="margin-bottom: 0; vertical-align: bottom; line-height: 1pt;">Таблиця 1</h4>
    <h3 class="py-2 text-lg-center" style="margin-top: 10px; background: rgb(24, 38, 51);  color: white; "><b>Заходи
            щодо підготовки робочих місць</b></h3>

    <table class="table  table-bordered table-sm" style="margin-top:0; margin-bottom: 1px;">
        <thead class="thead-dark">
        <tr valign="middle" align="center">
            <th scope="col" width="320px"> Назва електроустановок, у яких треба <br/> провести вимкнення і встановити
                <br/> заземлення
            </th>
            <th scope="col" width="580px" style="vertical-align: center;">Що повинно бути вимкнене і де заземлено</th>
            <th scope="col" style="vertical-align: center;">дії</th>
        </tr>
        <tr align="center">
            <th> 1</th>
            <th> 2</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if ($countRowPreparations > 0)
            @foreach ($preparations as $prrow)
                <tr>
                    <td>
                        {{$prrow['preparationTargetObj']}}
                    </td>
                    <td>
                        {{$prrow['preparationBody']}}
                    </td>
                    <td>
                        <button wire:click="editPreparation({{$prrow['id']}})" class="btn btn-primary btn-sm"><i
                                class="fa fa-pencil fa-fw"></i>{{$prrow['id']}}</button>
                        <button wire:click="$emit('destroyPreparation',{{$prrow['id']}})" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" align="center">
                    Немає передбачених заходів.
                </td>
            </tr>
        @endif
        @if($updatePreparation)
            @include('orders.edit.preparation.update')
        @else
            @include('orders.edit.preparation.create')
        @endif
        </tbody>
    </table>
</div>
