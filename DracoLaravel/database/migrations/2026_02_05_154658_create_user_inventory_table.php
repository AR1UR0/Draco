<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateUserInventoryTable
* This table manages user ownership of objects.
* It acts as the link between store products and the player's profile,
* allowing for the storage of consumables and temporary benefits.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'user_inventory' table with support for stock and expiration management:
    * - user_id: Owner of the item.
    * - item_id: Reference to the item in the catalog.
    * - quantity: Number of units owned (allows for accumulating consumables).
    * - expires_at: Expiration date, essential for subscriptions or limited-time offers.
    * @author Marta
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
    * Reverts the migration (Down).
    * Deletes the inventory table.
    * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('user_inventory');
    }
};
