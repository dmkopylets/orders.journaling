    <input type="hidden" wire:model="preparation_id">
    <tr>
    <td>
    <div class="form-group mb-3">
        <!--label for="preparationTarget_obj">Назва установки:</label-->
        <input type="text" class="form-control @error('preparationTargetObj') is-invalid @enderror" id="preparationTargetObj" wire:model="preparationTargetObj" placeholder="введіть підстанцію">
        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    </td>
    <td>
    <div class="form-group mb-3">
        <!--label for="preparationBody">що вимкнути і заземлити:</label-->
        <input type="text" class="form-control @error('preparationBody') is-invalid @enderror" id="preparationBody" wire:model="preparationBody" placeholder="що виконати">
        @error('body') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    </td>
    <td>
        <button wire:click="preparationUpdate()" class="btn btn-success"><i class="fa fa-save fa-fw"></i></button>
        <button wire:click="cancel()" class="btn btn-danger"><i class="fa fa-ban"></i></button>
    </td>
