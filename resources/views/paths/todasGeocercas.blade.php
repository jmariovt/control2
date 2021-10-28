@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Geocercas para Ruta {{$IdRuta}}</div>
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
                                <div class="modal-footer">
                                    <a href="/xadmin/paths/geocercasPorRuta/{{$IdRuta}}" class="btn btn-secondary btn-sm">Regresar</a>
                                </div>
                                
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaGeocercaRutas()" placeholder="Buscar..." id="inputBuscarGeocercaRutas" name="inputBuscarGeocercaRutas" >
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id Geocerca</th>
                                            <th>Nombre</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyRutasGeocerca" id="tbodyRutasGeocerca">
                                        @foreach($geocercas as $geocerca)
                                        <tr>
                                            <form method="POST" class="form-group" action="/xadmin/paths/asignarGeocerca">
                                                 @csrf
                                                 <input class="form-control form-control-sm" type="hidden" id="IdRuta" name="IdRuta" value="{{$IdRuta}}">
                                                 <input class="form-control form-control-sm" type="hidden" id="IdGeocerca" name="IdGeocerca" value="{{$geocerca->IdGeocerca}}">
                                                    <td>{{$geocerca->IdGeocerca}}</td>
                                                    <td>{{$geocerca->Nombre}}</td>
                                                    <td><div class="form-check">
                                                            <input class="form-check-input" checked disabled type="checkbox" value="" id="ckhGeocercaIn" name="ckhGeocercaIn">
                                                            <label class="form-check-label" for="ckhGeocercaIn">
                                                                Geocerca IN
                                                            </label>
                                                            
                                                            
                                                        </div></td>
                                                    <td><div class="form-check">
                                                            <input class="form-check-input" checked disabled type="checkbox" value="" id="ckhGeocercaOut" name="ckhGeocercaOut">
                                                            <label class="form-check-label" for="ckhGeocercaOut">
                                                                Geocerca OUT
                                                            </label>
                                                            
                                                            
                                                        </div></td>
                                                    <td width="10px"><button class="btn btn-info btn-sm" type="submit">Asignar</button><!--<a href="/xadmin/paths/remove/{{$IdRuta}}/{{$geocerca->IdGeocerca}}" class="btn btn-info btn-sm">Asignar</a>--></td>
                                            </form>
                                                                                    
                                        </tr>
                                        
                                        @endforeach
                                        
                                    </tbody>
                                    
                                </table>
                               
                            </div>
                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer">
					<a href="/xadmin/paths/geocercasPorRuta/{{$IdRuta}}" class="btn btn-secondary btn-sm">Regresar</a>
					
				</div>
            </div>
        </div>
    </div>
   
</div>


@endsection
