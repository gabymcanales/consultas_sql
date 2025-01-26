<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedidos>
 */
class PedidosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //se usa faker para genera nombres  más reales
            'producto' => $this->faker->word, // Nombre del producto
            'cantidad' => $this->faker->numberBetween(1, 100), // Cantidad entre 1 y 100
            'total' => $this->faker->randomFloat(2, 10, 1000), // Total entre 10.00 y 1000.00
            'id_usuario' => Usuarios::query()->inRandomOrder()->value('id') ?? Usuarios::factory(), // Toma un usuario existente o crea uno nuevo
        ];
    }
}
