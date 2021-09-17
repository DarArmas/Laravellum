<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment; //cargo el modelo para poder crear objetos de tipo Comment

class CommentController extends Controller
{
     public function __construct() {
        $this->middleware('auth');
    }
    
    //para recoger comentarios que viene en el formulario
    public function save(Request $request){
        //Validacion
        $validate = $this->validate($request,[
           'image_id' => 'integer|required',
            'content' => 'required|string'
        ]);
        
        //Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id'); //para poder relacionar el comentario con su imagen en la BD
        $content = $request->input('content');  //recoge del textarea
        
        $comment = new Comment();
        $comment->user_id  = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Guardar en la bd
        $comment->save();
        
        
        //Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])    //que me regrese al detalle de la publicacion en donde hice el comentario
                ->with([
                    'message' => 'Has publicado tu comentario correctamente'    //SESION FLASH
                ]);
    }
    
    
    //Eliminar comentraio
    public function delete($id){
        //Conseguir datos del usuario logueado
         $user = \Auth::user();
         
         //Conseguir objeto del comentario
         $comment = Comment::find($id); 
         
         //Si hay usuario log    Compoobar si soy el dueño del comentario,    TAMBIEN EL USUARIO QUE HA CREADO LA IMAGEN PUEDE BORRAR COMENTARIOS
         if($user && ($comment->user_id== $user->id|| $comment->image->user_id == $user->id)){
             $comment->delete();
             
             return redirect()->route('image.detail', ['id' => $comment->image->id])    //que me regrese al detalle de la imagen en donde borré el comentario
                ->with([
                    'message' => 'Comentario eliminado correctamente'    //SESION FLASH
                ]);
             
         }else{
             
              return redirect()->route('image.detail', ['id' => $comment->image->id])    //que me regrese al detalle de la imagen en donde borré el comentario
                ->with([
                    'message' => 'El comentario no se ha eliminado'    //SESION FLASH
                ]);
         }
    }
    
}
