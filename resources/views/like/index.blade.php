<!--aqui se encuentran todas las publicaciones que les he dado like (el usaurio identificado)-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Mis imagenes favoritas</h1>
            <hr/>
                <!--obtener todos mis likes-->
                @foreach($likes as $like)
                    <!--mostrar tarjeta de una imagen-->
                    @include('includes.image',['image' => $like->image]) <!--recuerda que a cada like le corresponde una imagen-->
                @endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
                {{$likes->links()}} <!--mostrar el numero de paginas -->
        </div>
        
    </div>
</div>
@endsection
