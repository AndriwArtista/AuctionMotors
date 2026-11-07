<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $anoMaximo = now()->year + 1;

        $regras = [
            'marca' => 'required|string|min:2|max:50',
            'modelo' => 'required|string|min:1|max:100',
            'ano' => "required|integer|min:1900|max:{$anoMaximo}",
            'kilometragem' => 'required|integer|min:0',
            'valor_inicial' => 'required|numeric|min:0|max:99999999',
            'data_encerramento' => 'required|date',
        ];

        // no cadastro o leilao tem que terminar no futuro
        if ($this->isMethod('post')) {
            $regras['data_encerramento'] .= '|after:now';
        }

        return $regras;
    }

    public function messages(): array
    {
        return [
            'marca.required' => 'Informe a marca do veículo.',
            'marca.min' => 'A marca deve ter pelo menos 2 letras.',
            'marca.max' => 'A marca pode ter no máximo 50 caracteres.',
            'modelo.required' => 'Informe o modelo do veículo.',
            'modelo.max' => 'O modelo pode ter no máximo 100 caracteres.',
            'ano.required' => 'Informe o ano do veículo.',
            'ano.integer' => 'O ano deve ser um número.',
            'ano.min' => 'O ano deve ser a partir de 1900.',
            'ano.max' => 'O ano não pode ser maior que ' . (now()->year + 1) . '.',
            'kilometragem.required' => 'Informe a kilometragem.',
            'kilometragem.integer' => 'A kilometragem deve ser um número inteiro.',
            'kilometragem.min' => 'A kilometragem não pode ser negativa.',
            'valor_inicial.required' => 'Informe o valor inicial do leilão.',
            'valor_inicial.numeric' => 'O valor inicial deve ser um número.',
            'valor_inicial.min' => 'O valor inicial não pode ser negativo.',
            'valor_inicial.max' => 'O valor inicial é alto demais.',
            'data_encerramento.required' => 'Informe a data de encerramento do leilão.',
            'data_encerramento.date' => 'Informe uma data válida.',
            'data_encerramento.after' => 'A data de encerramento precisa ser no futuro.',
        ];
    }
}
