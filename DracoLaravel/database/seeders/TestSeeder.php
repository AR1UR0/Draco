<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Tematica;
use Illuminate\Support\Facades\File;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Definimos los archivos que están en database/data
        $archivos = ['berserk.json', 'gloryhammer.json', 'lotr.json'];

        foreach ($archivos as $nombreArchivo) {
            $ruta = database_path("data/{$nombreArchivo}");

            if (!File::exists($ruta)) {
                $this->command->warn("Archivo no encontrado en: {$ruta}");
                continue;
            }

            // 2. Leemos y decodificamos el JSON
            $json = File::get($ruta);
            $data = json_decode($json, true);

            foreach ($data['datos'] as $temaData) {
                // Buscamos la temática por el nombre (Berserk, El Señor de los Anillos, etc.)
                $tema = Tematica::where('name', $temaData['nombre'])->first();

                if (!$tema) {
                    $this->command->error("Temática '{$temaData['nombre']}' no encontrada en la BD.");
                    continue;
                }

                foreach ($temaData['tests'] as $testData) {
                    // Mapeo: JSON 'titulo' -> Modelo 'title' | JSON 'orden' -> Modelo 'order'
                    $test = Test::create([
                        'title'       => $testData['titulo'],
                        'order'       => $testData['orden'],
                        'tematica_id' => $tema->id
                    ]);

                    foreach ($testData['preguntas'] as $qData) {
                        // Mapeo: JSON 'enunciado' -> Modelo 'enunciado'
                        $pregunta = Pregunta::create([
                            'enunciado'            => $qData['enunciado'],
                            'reward_points'   => $qData['puntos_recompensa'] ?? 10,
                            'test_id'         => $test->id
                        ]);

                        foreach ($qData['respuestas'] as $aData) {
                            // Mapeo: JSON 'texto' -> Modelo 'text'
                            // Mapeo: JSON 'correcta' -> Modelo 'is_correct'
                            Respuesta::create([
                                'opcion'        => $aData['texto'] ?? '',
                                'is_correct'  => $aData['correcta'], 
                                'pregunta_id' => $pregunta->id
                            ]);
                        }
                    }
                }
            }
        }
        $this->command->info("¡Tests y preguntas cargados con éxito desde database/data!");
    }
}