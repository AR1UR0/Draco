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
    $tematicas = [
            ['nombre' => 'Gloryhammer', 'descripcion' => 'Preguntas sobre la banda de Power Metal Gloryhammer.'],
            ['nombre' => 'El Señor de los Anillos', 'descripcion' => 'Preguntas sobre la saga de El Señor de los Anillos.'],
            ['nombre' => 'Berserk', 'descripcion' => 'Preguntas sobre el manga/anime Berserk.'],
        ];

        foreach ($tematicas as $t) {
            Tematica::firstOrCreate(
                ['nombre' => $t['nombre']],
                ['descripcion' => $t['descripcion']]
            );
        }
    }
}
