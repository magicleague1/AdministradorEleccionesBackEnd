<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EleccionesController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\EleccionController;
use App\Http\Controllers\PoblacionController;

use App\Http\Controllers\FacultadController;
use App\Http\Controllers\CarreraController;

use App\Http\Controllers\EleccionesFacCarrController;
use App\Http\Controllers\MesasController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return "holamundo";
});

//Route::get('/verificarAdministrador',[App\Http\Controllers\AdministradorController::class,"index"]);
Route::get('/verificarAdministradorall', [AdministradorController::class,'index']);

Route::get('verificarAdministrador/{name}', [AdministradorController::class, 'verificarAdministrador']);

Route::get('/obtenerProcesosElectorales',[App\Http\Controllers\ProcesoElectoralController::class,"obtenerProcesosElectorales"]);

Route::post('/crearProcesoElectoral',[App\Http\Controllers\ProcesoElectoralController::class,"agregarProcesoElectoral"]);


Route::post('/asignar-vocales/{COD_COMITE}', [App\Http\Controllers\PoblacionController::class, 'asignarVocales']);

Route::get('/elecciones', [App\Http\Controllers\EleccionController::class, 'index']);

Route::put('/asignar-comite/{COD_ELECCION}', [App\Http\Controllers\ComiteElectoralController::class, 'asignarComite']);


Route::get('/ver-lista-comite/{idComite}', [App\Http\Controllers\AsociarTitularSuplenteController::class, 'verListaComite']);

//veidicar exit
Route::get('/verificar-comite/{codComite}', [App\Http\Controllers\AsociarTitularSuplenteController::class, 'verificarExistenciaComite']);

//Route::get('/elecciones_data', [EleccionesController::class, 'index']);

Route::get('/elecciones_index', [EleccionesController::class, 'index']);

Route::post('/elecciones_data', [EleccionesController::class, 'store']);

Route::get('/obtener_id/{id}', [EleccionesController::class, 'obtenerEleccionPorId']);
Route::put('/eleccionesUpdate/{id}', [EleccionesController::class, 'update']);




Route::post('/eleccionesStore', [EleccionController::class, 'store']);


Route::get('/poblacionindex', [PoblacionController::class, 'index']);


//eleciones


Route::get('/facultades', [FacultadController::class, 'index']);



Route::get('/carreras', [CarreraController::class, 'index']);


Route::get('/carreras/{cod_facultad}', [CarreraController::class, 'getCarrerasByFacultad']);



Route::post('/elecciones_fac_carr', [EleccionesFacCarrController::class, 'store']);


Route::post('/asignar_mesas_carrera/{cod_eleccion}', [MesasController::class, 'asignarMesasPorCarrera']);



Route::get('/mesas_asignadas', [MesasController::class, 'listarMesasAsignadas']);



Route::get('/mesas_asignadas2', [MesasController::class, 'listarMesasAsignadas2']);




Route::post('/agregar_nueva_mesa', [MesasController::class, 'agregarNuevaMesa']);




Route::get('/facultades_por_eleccion/{codEleccion}', [FacultadController::class, 'obtenerFacultadesPorEleccion']);
