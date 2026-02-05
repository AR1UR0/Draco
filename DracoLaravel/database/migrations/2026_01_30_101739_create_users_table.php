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
        $table->id();
        $table->string('name', 50);
        $table->string('email', 50)->unique();
        $table->string('password');
        $table->integer('points')->default(0); 
        $table->integer('streak')->default(0);
        $table->integer('current_lives')->default(5);
        $table->integer('max_lives')->default(7);
        $table->timestamp('last_life_recovery')->nullable();
        $table->string('profile_image')->nullable();
        $table->foreignId('role_id')->constrained('roles'); // Esto requiere que 'roles' ya exista
        $table->rememberToken();
        $table->timestamps();
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
