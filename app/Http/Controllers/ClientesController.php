<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Clientes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
use DB;
use Illuminate\Validation\ValidationException;
class ClientesController extends Controller
{
    public function index()
    {
       $consulta=User::all();
       return response (["data"=>$consulta]);
    }
    public function store(Request $request)
    {
     // return response($request->all());
      
      $guardar = [
            'username' => 'required | string',
           
            'email' => 'required | string',
         ];
         $messages = [
            'username'  => 'The :attribute and :other must match.',
          
            'email' => 'The :attribute and :other must match.',
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
       
        if ($validator->fails()) {
           
            return response(['Error'=>$validator->errors()]);
        }
        else{
            $user = new User();
            $user->name = $request->username;
            $user->password = Hash::make($request->pass);
            $user->email = $request->email;
            $user->save();
            return response([
                "res"=>true,
                "data"=>'Usuario Registrador'
            ],200);
    }
    
    }
    public function show($cliente)
    {
        $cliente=User::findOrFail($cliente);
        return response (["data"=>$cliente]);
    }
    public function update(Request $request, $cliente)
    {
        $guardar = [
            'Nombre_Completo' => 'required | string',
            'Cedula' => 'required | string',
            'Telefono' => 'required | string',
            'Email' => 'required | string',
            'Direccion' => 'required | string',
         ];

         $messages = [
            'Nombre_Completo'  => 'The :attribute and :other must match.',
            'Cedula' => 'The :attribute must be exactly :size.',
            'Telefono' => 'The :attribute value :input is not between :min - :max.',
            'Email'=> 'The :attribute must be one of the following types: :values',
            'Direccion'=> 'The :attribute must be one of the following types: :values',
        ];
        $validator = Validator::make($request->all(), $guardar,  $messages);
        if ($validator->fails()) {
            return response(['Error de los datos'=>$validator->errors()]);
        }
        else{
            $actualizar_cliente=Clientes::findOrFail($cliente);
            $actualizar_cliente->Nombre_Completo=$request->Nombre_Completo;
            $actualizar_cliente->Cedula=$request->Cedula;
            $actualizar_cliente->Telefono=$request->Telefono;
            $actualizar_cliente->Email=$request->Email;
            $actualizar_cliente->Direccion=$request->Direccion;
            $actualizar_cliente->save();
            return response(["data"=>"datos actualizados"]);
        }
    }
    public function destroy($cliente)
    {
        $cliente=User::findOrFail($cliente);                          
        $cliente->delete();
        return response(["data"=> "Eliminado exitosamente"]);
    }

    public function acceso(Request $request){
        $user = User::where('email', $request->email)->first();
        
       // return response(["dtaa"=>$request->all()]);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'data' => ['Credenciales Incorrectas'],
            ]);
        }

        $token= $user->createToken($request->email)->plainTextToken;
        return response([
            "res"=>true,
            "data"=>$token
        ],200);
    }

    public function salir(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response([
            "res"=>true,
            "data"=>"se eliminoo token"
        ],200);
    }

    public function home($id_saludo){
       
   /*
      return response([
        "data"=>[
            "pestañas"=>[
                "Descripcion"=>[
                    "descripcion_restaurante"=>"dfkaljsdfkljasdklfa",
                    "horario"=>"8am a 9pm",
                    "ubicacion"=>"0X 8Y"
                ],
                "Calificaciones"=>[
                    "estrellas"=>2.4,
                    "calificacion"=>1.4,
                    "comentarios"=>[
                        "comentario_1"=>"chewvere",
                        "comentario_2"=>"me gusta"
                    ]

                    ],
                "Políticas"=>"estos son los terminos y condiciones"
            ],
        ]
        
        ]);

       */

    }

    public function todos(){
        return response(["data"=>[
            "centro_comerciales"=>[
                "a"=>"unico",
                "b"=>"unicentro"
            ]
        ]]);
    }
}
