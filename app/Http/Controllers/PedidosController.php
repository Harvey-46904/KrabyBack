<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=pedidos::all();
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
            'fecha' => 'required | date',
            'precio' => 'required | string',
            'descuento' => 'required | string',
            'estado' => 'required | string',
            'lista_menu' => 'required | string',
            
            
         ];

         $messages = [
            'fecha'  => 'The :attribute and :other must match.',
            'precio' => 'The :attribute must be exactly :size.',
            'descuento' => 'The :attribute value :input is not between :min - :max.',
            'estado' => 'The :attribute value :input is not between :min - :max.',
            'lista_menu'=> 'The :attribute must be one of the following types: :values',
            
            
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
        $guardar_pedido=new pedidos;
        $guardar_pedido->fecha=$request->fecha;
        $guardar_pedido->precio=$request->precio;
        $guardar_pedido->descuento=$request->descuento;
        $guardar_pedido->estado=$request->estado;
        $guardar_pedido->lista_menu=$request->lista_menu;
       $guardar_pedido->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show($pedidos)
    {
        $pedido=pedidos::findOrFail($pedidos);
        return response (["data"=>$pedido]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(pedidos $pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $pedidos)
    {
        $guardar = [
            'fecha' => 'required | date',
            'precio' => 'required | string',
            'descuento' => 'required | string',
            'estado' => 'required | string',
            'lista_menu' => 'required | string',
            
            
         ];

         $messages = [
            'fecha'  => 'The :attribute and :other must match.',
            'precio' => 'The :attribute must be exactly :size.',
            'descuento' => 'The :attribute value :input is not between :min - :max.',
            'estado' => 'The :attribute value :input is not between :min - :max.',
            'lista_menu'=> 'The :attribute must be one of the following types: :values',
            
            
        ];


        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_pedido=pedidos::findOrFail($pedidos);
        
        $guardar_pedido->fecha=$request->fecha;
        $guardar_pedido->precio=$request->precio;
        $guardar_pedido->descuento=$request->descuento;
        $guardar_pedido->estado=$request->estado;
        $guardar_pedido->lista_menu=$request->lista_menu;
       $guardar_pedido->save();
        return response(["data"=>"datos actualizados"]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy($pedidos)
    {
        $pedido=pedidos::findOrFail($pedidos);                          
        $pedido->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }
}
