<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreatePreguntasTable
 * * Define la estructura de los reactivos o desafíos del sistema.
 * Esta tabla almacena el cuerpo de la pregunta y establece la conexión
 * con el sistema de economía (puntos) de la aplicación.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'preguntas' con las siguientes propiedades:
     * - enunciado: Campo de tipo 'text' para permitir preguntas largas o complejas.
     * - reward_points: Define cuántos puntos (monedas) gana el usuario al acertar.
     * - test_id: Relación foránea con la tabla 'tests'.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('enunciado'); 
            $table->integer('reward_points')->default(10); 
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'preguntas'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
