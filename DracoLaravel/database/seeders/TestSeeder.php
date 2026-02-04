<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\File;
use App\Models\Tematica;
use App\Models\Test;
use App\Models\Pregunta;
use App\Models\Respuesta;


class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        // Lista de JSON a importar
        $jsonFiles = [
            'gloryhammer.json',
            'lotr.json',
            'berserk.json'
        ];

        foreach ($jsonFiles as $fileName) {
            $jsonPath = database_path("data/$fileName");
            if (!file_exists($jsonPath)) continue;

            $json = File::get($jsonPath);
            $data = json_decode($json, true);

            foreach ($data['datos'] as $tematicaData) {
                $tematica = Tematica::where('nombre', $tematicaData['nombre'])->first();
                if (!$tematica) continue;

                foreach ($tematicaData['tests'] as $testData) {
                    $test = Test::create([
                        'titulo' => $testData['titulo'],
                        'orden' => $testData['orden'],
                        'tematica_id' => $tematica->id,
                    ]);

                    foreach ($testData['preguntas'] as $preguntaData) {
                        $pregunta = Pregunta::create([
                            'enunciado' => $preguntaData['enunciado'],
                            'imagen' => $preguntaData['imagen'] ?? null,
                            'audio' => $preguntaData['audio'] ?? null,
                            'test_id' => $test->id,
                        ]);

                        foreach ($preguntaData['respuestas'] as $respuestaData) {
                            Respuesta::create([
                                'texto' => $respuestaData['texto'],
                                'es_correcta' => $respuestaData['correcta'],
                                'imagen' => $respuestaData['imagen'] ?? null,
                                'pregunta_id' => $pregunta->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
