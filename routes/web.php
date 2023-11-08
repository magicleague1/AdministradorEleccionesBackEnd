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

use App\Http\Controllers\PoblacionFacuCarrController;
use App\Http\Controllers\ConvocatoriaEleccionesController;

use App\Http\Controllers\PublicarConvocatoriaController;


use App\Http\Controllers\EleccionesFrenteController;

use App\Http\Controllers\CandidatoController;


use App\Http\Controllers\FrenteController;



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
//Route::get('/asignar-vocales/{COD_COMITE}/{COD_ELECCION}', [App\Http\Controllers\PoblacionController::class, 'asignarVocales']);

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


//contadores

// Ruta para contar la cantidad total de alumnos en una facultad
Route::get('/contar_alumnos_facultad/{codFacultad}', [PoblacionFacuCarrController::class, 'contarAlumnosPorFacultad']);

// Ruta para contar la cantidad de alumnos por carrera en una facultad
Route::get('/contar_alumnos_carrera/{codFacultad}/{codCarrera}', [PoblacionFacuCarrController::class, 'contarAlumnosPorCarrera']);


//cantidades

Route::get('/cantidad/{facultad_id}', [PoblacionFacuCarrController::class, 'obtenerCantidadPorFacultad']);

//convocatoria



Route::get('/convocatorias', [ConvocatoriaEleccionesController::class, 'index']);
Route::post('/convocatorias_crear', [ConvocatoriaEleccionesController::class, 'store']);
Route::get('/convocatorias/{id}', [ConvocatoriaEleccionesController::class, 'show']);
Route::get('/convocatorias2/{id}', [ConvocatoriaEleccionesController::class, 'show2']);

Route::put('/convocatorias/{id}', [ConvocatoriaEleccionesController::class, 'update']);
Route::delete('/convocatorias/{id}', [ConvocatoriaEleccionesController::class, 'destroy']);

Route::get('/obtener_id_convocatoria/{idEleccion}', [ConvocatoriaEleccionesController::class, 'obtenerIdConvocatoria']);



Route::get('/generar_pdf/{id}', [ConvocatoriaEleccionesController::class, 'generarPDF']);
Route::get('/generar_pdf_publicado/{id}', [ConvocatoriaEleccionesController::class, 'generarPDF_Publicado']);
Route::get('/generar_pdf2/{id}', [ConvocatoriaEleccionesController::class, 'generarPDF2']);




Route::get('/publicar_convocatorias', [PublicarConvocatoriaController::class, 'index']);
Route::post('/publicar_convocatorias_crear', [PublicarConvocatoriaController::class, 'store']);
Route::get('/publicar_convocatorias/{id}', [PublicarConvocatoriaController::class, 'show']);
Route::put('/publicar_convocatorias/{id}', [PublicarConvocatoriaController::class, 'update']);
Route::delete('/publicar_convocatorias/{id}', [PublicarConvocatoriaController::class, 'destroy']);



Route::get('/publicar_convocatoria_lista', [PublicarConvocatoriaController::class, 'listaPublicarConvocatoria']);


//fernado routes

Route::prefix('frentes')->group(function(){
    Route::get('/',[FrenteController::class, 'index'])->name('frentes');
    Route::post('/nuevo',[FrenteController::class, 'store']);
    Route::get('/{frente}',[FrenteController::class, 'show'])->name('frente.show');
    Route::put('/{frente}',[FrenteController::class, 'update'])->name('frente.update');
    Route::delete('/{frente}',[FrenteController::class, 'delete'])->name('frente.delete');
});

Route::get('/frentesyCandidatos', [FrenteController::class, 'listarFrentesYCandidatos'])->name('frente.candidatos');

//Asignar Candidatos al frente
Route::post('frentes/asignarCandidatos', [CandidatoController::class, 'asignarCandidatoAFrente']);

//Asignar Frente a Proceso electoral
Route::post('frentes/asignarFrenteAEleccion', [EleccionesController::class, 'asignarFrente']);

//para tabla eleccionesFrente
Route::post('/elecciones_frente', [EleccionesFrenteController::class, 'store']);
Route::get('/elecciones_frente', [EleccionesFrenteController::class, 'index']);
