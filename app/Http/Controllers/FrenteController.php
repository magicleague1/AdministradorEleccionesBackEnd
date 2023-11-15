<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarFrente;
use App\Models\Frente;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class FrenteController extends Controller
{
    public function index()
    {
        $frentes = Frente::where('ARCHIVADO', false)->get();

        return response()->json($frentes);
    }

    public function store(Request $request)
    {

        $fechaActual = now();
        $fechaFormateada = now()->toDateString(); 
        $frente = new Frente;


        $frente -> NOMBRE_FRENTE = $request->NOMBRE_FRENTE;
        $frente -> SIGLA_FRENTE = $request->SIGLA_FRENTE;
        $frente -> FECHA_INSCRIPCION = $request-> FECHA_INSCRIPCION; 
        $frente -> ARCHIVADO = false;

        $frente -> save();

        return response()->json(['message' => 'Se ha inscrito el frente correctamente.']);
    }

    public function show($id)
    {
        $frente = Frente::where('ARCHIVADO',false)->find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.', 404]);
        }

        return response()->json($frente);
    }

    public function update(Request $request, $id)
    {
        $frente = Frente::find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.']);
        }

        $frente -> NOMBRE_FRENTE = $request->NOMBRE_FRENTE;
        $frente -> SIGLA_FRENTE = $request->SIGLA_FRENTE;
        $frente ->FECHA_INSCRIPCION = $request->FECHA_INSCRIPCION;
        
        $frente -> save();
    }

    public function delete($id)
    {
        $frente = Frente::where('ARCHIVADO',false)->find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.']);
        }

        $frente -> ARCHIVADO = true;
        $frente->save();

        return response()->json(['message' => 'El frente se ha eliminado correctamente.']);
    }

    public function listarFrentesYCandidatos()
    {
        $frentes = Frente::with('candidato')->get();
        
        return response()->json(['frentes' => $frentes]);
    }
}

