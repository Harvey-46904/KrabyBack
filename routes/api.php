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

Route::resource('usuarios', 'UsuarioController',['except'=>['create','edit']]);
Route::resource('comentarios', 'ComentariosController',['except'=>['create','edit']]);
Route::resource('categorias', 'CategoriasController',['except'=>['create','edit']]);
Route::resource('publicidad', 'PublicidadController',['except'=>['create','edit']]);
Route::resource('pagos', 'PagosController',['except'=>['create','edit']]);

Route::resource('tarjetas','TarjetasController',['except'=>['create','edit']]);
Route::resource('comercial','CentroComercialesController',['except'=>['create','edit']]);
Route::resource('calificacion','CalificacionesController',['except'=>['create','edit']]);
Route::resource('menu','MenuController',['except'=>['create','edit']]);
Route::resource('pedido','PedidosController',['except'=>['create','edit']]);
Route::resource('restaurante','RestaurantesController',['except'=>['create','edit']]);
Route::resource('venta','VentasController',['except'=>['create','edit']]);
Route::get('menurestaurante/{id}','RestaurantesController@cons_menu');
Route::post('sesion','UsuarioController@inicioSesion');
