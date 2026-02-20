<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

/**
 * Clase StoreController
 * * Gestiona la economía virtual del proyecto DRACO. Permite a los usuarios
 * intercambiar los puntos acumulados en los tests por beneficios dentro de
 * la plataforma, como la restauración de salud (vidas) o la suscripción premium.
 * * @author Marta
 */
class StoreController extends Controller
{
    /**
     * Carga la interfaz de la tienda virtual.
     * * @author Marta
     * @return \Illuminate\View\View Vista principal de la tienda.
     */
    public function index()
    {
        return view('store'); 
    }

    /**
     * Procesa la compra de restauración de salud (vidas).
     * * Valida si el usuario ya posee el máximo de vidas permitidas para evitar
     * el gasto innecesario de puntos y verifica que el saldo de puntos sea suficiente
     * para realizar la transacción.
     * * @author Marta
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de estado (éxito/error).
     */
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

    /**
     * Procesa la adquisición del estatus "Draco Plus".
     * * Eleva el rango del usuario a Premium, lo que otorga beneficios exclusivos
     * como la restauración inmediata de vidas y acceso a ventajas adicionales.
     * Utiliza el método decrement para asegurar una operación atómica sobre los puntos.
     * * @author Marta
     * @return \Illuminate\Http\RedirectResponse Redirección con feedback sobre la operación.
     */
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
