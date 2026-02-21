<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: AddMultimediaToRespuestasTable
* This migration expands the 'answers' table to integrate multimodal capabilities.
* It allows answer options to contain visual or audio files, enhancing the pedagogical and engaging quality of the tests.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Runs the migration (Up).
    * Modifies the 'answers' table by adding fields for external resources:
    * - image: Stores the path or filename of the image (e.g., 'imgs/lotr/mordor.jpg').
    * - audio: Stores the path of the audio file (e.g., 'audio/effects/correct.mp3').
    * - after('is_correct'): Keeps the multimedia fields organized at the end of the structure.
    * @author Marta
    */
    public function up(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
            // They are defined as nullable since not all responses require multimedia
            $table->string('image')->nullable()->after('is_correct');
            $table->string('audio')->nullable()->after('image');
        });
    }

    /**
    * Reverts the migration (Down).
    * * Removes the 'image' and 'audio' columns in case of a rollback.
    * * @author Marta
    */
    public function down(): void
    {
        Schema::table('respuestas', function (Blueprint $table) {
            $table->dropColumn(['image', 'audio']);
        });
    }
};
