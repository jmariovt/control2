@extends('layouts.apppostventa')
@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Detalle de Mensajes Enviados por Unidad
                    </br>
                    Desde {{$fechaDesde??''}} Hasta {{$fechaHasta??''}}
                    </br>
                    VID: {{$vid}}
                </div>
                

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
                            <form class="form-group" method="POST" action="/xadmin/postventa/grabarModificarAlias">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSNumero" name="detalleSMSNumero" value="{{$numero}}">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSFechaDesde" name="detalleSMSFechaDesde" value="{{$fechaDesde}}">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSFechaHasta" name="detalleSMSFechaHasta" value="{{$fechaHasta}}">
                            
                            @csrf
                                <table id="DetalleSMSTablaVid" class="display"  style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Alerta</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registros as $registro)
                                        <tr>
                                            <td>
                                                {{$registro->ALERTA}}
                                            </td>
                                            <td>
                                                {{$registro->CANTIDAD}}
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Alerta</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection