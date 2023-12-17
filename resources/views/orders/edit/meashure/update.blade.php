    <input type="hidden" wire:model="meashure_id">
    <tr>
    <td>
    <div class="form-group mb-3">
        <!--label for="meashureLicensor">Видав дозвіл:</label-->
        <input type="text" class="form-control @error('licesor') is-invalid @enderror" id="meashureLicensor" wire:model="licensor" placeholder="дозвіл видав">
        @error('licensor') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    </td>
    <td>
    <div class="form-group mb-3">
        <!--label for="meashureLic_date">що вимкнути і заземлити:</label-->
        <input type="text" class="form-control @error('lic_date') is-invalid @enderror" id="meashureLic_date" wire:model="lic_date" placeholder="дата дозволу">
        <!--textarea  class="form-control #error('lic_date') is-invalid #enderror" id="meashureLic_date" wire:model="lic_date" placeholder="що виконати"></textarea-->
        @error('lic_date') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    </td>
    <td>   
        <button wire:click="meashureUpdate()" class="btn btn-success"><i class="fa fa-save fa-fw"></i></button>
        <button wire:click="cancel()" class="btn btn-danger"><i class="fa fa-ban"></i></button>
    </td>
