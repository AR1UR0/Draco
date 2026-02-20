<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: AddIsPlusToUsersTable
 * * Esta migración implementa la distinción de cuenta "Premium" o "Plus".
 * Es una columna booleana que actúa como un interruptor (flag) para habilitar
 * funcionalidades avanzadas y beneficios exclusivos dentro de la plataforma.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Modifica la tabla 'users' para añadir el estatus de membresía:
     * - is_plus: Booleano que indica si el usuario tiene la suscripción activa.
     * - after('max_lives'): Se posiciona tras la configuración de vidas, ya que
     * el estatus Plus suele estar directamente relacionado con la gestión de estas.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_plus')->default(false)->after('max_lives');
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la columna 'is_plus' de la tabla 'users'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
