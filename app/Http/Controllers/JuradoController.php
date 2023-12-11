<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcesoElectoral;
use App\Models\Poblacion;
use App\Models\Mesas;
use App\Models\Jurado;
use App\Notifications\NotificacionModelo;

class JuradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurados = Jurado::with('poblacion')->get();

        return response()->json(['data' => $jurados]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //juradoRequest
    public function store(Request $request,$cod_mesa)
    {   
        $poblacion=Poblacion::all();
        $mesa=Mesas::find($cod_mesa)->NUM_MESA;
       
        [$docentes, $estudiantes] = $poblacion->partition(function ($usuario) {
        return $usuario->DOCENTE;
        });
        
        $docentes=$docentes->random(2);
        $estudiantes=$estudiantes->random(2);

        foreach ($docentes as $key=>$docente) {
            $jurado=new Jurado;
            $jurado->CARGO_JURADO="JURADO";
            
            if($key==0){
                $jurado->CARGO_JURADO="PRESIDENTE DE MESA";
            }
            
            $jurado->COD_SIS=$docente->CODSIS;
            $jurado->COD_MESA=$cod_mesa;

            $jurado->save();
            
            
            if($docente->EMAIL!=NULL){

                if($jurado->CARGO_JURADO=="JURADO"){
                    $docente->notify(new NotificacionModelo("Usted fue eligido como Jurado electoral, Mesa Nro ".$mesa));
                }else{
                    $docente->notify(new NotificacionModelo("Usted fue eligido como Jurado electoral y es Presidente de mesa, Mesa Nro ".$mesa));
                }
            }
                        
        }

        foreach ($estudiantes as $key=>$estudiante) {
            $jurado=new Jurado;
            $jurado->CARGO_JURADO="JURADO";           
            $jurado->COD_SIS=$estudiante->CODSIS;
            $jurado->COD_MESA=$cod_mesa;

            $jurado->save();
                 
            if($estudiante->EMAIL!=NULL){
                $estudiante->notify(new NotificacionModelo("Usted fue eligido como Jurado electoral, Mesa Nro ".$mesa));
            }
            
        }

        return response()->json(['message' => 'Datos registrados en la tabla Jurados']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $jurado=Jurado::find($id);
        $mesa=$jurado->mesa;
        $jurados_de_eleccion=$mesa->eleccion->jurados;


        
        $poblacion=[];
        if($jurado->poblacion->ESTUDIANTE){
            $poblacion=Poblacion::where('ESTUDIANTE',1)->get();
        }else{
            $poblacion=Poblacion::where('DOCENTE',1)->get();
        }

        $poblacionFiltrada = $poblacion->reject(function ($value, $key) use($jurados_de_eleccion){
            return $jurados_de_eleccion->contains('COD_SIS',$value->CODSIS);
        });

        $nuevoJurado=$poblacionFiltrada->random();
        
        $jurado->COD_SIS=$nuevoJurado->CODSIS;
        $jurado->save();

        if($nuevoJurado->EMAIL){
            if($jurado->CARGO_JURADO=="JURADO"){
                $nuevoJurado->notify(new NotificacionModelo("Usted fue eligido como Jurado electoral, Mesa Nro ".$mesa));
            }else{
                $nuevoJurado->notify(new NotificacionModelo("Usted fue eligido como Jurado electoral y es Presidente de mesa, Mesa Nro ".$mesa));
            }
        }
        
        return response()->json(['message' => 'Datos registrados en la tabla Jurados']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
