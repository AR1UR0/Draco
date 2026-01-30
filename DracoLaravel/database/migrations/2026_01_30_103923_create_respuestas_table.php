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
    Schema::create('respuestas', function (Blueprint $table) {
        $table->id(); // CP
        $table->text('texto');
        $table->boolean('es_correcta');
        $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade'); // FK a preguntas
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
