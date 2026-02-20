<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: AddExperienceToUsersTable
 * * Esta migración implementa el sistema de experiencia (XP) en la tabla de usuarios.
 * Es un componente vital de la gamificación de DRACO, permitiendo cuantificar 
 * el esfuerzo acumulado del jugador independientemente de los puntos (monedas) 
 * que gaste en la tienda.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Actualiza la tabla 'users' para integrar la progresión:
     * - experience: Valor entero que acumula el historial de aciertos.
     * - after('points'): Se sitúa junto a los puntos para mantener coherencia 
     * en el bloque de atributos económicos y de progreso.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        // Añadimos la columna experience después de points
            $table->integer('experience')->default(0)->after('points');
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina el campo 'experience'. Se debe usar con precaución ya que 
     * borraría el progreso acumulado de todos los jugadores.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('experience');
        });
    }
};
