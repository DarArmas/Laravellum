@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--esto se conoce como panel de bootstrap-->
            <div class="card">
                <div class="card-header">Editar mi imagen</div>


                <div class="card-body">
                    <form method="POST" action="{{route('image.update')}}" enctype="multipart/form-data">
                        @csrf  <!--PROTECCION QUE TRAE YA LARAVEL-->
                        <!--necesito el id de la imagen que voy a actaulizar-->
                        <input type="hidden" name="image_id" value="{{$image->id}}"/>
                        
                        <div class="form-group row">  
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                           
                            <div class="col-md-7">     
                                <!--MOSTRAR LA MINIATURA DE LA IMAGEN A EDITAR-->
                                @if($image->image_path) <!--si la publicaion tiene foto-->                                  
                                    <div class="container-avatar">
                                        <img src="{{route('image.file', ['fileName' => $image->image_path])}}" class="edit">
                                    </div>
                                @endif


                                <input id="image_path" type="file" name="image_path" class="form-control {{$errors->has('image_path') ? 'is-invalid' : ''}}"/>

                                @if($errors->has('image_path'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$errors->first('image_path')}}</strong>
                                </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row">  
                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" required>{{$image->description}}</textarea>

                                @if($errors->has('description'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$errors->first('description')}}</strong>
                                </span>
                                @endif

                            </div>
                        </div>


                        <div class="form-group row">  
                            <!--el espacio que va a dejar vacio entre su proximo hijo y él-->
                            <div class="col-md-6 offset-md-3">
                                <input type='submit' class='btn btn-primary' value='Guardar cambios'/>

                            </div>
                        </div>


                    </form>


                </div>
            </div>


        </div>
    </div>
</div>
@endsection
