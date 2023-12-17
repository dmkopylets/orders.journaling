<?php

declare(strict_types=1);

namespace App\Http\Requests;

class EditOrderPart4Request  extends OrderEditRequest
{
    public function rules(): array
    {
        return [
            'licensor'=>'required',
            'datetimeLicense'=>'required'
        ];
    }
    public function messages(): array
    {
        return [
            'licensor.required'=>'Не вказано хто дав дозвіл на підготовку',
            'datetimeLicense.required'=>'Не вказано дати дозвілу'
        ];
    }
}
