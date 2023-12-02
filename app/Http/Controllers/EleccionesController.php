<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Elecciones;
use App\Models\Frente;

use App\Models\EleccionesFacCarr;
use App\Models\EleccionesFrente;
use App\Models\Facultad;
use App\Models\Carrera;

use Illuminate\Support\Facades\DB;


class EleccionesController extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de la tabla eleccions
        return Elecciones::get();
    }

    public function store(Request $request)
    {
        $cod_admin = $request->input('COD_ADMIN');
        $cod_frente = $request->input('COD_FRENTE');
        $cod_teu = $request->input('COD_TEU');
        $motivo_eleccion = $request->input('MOTIVO_ELECCION');
        $fecha_eleccion = $request->input('FECHA_ELECCION');
        $fecha_ini_convocatoria = $request->input('FECHA_INI_CONVOCATORIA');
        $fecha_fin_convocatoria = $request->input('FECHA_FIN_CONVOCATORIA');
        $eleccion_activa = $request->input('ELECCION_ACTIVA');
        $tipo_eleccion = $request->input('TIPO_ELECCION');
        $cod_facultad = $request->input('cod_facultad');
        $cod_carrera = $request->input('cod_carrera');

        $cod_facultad = $request->input('cod_facultad');
        $cod_carrera = $request->input('cod_carrera');

        $eleccion = new Elecciones();
        $eleccion->cod_admin = $cod_admin;
        $eleccion->cod_frente = $cod_frente;
        $eleccion->cod_teu = $cod_teu;
        $eleccion->cod_comite = rand(1, 500); // Genera el código de comité
        $eleccion->motivo_eleccion = $motivo_eleccion;
        $eleccion->tipo_eleccion=$tipo_eleccion;
        $eleccion->fecha_eleccion = $fecha_eleccion;
        $eleccion->fecha_ini_convocatoria = $fecha_ini_convocatoria;
        $eleccion->fecha_fin_convocatoria = $fecha_fin_convocatoria;
        $eleccion->eleccion_activa = $eleccion_activa;
        $eleccion->save();
        $cod_eleccion = $eleccion->getKey();

        

        if ($motivo_eleccion === 'universitaria') {
            // Obtener todas las facultades y sus carreras
            $facultadesYCarreras = DB::table('facultad')
                ->join('Carrera', 'Facultad.COD_FACULTAD', '=', 'Carrera.COD_FACULTAD')
                ->select('Facultad.COD_FACULTAD as cod_facultad', 'Carrera.COD_CARRERA as cod_carrera')
                ->get();

            // Insertar en la tabla EleccionesFacCarr
            foreach ($facultadesYCarreras as $row) {
                DB::table('elecciones_fac_carr')->insert([
                    'COD_ELECCION' => $cod_eleccion, // Utiliza el ID de la elección que acabas de crear
                    'COD_FACULTAD' => $row->cod_facultad,
                    'COD_CARRERA' => $row->cod_carrera,
                ]);
            }
        }elseif ($motivo_eleccion === 'facultativa') {
            // Obtener las carreras de una facultad específica
            $carrerasFacultad = DB::table('Carrera')
                ->where('COD_FACULTAD', $cod_facultad)
                ->select('COD_CARRERA as cod_carrera')
                ->get();

            // Insertar en la tabla EleccionesFacCarr
            foreach ($carrerasFacultad as $row) {
                DB::table('Elecciones_Fac_Carr')->insert([
                    'COD_ELECCION' => $cod_eleccion, // Utiliza el ID de la elección que acabas de crear
                    'COD_FACULTAD' => $cod_facultad,
                    'COD_CARRERA' => $row->cod_carrera,
                ]);
            }
        } elseif ($motivo_eleccion === 'carrera') {
            // Insertar en la tabla EleccionesFacCarr solo para una carrera específica
            DB::table('Elecciones_Fac_Carr')->insert([
                'COD_ELECCION' => $cod_eleccion, // Utiliza el ID de la elección que acabas de crear
                'COD_FACULTAD' => $cod_facultad,
                'COD_CARRERA' => $cod_carrera,
            ]);
        }
        elseif  ($motivo_eleccion === 'universitaria2') {
            $eleccion_fac_carr = new EleccionesFacCarr();
            $eleccion_fac_carr->cod_eleccion = $cod_eleccion;
            $eleccion_fac_carr->cod_facultad = $cod_facultad;
            $eleccion_fac_carr->cod_carrera = $cod_carrera;
            $eleccion_fac_carr->save();
        }

        return "La elección se ha creado correctamente.";
    }


    public function obtenerEleccionPorId($id)
    {
        $eleccion = Elecciones::find($id);

        if (!$eleccion) {
            return response()->json(['error' => 'El proceso electoral no se encontró.'], 404);
        }

        return response()->json($eleccion);
    }

    public function update(Request $request, $id)
    {
        $eleccion = Elecciones::find($id);

        if(!$eleccion){
            return response()->json(['error' => 'El proceso electoral no se encontró.'], 404);
        }


        $eleccion->update([
        'MOTIVO_ELECCION' => $request->MOTIVO_ELECCION,
        'FECHA_INI_CONVOCATORIA' => $request->FECHA_INI_CONVOCATORIA,
        'FECHA_FIN_CONVOCATORIA' => $request->FECHA_FIN_CONVOCATORIA,
        'FECHA_ELECCION' => $request->FECHA_ELECCION,
        ]);

        return response()->json(['message' => 'Proceso electoral actualizado correctamente.']);
    }

    // Otros métodos del controlador para actualizar, eliminar, mostrar un registro específico, etc.
    public function asignarFrente(Request $request)
    {
        $eleccionId = $request->COD_ELECCION;
        $frenteId = $request->COD_FRENTE;

        $eleccion = Elecciones::find($eleccionId);
        $frente = Frente::find($frenteId);

        if(!$eleccion || !$frente)
        {
            return response()->json(['error' => 'El proceso electoral o el frente político no existen.'], 400);
        }

        $eleccion->frente()->associate($frente);
        $eleccion->save();

        return response()->json(['message' => 'Frente asignado al procesos electoral correctamente.']);
    }

}
