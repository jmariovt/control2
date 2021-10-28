@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Recorrido</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td >Unidad:</td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="recorridoUnidad" id="recorridoUnidad" placeholder="Unidad">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="recorridoVid" id="recorridoVid">
                                                <input class="form-control form-control-sm" type="hidden" name="recorridoUid" id="recorridoUid">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Desde" id="recorridoFechaDesde" name="recorridoFechaDesde" value='{{ $fecha }}' autocomplete="off">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" id="recorridoFechaHasta" name="recorridoFechaHasta" type="text" placeholder="Hasta" value='{{ $fecha }}' autocomplete="off">
                                            </td>
                                            <td>
				                        	<button type="button" class="btn btn-outline-primary btn-sm " id="btBuscarRecorrido" name="btBuscarRecorrido">Buscar</button>
				                        </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                 
            </div>
        </div>
    </div>
</div>

@endsection