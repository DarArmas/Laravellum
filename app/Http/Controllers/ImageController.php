<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage; //para acceder a los discos virtuales
use Illuminate\Support\Facades\File; //para acceder a los archivos temporales
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller {

    //Restringir el acceso 
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {
        //Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        //Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');


        //Asignar valores nuevo objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;

        $image->description = $description;

        //Subir la imagen
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName(); //darle un nombre unico
            Storage::disk('images')->put($image_path_name, File::get($image_path));     //subirla al disco virtual
            //su nombre,   en donde estÃ¡ guardado ahorita
            $image->image_path = $image_path_name;
        }

        //hasta aqui ya rellene mi objeto Image, ahora tengo que guardarlo
        //Para que el cambio se haga en mi base de datos
        $image->save();

        //que me llegue mensaje flash 
        return redirect()->route('home')->with([
                    'message' => 'La foto se ha subido correctamente'
        ]);
    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename); //saca el nombre de la imagen del disco virtual
        return new Response($file, 200);
    }

    public function detail($id) {
        //obtener el objeto
        $image = Image::find($id);

        //manda el objeto a la vista por el url
        return view('image.detail', [
            'image' => $image
        ]);
    }

    //borrar toda la informacion de una publicacion
    public function delete($id) {
        //recuerda que se tiene que borrar todo lo relacionado a esa imagen por integridad referencial
        $user = \Auth::user();
        $image = Image::find($id);
        //sacame todos los comentarios y los likes que le pertenezcan a esta imagen
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();
         
        //solo si soy el que ha creado la publicacion 
        if ($user && $image && $image->user->id == $user->id) {
            //Eliminar comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            //Eliminar los likes
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
        
            
            //Eliminar ficheros de la imagen (los que están en los discos virtuales)
            Storage::disk('images')->delete($image->image_path);
                                            //124*********.png
                    
            //Eliminar registro imagen
            $image->delete();
            
            $message = array('message' => 'la imagen se ha borrado correctamente');
        }else{
            $message = array('message' => 'la imagen no se ha borrado correctamente');
        }
        
        return redirect()->route('home')->with($message);
    }
    
    //llevarme al formulario de editar, ya con el objeto image
    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);  
        
        //solo acceder si hay usuario, hay imagen y soy el dueño de la imagen
        if($user && $image && $image->user->id == $user->id){
                                        //pasale al publicacion que quieres editar 
            return view('image.edit', ['image' => $image]);
        }else{
            return redirect()->route('home');
        }
    }
    
    //actualizar la infromación recibida del formualario de editar
    public function update(Request $request){
        //validar los datos
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);
        
        //obtener la info del formulario
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        
        //Conseguir el objeto que voy a  actualizar
        $image = Image::find($image_id);
        $image->description = $description;
        
        //subir fichero
          if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName(); //darle un nombre unico
            Storage::disk('images')->put($image_path_name, File::get($image_path));     //subirla al disco virtual
            //su nombre,   en donde estÃ¡ guardado ahorita
            $image->image_path = $image_path_name;
        }
        
        //Actualizar registro
        $image->update();
        
        return redirect()->route('image.detail', ['id' => $image_id ])
                ->with(['message' => 'Imagen actualizada con exito']);
        
    }

}
