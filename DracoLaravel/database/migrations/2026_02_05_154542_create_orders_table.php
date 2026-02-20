<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateOrdersTable
 * * Gestiona el registro de transacciones comerciales dentro de la plataforma.
 * Esta tabla es esencial para auditar las compras de los usuarios, permitiendo
 * generar facturas o historiales de transacciones y garantizando la 
 * transparencia en el uso de la moneda virtual (points).
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'orders' con un enfoque en la persistencia transaccional:
     * - user_id: Identifica al comprador, vinculado permanentemente a la tabla users.
     * - total_price: El montante total de la operación (soporta decimales).
     * - status: Estado del pedido, vital para futuras integraciones de pasarelas de pago.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->decimal('total_price', 10, 2); 
            $table->string('status')->default('completed'); 
            $table->timestamps(); 
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'orders'.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
