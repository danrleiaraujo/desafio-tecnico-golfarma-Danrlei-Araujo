<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderCrudTest extends TestCase
{
    public function test_authenticated_user_can_create_order()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, [], 'web');

        $payload = ['cliente'=>'João','total'=>100.50,'status'=>'pending'];
        $this->postJson('/api/orders', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['cliente'=>'João']);
    }
}
