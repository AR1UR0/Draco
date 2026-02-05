<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    protected $table = 'tematicas';
    
    protected $fillable = ['name', 'description', 'image', 'is_active']; 

    public function tests()
    {
        return $this->hasMany(Test::class, 'tematica_id');
    }
    
    // Eliminamos progresos() porque esa tabla ya no existe
}