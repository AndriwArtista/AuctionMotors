<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Seeder;

class VeiculosSeeder extends Seeder
{
    public function run(): void
    {
        $carro = Categoria::where('nome', 'Carro')->first();
        $suv = Categoria::where('nome', 'SUV')->first();

        Veiculo::create([
            'marca' => 'Toyota',
            'modelo' => 'Corolla XEi 2.0',
            'ano' => 2021,
            'kilometragem' => 45000,
            'valor_inicial' => 85000.00,
            'status' => 'aberto',
            'data_encerramento' => now()->addDays(7),
            'user_id' => 1,
            'categoria_id' => $carro->id,
        ]);

        Veiculo::create([
            'marca' => 'Honda',
            'modelo' => 'Civic Touring 1.5 Turbo',
            'ano' => 2020,
            'kilometragem' => 62000,
            'valor_inicial' => 92000.00,
            'status' => 'aberto',
            'data_encerramento' => now()->addDays(10),
            'user_id' => 1,
            'categoria_id' => $carro->id,
        ]);

        Veiculo::create([
            'marca' => 'Jeep',
            'modelo' => 'Compass Longitude 1.3 Turbo',
            'ano' => 2022,
            'kilometragem' => 28000,
            'valor_inicial' => 115000.00,
            'status' => 'aberto',
            'data_encerramento' => now()->addDays(5),
            'user_id' => 2,
            'categoria_id' => $suv->id,
        ]);

        $usuarios = User::all();
        $categorias = Categoria::all();

        for ($i = 0; $i < 22; $i++) {
            $factory = Veiculo::factory()
                ->daCategoria($categorias->random())
                ->state(['user_id' => $usuarios->random()->id]);

            if ($i < 6) {
                $factory = $factory->vencido();
            }

            $factory->create();
        }
    }
}
