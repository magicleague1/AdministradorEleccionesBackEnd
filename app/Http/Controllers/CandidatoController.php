<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Frente;
use App\Models\Poblacion;

class CandidatoController extends Controller
{
    public function asignarCandidatoAFrente(Request $request)
    {
        $frenteId = $request->COD_FRENTE;
        $ci = $request->CARNETIDENTIDAD;
        $cargoPostulado = $request->CARGO_POSTULADO;
        

        $poblacion = Poblacion::where('CARNETIDENTIDAD', $ci)->first();

        if($poblacion)
        {
            $nuevoIdCandidato = mt_rand(10000, 99999);
            $nuevoCandidato = new Candidato;

            $nuevoCandidato->COD_CANDIDATO = $nuevoIdCandidato;
            $nuevoCandidato->COD_CARNETIDENTIDAD = $poblacion->CARNETIDENTIDAD;
            $nuevoCandidato->CARGO_POSTULADO = $cargoPostulado;
            $nuevoCandidato->HABILITADO = 1;
            $nuevoCandidato->COD_FRENTE = $frenteId; 

            $nuevoCandidato->save();

            return response()->json(['success', 'Candidato asignado correctmanete.']);
        }

        return response()->json(['error', 'No se encontró el CI proporcionado.'], 400);
    }

    public function obtenerCandidatosPorFrente($codFrente)
    {
        $candidatos = Candidato::where('COD_FRENTE', $codFrente)->get();

        return response()->json($candidatos);
    }

    public function buscarCarnet($carnetIdentidad)
{
    $carnetExiste = Poblacion::where('carnetidentidad', $carnetIdentidad)->exists();
    
    return response()->json($carnetExiste);
}


public function actualizarCandidato(Request $request)
{
    $candidato = Candidato::find($request->COD_CANDIDATO);

    if ($candidato) {
        $candidato->COD_CARNETIDENTIDAD = $request->CARNET_IDENTIDAD;
        $candidato->CARGO_POSTULADO = $request->CARGO;
        // Aquí puedes agregar más campos que se actualicen

        $candidato->save();

        return response()->json(['message' => 'Candidato actualizado correctamente']);
    } else {
        return response()->json(['error' => 'No se encontró el candidato'], 404);
    }
}

}