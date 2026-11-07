<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // usuarios fixos pra usar na apresentacao (senha: teste123)
        User::create([
            'nome' => 'fulano',
            'email' => 'fulano@exemplo.com',
            'senha' => bcrypt('teste123'),
        ]);

        User::create([
            'nome' => 'fulano2',
            'email' => 'fulano2@exemplo.com',
            'senha' => bcrypt('teste123'),
        ]);

        // mais alguns usuarios aleatorios pra ter licitantes
        User::factory(8)->create();
    }
}
