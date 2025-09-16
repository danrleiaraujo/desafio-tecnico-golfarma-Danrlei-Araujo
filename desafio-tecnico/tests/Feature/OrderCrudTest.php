<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use Laravel\Sanctum\Sanctum; // Toda função cria um usuario autenticado com o sactum do laravel.


class OrderCrudTest extends TestCase
{
    use RefreshDatabase; // cada teste roda em banco limpo

    public function test_authenticated_user_can_create_order() // Testa se um usuario autenticado consegue criar um novo pedido
    {
        Sanctum::actingAs(User::factory()->create());

        $payload = [
            'cliente' => 'João Silva',
            'total' => 150.75,
            'status' => 'pending',
        ];

        $this->postJson('/api/orders', $payload)
             ->assertStatus(201)
             ->assertJsonFragment(['cliente' => 'João Silva']);
    }

    public function test_authenticated_user_can_list_orders() // Testa se um usuario autenticado consegue listar pedidos
    {
        Sanctum::actingAs(User::factory()->create());
        Order::factory()->count(3)->create();

        $this->getJson('/api/orders')
             ->assertStatus(200)
             ->assertJsonStructure(['data']);
    }

    public function test_authenticated_user_can_update_order() // Testa se um usuario autenticado consegue atualizar pedidos
    {
        Sanctum::actingAs(User::factory()->create());
        $order = Order::factory()->create();

        $this->putJson("/api/orders/{$order->id}", ['status' => 'completed'])
             ->assertStatus(200)
             ->assertJsonFragment(['status' => 'completed']);
    }

    public function test_authenticated_user_can_delete_order() // Testa se um usuario autenticado consegue deletar pedidos
    {
        Sanctum::actingAs(User::factory()->create());
        $order = Order::factory()->create();

        $this->deleteJson("/api/orders/{$order->id}")
             ->assertStatus(204);

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
