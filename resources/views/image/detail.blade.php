<!--vista para una publicacion individual-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    <!--MOSTRAR EL AVATAR DEL USUARIO-->
                    @if($image->user->image) <!--si el usuario tiene foto de perfil muestrala-->
                    <div class="container-avatar">
                        <img src="{{route('user.avatar',
                                    ['filename' => $image->user->image])}}"/>      
                    </div>
                    @endif

                    <div class="data-user">
                        {{$image->user->name.' '.$image->user->surname}}
                        <span class="nickname">
                            {{' | @'. $image->user->nick}}
                        </span>
                    </div>

                </div>

                <div class="card-body">

                    <div class="image-container image-detail">
                        <!--para obtener la imagen llamo a la ruta que hace eso y ademas le paso el nombre de la imagen-->
                        <img src="{{route('image.file', ['filename' => $image->image_path])}}">
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                    </div>

                    <div class="likes">
                        <!--mostrar likes-->

                        <?php $user_like = false; ?>

                        @foreach($image->likes as $like)   <!--checame todos los likes de la imagen-->

                        @if($like->user->id == Auth::user()->id)  <!--el usuario identificado ha dado liek-->
                        <?php $user_like = true; ?>  
                        @endif

                        @endforeach

                        @if($user_like) <!--si di like muestrame el corazon rojo-->
                        <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike"/>
                        @else
                        <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like"/>
                        @endif

                        <span class="number_likes">{{count($image->likes)}}</span>

                    </div>


                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a href="{{route('image.edit', ['id' => $image->id])}}" class="btn btn-sm btn-primary">Actualizar</a>
                        <!--<a href="" class="btn btn-sm btn-danger">Borrar</a>-->
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
                            Borrar publicacion
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">CUIDADO EEEE</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Se eliminara tu publicacion permanentemente
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cancelar</button>
                                       <a href="{{route('image.delete', ['id' => $image->id])}}" class="btn btn-primary">Si si alv</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--aqui termina mi modal-->
                    </div>
                    @endif

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($image->comments)}})</h2>
                        <hr/>


                        <form method="POST" action="{{route('comment.save')}}">
                            @csrf
                            <input type="hidden" name="image_id" value="{{$image->id}}" />
                            <p>
                                <!--si hay errores          pon clase (remarcar de rojo) -->
                                <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''}}" name="content"></textarea>

                                <!--mostrar error por no poner comentario-->
                                @if($errors->has('content'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$errors->first('content')}}</strong>
                                </span>
                                @endif

                            </p> 

                            <button type="submit" class="btn btn-success">Enviar</button>

                        </form>

                        <hr>
                        <!--recorret todos los comentarios que le correspondan a esta publicacion-->
                        @foreach($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{'@'.$comment->user->nick}}</span> <!--quien hizo el comentario-->
                            <!--<span class="nickname">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span> <!--cuando se hizo-->
                            <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                            <p>{{$comment->content}}<br/> <!--el comentario-->

                                <!--solo muestrame este boton si estoy logeado, soy el creador del comentario o de la publicacion-->
                                @if(Auth::check() && ($comment->user_id== Auth::user()->id|| $comment->image->user_id == Auth::user()->id))
                                <a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">
                                    Eliminar
                                </a>
                                @endif

                            </p> <!--el comentraio-->
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>


        </div>
    </div>
    @endsection
