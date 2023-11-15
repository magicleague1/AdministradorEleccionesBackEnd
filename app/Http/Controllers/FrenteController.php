<?php

namespace App\Http\Controllers;

use App\Models\Frente;
use Illuminate\Http\Request;
use App\Http\Requests\FrenteRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


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
            $frente->save();
        }

        return response()->json(['message' => 'Frente actualizado correctamente.']);
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

