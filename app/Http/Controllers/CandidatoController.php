<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Frente;

class CandidatoController extends Controller
{
    public function asignarCandidatoAFrente(Request $request)
    {
        $frenteId = $request->COD_FRENTE;
        $ci = $request->CARNETIDENTIDAD;
        

        $candidato = Candidato::where('CARNETIDENTIDAD', $ci)->first();

        if(!$candidato)
        {
            return response()->json(['error', 'No se encontró el CI proporcionado.']);
        }

        $cargo = $request->input('CARGO_POSTULADO_');
        $candidato->cargo = $cargo;
        $candidato->save();

        $frente = Frente::find($frenteId);

        if(!$frente)
        {
            return response()->json(['error', 'El frente seleccionado no existe. ']);
        }

        $frente->candidatos()->attach($candidato->id);

        return response()->json(['success', 'Candidato asignado correctmanete.']);
    }


}
