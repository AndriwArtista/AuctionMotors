<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Carro', 'descricao' => 'Hatches e sedans de passeio'],
            ['nome' => 'SUV', 'descricao' => 'Utilitários esportivos'],
            ['nome' => 'Caminhonete', 'descricao' => 'Picapes leves e médias'],
            ['nome' => 'Moto', 'descricao' => 'Motocicletas de todas as cilindradas'],
            ['nome' => 'Caminhão', 'descricao' => 'Veículos de carga'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
