<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Populando banco de dados de order com 10 pedidos.
     */
    public function run(): void
    {
        Order::factory()->count(10)->create();
    }
}
