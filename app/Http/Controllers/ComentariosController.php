<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;

class ComentariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comentario = Comentarios::all();
        return response(['data'=>$comentario]);
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
            'Id_comentarios' => 'required|string',
            'Id_restaurante' => 'required|string',
            'Comentario' => 'required|string',
        ];

        $messages = [
            'Id_comentarios.required' => 'Digité id comentario',
            'Id_restaurante.required' => 'Digité id restaurante',
            'Comentario.required' => 'Digité comentario',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_comenta = new Comentarios;
            $agregar_comenta->Id_comentarios = $request->Id_comentarios;
            $agregar_comenta->Id_restaurante = $request->Id_restaurante;
            $agregar_comenta->Comentario = $request->Comentario;
            $agregar_comenta->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function show($comentarios)
    {
        $comenta = Comentarios::findOrFail( $comentarios );
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentarios $comentarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentarios $comentarios)
    {
        $rules = [
            'Id_comentarios' => 'required|string',
            'Id_restaurante' => 'required|string',
            'Comentario' => 'required|string',
        ];

        $messages = [
            'Id_comentarios.required' => 'Digité id comentario',
            'Id_restaurante.required' => 'Digité id restaurante',
            'Comentario.required' => 'Digité comentario',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_usuario = Comentarios::findOrFail($comentarios);
            $actualizar_comenta->Id_comentarios = $request->Id_comentarios;
            $actualizar_comenta->Id_restaurante = $request->Id_restaurante;
            $actualizar_comenta->Comentario = $request->Comentario;
            $actualizar_comenta->save();
            return response( [ 'data'=>'Actualizado exitosamente' ] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function destroy($comentarios)
    {
        $comentarios = Comentarios::findOrFail($comentarios);
        $comentarios->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }
}
