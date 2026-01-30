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
    Schema::create('preguntas', function (Blueprint $table) {
        $table->id(); // CP
        $table->integer('puntos_recompensa')->default(10);
        $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); // FK a tests
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
