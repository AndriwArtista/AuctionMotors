<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text_email' => 'required|email|min:10',
            'text_senha' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'text_email.required' => 'O campo e-mail é obrigatório.',
            'text_email.email' => 'O campo de e-mail deve conter um endereço válido.',
            'text_email.min' => 'O campo e-mail deve ter no mínimo 10 caracteres',

            'text_senha.required' => 'O campo senha é obrigatório.',
            'text_senha.min' => 'O campo senha deve ter no mínimo 6 caracteres',
        ];
    }
}
