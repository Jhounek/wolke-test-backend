<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{


    public function index(){
        return Usuario::all();
    }

    public function store(Request $request){
        try{
            $inputs = $request->input();
            $inputs["password"] = Hash::make(trim($request->password));
            $response = Usuario::create($inputs);
            return response()->json([
                'data'=> $response,
                'message'=> "User created successfully"
            ]);
        }catch(Exception $m){
            return "Error creating the user... ->".$m;
        }
    }

    public function show ($id){
        $user = Usuario::find($id);
        if(isset($user)){
            return response()->json([
                'data'=> $user,
                'message'=> "User found successfully"
            ]);
        }else{
            return response()->json([
                'error'=> true,
                'message'=> "We couldn't update the user, try it again"
            ]);
        }
    }

    public function update(Request $request, $id){
        try{
            $user = Usuario::find($id);
            if(isset($user)){
                $user->name = $request->name;
                $user->email = $request->email;
                $user["password"] = Hash::make(trim($request->password));
                return $user->save();
                return response()->json([
                    'data'=> $user,
                    'message'=> "User updated successfully"
                ]);
            }else{
                return response()->json([
                    'error'=> true,
                    'message'=> "We couldn't update the User, try it again"
                ]);
            }
        }catch(Exception $m){
            return "Error updating the user... ->".$m;
        }

    }

    public function destroy ($id){
        $user = Usuario::find($id);
        if(isset($user)){
            $res = Usuario::destroy($id);
            if($res){
                return response()->json([
                    'data'=> [],
                    'message'=> "User deleted successfully"
                ]);
            }
        }else{
            return response()->json([
                'error'=> true,
                'message'=> "We couldn't delete the User, try it again"
            ]);
        }
    }
}
