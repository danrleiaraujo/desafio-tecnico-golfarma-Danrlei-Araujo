<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register() // Cadastro de usuario
    {
        $payload = [
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'password' => 'maria123',
            'password_confirmation' => 'maria123',
        ];

        $this->postJson('/api/register', $payload)
             ->assertStatus(201)
             ->assertJsonStructure(['user', 'token']);
    }

    public function test_user_can_login() // Login
    {
        $user = User::factory()->create([
            'password' => bcrypt('maria123'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'maria123',
        ];

        $this->postJson('/api/login', $payload)
             ->assertStatus(200)
             ->assertJsonStructure(['user', 'token']);
    }

    public function test_user_cannot_login_with_wrong_password() // Login com senha errada
    {
        $user = User::factory()->create([
            'password' => bcrypt('maria123'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'wrongpass',
        ];

        $this->postJson('/api/login', $payload)
             ->assertStatus(401);
    }
}