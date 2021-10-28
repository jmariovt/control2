@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Puntos Referenciales</div>

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
                                <a href="/xadmin/puntos/create" class="btn btn-primary pull-right" onclick="window.open('/xadmin/puntos/create','CrearPunto','width=1500,height=900'); return false;">Crear Punto</a>
                                </p>
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaPuntosInput()" placeholder="Buscar..." id="inputBuscarPunto" name="inputBuscarPunto" >
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Id Cliente</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyPuntos" id="tbodyPuntos">
                                        @foreach($points as $point)
                                        <tr>
                                            <td >{{$point->Nombre}}</td>
                                            <td>{{$point->Latitud}}</td>
                                            <td>{{$point->Longitud}}</td>
                                            <td>{{$point->IdPuntoCliente}}</td>
                                            <td width="10px"><a href="" class="btn btn-warning btn-sm" onclick="window.open('/xadmin/puntos/edit/{{$point->IdPunto}}','ModificarPunto','width=1500,height=900'); return false;">Editar</a></td>
                                            <td width="10px"><a href="/xadmin/puntos/destroy/{{$point->IdPunto}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar el Punto {{$point->Nombre}}?')">Eliminar</a></td>
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
    <!--</p>
    <div class="text-center">
        <a href="/points/create" class="btn btn-primary">Crear Punto</a>
    </div>-->
@endsection