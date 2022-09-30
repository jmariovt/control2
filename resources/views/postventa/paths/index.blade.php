@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Rutas para monitoreos</div>

                <div class="card-body">

                    <div class="container">
                        <div class="row justify-content-center">
                            
                            <!--<div class="container h-100">
                              <div class="d-flex justify-content-center h-100">
                                <div class="searchbar">
                                  <input class="search_input" type="text" name="" placeholder="Buscar...">
                                  <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
                                </div>
                              </div>
                            </div>-->

                            <div class="col-sm-12">
                                <a href="/xadmin/postventa/paths/create" class="btn btn-primary pull-right">Crear Ruta</a>
                                </p>
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaRutasInput()" placeholder="Buscar..." id="inputBuscarRuta" name="inputBuscarRuta" >
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>N°</th>
                                            <th>Nombre</th>
                                            <th>Detalle</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyRutas" id="tbodyRutas">
                                        @foreach($rutas as $ruta)
                                        <tr>
                                            
                                                    <td>{{$ruta->IdRuta}}</td>
                                                    <td>{{$ruta->Nombre}}</td>
                                                    <td>{{$ruta->Detalle}}</td>

                                           
                                                    <td width="10px"><a href="/xadmin/postventa/paths/geocercasPorRuta/{{$ruta->IdRuta}}" class="btn btn-success btn-sm">Geocercas</a></td>
                                                    <td width="10px"><a href="/xadmin/postventa/paths/edit/{{$ruta->IdRuta}}" class="btn btn-warning btn-sm">Editar</a></td>
                                                    <td width="10px"><a href="/xadmin/postventa/paths/delete/{{$ruta->IdRuta}}" class="btn btn-danger btn-sm">Eliminar</a></td>
                                           
                                                                                       
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection