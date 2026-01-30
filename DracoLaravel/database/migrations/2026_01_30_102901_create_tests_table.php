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
    Schema::create('tests', function (Blueprint $table) {
        $table->id(); // CP
        $table->string('titulo', 150);
        $table->integer('orden');
        $table->foreignId('tematica_id')->constrained('tematicas')->onDelete('cascade'); // FK a tematicas
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
