<?php

declare(strict_types=1);

namespace App\Http\Requests;

class EditOrderPart2Request  extends OrderEditRequest
{
    public function rules()
    {
        return [
            'preparationTargetObj' => 'required',
            'preparationBody' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'preparationTargetObj' => 'Не вибрано станції',
            'preparationBody.required' => 'Не вказано що робити',
        ];
    }
}
