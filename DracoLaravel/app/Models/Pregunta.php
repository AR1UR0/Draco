<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $fillable = ['enunciado', 'reward_points', 'test_id', 'audio']; 

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }
}

