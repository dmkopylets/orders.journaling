<?php

declare(strict_types=1);

namespace App\Http\Requests\Rules;

class ContainsWord implements \Illuminate\Contracts\Validation\Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        return  strpos($value, ' виконати ');
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Текст завдання не містить слова "виконати"';
    }
}
