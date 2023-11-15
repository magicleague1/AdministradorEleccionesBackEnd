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



public function verListaComiteConID($idComite)
{
    // Obtener información de titulares
    $titulares = DB::table('asociartitularsuplente')
        ->join('poblacion', 'asociartitularsuplente.COD_SIS', '=', 'poblacion.CODSIS')
        ->select(
            'asociartitularsuplente.COD_COMITE',
            'asociartitularsuplente.ID_TS',
            'asociartitularsuplente.COD_SIS',
            'poblacion.CARNETIDENTIDAD',
            'poblacion.NOMBRE',
            'poblacion.APELLIDO',
            'poblacion.ESTUDIANTE',
            'poblacion.DOCENTE'
        )
        ->where('asociartitularsuplente.COD_COMITE', $idComite)
        ->where('asociartitularsuplente.COD_TITULAR_SUPLENTE', "1")
        ->get();

    // Obtener información de suplentes
    $suplentes = DB::table('asociartitularsuplente')
        ->join('poblacion', 'asociartitularsuplente.COD_SIS', '=', 'poblacion.CODSIS')
        ->select(
            'asociartitularsuplente.COD_COMITE',
            'asociartitularsuplente.ID_TS',
            'asociartitularsuplente.COD_SIS',
            'poblacion.CARNETIDENTIDAD',
            'poblacion.NOMBRE',
            'poblacion.APELLIDO',
            'poblacion.ESTUDIANTE',
            'poblacion.DOCENTE'
        )
        ->where('asociartitularsuplente.COD_COMITE', $idComite)
        ->where('asociartitularsuplente.COD_TITULAR_SUPLENTE', "2")
        ->get();

    // Devuelve una respuesta JSON con los datos
    return response()->json(['titulares' => $titulares, 'suplentes' => $suplentes]);
}


public function actualizarDatos(Request $request)
{

    $request->validate([
        'cod_sis_nuevo' => 'required',
    ]);
    $codComiteActual = $request->input('cod_comite_actual');
    $codSisActual = $request->input('cod_sis_actual');
    $codSisNuevo = $request->input('cod_sis_nuevo');


    $existeAsignacion = DB::table('asociartitularsuplente')
    ->where('COD_SIS', $codSisNuevo)
    ->exists();

    if ($existeAsignacion) {
        return response()->json(['error' => 'El codComiteActual ya está asignado en la tabla asociartitularsuplente'], 400);
    }
        // Eliminar el registro actual de poblacion
    // Eliminar el registro actual de poblacion
    DB::table('poblacion')
    ->where('codcomite', $codComiteActual)
    ->where('codsis', $codSisActual)
    ->update(['codcomite' => null]);

    // Actualizar el campo codcomite en la tabla poblacion
    DB::table('poblacion')
    ->where('codsis', $codSisNuevo)
    ->update(['codcomite' => $codComiteActual]);


    // Actualizar la tabla asociartitularsuplente
    DB::table('asociartitularsuplente')
        ->where('COD_COMITE', $codComiteActual)
        ->where('COD_SIS', $codSisActual)
        ->update(['COD_SIS' => $codSisNuevo]);

    return response()->json(['message' => 'Datos actualizados correctamente']);
}



}
