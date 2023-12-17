<!-- останній рядок в Табл.2 = форма додавання запису в масив "надавачі дозволу на підготовку робочих місць ..." -->
<tr>
    <td style="padding: 0 0 0 0">
      <div class="dropright input-group flex-nowrap">
            <input type="text" class="form-control @error('licensor') is-invalid @enderror" id="meashureLicensor" placeholder="<- введіть дані" wire:model="licensor">
      </div>
    </td>
    <td style="padding: 0 0 0 0">
      <div class="input-group flex-nowrap">

          <div class='input-group date3' id='groupDateMeashureLicense' data-target-input="nearest"
               style="margin-bottom: 5px;">

              <input type="text" class="form-control datetimepicker-input @error('datetimeLicense') is-invalid @enderror"
                     id="datetimeLicense" name="datetimeLicense"
                     placeholder="<- введіть дату" wire:model="datetimeLicense">
              <div class="input-group-append" data-target="#datetimeLicense"
                   data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
              <div class="input-group-append">
                  <div class="input-group-text datetimepickerClear"
                       style="padding-top: 0; margin-top:0; margin-right: 20px;">
                      <i class="fa fa-times"></i>
                  </div>
              </div>
          </div>

      </div>
    </td>
    <td style="padding: 0 0 0 0">
        <button wire:click="meashureStore()"
             class="btn btn-primary"
             type = "submit"
             name = "meashureStore"
             style="margin-right: 3px;>
          <span class="caret"><i class="fa fa-save fa-fw"></i>+</span></button>
      </div>
    </td>
   </tr>
    <tr>
        <td>@error('licensor') <span class="text-danger">{{ $message }}</span>@enderror</td>
        <td>@error('datetimeLicense') <span class="text-danger">{{ $message }}</span> @enderror</td>
    </tr>

