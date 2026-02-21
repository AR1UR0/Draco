<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Thematic Class
* * Represents the platform's main content categories (e.g., Mythology, Star Wars).
* This model acts as the top-level entity in the knowledge hierarchy,
* grouping the different tests under a common thematic context.
* * @author Marta
*/
class Tematica extends Model
{

    /**
    * @var string Name of the table in the database.
    */
    protected $table = 'tematicas';

    /**
    * @var array Attributes enabled for bulk assignment.
    * Includes visual metadata (image) and availability status (is_active).
    */
    protected $fillable = ['name', 'description', 'image', 'is_active']; 

    /**
    * Direct Relationship (One to Many): One topic encompasses multiple tests.
    * This relationship allows the system to automatically retrieve all associated levels or quizzes when a topic is selected in the interface.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function tests()
    {
        return $this->hasMany(Test::class, 'tematica_id');
    }
    
    
}