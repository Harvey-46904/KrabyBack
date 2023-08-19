<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\calificaciones;
use Illuminate\Http\Request;
use DB;
class CalificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=calificaciones::all();
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
        $rules = [
           
            'id_restaurante' => 'required|integer',
            'calificacion' => 'required|integer|between:1,5',
            

        ];

        $messages = [
            
            'id_restaurante.required' => 'digite id restaurante',
            'calificacion.required' => 'la calificacion es de 1 a 5',
           
        ];

        $validator = Validator::make( $request->all(), $rules, $messages );
        
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
        $guardar_calificacion=new calificaciones;
        $guardar_calificacion->id_restaurante=$request->id_restaurante;
        $guardar_calificacion->calificacion=$request->calificacion;
        $guardar_calificacion->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function show(calificaciones $calificaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(calificaciones $calificaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, calificaciones $calificaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\calificaciones  $calificaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(calificaciones $calificaciones)
    {
        //
    }
}
