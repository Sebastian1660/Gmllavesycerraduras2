<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador solo si no existe
        if (!User::where('email', 'gmllaves@gmail.com')->exists()) {
            User::create([
                'name' => 'GM Administrador',
                'email' => 'gmllaves@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+57 302 238 70 20',
                'address' => 'Servicio a domicilio',
                'is_active' => true,
                'email_verified_at' => now()
            ]);
        }

        // Crear usuario cliente de prueba solo si no existe
        if (!User::where('email', 'cliente@ejemplo.com')->exists()) {
            User::create([
                'name' => 'Cliente Ejemplo',
                'email' => 'cliente@ejemplo.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '+57 300 000 0000',
                'address' => 'Dirección de ejemplo',
                'is_active' => true,
                'email_verified_at' => now()
            ]);
        }
    }
}