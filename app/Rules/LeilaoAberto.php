<?php

namespace App\Rules;

use App\Models\Veiculo;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LeilaoAberto implements ValidationRule
{
    public function __construct(
        private ?Veiculo $veiculo,
        private ?int $userId,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->veiculo) {
            $fail('Veículo inválido.');
            return;
        }

        if ($this->veiculo->user_id === $this->userId) {
            $fail('Você não pode dar lance no seu próprio veículo.');
            return;
        }

        if (!$this->veiculo->estaAberto()) {
            $fail('Esse leilão já foi encerrado.');
        }
    }
}
