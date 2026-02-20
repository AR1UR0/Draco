<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateTematicasTable
 * * Define la estructura para las categorías principales de la aplicación.
 * Esta tabla permite agrupar los tests bajo conceptos temáticos (ej. Mitología, 
 * LOTR, Gloryhammer), facilitando una navegación organizada para el usuario.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'tematicas' con soporte para contenido descriptivo y visual:
     * - name: Nombre de la temática (limitado a 50 caracteres).
     * - description: Campo de texto para explicar de qué trata la categoría.
     * - image: Ruta al icono o banner representativo de la temática.
     * - is_active: Interruptor lógico para habilitar o deshabilitar la temática en la UI.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('tematicas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'tematicas'. 
     * Nota: Debido a la integridad referencial, esto fallará si existen tests vinculados 
     * a menos que se hayan configurado eliminaciones en cascada.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('tematicas');
    }
};
