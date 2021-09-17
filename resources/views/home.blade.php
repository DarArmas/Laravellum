@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')
            @foreach($images as $image)
            <!--mostrar tarjeta de una imagen-->
                @include('includes.image',['image' => $image])
            @endforeach

            <!--PAGINACION-->
            <div class="clearfix"></div>
            {{$images->links()}} <!--mostrar el numero de paginas -->

        </div>
    </div>
</div>
@endsection
