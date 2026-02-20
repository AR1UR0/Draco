<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateTestsTable
 * * Define la estructura para los cuestionarios.
 * Esta tabla actúa como el nivel intermedio de la jerarquía, vinculando
 * una categoría global (Temática) con un conjunto específico de preguntas.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'tests' con las siguientes especificaciones:
     * - title: Título del test (hasta 150 caracteres para permitir nombres descriptivos).
     * - order: Valor numérico para organizar la secuencia de niveles (Nivel 1, Nivel 2...).
     * - tematica_id: Clave foránea que vincula el test a su temática padre.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150); 
            $table->integer('order');
            $table->foreignId('tematica_id')->constrained('tematicas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'tests'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
