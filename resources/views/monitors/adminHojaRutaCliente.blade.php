@extends('layouts.appcliente')
@section('content')


@include('common.errors')
@include('common.success')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Plantillas Hojas de ruta</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="list-group">
                                    <!--<a class="list-group-item list-group-item-action">Plantillas</a>-->
                                    @foreach($hojasRuta as $hojaRuta)
                                        <a href="/xadmin/monitors/adminClienteModificarPlantilla/{{$cliente}}/{{$hojaRuta->Id}}" class="list-group-item list-group-item-action">{{$hojaRuta->NombrePlantilla}}</a>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <a href="/xadmin/monitors/adminClienteCrearPlantilla/{{$cliente}}"  class="btn btn-outline-primary">Crear nueva plantilla</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection