<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tematica;

/**
* Seeder: TematicaSeeder
* This component is responsible for registering the main categories.
* Marta has selected diverse themes (music, literature, and manga) to
* demonstrate the platform's versatility and segmentation capabilities.
* @author Marta
*/
class TematicaSeeder extends Seeder
{
    /**
    * Executes the seeding of the base themes.
    * Process:
    * 1. Definition of a data array with the properties of each universe.
    * 2. Iteration using a 'foreach' loop for bulk persistence.
    * @author Marta
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
