<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateUsersTable
* Defines the fundamental user structure in DRACO.
* Integrates authentication information, profile, and all necessary state variables for gamification into a single table.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Build the 'users' table with integrated business logic:
    * - Identity: name and email (unique to avoid duplicates).
    * - Gamification: points, streak, and lives system (current/max).
    * - Security: encrypted password and relationship with the 'roles' table.
    * - Recovery: last_life_recovery for regeneration time control.
    * @author Marta
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
        $table->foreignId('role_id')->constrained('roles'); 
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
    * Reverts the migration (Down).
    * Deletes the 'users' table, breaking the relationships with roles and results.
    * @author Marta
    */
    public function down()
{
    Schema::dropIfExists('users');
}
};
