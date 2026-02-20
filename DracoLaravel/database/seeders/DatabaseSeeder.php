<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder Maestro: DatabaseSeeder
 * * Clase principal encargada de coordinar la inserción masiva de datos iniciales.
 * Es un orquestador para garantizar que la base de datos pase 
 * de estar vacía a tener una estructura funcional completa con un solo comando.
 * * @author Marta
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Método principal de ejecución.
     * * Define el orden crítico de "siembra" de datos para respetar 
     * la integridad referencial de la base de datos.
     * * @author Marta
     */
    public function run(): void
    {
        $this->call([
            // 1. Identidad: Crea los roles y el usuario administrador inicial.
            RoleUserSeeder::class, 
            // 2. Estructura: Crea las categorías globales (Cine, Historia, etc.)
            TematicaSeeder::class,  
            // 3. Contenido: El seeder más complejo que inserta la lógica de los tests.
            TestSeeder::class, 
        ]);
    }
}