<!--esto de aqui es la card de la imagen, lo tengo disponible en includes para poder usarlo siempre que tenga que listar publicaciones-->

<div class="card pub_image">
    <div class="card-header">

        <!--MOSTRAR EL AVATAR DEL USUARIO-->
        @if($image->user->image) <!--si el usuario tiene foto de perfil muestrala-->
        <div class="container-avatar">
            <img src="{{route('user.avatar',
                                    ['filename' => $image->user->image])}}"/>      
        </div>
        @endif

        <div class="data-user">
            <!--para cuando le pique al nombre me lleve a mi perfil-->
            <a href=" {{route('profile', ['id' => $image->user->id])}}  ">
                {{$image->user->name.' '.$image->user->surname}}
                <span class="nickname">
                    {{' | @'. $image->user->nick}}
                </span>
            </a>
        </div>

    </div>

    <div class="card-body">

        <div class="image-container">
            <a href="{{route('image.detail', ['id' => $image->id])}}">
            <!--para obtener la imagen llamo a la ruta que hace eso y ademas le paso el nombre de la imagen-->
            <img src="{{route('image.file', ['filename' => $image->image_path])}}">
            </a>
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

        <div class="comments">
            <a href="{{route('image.detail', ['id' => $image->id])}} " class="btn btn-sm btn-warning btn-comments">
                Comentarios ({{count($image->comments)}})
            </a>
        </div>
    </div>
</div>