<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleUserSeeder::class, //roles y usuario admin
            TematicaSeeder::class, //tematicas 
            TestSeeder::class, //tests, preguntas y respuestas
        ]);
    }
}