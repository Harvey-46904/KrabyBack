<?php

namespace App\Http\Controllers;

use App\Models\Publicidad;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;

class PublicidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publicidad = Publicidad::all();
        return response(['data'=>$publicidad]);
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
            
            'Nombre_publicidad' => 'required|string',
        ];

        $messages = [
            
            'Nombre_publicidad.required' => 'Digité nombre publicidad',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_publicidad = new Publicidad;
           
            $agregar_publicidad->Nombre_publicidad = $request->Nombre_publicidad;
            $agregar_publicidad->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publicidad  $publicidad
     * @return \Illuminate\Http\Response
     */
    public function show($publicidad)
    {
        $publico = Publicidad::findOrFail( $publicidad );
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publicidad  $publicidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Publicidad $publicidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publicidad  $publicidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$publicidad)
    {
        $rules = [
            
            'Nombre_publicidad' => 'required|string',
        ];

        $messages = [
            
            'Nombre_publicidad.required' => 'Digité nombre publicidad',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_publicidad = Publicidad::findOrFail($publicidad);
           
            $actualizar_publicidad->Nombre_publicidad = $request->Nombre_publicidad;
            $actualizar_publicidad->save();
            return response( [ 'data'=>'Actualizado exitosamente' ] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publicidad  $publicidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($publicidad)
    {
        $publicidad = Publicidad::findOrFail($publicidad);
        $publicidad->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }
}
