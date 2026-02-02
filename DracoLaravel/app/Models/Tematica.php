<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    protected $table = 'tematicas';

    public function tests()
    {
        return $this->hasMany(Test::class, 'tematica_id');
    }

    public function progresos()
    {
        return $this->hasMany(Progreso::class, 'tematica_id');
    }
}
