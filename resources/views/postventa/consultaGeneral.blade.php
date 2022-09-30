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
                <?php
                    $perfiles = session('perfil');
                    $arregloPerfiles = explode(";",$perfiles);
                    $debeBloquear = "";
            
                    foreach ($arregloPerfiles as $perfil) {
                        //if($perfil=="1000"||$perfil=="6")
                        if($perfil=="1006")
                            $debeBloquear = "disabled";
                    }
                ?>
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
                                            <input class="form-control form-control-sm" type="hidden"  id="IdUsuario" name="IdUsuario" value='0'>
                                            <input class="form-control form-control-sm" type="hidden"  id="IdEntidad" name="IdEntidad" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="UID" name="UID" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="UsuarioSesion" name="UsuarioSesion" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="debeBloquear" name="debeBloquear" value='{{$debeBloquear}}'>
				                        </td>
                                        <td>
                                            
                                            <div class="col-md-8">
                                                <select class="form-select form-select-sm" id="consultaGeneralCriterio" name="consultaGeneralCriterio">
                                                    <option value='0'>Cédula o RUC</option>
                                                    <option value='1'>Nombre completo o razón social</option>
                                                    <option value='4' selected>Usuario GeoSys</option>
                                                    <option value='5'>vid</option>
                                                </select>
                                            </div>
                                           
                                        </td>
                                        <td>
                                            
                                            <div class="col-md-15">
                                                <select class="form-select form-select-sm"  id="consultaGeneralSeleccionarEntidad" name="consultaGeneralSeleccionarEntidad" disabled>
                                                    <option value='0' selected>Elija entidad...</option>
                                                    <!--<option value='1'>Entidad 1</option>
                                                    <option value='4'>Entidad 2</option>-->
                                                </select>
                                            </div>
                                           
                                        </td>
                                        <!--<td>
                                            <input class="form-control form-control-sm" value="Limpiar" type="button" id="btnEncerar" name="btnEncerar">
                                        </td>-->
                                        <td>
                                            <button class="btn btn-primary btn-sm" type="button" id="btnIngresarGeoSys" name="btnIngresarGeoSys"  {{$debeBloquear}}>Geosys</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"  type="button" id="btnRestablecerClave" name="btnRestablecerClave" >Restablecer clave</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" type="button" id="btnActualizarDatos" name="btnActualizarDatos" {{$debeBloquear}}>Actualizar datos</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-striped">
	    						<tbody>
				                    <tr>
				                        <td >Nombres o Razón Social:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralNombres" name="consultaGeneralNombres" value='' disabled>
				                        </td>
                                        <td >Entidad:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralCedularuc" name="consultaGeneralCedularuc" value='' disabled>
				                        </td>
                                    </tr>
                                    <tr>
				                        <!--<td >Dirección:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralDireccion" name="consultaGeneralDireccion" value='' disabled>
				                        </td>-->
                                        <td >E-Mail:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralEmail" name="consultaGeneralEmail" value='' {{$debeBloquear}}>
				                        </td>
                                        <td >Estado Usuario:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" id="consultaGeneralEstadoUsuario" name="consultaGeneralEstadoUsuario" value='' disabled>
				                        </td>
                                    </tr>
                                    <tr>
                                        <!--<td >Convencional:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralConvencional" name="consultaGeneralConvencional" value='' disabled>
				                        </td>-->
                                        <td >Celular:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralCelular" name="consultaGeneralCelular" value='' {{$debeBloquear}}>
				                        </td>
                                        <td >Operadora:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="consultaGeneralOperadora" name="consultaGeneralOperadora" value='' disabled>
				                        </td>
                                    </tr>
                                    <tr>
                                        <td>Usuario:</td>
                                        <td>
                                        <input class="form-control form-control-sm" type="text"  id="Usuario" name="Usuario" value='' disabled>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <!--<div style="overflow-x:auto;">-->
                            <table class="" id="tablaContadoresUnidades" border="0" name="tablaContadoresUnidades" width="100%">
                                
                                    
                                <tr>
                                    
                                    <td  ><label class="form-check-label text-dark"><b>Número de </br>Registros</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>Vehículos </br>Activos</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>Vehículos </br>Suspendidos</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>Dispositivos </br>Reportando</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>Dispositivos </br>No Reportando</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>SIMCards </br>Activas</b></label></td>
                                    <td  ><label class="form-check-label text-dark"><b>SIMCards </br>Cortadas</b></label></td>
                                    
                                </tr>
                                <tr>
                                    
                                
                                
                                    <td ><h3><span class="badge rounded-pill text-white bg-success" id="NumeroRegistros">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-success" id="VehiculosActivados">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-danger" id="VehiculosDesactivados">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-success" id="DispositivosTransmitiendo">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-danger" id="DispositivosDesactivados">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-success" id="SimActivas">0</span></h3></td>
                                    <td ><h3><span class="badge rounded-pill text-white bg-danger" id="SimDesactivadas">0</span></h3></td>
                                    
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <div class="material-switch">
                                            
                                            <input class="form-check-input" type="checkbox" id="switchTodos">
                                            <label class="label-primary" for="switchTodos"></label>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="material-switch">
                                            
                                            <input class="form-check-input" type="checkbox" id="switchActivos">
                                            <label class="label-primary" for="switchActivos"></label>
                                        </div>
                                    </td>
                                    
                                    <td> 
                                        <div class="material-switch">
                                            
                                            <input class="form-check-input" type="checkbox" id="switchSuspendidos">
                                            <label class="label-primary" for="switchSuspendidos"></label>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div class="material-switch">
                                            
                                            <input class="form-check-input" type="checkbox" id="switchNoReportando">
                                            <label class="label-primary" for="switchNoReportando"></label>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div class="material-switch">
                                            
                                            <input class="form-check-input" type="checkbox" id="switchSimCortadas">
                                            <label class="label-primary" for="switchSimCortadas"></label>
                                        </div>
                                    </td>
                                </tr>
                                
                                            
                                
                                
                            
                            </table>
                        <!--</div>-->


                        </br>
	    				<div class="row justify-content-center">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#unidades" id="navunidades">Unidades</a>
                                </li>
                                <li class="nav-item" >
                                    <a class="nav-link {{$debeBloquear}}" data-bs-toggle="tab" href="#celularesmail" id="navcelulares" >Celulares y E-mail</a>
                                </li>
                                <li class="nav-item" >
                                    <a class="nav-link {{$debeBloquear}}" data-bs-toggle="tab" href="#aplicaciones" id="navaplicaciones" >Aplicaciones</a>
                                </li>
                                
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active show" id="unidades" name="unidades">
                                    <!--<label for="consultaGeneralCriterioAgrupar" class="form-label mt-4 form-label-sm">Agrupar por</label>
                                    <select class="form-select  form-select-sm" id="consultaGeneralCriterioAgrupar" name="consultaGeneralCriterioAgrupar">
                                        <option value='0' selected>Seleccione...</option>
                                        <option value='2'>Entidad</option>
                                        <option value='3'>Entidad y Estado</option>
                                    </select>-->
                                    <table id="UnidadesTabla" class="display responsive nowrap"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>Estado</th>
                                                <th>ID Hunter</th>
                                                <th>VID</th>
                                                <th>Placa</th>
                                                <th>Etiqueta</th>
                                                <th>Ultimo Reporte GPS</th>
                                                <th>Ultimo Reporte Servidor</th>
                                                <th>Producto</th>
                                                <th>Dispositivo</th>
                                                <th>Entidad</th>
                                                <th>Marca</th>
                                                <th>Model</th>
                                                <th>Chasis</th>
                                                <th>Motor</th>
                                                <th>Imei</th>
                                                <th>Icc</th>
                                                <th>Estado SIM</th>
                                                <th>Observacion SIM</th>
                                                <th>Número Celular</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>Estado</th>
                                                <th>ID Hunter</th>
                                                <th>VID</th>
                                                <th>Placa</th>
                                                <th>Etiqueta</th>
                                                <th>Ultimo Reporte GPS</th>
                                                <th>Ultimo Reporte Servidor</th>
                                                <th>Producto</th>
                                                <th>Dispositivo</th>
                                                <th>Entidad</th>
                                                <th>Marca</th>
                                                <th>Model</th>
                                                <th>Chasis</th>
                                                <th>Motor</th>
                                                <th>Imei</th>
                                                <th>Icc</th>
                                                <th>Estado SIM</th>
                                                <th>Observacion SIM</th>
                                                <th>Número Celular</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!--<div id="jqxgrid">
                                    </div>
                                    <div style="margin-top: 20px" id="jqxlistbox"></div>	
                                    <div style='float: left;'>
                                        <input type="button" value="Export to Excel" id='excelExport'  name='excelExport' />
                                        <br /><br />
                                        <input type="button" value="Export to PDF" id='pdfExport' name='pdfExport' />
                                    </div>-->
                                </div>
                                <div class="tab-pane fade" id="celularesmail" name="celularesmail">
                                    <!--<table id="UnidadesCelularesEmail" class="display nowrap"  style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Dato</th>
                                                <th>Propietario</th>
                                                <th>Operadora</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Dato</th>
                                                <th>Propietario</th>
                                                <th>Operadora</th>
                                            </tr>
                                        </tfoot>
                                    </table>-->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary btn-sm" id="btnNuevoCelular">Nuevo Celular</button>
                                            </p>
                                            <div id="areaCelular" style="display: none;">
                                                <table id="tablaAreaCelular">
                                                    <tr>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" placeholder="Número" id="nuevoCelularNumero" name="nuevoCelularNumero" value=''>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" placeholder="Propietario" id="nuevoCelularPropietario" name="nuevoCelularPropietario" value=''>
                                                            <input class="form-control form-control-sm" type="hidden" id="nuevoCelularOperacion" name="nuevoCelularOperacion" value='N'>
                                                            <input class="form-control form-control-sm" type="hidden" id="antiguoCelular" name="antiguoCelular" value=''>
                                                            <input class="form-control form-control-sm" type="hidden" id="antiguoPropietarioCelular" name="antiguoPropietarioCelular" value=''>
                                                        </td>
                                                        <td>
                                                            <select class="form-control-sm" id="nuevoCelularOperadora" name="nuevoCelularOperadora">
                                                                <option value='0' selected>Operadora...</option>
                                                                <option value='1'>Claro</option>
                                                                <option value='2'>Movistar</option>
                                                                <option value='4'>Indeterminada</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <a id="guardarCelular" ><img src="../Imagenes/floppy-disk-solid.svg"  title="Guardar"  style="height: 20px;"/></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            
                                            
                                            </div>

                                            <table class="table table-sm table-hover table-striped" id="tablaCelulares">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Celular</th>
                                                        <th>Propietario</th>
                                                        <th>Operadora</th>
                                                        <th colspan="2">&nbsp;</th>
                                                        <th colspan="2">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="tbodyCelulares" id="tbodyCelulares">
                                                    
                                                    
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-6">
                                            <button class="btn btn-primary btn-sm" id="btnNuevoCorreo" name="btnNuevoCorreo">Nuevo Correo</button>
                                            </p>
                                            <div id="areaCorreo" style="display: none;">
                                                <table id="tablaAreaCorreo">
                                                    <tr>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" placeholder="Correo electrónico" id="nuevoCorreoCorreo" name="nuevoCorreoCorreo" value=''>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text" placeholder="Propietario" id="nuevoCorreoPropietario" name="nuevoCorreoPropietario" value=''>
                                                            <input class="form-control form-control-sm" type="hidden" id="nuevoCorreoOperacion" name="nuevoCorreoOperacion" value='N'>
                                                            <input class="form-control form-control-sm" type="hidden" id="antiguoCorreo" name="antiguoCorreo" value=''>
                                                            <input class="form-control form-control-sm" type="hidden" id="antiguoPropietario" name="antiguoPropietario" value=''>
                                                        </td>
                                                        <td>
                                                            <a  id="guardarCorreo"><img src="../Imagenes/floppy-disk-solid.svg"  title="Guardar"  style="height: 20px;"/></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            
                                            
                                            </div>
                                            <table class="table table-sm table-hover table-striped" id="tablaCorreos">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Correo Electrónico</th>
                                                        <th>Propietario</th>
                                                        <th colspan="2">&nbsp;</th>
                                                        <th colspan="2">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="tbodyCorreo" id="tbodyCorreo">
                                                    
                                                    
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    


                                    
                                   
                                </div>
                               
                                <div class="tab-pane fade" id="aplicaciones" name="aplicaciones">
                                    
                                    <div class="row">
                                        
                                        <ul class="columns">

                                            <li class="column to-do-column">
                                            <div class="column-header">
                                                <h4>Disponibles</h4>
                                            </div>
                                            <ul class="task-list" id="to-do">
                                                
                                            </ul>
                                            </li>

                                            <li class="column trash-column">
                                                <div class="column-header">
                                                    <h4>Seleccionadas</h4>
                                                </div>
                                                <ul class="task-list" id="trash">
                                                   

                                                </ul>
                                                <div class="column-button">
                                                    <!--<button class="button delete-button" onclick="emptyTrash()">Borrar</button>-->
                                                    <button class="btn btn-info btn-sm pull-right" id="btnGrabarApps" name="btnGrabarApps">Guardar Aplicaciones</button>
                                                </div>
                                            
                                            </li>

                                        </ul>
                                       
                                    </div>
                                    <!--<div class="row">
                                        <button class="btn btn-primary btn-sm pull-right" id="btnGrabarApps" name="btnGrabarApps">Guardar Aplicaciones</button>
                                    </div>-->
                                    
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