<?php

namespace App\Http\Controllers; // Esto es vital, indica dónde está el archivo

use App\Models\Tematica;
use Illuminate\Http\Request; // Importación estándar por si la necesitas luego
use App\Http\Controllers\Controller; // Esto le dice a PHP de dónde sacar la clase Controller

/**
 * Clase TematicaController
 * * Actúa como el orquestador principal de la interfaz de navegación.
 * Su función principal es servir de puente entre la base de datos de contenidos
 * (universos de fantasía, videojuegos, mitología) y la interfaz de usuario.
 * * @author Marta
 */
class TematicaController extends Controller
{
    /**
     * Gestiona la carga de la página principal (Dashboard de aprendizaje).
     * * Recupera el catálogo completo de temáticas disponibles en el sistema
     * mediante el modelo Eloquent y las inyecta en la vista para su visualización.
     * * @author Marta
     * @return \Illuminate\View\View Vista 'pagPrincipal' con la colección de temáticas.
     */
    public function index()
    {

        $tematicas = Tematica::all();

        return view('pagPrincipal', compact('tematicas'));
    }
}