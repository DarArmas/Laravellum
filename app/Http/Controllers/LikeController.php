<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like; //para poder usar objetos de tipo like

class LikeController extends Controller {

    public function __construct() {
        //este middleware hace que todos mis metodos sean privados
        $this->middleware('auth');
    }
    
    //mostrar mis likes (del usuario identificado)
    public function index() {
        $user = \Auth::user();
        
        //me va a ordenar mis likes del mas reciente al más viejo
        $likes = Like::where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->paginate(5);

        //          carpeta.fichero
        return view('like.index', [
            'likes' => $likes
        ]);
    }
    

    public function like($image_id) {
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();

        //no pueden haber likes duplicados
        $isset_like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->count();

        //solo guardame el like si no existe antes
        if ($isset_like == 0) {

            $like = new Like();
            $like->user_id = $user->id;    //el usuario que dio like va a ser el identificado
            $like->image_id = (int) $image_id;  //la imagen a la que le di like la voy a recibir como parametro
            //Guardar
            $like->save();

            //tengo que regresar un JSON para luego manipularlo con javascript
            return response()->json([
                        'like' => $like
                            //mandame todo el objeto like
            ]);
        } else {

            return response()->json([
                        'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id) {
        //NO ES DISLIKE, ES QUITAR LIKE
        //Recoger datos del usuario y la imagen
        $user = \Auth::user();

        //recogeme el like mio m
        $like = Like::where('user_id', $user->id)  //que el like sea mio
                ->where('image_id', $image_id) //en esta publicacion
                ->first();

        //solo guardame el dislike si no existe antes
        if ($like) {


            $like->delete();
            return response()->json([
                        'like' => $like,
                        'message' => 'Has dado dislike correctamente'
            ]);
        } else {

            return response()->json([
                        'message' => 'El like no existe'
            ]);
        }
    }

 

}
