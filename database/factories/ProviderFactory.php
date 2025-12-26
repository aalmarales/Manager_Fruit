<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=> fake()->name(),
        'telefono' => fake()->numberBetween(1000,10000),
        'direccion' => fake()->address(),
        'especialidad' => fake()->name(),
        'activo' => fake()->boolean(),
        ];
    }
}
