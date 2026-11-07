<?php

namespace App\Http\Requests;

use App\Services\Operations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // na edicao ignora a propria categoria na regra de nome unico
        $id = $this->route('categoria')
            ? app(Operations::class)->decryptId($this->route('categoria'))
            : null;

        return [
            'nome' => ['required', 'string', 'min:2', 'max:50', Rule::unique('categorias', 'nome')->ignore($id)],
            'descricao' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome da categoria.',
            'nome.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'nome.max' => 'O nome pode ter no máximo 50 caracteres.',
            'nome.unique' => 'Já existe uma categoria com esse nome.',
            'descricao.max' => 'A descrição pode ter no máximo 255 caracteres.',
        ];
    }
}
