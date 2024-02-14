<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\clientes;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=clientes::all();

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
        $guardar = [
            'Tipo_documento' => 'required | string',
            'numero_documento' => 'required | string',
            'Nombres_completos' => 'required | string',
            'Telefono' => 'required | string',
            'Correo' => 'required | string',
            'Direccion' => 'required | string',
            'limite_restaurantes' => 'required | string',
            'estado' => 'required | string',
          
         ];
         $messages = [
            'Tipo_documento'  => 'The :attribute and :other must match.',
            'numero_documento' => 'The :attribute must be exactly :size.',
            'Nombres_completos' => 'The :attribute value :input is not between :min - :max.',
            'Telefono'=> 'The :attribute must be one of the following types: :values',
            'Correo'=> 'The :attribute must be one of the following types: :values',
            'Direccion'=> 'The :attribute must be one of the following types: :values',
            'limite_restaurantes'=> 'The :attribute must be one of the following types: :values',
            'estado'=> 'The :attribute must be one of the following types: :values',   
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

            $guardar_cliente=new clientes;
            $guardar_cliente->Tipo_documento=$request->Tipo_documento;
            $guardar_cliente->numero_documento=$request->numero_documento;
            $guardar_cliente->Nombres_completos=$request->Nombres_completos;
            $guardar_cliente->Telefono=$request->Telefono;
            $guardar_cliente->Correo=$request->Correo;
            $guardar_cliente->Direccion=$request->Direccion;
            $guardar_cliente->limite_restaurantes=$request->limite_restaurantes;
            $guardar_cliente->estado=$request->estado;
            $guardar_cliente->save();

            $logicaCompartida = new AuthController();
            $totalCitasEnEspera =$logicaCompartida->register(
                $request->Nombres_completos,
                $request->Correo,
                123456
            );
            return self::index();
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente=clientes::findOrFail($id);                          
        $cliente->delete();
        return self::index();
    }
}
