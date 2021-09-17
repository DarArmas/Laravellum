@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">


                <!--mostrar imagen-->
                @if($user->image) <!--si el usuario tiene foto de perfil muestrala-->
                <div class="container-avatar">
                    <img src="{{route('user.avatar', ['filename' => $user->image])}}"/>      
                </div>
                @endif


                <div class="user-info">
                    <h1>{{'@'.$user->nick}}</h1>
                    <h2>{{$user->name.' '.$user->surname}}</h2>
                    <p>se unio: {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
                </div>

                <div class="clearfix"></div>
                <hr>


            </div>

            <div class="clearfix"></div>



            @foreach($user->images as $image)
            <!--mostrar tarjeta de una imagen-->
            @include('includes.image',['image' => $image])
            @endforeach

        </div>
    </div>
</div>
@endsection
