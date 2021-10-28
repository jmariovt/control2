@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Reporte Gerencial</div>
                <div class="card-body">
                    
                        <div class="container">
                            <div class="row justify-content-center">
                                
                                <div class="col-sm-12">
                                    
                                    </p>
                                    <div class="form-group" id="grupoAnio" >
                                                <label for="anio">Año:</label>
                                                <select class="form-control form-control-sm" id="anio" name="anio">
                                                    <option value='0' selected></option>
                                                    @foreach($anios as $anio)
                                                    <option value='{{ $anio }}' >{{ $anio }}</option>
                                                    @endforeach
                                                </select>
                                    </div>
                                    <div class="form-group" id="grupoMarca" >
                                            <label for="marca">Marca:</label>
                                            <select class="form-control form-control-sm" id="comboMarca" name="comboMarca">
                                                <option value='0' selected></option>
                                                    @foreach($comboMarcas as $marca)
                                                    <option value='{{ $marca->Descripcion }}' >{{ $marca->Descripcion }}</option>
                                                    @endforeach
                                            </select>
                                    </div>
                                    <h2 align="center"><label >CENTRAL DE MONITOREO</label></h2>

                                    <h2 align="center"><label id="labelReporteGerencial" name="labelReporteGerencial">ALERTAS</label></h2>
                                    <h4 align="center"><label id="labelDesdeHasta" name="labelDesdeHasta">DESDE ... HASTA ...</label></h4>

                                    <table class="table table-sm table-hover table-striped" name="tablaReporte" id="tablaReporte">
                                        <thead class="thead-dark">
                                            <tr align="center">
                                                <th >MES</th>
                                                <th>ALERTAS</th>
                                                <th >PROM. DIA</th>
                                            </tr>
                                        </thead>
                                        <tbody name="tbodyReporteAlertas" id="tbodyReporteAlertas">
                                            
                                            
                                            
                                        
                                        </tbody>
                                    </table>
                                    </br>
                                    </br>
                                    <h2 align="center"><label>HORAS DE MAYOR ATENCIÓN DE ALERTAS</label></h2>
                                    <table class="table table-sm table-hover table-striped" name="tablaReporteHorasMayorAtencion" id="tablaReporteHorasMayorAtencion">
                                        <thead class="thead-dark">
                                            <tr align="center">
                                                <th>HORA</th>
                                                <th>CANT. LLAMADAS</th>
                                            </tr>
                                        </thead>
                                        <tbody name="tbodyReporteHorasMayorAtencion" id="tbodyReporteHorasMayorAtencion">
                                            
                                            
                                            
                                        
                                        </tbody>
                                    </table>
                                    </br>
                                    </br>
                                    <h2 align="center"><label>MAYOR MOTIVO ALERTAS</label></h2>
                                    <table class="table table-sm table-hover table-striped" name="tablaReporteMayorMotivo" id="tablaReporteMayorMotivo">
                                        <thead class="thead-dark">
                                            <tr align="center">
                                                <th>MOTIVO</th>
                                                <th>CANTIDAD</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody name="tbodyReporteMayorMotivoAlertas" id="tbodyReporteMayorMotivoAlertas">
                                            
                                            
                                            
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                        </div>
                   

                </div>
                <div class="modal-footer">
					<a href="/xadmin/paths" class="btn btn-secondary">Regresar</a>
					
				</div>
            </div>
        </div>
    </div>
</div>

@endsection