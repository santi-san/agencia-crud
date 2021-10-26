<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
# Route::get( 'peticion', acción );
Route::get('/saludo', function (){
    return 'buen día marcos';
} );
Route::get('/uno', function (){
    return view('primera');
});
Route::get('/dos', function (){
    // crearemos datos a pasar a una vista
    $limite = 15;

    // retornamos vista pasandoe datos
    return view('segunda',
                [
                    'nombre'=>'marcos',
                    'limite'=>$limite
                ]
            );
});
Route::get('/formulario', function (){
    return view('formulario');
});
Route::post('/procesa', function (){
    $nombre = $_POST['nombre'];
    return view('procesa',
                    [ 'nombre'=>$nombre ]
            );
});
######## Plantillas
Route::get('/inicio', function ()
{
    return view('inicio');
});

######################################
####### CRUD de regiones #############
Route::get('/adminRegiones', function ()
{
    $regiones = DB::table('regiones')
                        ->get();
    return view('adminRegiones',
                    [ 'regiones'=>$regiones ]
            );
});
Route::get('/agregarRegion', function ()
{
    return view('agregarRegion');
});
Route::post('/agregarRegion', function ()
{
    //capturamos datos enviados por el form
    $regNombre = $_POST['regNombre'];
    //dar alta
    DB::table('regiones')->insert([ 'regNombre'=>$regNombre ]);
    //redireccionar con un mensaje
    return redirect('/adminRegiones')
                ->with('mensaje', 'Región: '.$regNombre.' agregada correctamente');
});
Route::get('/modificarRegion/{id}', function($id)
{
    //obtenemos datos de región por su id
    $region = DB::table('regiones')
                        ->where('regID', $id)
                        ->first();
    //retornamos vista del form pasando los datos
    return view('modificarRegion',
                    [ 'region'=>$region ]
                );
});
Route::post('/modificarRegion', function ()
{
    //capturamos datos enviados por el form
    $regID = $_POST['regID'];
    $regNombre = $_POST['regNombre'];
    //modificamos
    DB::table('regiones')
                ->where('regID', $regID)
                ->update( [ 'regNombre'=>$regNombre ] );
    //redirección con mensaje
    return redirect('/adminRegiones')
                ->with('mensaje', 'Región: '.$regNombre.' modificada correctamente');
});
Route::get('/eliminarRegion/{id}', function ($id)
{
    //obtenemos datos de la región a eliminar
    $region = DB::table('regiones')
                    ->where('regID', $id)
                    ->first();
    //retornamos vista de confirmacion pasando datos
    return view('eliminarRegion',
                    [ 'region'=>$region ]
            );
});
Route::post('/eliminarRegion', function ()
{
    //capturamos datos en viados por el form
    $regNombre = $_POST['regNombre'];
    $regID = $_POST['regID'];
    //borramos la región
    /*
    DB::delete('DELETE FROM regiones
                    WHERE regID = :regID',
                    [ $regID ]
              );
    */
    DB::table('regiones')
                ->where('regID', $regID)
                ->delete();
    //redirección con mensaje de confirmación
    return redirect('/adminRegiones')
        ->with('mensaje', 'Región: '.$regNombre.' eliminada correctamente');

});
########################################
######## CRUD de destinos  #############
Route::get('/adminDestinos', function()
{
    $destinos = DB::table('destinos as d')
                        ->join('regiones as r', 'r.regID', 'd.regID')
                        ->get();
    return view('adminDestinos',
                        [ 'destinos'=>$destinos ]
                );
});
Route::get('/agregarDestino', function ()
{
    $regiones = DB::table('regiones')
                        ->get();
    return view('agregarDestino',
                [ 'regiones'=>$regiones ]
            );
});
Route::post('/agregarDestino', function ()
{
    //capturamos datos enviados por el form
    $destNombre = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];
    //dar alta
    DB::table('destinos')->insert(
        [ 'destNombre'=>$destNombre,
          'regID'=>$regID,
          'destPrecio'=>$destPrecio,
          'destAsientos'=>$destAsientos,
          'destDisponibles'=>$destDisponibles
        ]
    );
    //redireccionar con un mensaje
    return redirect('/adminDestinos')
                ->with('mensaje', 'Destino: '.$destNombre.' agregada correctamente');
});
Route::get('/modificarDestino/{id}', function($id)
{
    //obtenemos datos de destino por su id
    $destino = DB::table('destinos as d')
                        ->join('regiones as r', 'r.regID', 'd.regID')
                        ->where('destID', $id)
                        ->first();
    //retornamos vista del form pasando los datos
    return view('modificarDestino',
                    [ 
                        'destino'=>$destino
                    ]
                );
});
Route::post('/modificarDestino', function () {
    //capturamos datos enviados por el form
    $destID = $_POST['destID'];
    $destNombre = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];

    //modificamos
    DB::table('destinos')
                ->where('destID', $destID)
                ->update(
                    [ 
                        'destNombre'=>$destNombre,
                        'regID'=>$regID,
                        'destPrecio'=>$destPrecio,
                        'destAsientos'=>$destAsientos,
                        'destDisponibles'=>$destDisponibles
                    ]
                 );
    //redirección con mensaje
    return redirect('/adminDestinos')
                ->with('mensaje', 'Destino: '.$destNombre.' modificada correctamente');
});
Route::get('/eliminarDestino/{id}', function ($id)
{
    //obtenemos datos de la región a eliminar
    $destino = DB::table('destinos as d')
                        ->join('regiones as r', 'r.regID', 'd.regID')
                        ->where('destID', $id)
                        ->first();
    //retornamos vista de confirmacion pasando datos
    return view('eliminarDestino',
                    [ 'destino'=>$destino ]
            );
});
Route::post('/eliminarRegion', function ()
{
    //capturamos datos en viados por el form
    $destNombre = $_POST['destNombre'];
    $destID = $_POST['destID'];
    //borramos el destino
    DB::table('destinos')
                ->where('destID', $destID)
                ->delete();
    //redirección con mensaje de confirmación
    return redirect('/adminDestiones')
        ->with('mensaje', 'destión: '.$destNombre.' eliminada correctamente');
});