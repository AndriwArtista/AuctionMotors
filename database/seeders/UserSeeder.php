<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nome' => 'fulano',
                'email' => 'fulano@exemplo.com',
                'senha' => bcrypt('teste123')
            ],
            [
                'nome' => 'fulano2',
                'email' => 'fulano2@exemplo.com',
                'senha' => bcrypt('teste123')
            ],
        ]);
    }
}
