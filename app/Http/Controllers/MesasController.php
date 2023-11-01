<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesas;
use App\Models\EleccionesFacCarr;
use App\Models\Elecciones;

use Illuminate\Support\Facades\DB;



class MesasController extends Controller
{
    // Métodos del controlador, como store, index, show, update, destroy, etc.
    // por ejemplo, store para la creación de mesas:
    public function store(Request $request)
    {
        $mesa = Mesas::create($request->all());

        // Puedes realizar acciones adicionales aquí, si es necesario
        // Por ejemplo, devolver una respuesta JSON con la mesa creada
        return response()->json($mesa, 201);
    }



    public function asignarMesasPorCarrera($cod_eleccion)
    {
        // Obtener las carreras para la elección especificada
        $carreras = EleccionesFacCarr::where('COD_ELECCION', $cod_eleccion)->get();

        foreach ($carreras as $carrera) {
            $cod_carrera = $carrera->COD_CARRERA;
            $cod_facultad = $carrera->COD_FACULTAD;

            // Insertar 3 mesas por cada carrera
            for ($i = 1; $i <= 3; $i++) {
                $mesa = new Mesas();
                $mesa->COD_ELECCION = $cod_eleccion;
                $mesa->COD_FACULTAD = $cod_facultad;
                $mesa->COD_CARRERA = $cod_carrera;
                $mesa->NUM_MESA = $i;
                $mesa->CANT_EST_MESA = 0; // Asignar la cantidad de estudiantes inicial, si es necesario
                $mesa->save();
            }
        }

        return response()->json(['message' => 'Mesas asignadas por carrera para la elección.']);
    }


    public function listarMesasAsignadas()
    {
        


    $mesasAsignadas = Mesas::select(
        'Mesas.*',
        'Eleccioness.MOTIVO_ELECCION',
        'Facultad.nombre_facultad',
        'Carrera.nombre_carrera'
    )
        ->join('Eleccioness', 'Mesas.COD_ELECCION', '=', 'Eleccioness.COD_ELECCION')
        ->join('Facultad', 'Mesas.COD_FACULTAD', '=', 'Facultad.COD_FACULTAD')
        ->join('Carrera', 'Mesas.COD_CARRERA', '=', 'Carrera.COD_CARRERA')
        ->get();

        return response()->json([
            'listaElecciones' => Elecciones::all(),
            'mesasPorCarrera' => $mesasPorCarrera,
            'mesasDetalladas' => $mesasAsignadas
        ]);
}


public function listarMesasAsignadas2()
{
    $mesasAsignadas = Mesas::select(
        'Eleccioness.COD_ELECCION',
        'Eleccioness.MOTIVO_ELECCION',
        'Facultad.nombre_facultad',
        'Eleccioness.fecha_eleccion',
        'Carrera.COD_CARRERA',
        'Carrera.nombre_carrera'
    )
        ->join('Eleccioness', 'Mesas.COD_ELECCION', '=', 'Eleccioness.COD_ELECCION')
        ->join('Facultad', 'Mesas.COD_FACULTAD', '=', 'Facultad.COD_FACULTAD')
        ->join('Carrera', 'Mesas.COD_CARRERA', '=', 'Carrera.COD_CARRERA')
        ->distinct()
        ->get();

    $response = [];

    foreach ($mesasAsignadas as $mesa) {
        $codEleccion = $mesa->COD_ELECCION;
        $motivo = $mesa->MOTIVO_ELECCION;
        $fecha = $mesa->fecha_eleccion;
        $facultad = $mesa->nombre_facultad;
        $nombreCarrera = $mesa->nombre_carrera;

        if (!isset($response[$codEleccion])) {
            $response[$codEleccion] = [
                'motivo' => $motivo,
                'fecha_eleccion' => $fecha,
                'facultad' => $facultad,
                'carreras' => []
            ];
        }

        if (!isset($response[$codEleccion]['carreras'][$nombreCarrera])) {
            $totalMesas = Mesas::where('COD_ELECCION', $codEleccion)
                ->where('COD_CARRERA', $mesa->COD_CARRERA)
                ->count();

            $response[$codEleccion]['carreras'][$nombreCarrera] = [
                'nombre_carrera' => $nombreCarrera,
                'total_mesas_por_carrera' => $totalMesas
            ];
        }
    }

    // Reorganizar la respuesta para obtener el formato correcto
    $formattedResponse = [];
    foreach ($response as $codEleccion => $eleccionData) {
        $formattedResponse[] = [
            'motivo' => $eleccionData['motivo'],
            'facultad' => $eleccionData['facultad'],
            'fecha_eleccion' => $eleccionData['fecha_eleccion'],
            'carreras' => array_values($eleccionData['carreras'])
        ];
    }

    return response()->json($formattedResponse);
}



public function agregarNuevaMesa(Request $request)
{
    $cod_eleccion = $request->input('COD_ELECCION');
    $cod_facultad = $request->input('COD_FACULTAD');
    $cod_carrera = $request->input('COD_CARRERA');
    
    // Obtener el último número de mesa para una carrera en una elección
    $ultimaMesa = Mesas::where('COD_ELECCION', $cod_eleccion)
        ->where('COD_FACULTAD', $cod_facultad)
        ->where('COD_CARRERA', $cod_carrera)
        ->orderBy('NUM_MESA', 'desc')
        ->first();

    // Aumentar el número de mesa
    $nuevoNumeroMesa = $ultimaMesa ? $ultimaMesa->NUM_MESA + 1 : 1;

    $cant_est_mesa = $request->input('CANT_EST_MESA');

    // Crear y guardar la nueva mesa con el nuevo número
    $nuevaMesa = new Mesas();
    $nuevaMesa->COD_ELECCION = $cod_eleccion;
    $nuevaMesa->COD_FACULTAD = $cod_facultad;
    $nuevaMesa->COD_CARRERA = $cod_carrera;
    $nuevaMesa->NUM_MESA = $nuevoNumeroMesa;
    $nuevaMesa->CANT_EST_MESA = $cant_est_mesa;
    $nuevaMesa->save();

    return response()->json(['message' => 'Nueva mesa agregada con éxito', 'num_mesa' => $nuevoNumeroMesa]);
}


        /*$mesasAsignadas = Mesas::select('Mesas.*', 'eleccioness.MOTIVO_ELECCION', 'facultad.nombre_facultad', 'carrera.nombre_carrera')
            ->join('eleccioness', 'mesas.COD_ELECCION', '=', 'eleccioness.COD_ELECCION')
            ->join('facultad', 'mesas.COD_FACULTAD', '=', 'facultad.COD_FACULTAD')
            ->join('carrera', 'mesas.COD_CARRERA', '=', 'carrera.COD_CARRERA')
            ->get();

        return response()->json($mesasAsignadas);*/
    

    // Otros métodos del controlador según sea necesario
}
