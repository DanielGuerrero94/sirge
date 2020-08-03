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

Route::view('/', 'welcome');

Route::get('/doi3', 'DoiController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('importaciones', 'ImportacionController');
Route::resource('prestaciones', 'PrestacionController');
Route::get('diccionarios/export', 'DiccionarioController@export');
Route::get('jobs', 'AdvertenciaController@jobs');
Route::get('advertencias/{importacion}', 'AdvertenciaController@jobs');
Route::resource('diccionarios', 'DiccionarioController');
Route::resource('advertencias', 'AdvertenciaController');
Route::resource('tipo_advertencias', 'TipoAdvertenciaController');
Route::get('analisis/{importacion}', 'ImportacionController@analisis');
Route::get('importaciones/{importacion}/errores', 'ImportacionController@errores');
Route::get('importaciones/{importacion}/validaciones', 'ImportacionController@validaciones');

Route::get('tipo_advertencias/export', 'TipoAdvertenciaController@export');
