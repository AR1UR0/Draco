<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: AddIsPlusToUsersTable
* This migration implements the "Premium" or "Plus" account distinction.
* It's a Boolean column that acts as a toggle (flag) to enable
* advanced features and exclusive benefits within the platform.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Runs the migration (Up).
    * Modifies the 'users' table to add membership status:
    * - is_plus: Boolean indicating whether the user has an active subscription.
    * - after('max_lives'): Positioned after the lives configuration, since
    * the Plus status is usually directly related to lives management.
    * @author Marta
    */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_plus')->default(false)->after('max_lives');
        });
    }

    /**
    * Reverts the migration (Down).
    * * Removes the 'is_plus' column from the 'users' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
