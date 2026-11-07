<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|min:3|max:50|unique:users,nome',
            'email' => 'required|email|max:255|unique:users,email',
            'senha' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe seu nome.',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'nome.max' => 'O nome pode ter no máximo 50 caracteres.',
            'nome.unique' => 'Esse nome já está em uso.',
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Já existe uma conta com esse e-mail.',
            'senha.required' => 'Informe uma senha.',
            'senha.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'senha.confirmed' => 'As senhas não conferem.',
        ];
    }
}
