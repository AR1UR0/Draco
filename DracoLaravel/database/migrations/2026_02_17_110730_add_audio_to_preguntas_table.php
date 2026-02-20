<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

    /**
 * Migración: AddAudioToPreguntasTable
 * * Esta migración extiende la funcionalidad de la tabla 'preguntas' permitiendo
 * la inclusión de recursos sonoros en el planteamiento del reto.
 * Es fundamental para tipos de preguntas basadas en reconocimiento auditivo.
 * * @author Thais
 */
return new class extends Migration
{

/**
     * Ejecuta la migración (Up).
     * * Modifica la tabla 'preguntas' para integrar soporte de audio:
     * - audio: Campo de tipo string para almacenar la ruta del archivo (nullable).
     * - after('enunciado'): Ubicación lógica justo después del texto de la pregunta.
     * * @author Thais
     */
    public function up(): void
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->string('audio')->nullable()->after('enunciado');
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la columna 'audio' de la tabla 'preguntas'.
     * * @author Thais
     */
    public function down(): void
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->dropColumn('audio');
        });
    }
};
