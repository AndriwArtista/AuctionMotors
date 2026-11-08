<?php

namespace App\Http\Requests;

use App\Models\Veiculo;
use App\Rules\LeilaoAberto;
use App\Services\Operations;
use Illuminate\Foundation\Http\FormRequest;

class LanceRequest extends FormRequest
{
    private ?Veiculo $veiculo = null;

    public function authorize(): bool
    {
        return true;
    }

    public function veiculo(): ?Veiculo
    {
        if (!$this->veiculo) {
            $id = app(Operations::class)->decryptId($this->route('veiculo_id'));
            $this->veiculo = $id ? Veiculo::find($id) : null;
        }

        return $this->veiculo;
    }

    public function rules(): array
    {
        $minimo = $this->veiculo()?->valorMinimoLance() ?? 0.01;

        return [
            'valor_ofertado' => [
                'required',
                'numeric',
                "min:{$minimo}",
                new LeilaoAberto($this->veiculo(), session('user.id')),
            ],
        ];
    }

    public function messages(): array
    {
        $minimo = $this->veiculo()?->valorMinimoLance() ?? 0.01;

        return [
            'valor_ofertado.required' => 'Informe o valor do lance.',
            'valor_ofertado.numeric' => 'O lance deve ser um número.',
            'valor_ofertado.min' => 'O lance deve ser maior do que a última oferta (Mínimo: R$ ' . number_format($minimo, 2, ',', '.') . ').',
        ];
    }
}
