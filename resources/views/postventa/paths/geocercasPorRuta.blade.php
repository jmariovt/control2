@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Geocercas de Ruta {{$IdRuta}}</div>
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
                                <a href="/xadmin/postventa/paths/geocercasPorRuta/{{$IdRuta}}/geocercas" class="btn btn-primary pull-right">Ver todas las geocercas</a>
                                </p>
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaRutasInput()" placeholder="Buscar..." id="inputBuscarRuta" name="inputBuscarRuta" >
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id Geocerca</th>
                                            <th>Nombre</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyRutas" id="tbodyRutas">
                                        @foreach($geocercas as $geocerca)
                                        <tr>
                                            
                                                    <td>{{$geocerca->IdGeocerca}}</td>
                                                    <td>{{$geocerca->Nombre}}</td>
                                                    <td width="10px"><a href="/xadmin/postventa/paths/quitarGeocerca/{{$IdRuta}}/{{$geocerca->IdGeocerca}}" class="btn btn-danger btn-sm">Quitar</a></td>
                                        
                                                                                    
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer">
					<a href="/xadmin/postventa/paths" class="btn btn-secondary">Regresar</a>
					
				</div>
            </div>
        </div>
    </div>
</div>

@endsection
