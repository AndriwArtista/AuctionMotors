<?php

namespace Database\Factories;

use App\Models\Lance;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'valor_ofertado' => fake()->randomFloat(2, 10000, 100000),
            'veiculo_id' => Veiculo::factory(),
            'user_id' => User::factory(),
            'nome_licitante' => fn (array $atributos) => User::find($atributos['user_id'])->nome,
        ];
    }
}
