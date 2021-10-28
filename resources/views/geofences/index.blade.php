@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Geocercas</div>

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
                                <a href="" class="btn btn-primary pull-right" onclick="window.open('/xadmin/geofences/create','CrearGeocerca','width=1500,height=900'); return false;">Crear Geocerca</a>
                                </p>
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaGeocercasInput()" placeholder="Buscar..." id="inputBuscarGeocerca" name="inputBuscarGeocerca" >
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Ancho de línea</th>
                                            <th>Número de puntos</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyGeocercas" id="tbodyGeocercas">
                                        @foreach($geofences as $geofence)
                                        <tr>
                                            <?php
                                            $indice = 0;
                                            foreach ($geofence as $key => $value)
                                            {
                                                if($indice == 1 || $indice == 3 || $indice == 4 || $indice == 7)
                                                {?>
                                                    <td>{{$value}}</td>

                                            <?php }
                                                $indice = $indice + 1;
                                            }
                                            ?>


                                            <?php
                                            $indice = 0;
                                            foreach ($geofence as $key => $value)
                                            {
                                                if($indice == 0 )
                                                {?>
                                                    
                                                    <td width="10px"><a href="/xadmin/geofences/edit/{{$value}}" onclick="window.open('/xadmin/geofences/edit/{{$value}}','CrearGeocerca','width=1500,height=900'); return false;" class="btn btn-warning btn-sm">Editar</a></td>
                                                    <td width="10px"><a href="/xadmin/geofences/delete/{{$value}}" class="btn btn-danger btn-sm">Eliminar</a></td>
                                            <?php }
                                                $indice = $indice + 1;
                                            }
                                            ?>
                                            
                                            
                                            
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