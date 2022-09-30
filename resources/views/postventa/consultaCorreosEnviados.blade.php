
@extends('layouts.apppostventa')


@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Consulta de Correos Enviados</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>
                                            <input class="form-control form-control-sm" type="text" name="correosBuscar" id="correosBuscar" placeholder="Buscar">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Rango de Fechas" id="txtRangoFechasBuscarCorreosEnviados" name="txtRangoFechasBuscarCorreosEnviados" value="{{$fechaDesde}} - {{$fecha}}" autocomplete="off">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" id="btConsultaCorreosEnviados" name="btConsultaCorreosEnviados">Buscar</button>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table id="CorreosEnviadosTabla" class="display"  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Destinatario</th>
                                                    <th>Asunto</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Destinatario</th>
                                                    <th>Asunto</th>
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