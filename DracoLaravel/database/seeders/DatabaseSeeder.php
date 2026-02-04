<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,     // 1º Roles
            TematicaSeeder::class, // 2º Temáticas
            TestSeeder::class,     // 3º Tests y Preguntas
        ]);
    }
}