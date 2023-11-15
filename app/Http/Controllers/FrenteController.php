<?php

namespace App\Http\Controllers;

use App\Models\Frente;
use Illuminate\Http\Request;
use App\Http\Requests\FrenteRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\MotivoEliminacion;


class FrenteController extends Controller
{
    public function index()
    {
        $frentes = Frente::where('ARCHIVADO', false)->get();

        return response()->json($frentes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'NOMBRE_FRENTE' => 'required|string|min:2|max:30|unique:frentes,NOMBRE_FRENTE',
            'SIGLA_FRENTE' => 'required|string|min:2|max:15|unique:frentes,SIGLA_FRENTE',
            'LOGO' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fechaActual = now();

        if($request->hasFile('LOGO'))
        {
            $logo = $request->file('LOGO');
            $nombreLogo = uniqid() . '-' . $logo->getClientOriginalName();
            $logo->storeAs('public/logos', $nombreLogo);

            $frente = new Frente();

            $frente -> NOMBRE_FRENTE = $request->NOMBRE_FRENTE;
            $frente -> SIGLA_FRENTE = $request->SIGLA_FRENTE;
            $frente -> FECHA_INSCRIPCION = $fechaActual; 
            $frente -> ARCHIVADO = false;
            $frente->LOGO = $nombreLogo;
            
            $frente -> save();
        } else {
            return response()->json(['error' => 'No se proporcionó ningun logo.'], 400);
        }

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

        $request->validate([
            'NOMBRE_FRENTE' => 'string|min:2|max:30|unique:frentes,NOMBRE_FRENTE,'. $id,
            'SIGLA_FRENTE' => 'string|min:2|max:15|unique:frentes,SIGLA_FRENTE,id,lt_field:NOMBRE_FRENTE'. $id,
            'LOGO' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $frente = Frente::find($id);

        if (!$frente) {
            return response()->json(['error' => 'No se encontró el frente para actualizar.']);
        }

        $frente->fill($request->only(['NOMBRE_FRENTE', 'SIGLA_FRENTE']));

        if ($request->hasFile('LOGO')) {

            Storage::delete('public/logos/' . $frente->LOGO);

            $logo = $request->file('LOGO');
            $nombreLogo = uniqid() . '-' . $logo->getClientOriginalName();
            $logo->storeAs('public/logos', $nombreLogo);

            $frente->LOGO = $nombreLogo;
            
            if($frente->save()){
                return response()->json(['message' => 'Frente actualizado correctamente.']);
            }else{
                return response()->json(['error' => 'Error al actualizar el frente.']);
            }
        }

        
    }


    public function delete(Request $request, $id)
    {
        $motivo = $request->MOTIVO;

        if(empty(trim($motivo))){
            return response()->json(['error' => 'El motivo no puede estar vacio.']);
        }

        $motivoEliminacion = MotivoEliminacion::where('MOTIVO', $motivo)->first();

        if(!$motivoEliminacion){
            $motivoEliminacion = MotivoEliminacion::create(['MOTIVO' => $motivo]);
        }

        $frente = Frente::where('ARCHIVADO',false)->find($id);

        if(!$frente)
        {
            return response()->json(['error' => 'No se encontró el frente.']);
        }

        $frente -> ARCHIVADO = true;
        $frente -> COD_MOTIVO = $motivoEliminacion->COD_MOTIVO;
        $frente -> save();

        return response()->json(['message' => 'El frente se ha eliminado correctamente.']);
    }

    public function listarFrentesYCandidatos()
    {
        $frentes = Frente::with('candidato')->get();
        
        return response()->json(['frentes' => $frentes]);
    }
}

