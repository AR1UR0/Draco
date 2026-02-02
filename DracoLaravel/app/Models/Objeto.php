<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    protected $table = 'objetos';

    public function compras()
    {
        return $this->belongsToMany(
            Compra::class,
            'compra_objeto',
            'objeto_id',
            'compra_id'
        );
    }
}




