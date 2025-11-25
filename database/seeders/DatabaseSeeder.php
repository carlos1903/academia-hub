<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Definir los datos de identificación (usados para buscar si el usuario ya existe)
        $identification = [
            'email' => 'admin@academia.com'
        ];

        // 2. Definir los datos a crear/actualizar
        $attributes = [
            'name' => 'Administrador',
            // Asegúrate de que la contraseña SIEMPRE se haga hash aquí
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ];

        // Usamos updateOrCreate: Busca por el email. 
        // Si lo encuentra, actualiza los campos. Si no lo encuentra, lo crea.
        // Esto asegura que la contraseña siempre se guarde hasheada.
        User::updateOrCreate($identification, $attributes);
        
    }
}