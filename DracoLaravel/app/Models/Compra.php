<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function objetos()
    {
        return $this->belongsToMany(
            Objeto::class,
            'compra_objeto',
            'compra_id',
            'objeto_id'
        );
    }
}
