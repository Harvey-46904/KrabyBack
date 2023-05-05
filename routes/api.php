<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('cliente','ClientesController',['except'=>['create','edit']]);


Route::get('wasap',"UsuarioController@soporte_wasap");
Route::get('home/{id_saludo}',"ClientesController@home");
Route::get('home',"ClientesController@todos");
Route::post("Registro","UsuarioController@store");
Route::post("acceso","ClientesController@acceso");



Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post("salir","ClientesController@salir");
    Route::resource('cliente','ClientesController',['except'=>['create','edit']]);
});