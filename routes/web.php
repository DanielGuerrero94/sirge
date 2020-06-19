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

Route::get('/doi3',function() {
	config(['database.connections.sirge.port' => '5432']);
	$provincias = App\Provincia::get();
	return view('doi3.doi3', ['provincias' => $provincias]);
});

Route::view('/analisis', 'analisis');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('importaciones', 'ImportacionController');
Route::resource('prestaciones', 'PrestacionController');
Route::get('diccionarios/export', 'DiccionarioController@export');
Route::resource('diccionarios', 'DiccionarioController');
Route::resource('advertencias', 'AdvertenciaController');
Route::resource('tipo_advertencias', 'TipoAdvertenciaController');
Route::resource('errores_importacion', 'ErrorImportacionController');

Route::get('tipo_advertencias/export', 'TipoAdvertenciaController@export');
