<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VeiculosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('veiculos')->insert([
            [
                'marca' => 'Toyota',
                'modelo' => 'Corolla XEi 2.0',
                'ano' => 2021,
                'kilometragem' => 45000,
                'valor_inicial' => 85000.00,
                'status' => 'Aberto',
                'data_encerramento' => Carbon::now()->addDays(7),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1
            ],
            [
                'marca' => 'Honda',
                'modelo' => 'Civic Touring 1.5 Turbo',
                'ano' => 2020,
                'kilometragem' => 62000,
                'valor_inicial' => 92000.00,
                'status' => 'Aberto',
                'data_encerramento' => Carbon::now()->addDays(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1
            ],
            [
                'marca' => 'Jeep',
                'modelo' => 'Compass Longitude 1.3 Turbo',
                'ano' => 2022,
                'kilometragem' => 28000,
                'valor_inicial' => 115000.00,
                'status' => 'Aberto',
                'data_encerramento' => Carbon::now()->addDays(5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1
            ],
        ]);
    }
}
