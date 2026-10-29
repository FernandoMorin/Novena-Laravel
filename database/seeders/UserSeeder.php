<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'email' => 'admin@novena.com',
            'password' => 'admin123',
        ]);

        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'user@novena.com',
            'password' => 'user123',
        ]);
    }
}
