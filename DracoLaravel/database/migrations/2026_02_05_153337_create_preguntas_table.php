<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreatePreguntasTable
* Defines the structure of the system's questions or challenges.
* This table stores the question body and establishes the connection
* with the application's point system.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'questions' table with the following properties:
    * - statement: 'Text' field to allow long or complex questions.
    * - reward_points: Defines how many points (coins) the user earns for a correct answer.
    * - test_id: Foreign relationship with the 'tests' table.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('enunciado'); 
            $table->integer('reward_points')->default(10); 
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * * Deletes the 'questions' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
