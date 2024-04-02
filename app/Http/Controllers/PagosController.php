<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use Illuminate\Http\Request;
use Validator;
use App\Services\CobruServices;
use DB;
class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pagos::all();
        return response(['data'=>$pagos]);
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
           
            'Id_pedido' => 'required|string',
            'Monto' => 'required|string',
            'Estado' => 'required|string',

        ];

        $messages = [
            
            'Id_pedido.required' => 'Digité id pedido',
            'Monto.required' => 'Digité el monto',
            'Estado.required' => 'Digité el estado',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_pagos = new Pagos;
           
            $agregar_pagos->Id_pedido = $request->Id_pedido;
            $agregar_pagos->Monto = $request->Monto;
            $agregar_pagos->Estado = $request->Estado;
            $agregar_pagos->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function show($pagos)
    {
        $pago = Pagos::findOrFail($pagos);
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagos $pagos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$pagos)
    {
        $rules = [
           
            'Id_pedido' => 'required|string',
            'Monto' => 'required|string',
            'Estado' => 'required|string',

        ];

        $messages = [
            
            'Id_pedido.required' => 'Digité id pedido',
            'Monto.required' => 'Digité el monto',
            'Estado.required' => 'Digité el estado',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_pagos = Pagos::findOrFail($pagos);
           
            $actualizar_pagos->Id_pedido = $request->Id_pedido;
            $actualizar_pagos->Monto = $request->Monto;
            $actualizar_pagos->Estado = $request->Estado;
            $actualizar_pagos->save();
            return response( [ 'data'=>'Actualizado exitosamente' ] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function destroy($pagos)
    {
        $pagos = Pagos::findOrFail($pagos);
        $pagos->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }

    public function crear_orden(Request $request,CobruServices $cobru){
        //generar cobru
      
        $datos=$cobru->crear_cobru($request->subtotal);
        
        $data = [
            'pk' => $datos["pk"],
            'amount' => $datos["amount"],
            'state' => $datos["state"],
            'date_created' => $datos["date_created"],
            'payment_method' => $datos["payment_method"],
            'url' => $datos["url"],
            'owner' => $datos["owner"],
            'payed_amount' => $datos["payed_amount"],
            'description' => "Pago Kraby",
            'payment_method_enabled' => $datos["payment_method_enabled"],
            'expiration_days' => $datos["expiration_days"],
            'fee_amount' =>$datos["fee_amount"],
            'iva_amount' => $datos["iva_amount"],
            'platform' => $datos["platform"],
            'carrito' => '{"producto1": "descripcion producto 1", "producto2": "descripcion producto 2"}'
        ];
            
           
            DB::table('pedidos')->insert($data);

            return response($data);
          
       // return response();
    }

    public function pago_nequi(Request $request,CobruServices $cobru){

        $uri=$request->urlcobru;
        return response($cobru->push_nequi($uri));
    }
}
