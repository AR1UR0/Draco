<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Test Class
* * Represents a specific questionnaire or level within a topic.
* This model organizes the questions into logical blocks and allows for establishing
* a sequential learning order for the user.
* * @author Marta
*/
class Test extends Model
{
    /**
    * @var string Name of the associated table in the database.
    */
    protected $table = 'tests';

    /**
    * @var array Attributes enabled for bulk assignment.
    * 'order' allows sorting the tests so they appear in a specific sequence.
    */
    protected $fillable = ['title', 'order', 'tematica_id']; 

    /**
    * Direct Relationship (Many to One): Each test belongs to a single theme.
    * Allows access to data from the parent category (e.g., knowing that the "Gondor" test belongs to the "Lord of the Rings" theme).
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'tematica_id');
    }

    /**
    * Inverse Relationship (One to Many): A test contains multiple questions.
    * This is the main relationship used by the QuestionController to load
    * the test content.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'test_id');
    }
}