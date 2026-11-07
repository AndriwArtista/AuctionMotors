<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // usuarios fixos pra usar na apresentacao (senha: teste123)
        // o fulano e o administrador (unico que gerencia as categorias)
        $admin = User::create([
            'nome' => 'fulano',
            'email' => 'fulano@exemplo.com',
            'senha' => bcrypt('teste123'),
        ]);
        $admin->is_admin = true;
        $admin->save();

        User::create([
            'nome' => 'fulano2',
            'email' => 'fulano2@exemplo.com',
            'senha' => bcrypt('teste123'),
        ]);

        // mais alguns usuarios aleatorios pra ter licitantes
        User::factory(8)->create();
    }
}
