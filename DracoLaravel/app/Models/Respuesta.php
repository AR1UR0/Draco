<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* Response Class
* * Represents the possible answer options for each question in the system.
* This model allows determining the validity of the user's choices and supports
* various response formats (text, image, or audio) to enrich the experience.
* * @author Marta
*/
class Respuesta extends Model
{

    /**
    * @var string Name of the table in the database.
    */
    protected $table = 'respuestas';

    /**
    * @var array Attributes enabled for bulk assignment.
    * 'is_correct' is the critical boolean field for the TestController's correctness logic.
    */
    protected $fillable = ['opcion', 'is_correct', 'pregunta_id', 'image', 'audio'];

    /**
    * Inverse Relationship (Many-to-One): Each response belongs to only one question.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
}

