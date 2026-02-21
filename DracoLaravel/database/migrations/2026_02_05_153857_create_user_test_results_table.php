<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateUserTestResultsTable
* This table acts as a historical activity log. It stores the performance
* of each user in each specific test, allowing data persistence
* regarding their progress and success on the platform.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Runs the migration (Up).
    * Creates the 'user_test_results' table that links users with content:
    * - user_id: Reference to the user who took the test.
    * - test_id: Reference to the completed test.
    * - score: Grade or score obtained in that session.
    * - completed_at: Exact date and time of completion, configured by default.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('user_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
            $table->integer('score'); 
            $table->timestamp('completed_at')->useCurrent(); 
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * * Deletes the 'user_test_results' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('user_test_results');
    }
};
