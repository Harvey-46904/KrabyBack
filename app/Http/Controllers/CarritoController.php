<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Validator;
use App\Models\carrito;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrito = carrito::all();
        return response(['data'=>$carrito]);
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
        $rules = [
            
            'producto_cantidad' => 'required|string',
        ];

        $messages = [
            
            'producto_cantidad.required' => 'Digité nombre de carrito',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_carrito = new carrito;
            
            $agregar_carrito->producto_cantidad = $request->producto_cantidad;
            $agregar_carrito->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\carrito  $carrito
     * @return \Illuminate\Http\Response
     */
    public function show($carrito)
    {
        $carrito = carrito::findOrFail( $carrito );
        return response( [ 'data'=>$carrito ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\carrito  $carrito
     * @return \Illuminate\Http\Response
     */
    public function edit(carrito $carrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\carrito  $carrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $carrito)
    {
        $rules = [
            
            'producto_cantidad' => 'required|string',
        ];

        $messages = [
            
            'producto_cantidad.required' => 'Digité nombre de categoria',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {

        $guardar_carrito=carrito::findOrFail($carrito);
        $guardar_carrito->producto_cantidad=$request->producto_cantidad;
         $guardar_carrito->save();
        return response(["data"=>"datos actualizados"]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\carrito  $carrito
     * @return \Illuminate\Http\Response
     */
    public function destroy( $carrito)
    {
        $carrito=carrito::findOrFail($carrito);                          
        $carrito->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }
}
