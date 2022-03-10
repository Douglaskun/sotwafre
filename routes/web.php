<?php

use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MesaController;
use App\Producto;
use Illuminate\Support\Facades\Auth;
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
    return redirect('/login');
});

Auth::routes();

Route::resource('mesas', MesaController::class);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cuerpo', 'HomeController@Principal');

Route::get('/Registrar',            'ProductoController@index');
Route::get('/prueba/{id}',          'ProductoController@prueba');
Route::get('/prueba/{id}/{idmesa}', 'ProductoController@prueba2');
Route::post('/registrarproducto',   'ProductoController@create')->name('RegistrarProductos'); //revisar su url
Route::post('/editarproducto',      'ProductoController@edit');

Route::get('/pedir/{idPro}/{idMesa}',                                       'PedidoController@create');
Route::post('/atenderpedido/{id}/{idMesa}',                                 'PedidoController@create');
Route::get('/EliminarPedido/{idMesa}/{idDetallePedido}/{idPedido}/{id}',    'PedidoController@destroy');
Route::post('/editarPedido/{id}/{idMesa}',                                  'PedidoController@edit');

Route::get('/cobrar/{idMesa}/{comensal?}',  'ConsumoController@create');
Route::get('registrarConsumo/{idMesa}',     'ConsumoController@show');
Route::post('/ConsultarReporteDiario',      'ConsumoController@ReporteDia');
Route::get('/DetalleBoleta/{id}',           'ConsumoController@ReporteDetallado');
Route::get('/ObtenerPdf/{id}',              'ConsumoController@ObtenerPdf');
Route::get('/ObtenerPdfDiario/{fecha}',     'ConsumoController@ObtenerPdfDiario');

Route::get('/comensal',                 'HomeController@dirigir');
Route::post('/registrarComensal',       'HomeController@registrarComensal')->name('registrarComensal');
Route::post('/editarComensal',          'HomeController@editarComensal');
Route::post('/buscarComensal/{idMesa}', 'ConsumoController@buscarComensal');

Route::get('/Reportes', 'ConsumoController@VerReporte');

Route::get('/carta',  'HomeController@carta');

Route::get('/crearboleta/{idPedido}/{idComensal}', 'ConsumoController@creaBoleta');

Route::get('registerMozo',      'HomeController@VerRegister');
Route::get('/AtenderMesa/{id}', 'MesaController@VerPedido');

Route::get('/registrarmes', 'MesaController@index');
Route::get('/regismes', 'MesaController@store');
