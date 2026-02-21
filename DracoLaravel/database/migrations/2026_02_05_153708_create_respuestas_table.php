<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateRespuestasTable
* Defines the structure for the answer options of each question.
* It is the final level of the content hierarchy and enables
* interactivity and evaluation of the DRACO system.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'answers' table with binary validation logic:
    * - option: The answer text or option description.
    * - is_correct: Boolean flag (true/false) to identify a valid answer.
    * - question_id: Foreign key that associates the answer with its parent question.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->text('opcion'); 
            $table->boolean('is_correct'); 
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * * Deletes the 'responses' table.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
