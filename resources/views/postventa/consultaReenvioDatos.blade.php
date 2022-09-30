
@extends('layouts.apppostventa')


@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Consulta Reenvío de Datos</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>
                                            <input class="form-control form-control-sm" type="text" name="consultaReenvioDatosBuscar" id="consultaReenvioDatosBuscar" placeholder="Buscar VID">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Rango de Fechas" id="txtRangoFechasconsultaReenvioDatos" name="txtRangoFechasconsultaReenvioDatos" value="{{$fechaDesde}} - {{$fecha}}" autocomplete="off">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" id="btConsultaReenvioDatos" name="btConsultaReenvioDatos">Consultar</button>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table id="ConsultaReenvioDatosTabla" class="display"  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Fecha Transacción</th>
                                                    <th>Evento</th>
                                                    <th>Destino</th>
                                                    <th>Respuesta</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Fecha Transacción</th>
                                                    <th>Evento</th>
                                                    <th>Destino</th>
                                                    <th>Respuesta</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection