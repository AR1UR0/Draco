<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Tematica;
use Illuminate\Support\Facades\File;

/**
 * Seeder: TestSeeder (El Motor de Carga JSON)
 * * Este componente es la pieza más avanzada de la siembra de datos. 
 * Implementa un sistema de parseo de archivos JSON para poblar de forma 
 * recursiva los tres niveles de contenido: Tests, Preguntas y Respuestas.
 * * @author Thais 
 */
class TestSeeder extends Seeder
{
    /**
     * Ejecuta el proceso de importación masiva.
     * * Lógica de operación:
     * 1. Localiza los archivos JSON en la carpeta 'database/data/'.
     * 2. Mapea cada archivo con su Temática correspondiente.
     * 3. Procesa y normaliza las rutas multimedia (Audio y Video).
     * 4. Persiste la información respetando la jerarquía de claves foráneas.
     * * @author Thais
     */
    public function run(): void
    {
        $archivos = ['berserk.json', 'gloryhammer.json', 'lotr.json'];

        foreach ($archivos as $nombreArchivo) {
            $ruta = database_path("data/{$nombreArchivo}");

            if (!File::exists($ruta)) {
                $this->command->warn("Archivo no encontrado en: {$ruta}");
                continue;
            }

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
                        $rutaAudio = null;
                        if (isset($qData['audio'])) {
                            $rutaAudio = "media/" . $qData['audio'];
                        }

                        $pregunta = Pregunta::create([
                            'enunciado'     => $qData['enunciado'],
                            'audio'         => $rutaAudio, 
                            'reward_points' => $qData['puntos_recompensa'] ?? 10,
                            'test_id'       => $test->id
                        ]);

                        foreach ($qData['respuestas'] as $aData) {
                            
                            $rutaImagen = null;
                            if (isset($aData['imagen'])) {
                                    $rutaImagen = "media/" . $aData['imagen'];
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