<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
* Migration: CreateRolesTable
* This class defines the structure of the 'roles' table in the database.
* It is the cornerstone of DRACO's RBAC security system, allowing
* users to be categorized according to their privileges.
* @author Marta
*/
return new class extends Migration
{
    /**
    * Run the migration (Up).
    * Create the 'roles' table with the following fields:
    * - id: Auto-incrementing primary key.
    * - name: Role name (e.g., 'admin', 'user'), limited to 50 characters to optimize space.
    * - timestamps: Automatically records the creation and update dates.
    * @author Marta
    */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); 
            $table->timestamps();
        });
    }

    /**
    * Reverts the migration (Down).
    * Deletes the table from the database. This method is essential for
    * maintaining a clean development environment and enabling the rollback of changes.
    * @author Marta
    */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
