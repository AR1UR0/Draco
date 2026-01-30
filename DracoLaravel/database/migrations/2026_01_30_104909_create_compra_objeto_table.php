<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('compra_objeto', function (Blueprint $table) {
        $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade'); // FK a compras
        $table->foreignId('objeto_id')->constrained('objetos')->onDelete('cascade');   // FK a objetos
        $table->primary(['compra_id', 'objeto_id']); // CP compuesta
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_objeto');
    }
};
