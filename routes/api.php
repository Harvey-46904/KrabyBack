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

Route::resource('clientes', 'ClientesController',['except'=>['create','edit']]);
Route::resource('usuarios', 'UsuarioController',['except'=>['create','edit']]);
Route::resource('comentarios', 'ComentariosController',['except'=>['create','edit']]);
Route::resource('categorias', 'CategoriasController',['except'=>['create','edit']]);
Route::resource('publicidad', 'PublicidadController',['except'=>['create','edit']]);
Route::resource('pagos', 'PagosController',['except'=>['create','edit']]);

Route::resource('carrito','CarritoController',['except'=>['create','edit']]);
Route::resource('tarjetas','TarjetasController',['except'=>['create','edit']]);
Route::resource('comercial','CentroComercialesController',['except'=>['create','edit']]);
Route::resource('calificacion','CalificacionesController',['except'=>['create','edit']]);
Route::resource('menu','MenuController',['except'=>['create','edit']]);
Route::resource('pedido','PedidosController',['except'=>['create','edit']]);
Route::resource('restaurante','RestaurantesController',['except'=>['create','edit']]);
Route::resource('venta','VentasController',['except'=>['create','edit']]);
Route::resource('variacion','VariacionesController',['except'=>['create','edit']]);
Route::get('menurestaurante/{id}','RestaurantesController@cons_menu');
Route::get('informacion_restaurante_total/{id}','RestaurantesController@informacion_total_restaurante');
Route::post('sesion','UsuarioController@inicioSesion');
Route::post('registro_usuario','AuthController@register');
Route::post('Login','AuthController@Login');
Route::get('menurestaurantecate/{id}','RestaurantesController@menu_categorizado');
Route::get('configuracion_restaurante/{id}','MenuController@configuracion_restaurante');
Route::get('configuracion_restaurante_app/{id}','MenuController@configuracion_restaurante_app');

Route::get('lista_restaurantes_centro_comercial/{id_centro_comercial}','RestaurantesController@lista_resutarantes_centro_comercial');
Route::get('filtrado/{id}','VariacionesController@filtrado');



Route::get('data/{carpeta}/{nombre}', function ($carpeta,$nombre) {
    
    $public_path = public_path();
    $url = $public_path.'/storage/'.$carpeta."/".$nombre;// depende de root en el archivo filesystems.php.
    //verificamos si el archivo existe y lo retornamos
    return response()->file($url);
        return response()->download($url);
    
    //si no se encuentra lanzamos un error 404.
    abort(404);
  
  });