<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Validator;
use App\Models\tarjetas;
use Illuminate\Http\Request;
use DB;
class TarjetasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=tarjetas::all();
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
    function visaomastercard($numtarjeta) {
        $tipot="";
        $numt = substr($numtarjeta, 0, 1);
        if ($numt == 4) {
            $tipot="visa";
           
            
        } else if ($numt == 5) {
            $tipot="mastercard";
            
        } 
        return $tipot;
    }
    public function store(Request $request)
    {
        
        //parent::boot();
       $tipot="";
        $guardar = [
           
            'id_usuario' => 'required | integer',
            'nombre' => 'required | string',
            'apellido' => 'required | string',
            'numero_tarjeta' => 
                'required', 'string',
             
            'fecha_expedicion' => 'required | string',
            
            ];

         $messages = [
            'id_usuario'  => 'The :attribute and :other must match.',
            'nombre' => 'The :attribute value :input is not between :min - :max.',
            'apellido'=> 'The :attribute must be one of the following types: :values',
            'numero_tarjeta'=> 'hola',
            'fecha_expedicion'=> 'The :attribute must be one of the following types: :values',
            
            ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
            
           
        }
        else{
        $tipot=self::visaomastercard($request->numero_tarjeta);
        $guardar_tarjeta=new tarjetas;
        $guardar_tarjeta->id_usuario=$request->id_usuario;
        $guardar_tarjeta->nombre=$request->nombre;
        $guardar_tarjeta->apellido=$request->apellido;
        $guardar_tarjeta->numero_tarjeta=$request->numero_tarjeta;
        $guardar_tarjeta->fecha_expedicion=$request->fecha_expedicion;
        $guardar_tarjeta->tipo_tajeta= $tipot;
        $guardar_tarjeta->save();
        return response(["data"=>"guardado exitosamente"]);
        
    }
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tarjetas  $tarjetas
     * @return \Illuminate\Http\Response
     */
    public function show($tarjetas)
    {
        $consultar = tarjetas::findOrFail($tarjetas);
        return response( [ 'data'=>$consultar ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tarjetas  $tarjetas
     * @return \Illuminate\Http\Response
     */
    public function edit(tarjetas $tarjetas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tarjetas  $tarjetas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$tarjetas)
    {
        $guardar = [
            'id_usuario' => 'required | integer',
            'nombre' => 'required | string',
            'apellido' => 'required | string',
            'numero_tarjeta' => 'required | string',
            'fecha_expedicion' => 'required | string',
            'tipo_tajeta' => 'required | string',
            ];

         $messages = [
            'id_usuario'  => 'The :attribute and :other must match.',
            'nombre' => 'The :attribute value :input is not between :min - :max.',
            'apellido'=> 'The :attribute must be one of the following types: :values',
            'numero_tarjeta'=> 'The :attribute must be one of the following types: :values',
            'fecha_expedicion'=> 'The :attribute must be one of the following types: :values',
            'tipo_tajeta'=> 'The :attribute must be one of the following types: :values',
            ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
        $guardar_tarjeta=tarjetas::findOrFail($tarjetas);
        $guardar_tarjeta->id_usuario=$request->id_usuario;
        $guardar_tarjeta->nombre=$request->nombre;
        $guardar_tarjeta->apellido=$request->apellido;
        $guardar_tarjeta->numero_tarjeta=$request->numero_tarjeta;
        $guardar_tarjeta->fecha_expedicion=$request->fecha_expedicion;
        $guardar_tarjeta->tipo_tajeta=$request->tipo_tajeta;
        $guardar_tarjeta->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tarjetas  $tarjetas
     * @return \Illuminate\Http\Response
     */
    public function destroy($tarjetas)
    {
        $restaurantes=tarjetas::findOrFail($tarjetas);                          
        $restaurantes->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }


    public function tarjestas(){
        
    }



}
