<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateUserTestResultsTable
 * * Esta tabla actúa como un registro histórico de actividad. Almacena el desempeño
 * de cada usuario en cada test específico, permitiendo la persistencia de datos 
 * sobre su progreso y éxito en la plataforma.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'user_test_results' que vincula usuarios con contenidos:
     * - user_id: Referencia al usuario que realizó la prueba.
     * - test_id: Referencia al test completado.
     * - score: Calificación o puntuación obtenida en esa sesión.
     * - completed_at: Fecha y hora exacta de finalización, configurada por defecto.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('user_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
            $table->integer('score'); 
            $table->timestamp('completed_at')->useCurrent(); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'user_test_results'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('user_test_results');
    }
};
