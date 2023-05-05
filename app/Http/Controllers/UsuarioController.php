<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $user = new User();

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->save();

       
    }


    public function show(Usuario $usuario)
    {
        //
    }

    public function edit(Usuario $usuario)
    {
        //
    }
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    public function destroy(Usuario $usuario)
    {
       
    }



    public function soporte_wasap(){

        return response(["data"=>"url_wasa"]);
    }
}
