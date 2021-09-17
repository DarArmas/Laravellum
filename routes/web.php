<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//use App\Image;

Route::get('/', function () {
    
    /*

    //METODO DE MI ORM, SOLAMENTE NECESITO UTILIZAR EL MODELO App\Image
    $images = Image::all();
    foreach ($images as $image) {
        echo $image->image_path . "<br/>";
        echo $image->description . "<br/>";
        //ORM ME PERMITE HACER JOINS ASI DE SENCILLO
        echo $image->user->name . ' ' . $image->user->surname;



        if (count($image->comments) >= 1) {
            echo '<h4>Comentarios</h4>';

            foreach ($image->comments as $comment) {
                echo $comment->user->name . ' ' . $comment->user->surname . ':';
                echo $comment->content . '<br/>';
            }
        }
        
        echo "<br/>";
        echo 'Likes: '.count($image->likes);
        echo "<hr/>";
    }

    die();
     * 
     */
    
    return view('welcome');
});

//RECUERDA: organizar tus rutas por ENTIDADES
//GENERALES
Auth::routes();
Route::get('/', 'HomeController@index')->name('home'); //name me sirve solo para identificar la ruta por ejemplo en vinculos

//USUARIO
Route::get('/configuracion','UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update'); //recuerda indiacr si la info llega por post o por get
Route::get('/user/avatar/{filename}','UserController@getImage')->name('user.avatar'); //ruta para obtener la imagen de perfil
Route::get('/perfil/{id}','UserController@profile')->name('profile'); 
Route::get('/gente/{search?}','UserController@index')->name('user.index');  //{parametro?}<- opcional

//IMAGEN
Route::get('/subir-imagen','ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}','ImageController@getImage')->name('image.file'); 
Route::get('/image/{id}','ImageController@detail')->name('image.detail'); 
Route::get('/image/delete/{id}','ImageController@delete')->name('image.delete'); 
Route::get('/image/editar/{id}','ImageController@edit')->name('image.edit'); 
Route::post('/image/update', 'ImageController@update')->name('image.update');


// COMENTARIO
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}','CommentController@delete')->name('comment.delete'); 
Route::get('/like/{image_id}','LikeController@like')->name('like.save'); 
Route::get('/dislike/{image_id}','LikeController@dislike')->name('like.delete'); 
Route::get('/likes','LikeController@index')->name('likes'); 




