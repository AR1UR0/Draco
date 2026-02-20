<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateRolesTable
 * * Esta clase se encarga de definir la estructura de la tabla 'roles' en la base de datos.
 * Es la piedra angular del sistema de seguridad (RBAC) de DRACO, permitiendo 
 * categorizar a los usuarios según sus privilegios.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'roles' con los siguientes campos:
     * - id: Clave primaria autoincremental.
     * - name: Nombre del rol (ej: 'admin', 'user'), limitado a 50 caracteres para optimizar espacio.
     * - timestamps: Registra automáticamente la fecha de creación y actualización.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla de la base de datos. Este método es esencial para 
     * mantener un entorno de desarrollo limpio y permitir el rollback de cambios.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
