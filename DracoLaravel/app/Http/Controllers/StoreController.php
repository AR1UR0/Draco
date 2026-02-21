<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

/**
* StoreController Class
* Manages the virtual economy of the DRACO project. Allows users to
*exchange points accumulated in tests for benefits within
*the platform, such as restoring health (lives) or a premium subscription.
* @author Marta
*/
class StoreController extends Controller
{
    /**
    * Loads the online store interface.
    * @author Marta
    * @return \Illuminate\View\View Main store view.
    */
    public function index()
    {
        return view('store'); 
    }

    /**
    * Processes the purchase of health restoration (lives).
    * * Validates if the user already has the maximum number of lives allowed to avoid
    * unnecessary point spending and verifies that the point balance is sufficient
    * to complete the transaction.
    * * @author Marta
    * @return \Illuminate\Http\RedirectResponse Redirect with status message (success/error).
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
    * Processes the acquisition of "Draco Plus" status.
    * * Raises the user's rank to Premium, granting exclusive benefits
    * such as immediate life restoration and access to additional advantages.
    * Uses the decrement method to ensure atomic operation on the points.
    * * @author Marta
    * @return \Illuminate\Http\RedirectResponse Redirection with feedback on the operation.
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
