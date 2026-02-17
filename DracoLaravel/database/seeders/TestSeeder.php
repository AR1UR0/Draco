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
        $archivos = ['berserk.json', 'gloryhammer.json', 'lotr.json'];

        foreach ($archivos as $nombreArchivo) {
            $ruta = database_path("data/{$nombreArchivo}");

            if (!File::exists($ruta)) {
                $this->command->warn("Archivo no encontrado en: {$ruta}");
                continue;
            }

            // EXTRAER EL SLUG (nombre de la carpeta) del nombre del archivo
            // Ejemplo: 'lotr.json' -> 'lotr'
            $slug = str_replace('.json', '', $nombreArchivo);

            $json = File::get($ruta);
            $data = json_decode($json, true);

            foreach ($data['datos'] as $temaData) {
                $tema = Tematica::where('name', $temaData['nombre'])->first();

                if (!$tema) {
                    $this->command->error("Temática '{$temaData['nombre']}' no encontrada.");
                    continue;
                }

                foreach ($temaData['tests'] as $testData) {
                    $test = Test::create([
                        'title'       => $testData['titulo'],
                        'order'       => $testData['orden'],
                        'tematica_id' => $tema->id
                    ]);

                    foreach ($testData['preguntas'] as $qData) {
                        // Lógica para AUDIO en Pregunta
                        $rutaAudio = null;
                        if (isset($qData['audio'])) {
                            $rutaAudio = "media/audio/{$slug}/" . $qData['audio'];
                        }

                        $pregunta = Pregunta::create([
                            'enunciado'     => $qData['enunciado'],
                            'audio'         => $rutaAudio, // Asegúrate de tener esta columna en Preguntas
                            'reward_points' => $qData['puntos_recompensa'] ?? 10,
                            'test_id'       => $test->id
                        ]);

                        foreach ($qData['respuestas'] as $aData) {
                            // Lógica para IMAGEN en Respuesta
                            $rutaImagen = null;
                            if (isset($aData['imagen'])) {
                                // Caso especial para lotr que me dijiste que está en media/img/lotr
                                if ($slug === 'lotr') {
                                    $rutaImagen = "media/img/{$slug}/" . $aData['imagen'];
                                } else {
                                    // Para berserk y gloryhammer que están en media/nombre/
                                    $rutaImagen = "media/{$slug}/" . $aData['imagen'];
                                }
                            }

                            Respuesta::create([
                                'opcion'      => $aData['texto'] ?? '',
                                'is_correct'  => $aData['correcta'], 
                                'image'       => $rutaImagen,
                                'pregunta_id' => $pregunta->id
                            ]);
                        }
                    }
                }
            }
        }
        $this->command->info("¡Tests y multimedia cargados con éxito!");
    }
}