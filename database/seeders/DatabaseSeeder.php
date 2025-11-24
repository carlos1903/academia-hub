<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@academiahub.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);
    }
}   