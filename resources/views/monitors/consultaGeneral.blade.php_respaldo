@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Consulta General

                </div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
							
	    					<table class="table table-sm">
	    						<tbody>
				                    <tr>
				                        <td >Buscar:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" placeholder="Cedula, RUC, nombre, razón social o usuario GeoSys" id="consultaGeneralBuscar" name="consultaGeneralBuscar" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="consultaGeneralDatosEncontrados" name="consultaGeneralDatosEncontrados" value=''>
				                        </td>
                                        <td>
                                            <div class="form-group row">
                                                
                                                <div class="col-md-6">
                                                    <select class="form-control-sm" id="consultaGeneralCriterio" name="consultaGeneralCriterio">
                                                        <option value='0'>Cédula o RUC</option>
                                                        <option value='1'>Nombre completo o razón social</option>
                                                        <option value='4' selected>Usuario GeoSys</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-striped">
	    						<tbody>
				                    <tr>
				                        <td >Nombres o Razón Social:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralNombres" name="consultaGeneralNombres" value=''>
				                        </td>
                                        <td >Ced o RUC:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralCedularuc" name="consultaGeneralCedularuc" value=''>
				                        </td>
                                    </tr>
                                    <tr>
				                        <td >Dirección:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralDireccion" name="consultaGeneralDireccion" value=''>
				                        </td>
                                        <td >E-Mail:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralEmail" name="consultaGeneralEmail" value=''>
				                        </td>
                                    </tr>
                                    <tr>
                                        <td >Convencional:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralConvencional" name="consultaGeneralConvencional" value=''>
				                        </td>
                                        <td >Celular:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralCelular" name="consultaGeneralCelular" value=''>
				                        </td>
                                    </tr>
                                    <tr>
                                        <td >Estado Usuario:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" id="consultaGeneralEstadoUsuario" name="consultaGeneralEstadoUsuario" value=''>
				                        </td>
                                        <td >Operadora:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralOperadora" name="consultaGeneralOperadora" value=''>
				                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
	    				<div class="row justify-content-center">
                        <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#unidades" id="navunidades">Unidades</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#celularesmail" id="navcelulares">Celulares y E-mail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#aplicaciones" id="navaplicaciones">Aplicaciones</a>
                                </li>
                                
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active show" id="unidades" name="unidades">
                                    <p>Unidades.</p>
                                    <table class="table table-condensed table-hover table-striped" id="tablaUnidades" name="tablaUnidades" width="100%" >
                                        <thead >
                                            <tr>
                                                <th width="8%">VID</th>
                                                <th width="8%">Placa</th>
                                                <th width="8%">Entidad</th>
                                                <th width="8%">Marca</th>
                                                <th width="8%">Modelo</th>
                                                <th width="10%">UltimoReporte GPS</th>
                                                <th width="10%">UltimoReporte Servidor</th>
                                                <th width="8%">Producto</th>
                                                <th width="8%">Dispositivo</th>
                                                <th width="8%">CodSysHunter</th>
                                                <th width="8%">Editar</th>
                                                <th width="8%">Configuracion</th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyUnidades" name="tbodyUnidades">
                                            <tr>
                                                <td colspan="13">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="celularesmail" name="celularesmail">
                                    <p>Celulares.</p>
                                    <table class="table table-condensed table-hover table-striped" id="tablaCelulares" name="tablaCelulares" width="100%" >
                                        <thead >
                                            <tr>
                                                <th width="25%">Tipo</th>
                                                <th width="25%">Numero / Email</th>
                                                <th width="25%">Propietario</th>
                                                <th width="25%">Operadora</th>
                                                
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyCelulares" name="tbodyCelulares">
                                            <tr>
                                                <td colspan="13">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="aplicaciones" name="aplicaciones">
                                    <p>Aplicaciones.</p>
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