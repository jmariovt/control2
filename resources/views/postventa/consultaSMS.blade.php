
@extends('layouts.apppostventa')


@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Consulta de SMS</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                        <fieldset class="form-group">
                                            
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="sms" name="optionsRadiosConsultaSMS" id="optionsRadiosCelular" value="celular" checked="">
                                                Buscar por Número celular
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="sms" name="optionsRadiosConsultaSMS" id="optionsRadiosPlaca" value="placa">
                                                Buscar por Placa
                                                </label>
                                            </div>
                                            
                                        </fieldset>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="smsBuscar" id="smsBuscar" placeholder="Buscar">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="consultaSmsFechas" id="consultaSmsFechas" placeholder="Ingresar Fechas" value="{{$consultaSmsFechas??''}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <select class="form-select  form-select-sm" id="verMensajes">
											      <option value="R" selected>Recibidos (SMPP)</option>
											      <option value="E">Enviados (SMPP)</option>
											      <option value="EX">Enviados (XMPP)</option>
											    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" id="btConsultaSMS" name="btConsultaSMS">Buscar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div id="areaImagen" style="display: none;">
                                                    <img src="{{asset('Imagenes/cargando.gif')}}" width="40"  height="40"  id="imagenBuscando" >
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover table-striped" id="tablaMensajes" name="tablaMensajes" width="100%" >
                                        <thead >
                                            <tr>
                                                <th width="15%">Fecha</th>
                                                <th width="15%">Celular</th>
                                                <th width="40%">Mensaje</th>
                                                <th width="15%">Longitud</th>
                                                <th width="15%">Estado</th>
                                                
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyMensajes" name="tbodyMensajes">
                                            <tr>
                                                <td colspan="13">&nbsp;</td>
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