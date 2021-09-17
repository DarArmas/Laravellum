<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Storage; //para poder tener acceso a los discos virtuales
use Illuminate\Support\Facades\File;
use App\User;


class UserController extends Controller {

     public function __construct()
    {
        //este middleware hace que todos mis metodos sean privados
        $this->middleware('auth');
    }
    
    //listar todos los usuarios
    public function index($search = null){
        //$search por defecto será nulo y me mostrará todos los usuarios 
        if(!empty($search)){
                                                //%<-comodines
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                                ->orWhere('name', 'LIKE', '%'.$search.'%')
                                ->orWhere('surname', 'LIKE', '%'.$search.'%')
                                ->orderBy('id', 'desc')
                                ->paginate(5);
        }else{
        $users = User::orderBy('id', 'desc')->paginate(5);    
        }
        
        return view('user.index',[
            'users' => $users
        ]);
    }
    
    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {
        
       
        
        
        $user = \Auth::user(); //la instancia del user identificado 
        $id = $user->id; 
        
        //validacion de lo que me llega del formulario
        $validate = $this->validate($request, [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'nick' => 'required|string|max:255|unique:users,nick,'.$id,
        'email' => 'required|string|email|max:255|unique:users,email,'.$id
                                            //que sea unico en tabla users, si dejo el mismo y coincide con mi id no hay problema 
        ]);
        
        //$request me trae toda la informacion por post
        //recoger los datos del formulario
        $name = $request->input('name'); 
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        
        //Asignar nuevos valores al objeto del usuarios
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        //Subir la imagen
         $image_path = $request->file('image_path');
         
         if($image_path){
             //PONER NOMBRE UNICO
             $image_path_name = time().$image_path->getClientOriginalName();
             
             //SELECCIONA EL DISCO ->   NOMBRE, ARCHIVO A SUBIR  (storage/app/users)
             Storage::disk('users')->put($image_path_name, File::get($image_path));
             
             $user->image = $image_path_name; 
         }
       
         
        //Ejecutar consulta y cambios en la base de datos
        $user->update();
        
        return redirect()->route('config') 
                ->with(['message' => 'Usuario actualizado correctamente']);
                        //esto me llega en forma de sesion
        }
        
        public function getImage($filename){
            $file = Storage::disk('users') -> get($filename);
            return new Response($file,200);
        }
        
        
        public function profile($id){
            $user = User::find($id);
            
            return view('user.profile', [
                'user' => $user
            ]);
            
        }
        
        

}
