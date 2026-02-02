<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progreso extends Model
{
    protected $table = 'progresos';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'tematica_id');
    }
}

