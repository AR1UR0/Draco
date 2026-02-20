<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: CreateItemsTable
 * * Define el catálogo de productos disponibles en la tienda virtual de DRACO.
 * Permite categorizar diferentes tipos de beneficios (vidas, acceso premium, etc.)
 * y establecer su valor económico dentro del ecosistema de la aplicación.
 * * @author Marta
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración (Up).
     * * Crea la tabla 'items' con las propiedades necesarias para la venta:
     * - name: Nombre comercial del producto.
     * - type: Categoría del objeto (clave para la lógica de uso posterior).
     * - price: Coste del item (formato decimal para precisión).
     * - description: Detalles sobre los beneficios que otorga el objeto.
     * * @author Marta
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); 
            $table->string('type', 50);// Ejemplo: 'life', 'premium', 'cosmetic'
            $table->decimal('price', 10, 2); 
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración (Down).
     * * Elimina la tabla 'items' y, por consiguiente, el catálogo de la tienda.
     * * @author Marta
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
