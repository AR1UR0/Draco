<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tematica;

class TematicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void {
    $temas = [
        [
            'name' => 'Gloryhammer', 
            'description' => 'Preguntas sobre la banda de Power Metal Gloryhammer.',
            'image' => 'gloryhammer.jpg' // <-- Verifica que el archivo existe
        ],
        [
            'name' => 'El Señor de los Anillos', 
            'description' => 'Preguntas sobre la saga de El Señor de los Anillos.',
            'image' => 'lotr.jpg' // <-- Verifica si es .jpg o .png
        ],
        [
            'name' => 'Berserk', 
            'description' => 'Preguntas sobre el manga/anime Berserk.',
            'image' => 'berserk.jpg' // <-- Verifica que el archivo existe
        ],
    ];

    foreach ($temas as $tema) {
        Tematica::create($tema); 
    }
}
}
