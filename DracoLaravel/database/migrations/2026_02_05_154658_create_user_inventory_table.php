<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateUserInventoryTable
 * * Esta tabla gestiona la propiedad de los objetos por parte de los usuarios.
 * Funciona como el nexo de unión entre los productos de la tienda y el perfil
 * del jugador, permitiendo el almacenamiento de consumibles y beneficios temporales.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'user_inventory' con soporte para gestión de stock y caducidad:
     * - user_id: Propietario del objeto.
     * - item_id: Referencia al objeto del catálogo.
     * - quantity: Cantidad de unidades poseídas (permite acumular consumibles).
     * - expires_at: Fecha de vencimiento, esencial para suscripciones o ventajas limitadas.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('user_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); 
            $table->integer('quantity')->default(1); 
            $table->timestamp('expires_at')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla de inventarios.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inventory');
    }
};
