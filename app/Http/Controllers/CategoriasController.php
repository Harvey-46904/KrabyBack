<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Validator;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoria = Categorias::all();
        return response($categoria);
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
            
            'Nombre_categoria' => 'required|string',
        ];

        $messages = [
            
            'Nombre_categoria.required' => 'Digité nombre de categoria',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $agregar_categoria = new Categorias;
            $agregar_categoria->restaurante_id = $request->idrestaurante;
            $agregar_categoria->Nombre_categoria = $request->Nombre_categoria;
            $agregar_categoria->save();
            return self::index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show($categorias)
    {
        $categoria = Categorias::findOrFail( $categorias );
        return response( [ 'data'=>'Dato buscado' ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorias $categorias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$categorias)
    {
        $rules = [
            
            'Nombre_categoria' => 'required|string',
        ];

        $messages = [
           
            'Nombre_categoria.required' => 'Digité nombre de categoria',
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        if ( $validator->fails() ) {
            return response ( [ 'Error de los datos'=>$validator->errors() ] );
        } else {
            $actualizar_categoria = Categorias::findOrFail($categorias);
            
            $actualizar_categoria->Nombre_categoria = $request->Nombre_categoria;
            $actualizar_categoria->save();
            return response( [ 'data'=>'Agregado exitosamente' ] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy($categorias)
    {
        $categorias = Categorias::findOrFail($categorias);
        $categorias->delete();
        return response( [ 'data'=> 'Eliminado exitosamente' ] );
    }
}
