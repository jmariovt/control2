@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Creación de Ruta</div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form-group" method="POST" action="/xadmin/postventa/paths/store" id="storePath">
                                    @csrf
                                    <div class="modal-body">
                                        
                                            
                                            
                                                <label for="rutaNombre">Nombre</label>
                                                <input class="form-control form-control-sm" type="text" id="rutaNombre" value="" name="rutaNombre">
                                            
                                                <label for="rutaDetalle">Detalle</label>
                                                <input class="form-control form-control-sm" type="text" id="rutaDetalle" value="" name="rutaDetalle">
                                         
                                            
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/xadmin/postventa/paths" class="btn btn-secondary">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection