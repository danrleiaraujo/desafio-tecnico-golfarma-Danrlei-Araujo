<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Populando banco de dados de User com 2 Usuarios.
     */
    public function run(): void
    {        
        // Usuario defaut
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(2)->create();


    }
}
