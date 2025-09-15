<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * População do banco de dados de pedidos: cliente, total, status.
     */
    public function definition(): array
    {
        return [
            'cliente' => $this->faker->name,
            'total' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['pending','processing','completed','cancelled']),
        ];
    }
}
