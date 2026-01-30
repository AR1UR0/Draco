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
    Schema::create('progresos', function (Blueprint $table) {
        $table->id(); // CP
        $table->decimal('porcentaje', 5, 2)->default(0); // porcentaje completado
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK a users
        $table->foreignId('tematica_id')->constrained('tematicas')->onDelete('cascade'); // FK a tematicas
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progresos');
    }
};
