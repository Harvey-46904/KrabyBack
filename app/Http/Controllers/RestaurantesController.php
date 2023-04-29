<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Validator;
use App\Models\restaurantes;
use Illuminate\Http\Request;

class RestaurantesController extends Controller
 {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
 {
        $consulta = restaurantes::all();
        return response ( [ 'data'=>$consulta ] );
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

    public function store( Request $request )
 {
        $guardar = [
            'id_centro_comercial' => 'required | string',
            'id_cliente' => 'required | string',
            'nombre_restaurante' => 'required | string',
            'foto_baner' => 'required | string',

        ];

        $messages = [
            'id_centro_comercial'  => 'The :attribute and :other must match.',
            'id_cliente' => 'The :attribute must be exactly :size.',
            'nombre_restaurante' => 'The :attribute value :input is not between :min - :max.',
            'foto_baner'=> 'The :attribute must be one of the following types: :values',

        ];

        $validator = Validator::make( $request->all(), $guardar,  $messages );

        if ( $validator->fails() ) {
            return response( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $guardar_restaurante = new restaurantes;
            $guardar_restaurante->id_centro_comercial = $request->id_centro_comercial;
            $guardar_restaurante->id_cliente = $request->id_cliente;
            $guardar_restaurante->nombre_restaurante = $request->nombre_restaurante;
            $guardar_restaurante->foto_baner = $request->foto_baner;
            $guardar_restaurante->save();
            return response( [ 'data'=>'guardado exitosamente' ] );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\restaurantes  $restaurantes
    * @return \Illuminate\Http\Response
    */

    public function show( $restaurantes )
 {
        $restaurante = restaurantes::findOrFail( $restaurantes );
        return response ( [ 'data'=>$restaurante ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\restaurantes  $restaurantes
    * @return \Illuminate\Http\Response
    */

    public function edit( restaurantes $restaurantes )
 {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\restaurantes  $restaurantes
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request,  $restaurantes )
 {
        $guardar = [
            'id_centro_comercial' => 'required | string',
            'id_cliente' => 'required | string',
            'nombre_restaurante' => 'required | string',
            'foto_baner' => 'required | string',

        ];

        $messages = [
            'id_centro_comercial'  => 'The :attribute and :other must match.',
            'id_cliente' => 'The :attribute must be exactly :size.',
            'nombre_restaurante' => 'The :attribute value :input is not between :min - :max.',
            'foto_baner'=> 'The :attribute must be one of the following types: :values',

        ];
        $validator = Validator::make( $request->all(), $guardar,  $messages );
        if ( $validator->fails() ) {
            return response( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $guardar_restaurante = restaurantes::findOrFail( $restaurantes );
            $guardar_restaurante->id_centro_comercial = $request->id_centro_comercial;
            $guardar_restaurante->id_cliente = $request->id_cliente;
            $guardar_restaurante->nombre_restaurante = $request->nombre_restaurante;
            $guardar_restaurante->foto_baner = $request->foto_baner;
            $guardar_restaurante->save();
            return response( [ 'data'=>'datos actualizados' ] );
        }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\restaurantes  $restaurantes
    * @return \Illuminate\Http\Response
    */

    public function destroy( $restaurantes )
 {
        $restaurantes = restaurantes::findOrFail( $restaurantes );
        $restaurantes->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }
}
