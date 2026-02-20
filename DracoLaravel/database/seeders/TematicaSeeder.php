<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tematica;

/**
 * Seeder: TematicaSeeder
 * * Este componente es el encargado de dar de alta las categorías principales.
 * Marta ha seleccionado temáticas diversas (música, literatura y manga) para
 * demostrar la versatilidad de la plataforma y su capacidad de segmentación.
 * * @author Marta
 */
class TematicaSeeder extends Seeder
{
    /**
     * Ejecuta la siembra de las temáticas base.
     * * Proceso:
     * 1. Definición de un array de datos con las propiedades de cada universo.
     * 2. Iteración mediante un bucle 'foreach' para la persistencia masiva.
     * * @author Marta
     */
   public function run(): void {
    $temas = [
        [
            'name' => 'Gloryhammer', 
            'description' => 'Preguntas sobre la banda de Power Metal Gloryhammer.',
            'image' => 'gloryhammer.jpg' 
        ],
        [
            'name' => 'El Señor de los Anillos', 
            'description' => 'Preguntas sobre la saga de El Señor de los Anillos.',
            'image' => 'lotr.jpg' 
        ],
        [
            'name' => 'Berserk', 
            'description' => 'Preguntas sobre el manga/anime Berserk.',
            'image' => 'berserk.jpg' 
        ],
    ];

    foreach ($temas as $tema) {
        Tematica::create($tema); 
    }
}
}
