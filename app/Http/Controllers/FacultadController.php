<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facultad;

use App\Models\Carrera;
use App\Models\EleccionesFacCarr;

class FacultadController extends Controller
{
    public function index()
    {
        $facultades = Facultad::all();
        return response()->json($facultades);
    }


 
public function obtenerFacultadesPorEleccion($codEleccion)
{
    $facultades = EleccionesFacCarr::select('COD_FACULTAD')
        ->where('COD_ELECCION', $codEleccion)
        ->distinct()
        ->get();

    $facultades = Facultad::whereIn('COD_FACULTAD', $facultades)->get();

    return response()->json($facultades);
}

  


    // Otros métodos del controlador (store, show, update, delete) según tus necesidades
}
