<?php

namespace Database\Seeders;

use App\Models\Lance;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Seeder;

class LancesSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all();

        foreach (Veiculo::all() as $veiculo) {
            $licitantes = $usuarios->where('id', '!=', $veiculo->user_id);
            $quantidade = fake()->numberBetween(0, 6);

            $valor = (float) $veiculo->valor_inicial;
            $fim = $veiculo->data_encerramento->isPast() ? $veiculo->data_encerramento->copy() : now();
            $inicio = $fim->copy()->subDays(7);

            for ($i = 0; $i < $quantidade; $i++) {
                $valor = round($valor * fake()->randomFloat(3, 1.01, 1.05), 2);
                $momento = fake()->dateTimeBetween($inicio, $fim);
                $inicio = $momento;

                Lance::factory()->create([
                    'veiculo_id' => $veiculo->id,
                    'user_id' => $licitantes->random()->id,
                    'valor_ofertado' => $valor,
                    'created_at' => $momento,
                    'updated_at' => $momento,
                ]);
            }
        }

        $nivus = Veiculo::where('modelo', 'Nivus Highline 1.0 TSI')->first();
        $maior = Lance::where('veiculo_id', $nivus->id)->max('valor_ofertado') ?? $nivus->valor_inicial;
        $momento = $nivus->data_encerramento->copy()->subMinute();

        Lance::factory()->create([
            'veiculo_id' => $nivus->id,
            'user_id' => 1,
            'valor_ofertado' => round($maior * 1.03, 2),
            'created_at' => $momento,
            'updated_at' => $momento,
        ]);
    }
}
