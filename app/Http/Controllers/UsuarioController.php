<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Validator;

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
        return response([$adicion]);
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
           
            'Nombre' => 'required|string',
            'Telefono' => 'required|string',
            'Correo' => 'required|string',
            'Direccion' => 'required|string',
            'Tipo_documento' => 'required|string',
            'Ciudad' => 'required|string',
        ];

        $messages = [
           
            'Nombre.required' => 'Digité nombre',
            'Telefono.required' => 'Digité teléfono',
            'Correo.required' => 'Digité correo',
            'Direccion.required' => 'Digité dirección',
            'Tipo_documento.required' => 'Digité Tipo de Documento',
            'Ciudad.required' => 'Digité Ciudad',
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_usuario = new Usuario;
           
            $agregar_usuario->Nombre = $request->Nombre;
            $agregar_usuario->Telefono = $request->Telefono;
            $agregar_usuario->Correo = $request->Correo;
            $agregar_usuario->Direccion = $request->Direccion;
            $agregar_usuario->Tipo_documento = $request->Tipo_documento;
            $agregar_usuario->Ciudad = $request->Ciudad;
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
    public function show($usuario)
    {
        $consultar = Usuario::findOrFail($usuario);
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
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
    public function update(Request $request,$usuario)
    {
        $rules = [
        
            'Nombre' => 'required|string',
            'Telefono' => 'required|string',
            'Correo' => 'required|string',
            'Direccion' => 'required|string',
            'Tipo_documento' => 'required|string',
            'Ciudad' => 'required|string',
        ];

        $messages = [
            
            'Nombre.required' => 'Digité nombre',
            'Telefono.required' => 'Digité teléfono',
            'Correo.required' => 'Digité correo',
            'Direccion.required' => 'Digité dirección',
            'Tipo_documento.required' => 'Digité Tipo de Documento',
            'Ciudad.required' => 'Digité Ciudad',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_usuario = Usuario::findOrFail($usuario);
           
            $actualizar_usuario->Nombre = $request->Nombre;
            $actualizar_usuario->Telefono = $request->Telefono;
            $actualizar_usuario->Correo = $request->Correo;
            $actualizar_usuario->Direccion = $request->Direccion;
            $actualizar_usuario->Tipo_documento = $request->Tipo_documento;
            $actualizar_usuario->Ciudad = $request->Ciudad;
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
    public function destroy($usuario)
    {
        $usuario = Usuario::findOrFail($usuario);
        $usuario->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }

    public function inicioSesion(Request $request){
        $rules = [
        'Telefono' => 'required|string',
        ];
        $messages = [
        'Telefono.required' => 'Digité teléfono',
        ];
        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
        $Telefono = $request->Telefono;
        //return response (["data"=>$consulta]);
        $sesion = DB::table('usuarios')->select("usuarios.Nombre","usuarios.Telefono","usuarios.Correo","usuarios.Direccion")
        ->where("usuarios.Telefono","=",$Telefono)
        ->get();

       return response (["data"=>[
                    "usuario"=>count($sesion)==0?"usuario no disponible":$sesion,
        ]]);
    }
}
}
