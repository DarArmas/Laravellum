<?php

namespace App;

//EL ORM: ELOQUENT ME PERMITE INTERACTUAR CON LA BASE DE DATOS UTILIZANDO MODELOS
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    
    //Relacion One To Many//Un solo modelo puede tener muchos comentarios
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id','desc');
    }//REGRESA EL ARRAYD E OBJETOS DE LOS COMENTARIOS
    //CUYO ID DE IMAGE SEA EL DE ESTE MODELO
    
    //Relacion One To Many
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    //Relacion de muchos a uno (muchas imagenes pueden tener un unico creador)
    public function user(){
        return $this->belongsTo('App\User','user_id');  
                                            //compara el user_id con el id del objeto user
    }
    
}
