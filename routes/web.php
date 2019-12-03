<?php

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

Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('ajax/horarios', 'HorarioEmpleadoController@getHorarios');
Route::get('/categorias/reporte', 'CategoriaController@generarPDF');
Route::get('/empleados/reporte', 'EmpleadoController@generarPDF');
Route::get('/logs/reporte', 'LogEmpleadoController@generarPDF');

Route::resource('categorias', 'CategoriaController');
Route::resource('empleados', 'EmpleadoController');
Route::resource('horarios', 'HorarioEmpleadoController');
Route::resource('logs', 'LogEmpleadoController');
