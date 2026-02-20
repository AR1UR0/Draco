<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateUsersTable
 * * Define la estructura fundamental de los usuarios en DRACO. 
 * Integra en una sola tabla la información de autenticación, el perfil 
 * estético y todas las variables de estado necesarias para la gamificación.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Construye la tabla 'users' con lógica de negocio integrada:
     * - Identidad: name y email (único para evitar duplicados).
     * - Gamificación: points, streak y sistema de vidas (current/max).
     * - Seguridad: password encriptado y relación con la tabla 'roles'.
     * - Recuperación: last_life_recovery para el control de tiempo de regeneración.
     * * @author Marta
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name', 50);
        $table->string('email', 50)->unique();
        $table->string('password');
        $table->integer('points')->default(0); 
        $table->integer('streak')->default(0);
        $table->integer('current_lives')->default(5);
        $table->integer('max_lives')->default(7);
        $table->timestamp('last_life_recovery')->nullable();
        $table->string('profile_image')->nullable();
        $table->foreignId('role_id')->constrained('roles'); 
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'users', rompiendo las relaciones con roles y resultados.
     * * @author Marta
     */
    public function down()
{
    Schema::dropIfExists('users');
}
};
