<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Poblacion;
use App\Models\Eleccion;
use App\Models\AsociarTitularSuplente;
use Illuminate\Support\Facades\DB;

class AsociarTitularSuplenteController extends Controller
{
    public function store(Request $request)
    {
        // Valida y guarda los datos en la tabla asociar_titularSuplente
        $data = $request->validate([
            'ID_TS' => 'required',
            'COD_SIS' => 'required',
            'COD_COMITE' => 'required',
            'COD_TITULAR_SUPLENTE' => 'required',
        ]);

        AsociarTitularSuplente::create($data);

        return response()->json(['message' => 'Registro creado con éxito'], 201);
    }

    public function verListaComite($idComite)
    {
        // Filtrar registros con codTitular_Suplente = 1
        $titulares = DB::table('asociartitularsuplente')
            ->join('poblacion', 'asociartitularsuplente.COD_SIS', '=', 'poblacion.CODSIS')
            ->select(
                'poblacion.CARNETIDENTIDAD',
                'poblacion.NOMBRE',
                'poblacion.APELLIDO',
                'poblacion.ESTUDIANTE', // Agregar campo ESTUDIANTE
                'poblacion.DOCENTE' // Agregar campo DOCENTE
            )
            ->where('asociartitularsuplente.COD_COMITE', $idComite)
            ->where('asociartitularsuplente.COD_TITULAR_SUPLENTE', "1")
            ->get();
    
        // Consulta para los suplentes (codTitular_Suplente = 2)
        $suplentes = DB::table('asociartitularsuplente')
            ->join('poblacion', 'asociartitularsuplente.COD_SIS', '=', 'poblacion.CODSIS')
            ->select(
                'poblacion.CARNETIDENTIDAD',
                'poblacion.NOMBRE',
                'poblacion.APELLIDO',
                'poblacion.ESTUDIANTE', // Agregar campo ESTUDIANTE
                'poblacion.DOCENTE' // Agregar campo DOCENTE
            )
            ->where('asociartitularsuplente.COD_COMITE', $idComite)
            ->where('asociartitularsuplente.COD_TITULAR_SUPLENTE', "2")
            ->get();
    
        // Devuelve una respuesta JSON con los datos
        return response()->json(['titulares' => $titulares, 'suplentes' => $suplentes]);
    }
    

    public function verificarExistenciaComite($codComite)
{
    // Realiza una consulta para verificar la existencia del comité en la tabla asocialtitularsuplente
    $existeComite = DB::table('asociartitularsuplente')
        ->where('COD_COMITE', $codComite)
        ->exists();

    return response()->json(['existeComite' => $existeComite]);
}



}
