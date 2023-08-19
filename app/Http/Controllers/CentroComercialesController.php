<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\centro_comerciales;
use Illuminate\Http\Request;

class CentroComercialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=centro_comerciales::all();

        return response ($consulta);
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
      


       // return response(["data"=>$request->all()]);
        $guardar = [
            'nombre_centro_comercial' => 'required | string',
            'direccion' => 'required | string',
            'telefono' => 'required | string',
            'correo' => 'required | string',
            'ubicacion' => 'required | string',
          
         ];

         $messages = [
            'nombre_centro_comercial'  => 'The :attribute and :other must match.',
            'direccion' => 'The :attribute must be exactly :size.',
            'telefono' => 'The :attribute value :input is not between :min - :max.',
            'correo'=> 'The :attribute must be one of the following types: :values',
            'ubicacion'=> 'The :attribute must be one of the following types: :values',
           
        ];
       
       

        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

            $ldate = date('Y-m-d-H_i_s');
            $file = $request->file('imagen');
            $nombre = $file->getClientOriginalName();
            \Storage::disk('local')->put("/img_centros_comerciales/".$ldate.$nombre,  \File::get($file));

        $guardar_centro=new centro_comerciales;
        $guardar_centro->nombre_centro_comercial=$request->nombre_centro_comercial;
        $guardar_centro->direccion=$request->direccion;
        $guardar_centro->telefono=$request->telefono;
        $guardar_centro->correo=$request->correo;
        $guardar_centro->ubicacion=$request->ubicacion;
        $guardar_centro->imagen=$ldate.$nombre;
        $guardar_centro->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\centro_comerciales  $centro_comerciales
     * @return \Illuminate\Http\Response
     */
    public function show($centro_comerciales)
    {
        $centro=centro_comerciales::findOrFail($centro_comerciales);
        return response (["data"=>$centro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\centro_comerciales  $centro_comerciales
     * @return \Illuminate\Http\Response
     */
    public function edit(centro_comerciales $centro_comerciales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\centro_comerciales  $centro_comerciales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $centro_comerciales)
    {
        $guardar = [
            'nombre_centro_comercial' => 'required | string',
            'direccion' => 'required | string',
            'telefono' => 'required | string',
            'correo' => 'required | string',
            'ubicacion' => 'required | string',
            'imagen' => 'required | string',
         ];

         $messages = [
            'nombre_centro_comercial'  => 'The :attribute and :other must match.',
            'direccion' => 'The :attribute must be exactly :size.',
            'telefono' => 'The :attribute value :input is not between :min - :max.',
            'correo'=> 'The :attribute must be one of the following types: :values',
            'ubicacion'=> 'The :attribute must be one of the following types: :values',
            'imagen'=> 'The :attribute must be one of the following types: :values',
        ];
       
       

        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_centro=centro_comerciales::findOrFail($centro_comerciales);
        
        $guardar_centro->nombre_centro_comercial=$request->nombre_centro_comercial;
        $guardar_centro->direccion=$request->direccion;
        $guardar_centro->telefono=$request->telefono;
        $guardar_centro->correo=$request->correo;
        $guardar_centro->ubicacion=$request->ubicacion;
        $guardar_centro->imagen=$request->imagen;
        $guardar_centro->save();
        return response(["data"=>"datos actualizados"]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\centro_comerciales  $centro_comerciales
     * @return \Illuminate\Http\Response
     */
    public function destroy($centro_comerciales)
    {
        $centro=centro_comerciales::findOrFail($centro_comerciales);                          
        $centro->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }
}
