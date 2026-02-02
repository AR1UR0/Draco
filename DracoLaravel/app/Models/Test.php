<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'tematica_id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'test_id');
    }
}