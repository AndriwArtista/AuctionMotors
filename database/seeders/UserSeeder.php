<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
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

        User::factory(8)->create();
    }
}
