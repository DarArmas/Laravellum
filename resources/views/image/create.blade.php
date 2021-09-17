@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--esto se conoce como panel de bootstrap-->
            <div class="card">
                <div class="card-header">Subir nueva imagen</div>


                <div class="card-body">
                    <form method="POST" action="{{route('image.save')}}" enctype="multipart/form-data">
                        @csrf  <!--PROTECCION QUE TRAE YA LARAVEL-->

                        <div class="form-group row">  
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <!--SI QUIERO QUE ME OCUPE LA MITAD ENTONCES 6/12 col-->
                            <div class="col-md-7">
                                <input id="image_path" type="file" name="image_path" class="form-control {{$errors->has('image_path') ? 'is-invalid' : ''}}" required/>

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
                                <textarea id="description" name="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" required></textarea>

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
                                <input type='submit' class='btn btn-primary' value='Post'/>

                            </div>
                        </div>


                    </form>


                </div>
            </div>


        </div>
    </div>
</div>
@endsection
