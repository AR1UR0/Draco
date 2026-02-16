<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Carga la vista de la tienda
    public function index()
    {
        return view('store'); 
    }

    // Lógica para comprar vidas
    public function buyLife()
    {
        $user = Auth::user();
        $precioVida = 100; // Puedes ajustar el precio aquí

        if ($user->points >= $precioVida) {
            $user->decrement('points', $precioVida); // Resta puntos
            $user->increment('current_lives', 1);   // Suma una vida
            return back()->with('success', '¡Vida comprada!');
        }

        return back()->with('error', 'No tienes suficientes puntos.');
    }
}
