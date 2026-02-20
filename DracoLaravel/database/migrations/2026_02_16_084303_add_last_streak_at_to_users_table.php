<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: AddLastStreakAtToUsersTable
 * * Esta migración expande la tabla 'users' para soportar la lógica de persistencia
 * del sistema de rachas. Permite registrar el momento exacto del último acierto 
 * o login, dato indispensable para el middleware 'UpdateStreak'.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Modifica la estructura existente de 'users':
     * - last_streak_at: Campo de tipo timestamp que almacena la fecha del último hito.
     * - after('streak'): Posiciona la columna visualmente después de 'streak' para 
     * mantener el orden lógico en las herramientas de gestión de DB.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_streak_at')->nullable()->after('streak');
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la columna 'last_streak_at' de la tabla 'users'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_streak_at');
        });
    }
};
