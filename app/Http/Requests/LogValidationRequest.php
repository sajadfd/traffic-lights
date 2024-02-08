<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'The message field is required.',
        ];
    }
}
