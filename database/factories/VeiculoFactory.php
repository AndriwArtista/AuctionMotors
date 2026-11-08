<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeiculoFactory extends Factory
{
    public const CATALOGO = [
        'Carro' => [
            ['Toyota', 'Corolla XEi 2.0', 85000],
            ['Honda', 'Civic EXL 2.0', 95000],
            ['Volkswagen', 'Gol 1.0', 35000],
            ['Chevrolet', 'Onix LT 1.0 Turbo', 62000],
            ['Fiat', 'Argo Drive 1.3', 55000],
            ['Hyundai', 'HB20 Comfort 1.0', 58000],
        ],
        'SUV' => [
            ['Jeep', 'Compass Longitude 1.3 Turbo', 115000],
            ['Jeep', 'Renegade Sport 1.3', 90000],
            ['Hyundai', 'Creta Limited 1.0 Turbo', 105000],
            ['Volkswagen', 'T-Cross Highline 1.4', 120000],
            ['Toyota', 'SW4 SRX 2.8 Diesel', 290000],
        ],
        'Caminhonete' => [
            ['Toyota', 'Hilux SRV 2.8 Diesel', 210000],
            ['Ford', 'Ranger XLT 3.2', 180000],
            ['Fiat', 'Toro Volcano 2.0 Diesel', 150000],
            ['Chevrolet', 'S10 LTZ 2.8', 190000],
        ],
        'Moto' => [
            ['Honda', 'CG 160 Titan', 15000],
            ['Yamaha', 'MT-03', 28000],
            ['Honda', 'CB 500F', 35000],
            ['Kawasaki', 'Ninja 400', 32000],
        ],
        'Caminhão' => [
            ['Volvo', 'FH 540', 650000],
            ['Scania', 'R 450', 600000],
            ['Mercedes-Benz', 'Accelo 1016', 280000],
        ],
    ];

    public function definition(): array
    {
        [$marca, $modelo, $valor] = fake()->randomElement(self::CATALOGO['Carro']);

        return array_merge($this->dadosBase($marca, $modelo, $valor), [
            'user_id' => User::factory(),
            'categoria_id' => Categoria::factory(),
        ]);
    }

    public function daCategoria(Categoria $categoria): static
    {
        return $this->state(function () use ($categoria) {
            $opcoes = self::CATALOGO[$categoria->nome] ?? self::CATALOGO['Carro'];
            [$marca, $modelo, $valor] = fake()->randomElement($opcoes);

            return array_merge($this->dadosBase($marca, $modelo, $valor), [
                'categoria_id' => $categoria->id,
            ]);
        });
    }

    public function vencido(): static
    {
        return $this->state(fn () => [
            'data_encerramento' => fake()->dateTimeBetween('-10 days', '-1 hour'),
        ]);
    }

    private function dadosBase(string $marca, string $modelo, int $valor): array
    {
        $ano = fake()->numberBetween(2012, now()->year);
        $idade = now()->year - $ano;

        return [
            'marca' => $marca,
            'modelo' => $modelo,
            'ano' => $ano,
            'kilometragem' => $idade * fake()->numberBetween(8000, 18000) + fake()->numberBetween(0, 5000),
            'valor_inicial' => round($valor * (1 - min($idade, 10) * 0.05) * fake()->randomFloat(2, 0.9, 1.1), -2),
            'data_encerramento' => fake()->dateTimeBetween('+1 day', '+20 days'),
            'status' => 'aberto',
        ];
    }
}
