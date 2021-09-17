<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image; //para poder hacer finds y sacar informacion

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //este middleware hace que todos mis metodos sean privados
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::orderBy('id', 'desc')->paginate(5);  //obtener todas las imagenes que están en mi base de datos
        
        return view('home',[
            'images' => $images
        ]);
        
    }
}
