<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateTestsTable
* Defines the structure for the quizzes.
* This table acts as the intermediate level of the hierarchy, linking
* a global category (Topic) to a specific set of questions.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'tests' table with the following specifications:
    * - title: Test title (up to 150 characters to allow for descriptive names).
    * - order: Numeric value to organize the sequence of levels (Level 1, Level 2...).
    * - tematica_id: Foreign key that links the test to its parent topic.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150); 
            $table->integer('order');
            $table->foreignId('tematica_id')->constrained('tematicas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * * Deletes the 'tests' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
