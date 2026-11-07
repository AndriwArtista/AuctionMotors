<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Senha padrao dos usuarios gerados (fica em cache pra nao gerar o hash toda vez).
     */
    protected static ?string $senha;

    public function definition(): array
    {
        $nome = fake()->unique()->firstName() . ' ' . fake()->lastName();

        return [
            'nome' => mb_substr($nome, 0, 50),
            'email' => fake()->unique()->safeEmail(),
            'senha' => static::$senha ??= bcrypt('teste123'),
        ];
    }
}
