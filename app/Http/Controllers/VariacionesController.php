<?php

namespace App\Http\Controllers;

use App\Models\variaciones;
use Illuminate\Http\Request;
use DB;
class VariacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       
        $request->validate([
            'menus_id' => 'required|exists:menus,id',
            'nombre_variacion' => 'required|string',
         
        ]);
      
        $opciones = json_encode($request->opciones);
        $nuevaMigracion = variaciones::create([
            'menus_id' => $request->menus_id,
            'nombre_variacion' => $request->nombre_variacion,
            'opciones' => $opciones,
        ]);

        return response()->json(['message' => 'Registro creado correctamente', 'data' => $nuevaMigracion], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\variaciones  $variaciones
     * @return \Illuminate\Http\Response
     */
    public function show(variaciones $variaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\variaciones  $variaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(variaciones $variaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\variaciones  $variaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, variaciones $variaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\variaciones  $variaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(variaciones $variaciones)
    {
        //
    }

    public function filtrado(){
        $menusConYSinVariacion = DB::table('menus')
        ->select('menus.*', DB::raw('(SELECT COUNT(*) FROM variaciones WHERE variaciones.menus_id = menus.id) as tiene_variacion'))
        ->get();
        return response($menusConYSinVariacion);
    }
}
