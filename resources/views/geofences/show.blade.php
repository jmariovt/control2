@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Geocerca</div>

                <div class="card-body">
                    <div class="container-fluid">
	    				<div class="row justify-content-center">
							
								<div class="modal-body">
								    <div class="row">
								        <div class="col-lg6">
                                            <div class="form-group">
										        <label for="geofenceNombre">Nombre</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceNombre" name="geofenceNombre" value="{{$geocerca->Nombre}}" disabled>
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceTipo">Tipo de geocerca</label>
                                                <select class="form-control form-control-sm" id="geofenceTipo">
                                                    <option value="0">Poligonal</option>
                                                    <option value="1">Lineal</option>
                                                    <option value="2">Circular</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceAnchoLinea">Ancho de línea</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceAnchoLinea" name="geofenceAnchoLinea" value="{{$geocerca->Parametro1}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
									<a href="/xadmin/geofences" class="btn btn-secondary">Cancelar</a>
									<a href="/xadmin/geofences/edit/"  class="btn btn-primary">Editar</a>
								</div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection