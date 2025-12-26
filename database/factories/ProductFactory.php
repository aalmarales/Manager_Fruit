<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'nombre' => fake()->name(),
        'precio_compra' => fake()->numberBetween(1,10),
        'precio_venta' => fake()->numberBetween(11,20),
        'dias_caducidad' => fake()->numberBetween(5,30),
        'provider_id' => fake()->numberBetween(1,20),
        'category_id' => fake()->numberBetween(1,10),
        ];
    }
}
