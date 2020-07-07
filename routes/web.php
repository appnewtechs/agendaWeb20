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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('auth\login');
});

Route::get('/mailMessage', function () {
    return view('auth\mailMessage');
});



// Rotas de Cadastros - Perfil do Usuario
Route::group(['prefix' => 'perfilUsuario'], function () {
    Route::get('/'        , 'perfilUsuarioController@index');
    Route::post('create'  , 'perfilUsuarioController@create');
    Route::delete('delete', 'perfilUsuarioController@delete');
});


// Rotas de Cadastros - Usuarios
Route::group(['prefix' => 'usuario'], function () {
    Route::get('/'        , 'usuarioController@index');
    Route::post('create'  , 'usuarioController@create');
    Route::delete('delete', 'usuarioController@delete');
});


// Rotas de Cadastros - Empresas
Route::group(['prefix' => 'empresa'], function () {
    Route::get('/'        , 'empresaController@index');
    Route::post('create'  , 'empresaController@create');
    Route::delete('delete', 'empresaController@delete');
});