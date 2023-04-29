<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
use DB;

class UsuarioController extends Controller
 {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
 {
        $adicion = Usuario::all();
        return response( [ 'data'=>$adicion ] );
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
        $rules = [
            'Nombre' => 'required|string',
            'Apellido' => 'required|string',
            'Tipo_identificacion' => 'required|string',
            'Celular' => 'required|string',
            'Ciudad' => 'required|string',
            'Correo_electronico' => 'required|string',
        ];

        $messages = [
            'Nombre.required' => 'Digité nombre',
            'Apellido.required' => 'Digité apellido',
            'Tipo_identificacion.required' => 'Digité identificacion',
            'Celular.required' => 'Digité celular',
            'Ciudad.required' => 'Digité ciudad',
            'Correo_electronico.required' => 'Digité correo electronico',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_usuario = new Usuario;
            $agregar_usuario->Nombre = $request->Nombre;
            $agregar_usuario->Apellido = $request->Apellido;
            $agregar_usuario->Tipo_identificacion = $request->Tipo_identificacion;
            $agregar_usuario->Celular = $request->Celular;
            $agregar_usuario->Ciudad = $request->Ciudad;
            $agregar_usuario->Correo_electronico = $request->Correo_electronico;
            $agregar_usuario->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Usuario  $usuario
    * @return \Illuminate\Http\Response
    */

    public function show( $usuario ) {

        $consultar = Usuario::findOrFail( $usuario );
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Usuario  $usuario
    * @return \Illuminate\Http\Response
    */

    public function edit( Usuario $usuario )
 {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Usuario  $usuario
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $usuario )
 {
        $rules = [
            'Nombre' => 'required|string',
            'Apellido' => 'required|string',
            'Celular' => 'required|string',
            'Tipo_identificacion' => 'required|string',
            'Ciudad' => 'required|string',
            'Correo_electronico' => 'required|string',
        ];

        $messages = [
            'Nombre.required' => 'Digité nombre',
            'Apellido.required' => 'Digité apellido',
            'Tipo_identificacion.required' => 'Digité identificacion',
            'Celular.required' => 'Digité celular',
            'Ciudad.required' => 'Digité ciudad',
            'Correo_electronico.required' => 'Digité correo electronico',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_usuario = Usuario::findOrFail( $usuario );
            $actualizar_usuario->Nombre = $request->Nombre;
            $actualizar_usuario->Apellido = $request->Apellido;
            $actualizar_usuario->Tipo_identificacion = $request->Tipo_identificacion;
            $actualizar_usuario->Celular = $request->Celular;
            $actualizar_usuario->Ciudad = $request->Ciudad;
            $actualizar_usuario->Correo_electronico = $request->Correo_electronico;
            $actualizar_usuario->save();
            return response( [ 'data'=>'Registro actualizado exitosamente' ] );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Usuario  $usuario
    * @return \Illuminate\Http\Response
    */

    public function destroy( $usuario ) {
        $usuario = Usuario::findOrFail( $usuario );
        $usuario->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }
}

