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

Route::get('/', function () {
    return view('layouts.dashboard');
});

Route::get('logout','LoginController@logout');

Route::resource('login','LoginController');

Route::middleware(['role:admin|super-admin|estudiante','auth'])->group(function () {
    Route::get('/', function () {
        return view('layouts.dashboard');
    });
});

Route::middleware(['role:admin|super-admin','auth'])->group(function () {

    Route::post('validar-usuario','UserController@validar')->name('usuario.validar');
    Route::post('restaurar-usuario/{id}','UserController@restore')->name('usuario.restore');
    Route::resource('gestion-usuarios','UserController',['names'=>[
        'store' => 'usuario.store',
        'show' => 'usuario.show',
        'update' => 'usuario.update',
        'delete' => 'usuario.delete'
    ]]);

    Route::post('validar-dispositivo','DispositivoController@validar')->name('dispositivo.validar');
    Route::post('restaurar-dispositivo/{id}','DispositivoController@restore')->name('dispositivo.restore');
    Route::resource('gestion-dispositivos','DispositivoController',['names'=>[
        'store' => 'dispositivo.store',
        'show' => 'dispositivo.show',
        'update' => 'dispositivo.update',
        'delete' => 'dispositivo.delete'
    ]]);

    Route::post('realizar-prestamo','PrestamoController@realizar_prestamo')->name('prestamo.realizar');
    Route::get('detalle-prestamo/{id}','PrestamoController@detallePrestamo')->name('prestamo.detalle');
    Route::resource('prestamos','PrestamoController',['names'=>[
        'store' => 'prestamos.store',
        'show' => 'prestamos.show',
        'update' => 'prestamos.update',
        'delete' => 'prestamos.delete'
    ]]);

});