<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Rules\ContainsWord;

class EditOrderPart1Request extends OrderEditRequest
{
    public function rules()
    {
        return [
            'write_to_db_brigade' => 'required',
            'workslist' => ['required', 'string', new ContainsWord],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'write_to_db_brigade.required' => 'Не вибрано жодного члена бригади',
            'workslist.required' => 'Не вказано що робити',
            'workslist.ContainsWord' => 'Текст завдання не містить слова "виконати"',
        ];
    }
}
