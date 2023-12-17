<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class OrderEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Validator $validator
     * @trows HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
        $errorMessage = '';
        foreach ($validator->messages()->all() as $messageBag) {
            $errorMessage .= $messageBag . '! ';
        }
        session()->flash('error', 'сталася помилка! ' . $errorMessage);
    }
}
