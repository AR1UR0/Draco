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
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // CP
        $table->string('nombre', 50);
        $table->string('email', 50)->unique(); // único
        $table->string('password'); // hash del password
        $table->integer('dinero')->default(0);
        $table->integer('racha')->default(0);
        $table->integer('experiencia')->default(0);
        $table->timestamp('email_verified_at')->nullable();
        $table->timestamp('last_login_at')->nullable();
        $table->timestamp('last_life_recovery_at')->nullable();
        $table->integer('vidas_actuales')->default(7);
        $table->integer('vidas_max')->default(7);
        $table->string('imagen_usuario')->nullable();
        $table->foreignId('role_id')->default(2)->constrained('roles')->onDelete('cascade');
        $table->timestamps(); // created_at y updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::dropIfExists('users');
}
};
