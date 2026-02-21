<?php

namespace App\Http\Controllers; 

use App\Models\Tematica;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

/**
* ThematicController Class
* * Acts as the main orchestrator of the navigation interface.
* Its main function is to serve as a bridge between the content database
* (fantasy universes, video games, mythology) and the user interface.
* * @author Marta
*/
class TematicaController extends Controller
{
    /**
    * Manages the loading of the main page (Learning Dashboard).
    * * Retrieves the complete catalog of topics available in the system
    * using the Eloquent model and injects them into the view for display.
    * * @author Marta
    * @return \Illuminate\View\View 'mainPage' view with the collection of topics.
    */
    public function index()
    {

        $tematicas = Tematica::all();

        return view('pagPrincipal', compact('tematicas'));
    }
}