<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateRespuestasTable
 * * Define la estructura para las opciones de respuesta de cada pregunta.
 * Es el nivel final de la jerarquía de contenidos y el que permite 
 * la interactividad y evaluación del sistema DRACO.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'respuestas' con lógica de validación binaria:
     * - opcion: El texto de la respuesta o descripción de la opción.
     * - is_correct: Flag booleano (true/false) para identificar la respuesta válida.
     * - pregunta_id: Clave foránea que asocia la respuesta a su pregunta padre.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->text('opcion'); 
            $table->boolean('is_correct'); 
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'respuestas'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
