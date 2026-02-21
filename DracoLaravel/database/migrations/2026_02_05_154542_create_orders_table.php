<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateOrdersTable
* Manages the recording of business transactions within the platform.
* This table is essential for auditing user purchases, allowing you to
* generate invoices or transaction histories and ensuring
* transparency in the use of the virtual currency (points).
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'orders' table with a focus on transactional persistence:
    * - user_id: Identifies the buyer, permanently linked to the users table.
    * - total_price: The total amount of the transaction (supports decimals).
    * - status: Order status, essential for future payment gateway integrations.
    * @author Marta
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
    * Reverts the migration (Down).
    * * Deletes the 'orders' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
