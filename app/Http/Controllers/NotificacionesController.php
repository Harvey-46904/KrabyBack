<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
use DB;

class NotificacionesController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $agregar = Notificaciones::all();
        return response ( [ 'data'=>$agregar ] );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {

        $rules = [
            'Id_usuario' => 'required|string',
            'Nombre_notificacion' => 'required|string',
            'Descripcion' => 'required|string',
            'Estado' => 'required|string',
        ];

        $messages = [
            'Id_usuario.required' => 'Digité id usuario',
            'Nombre_notificacion.required' => 'Digité nombre notificación',
            'Descripcion.required' => 'Digité descripcion',
            'Estado.required' => 'Digité estado',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_nota = new Notificaciones;
            $agregar_nota->Id_usuario = $request->Id_usuario;
            $agregar_nota->Nombre_notificacion = $request->Nombre_notificacion;
            $agregar_nota->Descripcion = $request->Descripcion;
            $agregar_nota->Estado = $request->Estado;
            $agregar_nota->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Notificaciones  $notificaciones
    * @return \Illuminate\Http\Response
    */

    public function show( $notificaciones ) {

        $consultar = Notificaciones::findOrFail( $notificaciones );
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Notificaciones  $notificaciones
    * @return \Illuminate\Http\Response
    */

    public function edit( Notificaciones $notificaciones ) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Notificaciones  $notificaciones
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $notificaciones ) {

        $rules = [
            'Id_usuario' => 'required|string',
            'Nombre_notificacion' => 'required|string',
            'Descripcion' => 'required|string',
            'Estado' => 'required|string',
        ];

        $messages = [
            'Id_usuario.required' => 'Digité id usuario',
            'Nombre_notificacion.required' => 'Digité notificacion',
            'Descripcion.required' => 'Digité descripcion',
            'Estado.required' => 'Digité estado',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_nota = Notificaciones::findOrFail( $notificaciones );
            $actualizar_nota->Id_usuario = $request->Id_usuario;
            $actualizar_nota->Nombre_notificacion = $request->Nombre_notificacion;
            $actualizar_nota->Descripcion = $request->Descripcion;
            $actualizar_nota->Estado = $request->Estado;
            $actualizar_nota->save();
            return response( [ 'data'=>'Registro actualizado exitosamente' ] );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Notificaciones  $notificaciones
    * @return \Illuminate\Http\Response
    */

    public function destroy( $notificaciones ) {

        $notificaciones = Notificaciones::findOrFail( $notificaciones );
        $notificaciones->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }

    public function notificacion( Request $request ) {
        $enviar_nota = new Notificaciones;
        $enviar_nota->Id_usuario = $request->Id_usuario;
        $enviar_nota->Nombre_notificacion = $request->Nombre_notificacion;
        $enviar_nota->Descripcion = $request->Descripcion;
        $enviar_nota->Estado = $request->Estado;
        $enviar_nota->save();
        return response( [ 'data' => 'Dato registrado' ] );
    }

}
