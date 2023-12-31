<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comite_Electoral;
use App\Models\Elecciones;

use App\Models\Poblacion;
use App\Models\AsociarTitularSuplente;
use Illuminate\Support\Facades\DB;



class ComiteElectoralController extends Controller
{


    public function asignarComite(Request $request,$COD_ELECCION) {

    
        
        // Obtén la información de la elección
        $eleccion = Elecciones::where('COD_ELECCION', $COD_ELECCION)->first();

        $datop=$request->input('ELECCION');
        if ($eleccion) {
            // Paso 1: Obtén la lista de COD_SIS de asociar_titularSuplente para el comité actual
            $asignados = DB::table('asociartitularsuplente')
                ->pluck('COD_SIS')
                ->toArray();
          
            // Paso 2: Filtra docentes y estudiantes cuyos COD_SIS no estén en la lista de asignados
            $docentes = Poblacion::where('DOCENTE', 1)
                ->where('CODCOMITE', null)
                ->whereNotIn('CODSIS', $asignados)
                ->inRandomOrder()
                ->limit(6)
                ->get();
  

            $estudiantes = Poblacion::where('ESTUDIANTE', 1)
                ->where('CODCOMITE', null)
                ->whereNotIn('CODSIS', $asignados)
                ->inRandomOrder()
                ->limit(4)
                ->get();

            // Asigna el COD_COMITE de la elección a los registros obtenidos en el paso 2
            foreach ($docentes as $docente) {
                $docente->update(['CODCOMITE' => $eleccion->COD_COMITE]);
               // $docente->save();
            }

            foreach ($estudiantes as $estudiante) {
                $estudiante->update(['CODCOMITE' => $eleccion->COD_COMITE]);
               // $estudiante->save();
               
            }
          
            return response()->json(['message' => 'Asignación de comité exitosa']);
        } else {
            return response()->json(['error' => 'Election not found'], 404);
        }
    }

}
