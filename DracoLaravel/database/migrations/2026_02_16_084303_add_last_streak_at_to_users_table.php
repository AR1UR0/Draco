<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: AddLastStreakAtToUsersTable
* This migration expands the 'users' table to support the persistence logic
* of the streak system. It allows recording the exact time of the last hit
* or login, essential data for the 'UpdateStreak' middleware.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Runs the migration (Up).
    * Modifies the existing 'users' structure:
    * - last_streak_at: Timestamp field that stores the date of the last milestone.
    * - after('streak'): Visually positions the column after 'streak' to maintain the logical order in the database management tools.
    * @author Marta
    */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_streak_at')->nullable()->after('streak');
        });
    }

    /**
    * Reverts the migration (Down).
    * * Removes the 'last_streak_at' column from the 'users' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_streak_at');
        });
    }
};
