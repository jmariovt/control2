@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Reportes disponibles

                </div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
                        
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#registrosRecorrido" id="navregistrosRecorrido">Registros Recorrido</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#unidadesSinReportar" id="navunidadesSinReportar">Unidades sin reportar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#unidadesSinEntidad" id="navunidadesSinEntidad">Unidades sin entidad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#entiadadesSinUsuario" id="naventidadesSinUsuario">Entidades sin usuario</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#consumoSMS" id="navconsumoSMS">Consumo SMS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#comandosEnviados" id="navcomandosEnviados">Comandos enviados</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active show" id="registrosRecorrido" name="registrosRecorrido">
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                <td align="right"><font size=2>Buscar:</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="VID" id="unidadBuscar" name="unidadBuscar" value="{{ old('unidadBuscar')??''}}">
                                                    <input class="form-control form-control-sm" type="hidden"  id="idActivo" name="idActivo" value="{{ old('idActivo')??''}}" >
                                                    <input class="form-control form-control-sm" type="hidden"  id="uid" name="uid" value="" >
                                                    
                                                    
                                                </td>
                                                <td align="right"><font size=2>Placa:</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Placa" id="unidadPlaca" name="unidadPlaca" value="{{ old('unidadPlaca')??''}}" disabled>
                                                    
                                                    
                                                    
                                                </td>
                                                <td align="right"><font size=2>Fechas:</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Fechas" id="txtRangoFechasRegistrosRecorrido" name="txtRangoFechasRegistrosRecorrido" value="{{$fechaDesde}} - {{$fechaHasta}}" autocomplete="off">
                                                </td>

                                                <!--<td align="right"><font size=2>Hasta</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" id="fechaHasta" name="fechaHasta" type="text" placeholder="Hasta" value="{{$fechaHasta??''}}" autocomplete="off">
                                                </td>-->
                                                <td>
                                                    <button class="btn btn-info btn-sm pull-right" id="btnConsultarRegistrosRecorrido" name="btnConsultarRegistrosRecorrido">Consultar</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm pull-right" id="btnLimpiarRegistrosRecorrido" name="btnLimpiarRegistrosRecorrido">Limpiar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-active table-sm">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>FechaHora</strong>
                                                </td>
                                                <td>
                                                    GMT -5
                                                </td>
                                                <td>
                                                    <strong>Velocidad</strong>
                                                </td>
                                                <td>
                                                    km/h
                                                </td>
                                                <td>
                                                    <strong>Odómetro</strong>
                                                </td>
                                                <td>
                                                    metros
                                                </td>
                                                <td>
                                                    <strong>Origen</strong>
                                                </td>
                                                <td>
                                                    RP (ReportePosición)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>FechaHoraServidor</strong>
                                                </td>
                                                <td>
                                                    GMT -5
                                                </td>
                                                <td>
                                                    <strong>Horómetro</strong>
                                                </td>
                                                <td>
                                                    segundos
                                                </td>
                                                <td>
                                                    <strong>T1 y T2</strong>
                                                </td>
                                                <td>
                                                    segundos
                                                </td>
                                                <td>
                                                    <strong>Origen</strong>
                                                </td>
                                                <td>
                                                    RPNV (ReportePosición_Inválido)
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table id="RegistrosRecorridoTabla" class="display"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>T1</th>
                                                <th>T2</th>
                                                <th>Fecha Hora</th>
                                                <th>Fecha Hora Recibido</th>
                                                <th>Fecha Hora Servidor</th>
                                                <th>Fecha Hora GPS</th>
                                                <th>Fecha Hora RTC</th>
                                                <th>Id</th>
                                                <th>Evento</th>
                                                <th>Latitud</th>
                                                <th>Longitud</th>
                                                <th>Altitud</th>
                                                <th>Velocidad (km/h)</th>
                                                <th>Rumbo</th>
                                                <th>Número Satélites</th>
                                                <th>Estado GPS</th>
                                                <th>Odometro</th>
                                                <th>Configuracion IO</th>
                                                <th>Estado IO</th>
                                                <th>Evento Entrada</th>
                                                <th>Nombre Evento</th>
                                                <th>Calle</th>
                                                <th>Estado Ignicion</th>
                                                <th>Nivel Batería</th>
                                                <th>Voltaje Batería</th>
                                                <th>EA1</th>
                                                <th>EA2</th>
                                                <th>EA3</th>
                                                <th>SA1</th>
                                                <th>SA2</th>
                                                <th>SA3</th>
                                                <th>Horometro</th>
                                                <th>Voltaje Alimentación</th>
                                                <th>Driver ID</th>
                                                <th>Velocidad OBD</th>
                                                <th>rpm OBD</th>
                                                <th>Posicion AceleradorOBD</th>
                                                <th>Odometro OBD</th>
                                                <th>Odometro Viaje OBD</th>
                                                <th>Nivel Gasolina OBD</th>
                                                <th>Combustible Restante OBD</th>
                                                <th>Engrane Transmisión</th>
                                                <th>Temperatura Refr</th>
                                                <th>Indice Gasolina OBD</th>
                                                <th>Voltaje Alimentacion OBD</th>
                                                <th>Estado Señales Giro OBD</th>
                                                <th>Gasolina Consumida por Viaje OBD</th>
                                                <th>Indicadores OBD</th>
                                                <th>DTC</th>
                                                <th>Origen</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>T1</th>
                                                <th>T2</th>
                                                <th>Fecha Hora</th>
                                                <th>Fecha Hora Recibido</th>
                                                <th>Fecha Hora Servidor</th>
                                                <th>Fecha Hora GPS</th>
                                                <th>Fecha Hora RTC</th>
                                                <th>Id</th>
                                                <th>Evento</th>
                                                <th>Latitud</th>
                                                <th>Longitud</th>
                                                <th>Altitud</th>
                                                <th>Velocidad (km/h)</th>
                                                <th>Rumbo</th>
                                                <th>Número Satélites</th>
                                                <th>Estado GPS</th>
                                                <th>Odometro</th>
                                                <th>Configuracion IO</th>
                                                <th>Estado IO</th>
                                                <th>Evento Entrada</th>
                                                <th>Nombre Evento</th>
                                                <th>Calle</th>
                                                <th>Estado Ignicion</th>
                                                <th>Nivel Batería</th>
                                                <th>Voltaje Batería</th>
                                                <th>EA1</th>
                                                <th>EA2</th>
                                                <th>EA3</th>
                                                <th>SA1</th>
                                                <th>SA2</th>
                                                <th>SA3</th>
                                                <th>Horometro</th>
                                                <th>Voltaje Alimentación</th>
                                                <th>Driver ID</th>
                                                <th>Velocidad OBD</th>
                                                <th>rpm OBD</th>
                                                <th>Posicion AceleradorOBD</th>
                                                <th>Odometro OBD</th>
                                                <th>Odometro Viaje OBD</th>
                                                <th>Nivel Gasolina OBD</th>
                                                <th>Combustible Restante OBD</th>
                                                <th>Engrane Transmisión</th>
                                                <th>Temperatura Refr</th>
                                                <th>Indice Gasolina OBD</th>
                                                <th>Voltaje Alimentacion OBD</th>
                                                <th>Estado Señales Giro OBD</th>
                                                <th>Gasolina Consumida por Viaje OBD</th>
                                                <th>Indicadores OBD</th>
                                                <th>DTC</th>
                                                <th>Origen</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                        
                                </div>
                                <div class="tab-pane fade" id="unidadesSinReportar" name="unidadesSinReportar">
                                
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                    <td align="right"><font size=2>Fechas</font></td>
                                                    <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Rango de Fechas" id="txtRangoFechasUnidadesSinReportar" name="txtRangoFechasUnidadesSinReportar" value="{{$fechaDesdeUnidadesSinReportar}} - {{$fechaHastaUnidadesSinReportar}}" autocomplete="off">
                                                        <!--<input class="form-control form-control-sm" type="text" placeholder="Desde" id="fechaDesdeUnidadesSinReportar" name="fechaDesdeUnidadesSinReportar" value="{{$fechaDesdeUnidadesSinReportar??''}}" autocomplete="off">-->
                                                    </td>

                                                    <!--<td align="right"><font size=2>Hasta</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" id="fechaHastaUnidadesSinReportar" name="fechaHastaUnidadesSinReportar" type="text" placeholder="Hasta" value="{{$fechaHastaUnidadesSinReportar??''}}" autocomplete="off">
                                                    </td>-->
                                                    <td>
                                                        <button class="btn btn-info btn-sm pull-right" id="btnConsultarUnidadesSinReportar" name="btnConsultarUnidadesSinReportar">Consultar</button>
                                                    </td>
                                                    <td>
                                                    <button class="btn btn-primary btn-sm pull-right" id="btnLimpiarUnidadesSinReportar" name="btnLimpiarUnidadesSinReportar">Limpiar</button>
                                                    </td>
                                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="UnidadesSinReportarTabla" class="display"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID Hunter</th>
                                                <th>VID</th>
                                                <th>Último Reporte</th>
                                                <th>Identificación</th>
                                                <th>Propietario</th>
                                                <th>Estado Cobertura</th>
                                                <th>Actualización</th>
                                                <th>Ciudad</th>
                                                <th>Ejecutiva</th>
                                                <th>Celular</th>
                                                <th>Celulares</th>
                                                <th>Fin Cobertura</th>
                                                <th>Estado Cartera</th>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Producto</th>
                                                <th>Modelo Dispositivo</th>
                                                <th>Número SIM Card</th>
                                                <th>Operadora Celular</th>
                                                <th>Número Celular</th>
                                                <th>Serie Dispositivo</th>
                                                <th>Correos Electrónicos</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID Hunter</th>
                                                <th>VID</th>
                                                <th>Último Reporte</th>
                                                <th>Identificación</th>
                                                <th>Propietario</th>
                                                <th>Estado Cobertura</th>
                                                <th>Actualización</th>
                                                <th>Ciudad</th>
                                                <th>Ejecutiva</th>
                                                <th>Celular</th>
                                                <th>Celulares</th>
                                                <th>Fin Cobertura</th>
                                                <th>Estado Cartera</th>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Producto</th>
                                                <th>Modelo Dispositivo</th>
                                                <th>Número SIM Card</th>
                                                <th>Operadora Celular</th>
                                                <th>Número Celular</th>
                                                <th>Serie Dispositivo</th>
                                                <th>Correos Electrónicos</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <div class="tab-pane fade" id="unidadesSinEntidad" name="unidadesSinEntidad">
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                    
                                                <td>
                                                    <button class="btn btn-info btn-sm pull-right" id="btnConsultarUnidadesSinEntidad" name="btnConsultarUnidadesSinEntidad">Consultar</button>
                                                </td>
                                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                        <table id="UnidadesSinEntidadTabla" class="display"  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Alias</th>
                                                    <th>ID Hunter</th>
                                                    <th>VID</th>
                                                    <th>Estado</th>
                                                    <th>Último Reporte</th>
                                                    <th>Último Reporte Servidor</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha Ingreso</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Alias</th>
                                                    <th>ID Hunter</th>
                                                    <th>VID</th>
                                                    <th>Estado</th>
                                                    <th>Último Reporte</th>
                                                    <th>Último Reporte Servidor</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha Ingreso</th>
                                                </tr>
                                            </tfoot>
                                        </table>
    
                                </div>
                                <div class="tab-pane fade" id="entiadadesSinUsuario" name="entiadadesSinUsuario">
                                
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                    
                                                <td>
                                                    <button class="btn btn-info btn-sm pull-right" id="btnConsultarEntidadesSinUsuario" name="btnConsultarEntidadesSinUsuario">Consultar</button>
                                                </td>
                                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                        <table id="EntidadesSinUsuarioTabla" class="display"  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Tipo de Entidad</th>
                                                    <th>Nombre</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono convencional</th>
                                                    <th>Teléfono celular</th>
                                                    <th>Estado</th>
                                                    <th>Usuario ingreso</th>
                                                    <th>Unidades asociadas</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Tipo de Entidad</th>
                                                    <th>Nombre</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono convencional</th>
                                                    <th>Teléfono celular</th>
                                                    <th>Estado</th>
                                                    <th>Usuario ingreso</th>
                                                    <th>Unidades asociadas</th>
                                                </tr>
                                            </tfoot>
                                    </table>
    
                                </div>
                                
                                <div class="tab-pane fade" id="consumoSMS" name="consumoSMS">
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                <td align="right"><font size=2>Celular:</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Celular" id="celularBuscar" name="celularBuscar" value="{{ old('celularBuscar')??''}}">

                                                    
                                                    
                                                </td>
                                              
                                                <td align="right"><font size=2>Fechas</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Fechas" id="txtRangoFechasConsumoSMS" name="txtRangoFechasConsumoSMS" value="{{$fechaDesdeConsumoSMS}} - {{$fechaHastaConsumoSMS}}" autocomplete="off">
                                                </td>

                                                <!--<td align="right"><font size=2>Hasta</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" id="fechaHastaConsumoSMS" name="fechaHastaConsumoSMS" type="text" placeholder="Hasta" value="{{$fechaHastaConsumoSMS??''}}" autocomplete="off">
                                                </td>-->
                                                <td>
                                                    <button class="btn btn-info btn-sm pull-right" id="btnConsultarConsumoSMS" name="btnConsultarConsumoSMS">Consultar</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm pull-right" id="btnLimpiarConsumoSMS" name="btnLimpiarConsumoSMS">Limpiar</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="ConsumoSMSTabla" class="display"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Propietario</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Propietario</th>
                                                <th>Estado</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-sm-6">
                                        <canvas id="popChart" ></canvas>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="comandosEnviados" name="comandosEnviados">
                                    <table class="table table-primary table-sm">
                                            
                                        <tbody>
                                            <tr>
                                                <td align="right"><font size=2>Vid:</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Vid" id="vidBuscarComandosEnviados" name="vidBuscarComandosEnviados" value="{{ old('vidBuscarComandosEnviados')??''}}">

                                                    
                                                    
                                                </td>
                                              
                                                <td align="right"><font size=2>Fechas</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Fechas" id="txtRangoFechasComandosEnviados" name="txtRangoFechasComandosEnviados" value="{{$fechaDesdeComandosEnviados}} - {{$fechaHastaComandosEnviados}}" autocomplete="off">
                                                </td>

                                                <!--<td align="right"><font size=2>Hasta</font></td>
                                                <td>
                                                    <input class="form-control form-control-sm" id="fechaHastaConsumoSMS" name="fechaHastaConsumoSMS" type="text" placeholder="Hasta" value="{{$fechaHastaConsumoSMS??''}}" autocomplete="off">
                                                </td>-->
                                                <td>
                                                    <button class="btn btn-info btn-sm pull-right" id="btnConsultarComandosEnviados" name="btnConsultarComandosEnviados">Consultar</button>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="ComandosEnviadosTabla" class="display"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Fecha Enviado</th>
                                                <th>VID</th>
                                                <th>Tipo</th>
                                                <th>PDU</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Fecha Enviado</th>
                                                <th>VID</th>
                                                <th>Tipo</th>
                                                <th>PDU</th>
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
    </div>
</div>
@endsection