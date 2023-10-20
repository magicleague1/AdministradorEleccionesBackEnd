<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Elecciones;
use App\Models\Eleccion;
use Illuminate\Support\Facades\DB;


class EleccionesController extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de la tabla eleccions
        return Elecciones::get();
    }
   
    public function store(Request $request)
    {
        $numeroAleatorio = rand(1, 500);
        $eleccion = new Elecciones();
        $eleccion->COD_ADMIN = $request->COD_ADMIN;
        $eleccion->COD_FRENTE = $request->COD_FRENTE;
        $eleccion->COD_TEU = $request->COD_TEU;
        $eleccion->COD_COMITE = $numeroAleatorio;
        $eleccion->MOTIVO_ELECCION = $request->MOTIVO_ELECCION;
        $eleccion->FECHA_ELECCION = $request->FECHA_ELECCION;
        $eleccion->FECHA_INI_CONVOCATORIA = $request->FECHA_INI_CONVOCATORIA;
        $eleccion->FECHA_FIN_CONVOCATORIA = $request->FECHA_FIN_CONVOCATORIA;
        $eleccion->ELECCION_ACTIVA = $request->ELECCION_ACTIVA;
        $eleccion->save();

       

// Convertir el número a un valor de tipo char
      //  $numeroChar = $request->COD_ELECCION+$numeroAleatorio;

        $eleccion = new Eleccion();
        $eleccion->CODELECCION = (string)$numeroAleatorio;
        $eleccion->CODCOMITE = (string)$numeroAleatorio;
        $eleccion->CODADMINISTRADOR = $request->COD_ADMIN;
        $eleccion->MOTIVOELECCION = $request->MOTIVO_ELECCION;
        $eleccion->FECHAELECCION = $request->FECHA_ELECCION;
        $eleccion->ELECCIONACTIVA = $request->ELECCION_ACTIVA;
        $eleccion->save();
       
    
        return "La elección se ha creado correctamente.";
    }
    
    
    public function obtenerEleccionPorId($id)
    {
        $eleccion = Elecciones::find($id);

        if (!$eleccion) {
            return response()->json(['error' => 'El proceso electoral no se encontró.'], 404);
        }

        return response()->json($eleccion);
    }
    public function update(Request $request, $id)
    {
        $eleccion = Elecciones::find($id);

        if(!$eleccion){
            return response()->json(['error' => 'El proceso electoral no se encontró.'], 404);
        }


        $eleccion->update([
        'MOTIVO_ELECCION' => $request->MOTIVO_ELECCION,
        'FECHA_INI_CONVOCATORIA' => $request->FECHA_INI_CONVOCATORIA,
        'FECHA_FIN_CONVOCATORIA' => $request->FECHA_FIN_CONVOCATORIA,
        'FECHA_ELECCION' => $request->FECHA_ELECCION,
        ]);

        return response()->json(['message' => 'Proceso electoral actualizado correctamente.']);
    }


    // Otros métodos del controlador para actualizar, eliminar, mostrar un registro específico, etc.
}
