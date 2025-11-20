<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria um usuário ADMINISTRADOR
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@loja.com',
            'password' => bcrypt('senha123'), // Senha para login
            'is_admin' => true, // Define como Admin
        ]);

        // Cria um usuário CLIENTE comum
        User::factory()->create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@loja.com',
            'password' => bcrypt('senha123'),
            'is_admin' => false,
        ]);
    }
}