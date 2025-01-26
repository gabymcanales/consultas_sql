<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->name; // Genera un nombre aleatorio
        return [
            'nombre' => $nombre,
            'correo' => strtolower(str_replace(' ', '.', $nombre)) . '@example.com', // Correo basado en el nombre generado
            'telefono' => $this->faker->numerify('503-####-####'), // codigo de pais y Número de 8 dígitos
        ];
    }
}
