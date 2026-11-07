<?php

namespace Database\Seeders;

use App\Services\LeilaoService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriasSeeder::class,
            VeiculosSeeder::class,
            LancesSeeder::class,
        ]);

        // fecha os leiloes que ja venceram: gera os arremates e as notificacoes
        $encerrados = app(LeilaoService::class)->encerrarVencidos();
        $this->command?->info("{$encerrados} leilões encerrados com arremate.");
    }
}
