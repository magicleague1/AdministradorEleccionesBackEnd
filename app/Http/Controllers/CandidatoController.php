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
        $cargoPostulado = $request->CARGO_POSTULADO_;
        

        $poblacion = Poblacion::where('CARNETIDENTIDAD', $ci)->first();

        if($poblacion)
        {
            $nuevoIdCandidato = mt_rand(10000, 99999);
            $nuevoCandidato = new Candidato;

            $nuevoCandidato->COD_CANDIDATO = $nuevoIdCandidato;
            $nuevoCandidato->COD_SIS = $poblacion->CODSIS;
            $nuevoCandidato->CARGO_POSTULADO_ = $cargoPostulado;
            $nuevoCandidato->HABILITADO = 1;
            $nuevoCandidato->COD_FRENTE = $frenteId; 

            $nuevoCandidato->save();

            //asocia el candidato al frente
            
           

            return response()->json(['success', 'Candidato asignado correctmanete.']);
        }

        return response()->json(['error', 'No se encontró el CI proporcionado.'], 400);
    }


}