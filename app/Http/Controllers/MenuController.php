<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\menu;
use Illuminate\Http\Request;
use DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=menu::all();
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
            'idrestaurante' => 'required | string',
            'producto' => 'required | string',
            'is_menu_dia' => 'required | string',
            'precio' => 'required | integer',
            'imagen_menu' => 'required | image',
            'descripcion' => 'required | string',
          
            
         ];

         $messages = [
            'idrestaurante'  => 'The :attribute and :other must match.',
           
            'producto' => 'The :attribute must be exactly :size.',
            'is_menu_dia' => 'The :attribute value :input is not between :min - :max.',
            'precio' => 'The :attribute must be exactly :size.',
            'imagen_menu'=> 'The :attribute must be one of the following types: :values',
            'descripcion'=> 'The :attribute must be one of the following types: :values',
           
            
        ];

        $validator = Validator::make($request->all(), $guardar,  $messages);
        
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
            
            $ldate = date('Y-m-d-H_i_s');
            $file = $request->file('imagen_menu');
            $nombre = $file->getClientOriginalName();
            $nombrefinal=$ldate.$nombre;
            \Storage::disk('local')->put("/img_menu/". $nombrefinal,  \File::get($file));
          
        $guardar_menu=new menu;
        $guardar_menu->idrestaurante=$request->idrestaurante;
        $guardar_menu->categoria_id=$request->categoria_id;
        $guardar_menu->producto=$request->producto;
        $guardar_menu->is_menu_dia=$request->is_menu_dia;
        $guardar_menu->precio=$request->precio;
        $guardar_menu->imagen_menu= $nombrefinal;
        $guardar_menu->descripcion=$request->descripcion;
        $guardar_menu->save();
       
        return self::configuracion_restaurante($request->idrestaurante);
    }
    }



    public function cons_menu ($id){
        return response  ($menus);
        $menu =  $id;
         $menus = DB::table('menus')->select("producto","imagen_menu", "precio", "id", "descripcion","nombre_categoria")
         ->where("menus.idrestaurante","=",$menu)
         ->get();
        
         //$promedio = DB::table('restaurantes')->avg('calificacion');
         return response  ($menus);
         //return response ([$restauranMenus,count($menus)==0?"Menu No disponible":$menus,$descrip,count($comentario)==0?"Comentario No disponible":$comentario,$calificcion]);
 
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $men=restaurantes::findOrFail($menu);
        return response (["data"=>$men]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
    {
        $guardar = [
            'id_categoria' => 'required | string',
            'producto' => 'required | string',
            'is_menu_dia' => 'required | string',
            'precio' => 'required | integer',
            'imagen_menu' => 'required | string',
            'descripcion' => 'required | string',
            
         ];

         $messages = [
            'id_categoria'  => 'The :attribute and :other must match.',
            'producto' => 'The :attribute must be exactly :size.',
            'is_menu_dia' => 'The :attribute value :input is not between :min - :max.',
            'precio' => 'The :attribute must be exactly :size.',
            'imagen_menu'=> 'The :attribute must be one of the following types: :values',
            'descripcion'=> 'The :attribute must be one of the following types: :values',
            
        ];

        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_menu=menu::findOrFail($menu);
        
        $guardar_menu->id_categoria=$request->id_categoria;
        $guardar_menu->producto=$request->producto;
        $guardar_menu->is_menu_dia=$request->is_menu_dia;
        $guardar_menu->precio=$request->precio;
        $guardar_menu->imagen_menu=$request->imagen_menu;
        $guardar_menu->descripcion=$request->descripcion;
        $guardar_menu->save();
        return response(["data"=>"datos actualizados"]);
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $men=menu::findOrFail($menu);                          
        $men->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }


    public function configuracion_restaurante($id){
        $categorias=DB::table("categorias")->select("id","Nombre_categoria")->where("restaurante_id","=",$id)->get();
        $menus=DB::table("menus")->select()->where("idrestaurante","=",$id)->get();

        $menusConYSinVariacion = DB::table('menus')
    ->join('variaciones', 'menus.id', '=', 'variaciones.menus_id')
    ->select('menus.*', 'variaciones.nombre_variacion', 'variaciones.opciones')
    ->where('menus.idrestaurante', '=', $id)
    ->union(
        DB::table('menus')
            ->leftJoin('variaciones', 'menus.id', '=', 'variaciones.menus_id')
            ->where('menus.idrestaurante', '=', $id)
            ->whereNull('variaciones.id')
            ->select('menus.*', 'variaciones.nombre_variacion', 'variaciones.opciones')
    )
    ->distinct()
    ->get();

    $resultado = [];

    foreach ($menusConYSinVariacion as $objeto) {
        $id = $objeto->id;
        if (!isset($resultado[$id])) {
            // Si es la primera vez que encontramos este ID, creamos una entrada para él
            $resultado[$id] = $objeto;
            $resultado[$id]->variedades = [];
        }

        // Si el objeto actual tiene nombre_variacion y opciones, las agregamos a las variedades
        if ($objeto->nombre_variacion && $objeto->opciones) {
            $resultado[$id]->variedades[] = [
                'nombre_variacion' => $objeto->nombre_variacion,
                'opciones' => json_decode($objeto->opciones, true)
            ];
        }
    }

// Convertimos el array de resultado en un array indexado nuevamente
    $resultado = array_values($resultado);
        return response([
            "categorias"=>$categorias,
            "menu"=>$resultado
            
        ]);
        
    }
    public function transversar($objeto){
        $data = [
            $objeto
        ];
        
        $resultado = [];
        
        foreach ($data as $objeto) {
            $id = $objeto['id'];
            if (!isset($resultado[$id])) {
                // Si es la primera vez que encontramos este ID, creamos una entrada para él
                $resultado[$id] = $objeto;
                $resultado[$id]['variedades'] = [];
            }
        
            // Si el objeto actual tiene nombre_variacion y opciones, las agregamos a la variedades
            if ($objeto['nombre_variacion'] && $objeto['opciones']) {
                $resultado[$id]['variedades'][] = [
                    'nombre_variacion' => $objeto['nombre_variacion'],
                    'opciones' => json_decode($objeto['opciones'], true)
                ];
            }
        }
        
        // Convertimos el array de resultado en un array indexado nuevamente
        $resultado = array_values($resultado);
        return $resultado;
    }

    public function configuracion_restaurante_app($id){
        $categorias=DB::table("categorias")->select("id","Nombre_categoria")->where("restaurante_id","=",$id)->get();
        $menus=DB::table("menus")->select()->where("idrestaurante","=",$id)->get();

        $menusConYSinVariacion = DB::table('menus')
        ->join("categorias","categorias.id","=","menus.categoria_id")
    ->join('variaciones', 'menus.id', '=', 'variaciones.menus_id')
    ->select("categorias.Nombre_categoria",'menus.*', 'variaciones.nombre_variacion', 'variaciones.opciones')
    ->where('menus.idrestaurante', '=', $id)
    ->union(
        DB::table('menus')
        ->join("categorias","categorias.id","=","menus.categoria_id")
            ->leftJoin('variaciones', 'menus.id', '=', 'variaciones.menus_id')
            ->where('menus.idrestaurante', '=', $id)
            ->whereNull('variaciones.id')
            ->select("categorias.Nombre_categoria",'menus.*', 'variaciones.nombre_variacion', 'variaciones.opciones')
    )
    ->distinct()
    ->get();

    $resultado = [];

    foreach ($menusConYSinVariacion as $objeto) {
        $id = $objeto->id;
        if (!isset($resultado[$id])) {
            // Si es la primera vez que encontramos este ID, creamos una entrada para él
            $resultado[$id] = $objeto;
            $resultado[$id]->variedades = [];
        }

        // Si el objeto actual tiene nombre_variacion y opciones, las agregamos a las variedades
        if ($objeto->nombre_variacion && $objeto->opciones) {
            $resultado[$id]->variedades[] = [
                'nombre_variacion' => $objeto->nombre_variacion,
                'opciones' => json_decode($objeto->opciones, true)
            ];
        }
    }

// Convertimos el array de resultado en un array indexado nuevamente
    $resultado = array_values($resultado);
        return response(
          
           self::organizarPorCategoria($resultado)
            
        );
        
    }

    function organizarPorCategoria($array) {
        $result = [];
    
        foreach ($array as $item) {
            $categoria = $item->Nombre_categoria;
            unset($item->Nombre_categoria);
    
            if (!array_key_exists($categoria, $result)) {
                $result[$categoria] = [];
            }
    
            $result[$categoria][] = $item;
        }
    
        return $result;
    }
}
