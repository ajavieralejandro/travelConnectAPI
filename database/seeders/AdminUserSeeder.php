<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leer el password desde el archivo .env
        $adminPassword = env('ADMIN_PASSWORD');

        if (empty($adminPassword)) {
            $this->command->error('La variable ADMIN_PASSWORD no está definida en el archivo .env.');
            return;
        }

        // Crear un usuario admin
        User::create([
            'name' => 'Admin User 2',
            'email' => 'admin2@admin.com',
            'password' => Hash::make($adminPassword), // Usar el password del .env
            'is_admin' => 1, // Asignar el rol de admin
        ]);

        $this->command->info('Usuario admin creado exitosamente.');
    }
}
