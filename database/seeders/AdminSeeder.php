<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Verifica si el usuario admin ya existe para evitar duplicados.
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'username' => 'admin',
                'password' => Hash::make('admin'), // La contraseña por defecto es "admin", se puede cambiar posteriormente.
                'role' => 'admin'
            ]);
            $this->command->info('Usuario admin creado exitosamente con password "admin".');
        } else {
            $this->command->info('El usuario admin ya existe.');
        }
    }
}
