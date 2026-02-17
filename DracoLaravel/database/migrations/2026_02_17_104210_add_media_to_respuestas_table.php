<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
        // Guardaremos solo el nombre del archivo o la ruta relativa
            $table->string('image')->nullable()->after('is_correct');
            $table->string('audio')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
            $table->dropColumn(['image', 'audio']);
        });
    }
};
