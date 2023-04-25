<?php

namespace App\Http\Controllers;

use App\Models\ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=ventas::all();
        return response (["data"=>$consulta]);
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
            'id_pagos' => 'required | string',
            'id_restaurante' => 'required | string',
            
            
            
         ];

         $messages = [
            'id_pagos'  => 'The :attribute and :other must match.',
            'id_restaurante' => 'The :attribute must be exactly :size.',
            
            
            
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
        $guardar_ventas=new ventas;
        $guardar_ventas->id_pagos=$request->id_pagos;
        $guardar_ventas->id_restaurante=$request->id_restaurante;
        
       $guardar_ventas->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ventas  $ventas
     * @return \Illuminate\Http\Response
     */
    public function show($ventas)
    {
        $venta=ventas::findOrFail($ventas);
        return response (["data"=>$venta]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ventas  $ventas
     * @return \Illuminate\Http\Response
     */
    public function edit(ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ventas  $ventas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $ventas)
    {
        $guardar = [
            'id_pagos' => 'required | string',
            'id_restaurante' => 'required | string',
            
            
            
         ];

         $messages = [
            'id_pagos'  => 'The :attribute and :other must match.',
            'id_restaurante' => 'The :attribute must be exactly :size.',
            
            
            
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_ventas=ventas::findOrFail($ventas);
        
        $guardar_ventas->id_pagos=$request->id_pagos;
        $guardar_ventas->id_restaurante=$request->id_restaurante;
        
       $guardar_ventas->save();
        return response(["data"=>"guardado actualizados correctamente"]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ventas  $ventas
     * @return \Illuminate\Http\Response
     */
    public function destroy($ventas)
    {
        $venta=ventas::findOrFail($ventas);                          
        $venta->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }
}
