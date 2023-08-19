<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\restaurantes;
use Illuminate\Http\Request;
use DB;
class RestaurantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta=DB::table("restaurantes")
        ->select("restaurantes.*","centro_comerciales.nombre_centro_comercial")
        ->join("centro_comerciales","centro_comerciales.id","=","restaurantes.id_centro_comercial")
        ->get();
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
            'id_centro_comercial' => 'required | string',
            'nombre_restaurante' => 'required | string',
           
            'descripcion' => 'required | string',
            'horario' => 'required | string',
            'ubicacion' => 'required | string',
            
            'politicas' => 'required | string',
            
            
         ];

         $messages = [
            'id_centro_comercial'  => 'The :attribute and :other must match.',
            'nombre_restaurante' => 'The :attribute value :input is not between :min - :max.',
            
            'descripcion'=> 'The :attribute must be one of the following types: :values',
            'horario'=> 'The :attribute must be one of the following types: :values',
            'ubicacion'=> 'The :attribute must be one of the following types: :values',
            
            'politicas'=> 'The :attribute must be one of the following types: :values',

            
        ];
       
       

        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

            $ldate = date('Y-m-d-H_i_s');
            $file = $request->file('foto_baner');
            $nombre = $file->getClientOriginalName();
            \Storage::disk('local')->put("/img_banner/".$ldate.$nombre,  \File::get($file));
//
            $file1 = $request->file('foto_principal');
            $nombre1 = $file1->getClientOriginalName();
            \Storage::disk('local')->put("/img_restaurantes/".$ldate.$nombre1,  \File::get($file1));
            

        $guardar_restaurante=new restaurantes;
        $guardar_restaurante->id_centro_comercial=$request->id_centro_comercial;
        $guardar_restaurante->nombre_restaurante=$request->nombre_restaurante;

        $guardar_restaurante->foto_baner=$ldate.$nombre;
        $guardar_restaurante->foto_principal=$ldate.$nombre1;
        
        $guardar_restaurante->descripcion=$request->descripcion;
        $guardar_restaurante->horario=$request->horario;
        $guardar_restaurante->ubicacion=$request->ubicacion;
       
        $guardar_restaurante->politicas=$request->politicas;
       $guardar_restaurante->save();
        return response(["data"=>"guardado exitosamente"]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\restaurantes  $restaurantes
     * @return \Illuminate\Http\Response
     */
    public function show($restaurantes)
    {
        $restaurante=restaurantes::findOrFail($restaurantes)->get();
        return response ($restaurante);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\restaurantes  $restaurantes
     * @return \Illuminate\Http\Response
     */
    public function edit(restaurantes $restaurantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\restaurantes  $restaurantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $restaurantes)
    {
        $guardar = [
            'id_centro_comercial' => 'required | string',
            'nombre_restaurante' => 'required | string',
            'foto_baner' => 'required | string',
            'descripcion' => 'required | string',
            'horario' => 'required | string',
            'ubicacion' => 'required | string',
            
            'politicas' => 'required | string',
            
            
         ];

         $messages = [
            'id_centro_comercial'  => 'The :attribute and :other must match.',
            'nombre_restaurante' => 'The :attribute value :input is not between :min - :max.',
            'foto_baner'=> 'The :attribute must be one of the following types: :values',
            'descripcion'=> 'The :attribute must be one of the following types: :values',
            'horario'=> 'The :attribute must be one of the following types: :values',
            'ubicacion'=> 'The :attribute must be one of the following types: :values',
            
            'politicas'=> 'The :attribute must be one of the following types: :values',

            
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{

        $guardar_restaurante=restaurantes::findOrFail($restaurantes);
        
        $guardar_restaurante->id_centro_comercial=$request->id_centro_comercial;
        $guardar_restaurante->nombre_restaurante=$request->nombre_restaurante;
        $guardar_restaurante->foto_baner=$request->foto_baner;
        $guardar_restaurante->descripcion=$request->descripcion;
        $guardar_restaurante->horario=$request->horario;
        $guardar_restaurante->ubicacion=$request->ubicacion;
        
        $guardar_restaurante->politicas=$request->politicas;
        $guardar_restaurante->save();
        return response(["data"=>"datos actualizados"]);
    }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\restaurantes  $restaurantes
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurantes)
    {
        $restaurantes=restaurantes::findOrFail($restaurantes);                          
        $restaurantes->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }

    public function cons_menu ($id){
       $menu =  $id;
       $restauranMenus = DB::table('restaurantes')->select("nombre_restaurante","foto_baner")
        ->where("restaurantes.id","=",$menu)
        ->get();
        $menus = DB::table('menus')->select("producto","imagen_menu", "precio", "id", "descripcion")
        ->where("menus.idrestaurante","=",$menu)
        ->get();
        $descrip = DB::table('restaurantes')->select("descripcion","horario","ubicacion")
        ->where("restaurantes.id","=",$menu)
        ->get();
       // $califi = DB::table('restaurantes')->select("calificacion")
        //->where("restaurantes.id","=",$menu)
        //->get();
         $comentario = DB::table('restaurantes')
        ->join('comentarios', 'restaurantes.id', '=', 'comentarios.Id_restaurante')
        ->select('restaurantes.nombre_restaurante','comentarios.Comentario')
        ->where("comentarios.Id_restaurante","=",$menu)
        ->get();
        $calificcion = DB::table('restaurantes')
        ->join('calificaciones', 'restaurantes.id', '=', 'calificaciones.id_restaurante')
        ->select('calificaciones.calificacion')
        ->where("calificaciones.id_restaurante","=",$menu)
        ->avg('calificacion');
        //$promedio = DB::table('restaurantes')->avg('calificacion');
        return response  ($menus);
        //return response ([$restauranMenus,count($menus)==0?"Menu No disponible":$menus,$descrip,count($comentario)==0?"Comentario No disponible":$comentario,$calificcion]);

          /*  return response (

                [[
                    $restauranMenus,
                    count($menus)==0?"Menu No disponible":$menus,
                    
                ],
                [
                    $descrip
                ],
               
                [
                    
                    count($comentario)==0?"Comentario No disponible":$comentario,
                    
                ],
                [
                    $calificcion
                ]
                ]
            );*/
        
        
        
       
    }
    public function lista_resutarantes_centro_comercial($id_centro_comercial){
        $consulta=DB::table("restaurantes")->select("id","nombre_restaurante","foto_baner","horario","descripcion")->where("id_centro_comercial","=",$id_centro_comercial)->get();
        return response($consulta);
    }
}
