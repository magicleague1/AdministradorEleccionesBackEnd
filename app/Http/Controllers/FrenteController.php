<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidarFrente;
use App\Models\Frente;
use Carbon\Carbon;

class FrenteController extends Controller
{
    public function index()
    {
        $frentes = Frente::where('ARCHIVADO', false)->get();

        return response()->json($frentes);
    }

    public function store(ValidarFrente $request)
    {
        $frente = new Frente;

        $frente -> NOMBRE_FRENTE = $request->NOMBRE_FRENTE;
        $frente -> SIGLA_FRENTE = $request->SIGLA_FRENTE;
        $frente -> FECHA_INSCRIPCION = Carbon::now()->toDateString();
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

    public function update(ValidarFrente $request, $id)
    {
        $frente = Frente::find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.']);
        }

        $frente -> NOMBRE_FRENTE = $request->NOMBRE_FRENTE;
        $frente -> SIGLA_FRENTE = $request->SIGLA_FRENTE;
        
        $frente -> save();
    }

    public function destroy($id)
    {
        $frente = Frente::where('ARCHIVADO',false)->find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.']);
        }

        $frente -> ARCHIVADO = true;

        return response()->json(['message' => 'El frente se ha eliminado correctamente.']);
    }
}

