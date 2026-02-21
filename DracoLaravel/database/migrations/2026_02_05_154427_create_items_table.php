<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateItemsTable
* Defines the catalog of products available in the DRACO virtual store.
* Allows categorizing different types of benefits (lives, premium access, etc.)
* and establishing their economic value within the application's ecosystem.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'items' table with the properties necessary for the sale:
    * - name: Product name.
    * - type: Item category (key for subsequent usage logic).
    * - price: Item cost (decimal format for precision).
    * - description: Details about the benefits the item provides.
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
    * Reverts the migration (Down).
    * Deletes the 'items' table and, consequently, the store catalog.
    * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
