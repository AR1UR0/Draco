<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder: RoleUserSeeder
 * * Este componente inicializa el sistema de permisos y usuarios. 
 * Crea los roles fundamentales y genera cuentas de prueba con diferentes 
 * niveles de acceso para validar la seguridad de la aplicación.
 * * @author Marta
 */
class RoleUserSeeder extends Seeder
{
    /**
     * Ejecución de la siembra de roles y usuarios.
     * * Proceso:
     * 1. Definición de roles (admin/user).
     * 2. Creación de un administrador con privilegios totales.
     * 3. Creación de un usuario estándar para pruebas de interfaz.
     * * @author Marta
     */
    public function run(): void
    {
        // Crear Roles 
        $adminRole = Role::create(['name' => 'admin']); 
        $userRole = Role::create(['name' => 'user']); 

        // Crear Usuario Administrador de prueba 
        User::create([
            'name' => 'Admin Draco', 
            'email' => 'admin@draco.com', 
            'password' => Hash::make('admin123'), 
            'role_id' => $adminRole->id, 
            'points' => 100,
            'current_lives' => 7,
            'streak' => 1,
            'last_streak_at' => now(), 
            'max_lives' => 7, 
            'experience' => 0,
        ]);

        //Creación de usuario de prueba
        User::create([
            'name' => 'Pepet', 
            'email' => 'pepet@draco.com', 
            'password' => Hash::make('pepet123'), 
            'role_id' => $userRole->id, 
            'points' => 100, 
            'current_lives' => 7,
            'streak' => 1,
            'last_streak_at' => now(), 
            'max_lives' => 7, 
            'experience' => 0,
        ]);
    }
}