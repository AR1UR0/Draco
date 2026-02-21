<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Question Class
* * Represents the entity of a question within the DRACO assessment system.
* This model acts as the core of the content, linking each statement
* to a specific test and its multiple answer options.
* * @author Marta
*/
class Pregunta extends Model
{

    /**
    * @var string Name of the associated table in the database.
    */
    protected $table = 'preguntas';

    /**
    * @var array Attributes enabled for mass assignment.
    * Includes the question, reward points, test ID, and optional audio file.
    */
    protected $fillable = ['enunciado', 'reward_points', 'test_id', 'audio']; 

    /**
    * Direct Relationship (Many to One): Each question belongs to a single test.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
    * Inverse Relationship (One-to-Many): One question has multiple answers.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }
}

