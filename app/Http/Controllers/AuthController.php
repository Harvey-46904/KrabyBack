<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Empleados;
use \stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index(){
        $consulta=User::all();
        return response($consulta);
    }

    public function register($nombre,$email,$password){

        //return response(["data"=> Str::random(8)]);
      
        
      
        $user =User::create([
            'name'=>$nombre,
            'email'=>$email,
            'password'=>Hash::make($password)
        ]);
       

        //$token=$user->createToken("auth_tojen")->plainTextToken;


       // return response()->json(['data'=>$user, 'password' => $password, 'token'=>$token,'token_type'=>'Bearer']);
       return response()->json(['data'=>$user]);
    }

    public function Login(Request $request){
        
        if (!Auth::attempt($request->only('email','password'))){
            return response()->json(['status' => 'usuario o contraseña incorrecto']);
        }
    
        $user = User::where('email', $request['email'])->firstOrFail();
        
       
       
        return response()->json([
            'message' => "Hi " . $user->name,
            'token_type' => 'Bearer',
            'user' => $user,
            'status'=>"Authorized"
        ]);
       
    }

    public function Actulizar_contraseña(Request $request, $id){
         $validator = Validator::make($request->all(), [
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors());
    }

    $user = User::findOrFail($id);

    $user->password = Hash::make($request->password);
    $user->is_random_password = 0;
    $user->save();

    return response()->json(['message' => 'Contraseña actualizada correctamente']);

    }
    

    public function Logout(){
        auth()->user()->tokens()->delete();
        return response()->json(["message"=>"Logout correct"]);
    }

   



}
