<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: AddMultimediaToRespuestasTable
 * * Esta migración expande la tabla 'respuestas' para integrar capacidades 
 * multimodales. Permite que las opciones de respuesta contengan archivos 
 * visuales o auditivos, elevando la calidad pedagógica y lúdica de los tests.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Modifica la tabla 'respuestas' añadiendo campos para recursos externos:
     * - image: Almacena la ruta o nombre del archivo de imagen (ej. 'imgs/lotr/mordor.jpg').
     * - audio: Almacena la ruta del archivo de sonido (ej. 'audio/efectos/acierto.mp3').
     * - after('is_correct'): Mantiene los campos multimedia organizados al final de la estructura.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
            // Se definen como nullable ya que no todas las respuestas requieren multimedia
            $table->string('image')->nullable()->after('is_correct');
            $table->string('audio')->nullable()->after('image');
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina las columnas 'image' y 'audio' en caso de rollback.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
            $table->dropColumn(['image', 'audio']);
        });
    }
};
