<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: AddExperienceToUsersTable
* This migration implements the experience (XP) system in the user table.
* It is a vital component of DRACO's gamification, allowing us to quantify
* the player's accumulated effort regardless of the points (coins)
* they spend in the store.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Runs the migration (Up).
    * Updates the 'users' table to integrate the progression:
    * - experience: Integer value that accumulates the history of successes.
    * - after('points'): Placed next to the points to maintain consistency
    * in the economic and progress attributes block.
    * @author Marta
    */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('experience')->default(0)->after('points');
        });
    }

    /**
    * Reverts the migration (Down).
    * Removes the 'experience' field. Use with caution as it
    * would erase the accumulated progress of all players.
    * @author Marta
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('experience');
        });
    }
};
