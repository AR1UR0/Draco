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
        $precioVida = 100;

        if ($user->current_lives >= $user->max_lives) {
            return back()->with('error', 'Ya tienes el máximo de vidas permitidas.');
        }

        if ($user->points >= $precioVida) {
            $user->points -= $precioVida;
            $user->current_lives = $user->max_lives;
            $user->save(); 

            return back()->with('success', "¡Vida recargadas al máximo!");
        }

        return back()->with('error', 'No tienes suficientes monedas.');
    }


    public function buyPlus()
    {
        $user = Auth::user();
        $precioPlus = 2000; 

        if ($user->is_plus) {
            return back()->with('error', 'Ya tienes Draco Plus activado.');
        }

        if ($user->points >= $precioPlus) {
            $user->decrement('points', $precioPlus);
            $user->is_plus = true;
            $user->current_lives = $user->max_lives; 
            $user->save();

            return back()->with('success', '¡Bienvenido a Draco Plus! Vidas ilimitadas activadas.');
        }

        return back()->with('error', 'No tienes suficientes monedas para Draco Plus.');
    }


}
