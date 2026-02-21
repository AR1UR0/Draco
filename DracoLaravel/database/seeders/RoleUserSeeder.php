<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
* Seeder: RoleUserSeeder
* This component initializes the permissions and user system.
* It creates the fundamental roles and generates test accounts with different
* access levels to validate application security.
* @author Marta
*/
class RoleUserSeeder extends Seeder
{
    /**
    * Execution of role and user seeding.
    * Process:
    * 1. Definition of roles (admin/user).
    * 2. Creation of an administrator with full privileges.
    * 3. Creation of a standard user for interface testing.
    * @author Marta
    */
    public function run(): void
    {
        
        $adminRole = Role::create(['name' => 'admin']); 
        $userRole = Role::create(['name' => 'user']); 

       
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