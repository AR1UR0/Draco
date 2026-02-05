<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Roles [cite: 236, 313]
        $adminRole = Role::create(['name' => 'admin']); 
        $userRole = Role::create(['name' => 'user']); 

        // Crear Usuario Administrador de prueba 
        User::create([
            'name' => 'Admin Draco', 
            'email' => 'admin@draco.com', 
            'password' => Hash::make('admin123'), 
            'role_id' => $adminRole->id, 
            'current_lives' => 7, 
            'max_lives' => 7, 
        ]);
    }
}