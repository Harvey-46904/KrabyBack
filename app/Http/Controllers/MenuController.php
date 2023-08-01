<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Validator;
use App\Models\menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=menu::all();
        return response ($consulta);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guardar = [
            'idrestaurante' => 'required | string',
            'id_categoria' => 'required | string',
            'producto' => 'required | string',
            'is_menu_dia' => 'required | string',
            'precio' => 'required | integer',
            'imagen_menu' => 'required | string',
            
         ];

         $messages = [
            'idrestaurante'  => 'The :attribute and :other must match.',
            'id_categoria'  => 'The :attribute and :other must match.',
            'producto' => 'The :attribute must be exactly :size.',
            'is_menu_dia' => 'The :attribute value :input is not between :min - :max.',
            'precio' => 'The :attribute must be exactly :size.',
            'imagen_menu'=> 'The :attribute must be one of the following types: :values',
            
        ];

        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
        $guardar_menu=new menu;
        $guardar_menu->idrestaurante=$request->idrestaurante;
        $guardar_menu->id_categoria=$request->id_categoria;
        $guardar_menu->producto=$request->producto;
        $guardar_menu->is_menu_dia=$request->is_menu_dia;
        $guardar_menu->precio=$request->precio;
        $guardar_menu->imagen_menu=$request->imagen_menu;
        $guardar_menu->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $men=restaurantes::findOrFail($menu);
        return response (["data"=>$men]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
    {
        $guardar = [
            'id_categoria' => 'required | string',
            'producto' => 'required | string',
            'is_menu_dia' => 'required | string',
            'precio' => 'required | integer',
            'imagen_menu' => 'required | string',
            
         ];

         $messages = [
            'id_categoria'  => 'The :attribute and :other must match.',
            'producto' => 'The :attribute must be exactly :size.',
            'is_menu_dia' => 'The :attribute value :input is not between :min - :max.',
            'precio' => 'The :attribute must be exactly :size.',
            'imagen_menu'=> 'The :attribute must be one of the following types: :values',
            
        ];

        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_menu=menu::findOrFail($menu);
        
        $guardar_menu->id_categoria=$request->id_categoria;
        $guardar_menu->producto=$request->producto;
        $guardar_menu->is_menu_dia=$request->is_menu_dia;
        $guardar_menu->precio=$request->precio;
        $guardar_menu->imagen_menu=$request->imagen_menu;
        $guardar_menu->save();
        return response(["data"=>"datos actualizados"]);
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $men=menu::findOrFail($menu);                          
        $men->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }
}
