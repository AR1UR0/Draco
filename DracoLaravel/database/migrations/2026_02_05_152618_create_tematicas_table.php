<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateTematicasTable
* Defines the structure for the application's main categories.
* This table allows you to group tests under thematic concepts (e.g., Mythology,
* LOTR, Gloryhammer), facilitating organized navigation for the user.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'themes' table with support for descriptive and visual content:
    * - name: Theme name (limited to 50 characters).
    * - description: Text field to explain what the category is about.
    * - image: Path to the icon or banner representing the theme.
    * - is_active: Logical switch to enable or disable the theme in the UI.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('tematicas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * Deletes the 'tematicas' table.
    * Note: Due to referential integrity, this will fail if linked tests exist
    * unless cascading deletes have been configured.
    * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('tematicas');
    }
};
