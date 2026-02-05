<?php

namespace App\Http\Controllers; // Esto es vital, indica dónde está el archivo

use App\Models\Tematica;
use Illuminate\Http\Request; // Importación estándar por si la necesitas luego
use App\Http\Controllers\Controller; // Esto le dice a PHP de dónde sacar la clase Controller

class TematicaController extends Controller
{
    public function index()
    {
        // Recuperamos todas las temáticas de la base de datos
        $tematicas = Tematica::all();

        // Enviamos a la vista
        return view('pagPrincipal', compact('tematicas'));
    }
}