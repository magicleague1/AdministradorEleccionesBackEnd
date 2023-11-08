<?php

namespace App\Http\Controllers;

use App\Models\EleccionesFrente;
use Illuminate\Http\Request;

class EleccionesFrenteController extends Controller
{

    public function index()
    {
        $eleccionesFrentes = EleccionesFrente::all();

        return response()->json($eleccionesFrentes, 200);
    }
    public function store(Request $request)
    {
        // Valida y guarda los datos en la tabla Elecciones_Frente
        $data = $request->validate([
            'COD_ELECCION' => 'required|numeric',
            'COD_FRENTE' => 'required|numeric',
            // Agrega aquí otras validaciones si es necesario
        ]);

        $eleccionFrente = EleccionesFrente::create($data);

        return response()->json($eleccionFrente, 201);
    }

    public function guardarRelacionEleccionesFrente($idEleccion, $idFrente)
    {
        // Crear una nueva instancia del modelo EleccionesFrente y asignar los valores
        $relacion = new EleccionesFrente();
        $relacion->COD_ELECCION = $idEleccion;
        $relacion->COD_FRENTE = $idFrente;

        // Guardar los datos en la tabla elecciones_frente
        $relacion->save();

        return response()->json(['message' => 'Relación guardada exitosamente']);
    }
    
    // Otros métodos como update, destroy, etc., según lo que necesites.
}
