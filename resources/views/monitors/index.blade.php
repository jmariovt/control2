@extends('layouts.app')

@section('content')
@include('common.success')
@include('common.errors')
<!--<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">-->
			<?php
				$idUsuario = session('idUsuario');
				$idSubUsuario = session('idSubUsuario');
				$idCategoria = session('idCategoria');

				if($idSubUsuario=="0")
				{
					$styleColumna = "display: none;";
				}else
				{
					if($idCategoria=="9") //Es Supervisor
					{
						$styleColumna = "text-align: center;";
					}else{
						$styleColumna = "display: none;";
					}
				}

				
			?>
			<input type="hidden" class="form-control form-control-sm" id="idUsuario" name="idUsuario" value="{{$idUsuario}}">
			<input type="hidden" class="form-control form-control-sm" id="idSubUsuario" name="idSubUsuario" value="{{$idSubUsuario}}">
			<input type="hidden" class="form-control form-control-sm" id="idCategoria" name="idCategoria" value="{{$idCategoria}}">
								
			<table class="table table-sm ">
	    						<tbody>
				                    <tr>
				                        
				                        <td>
				                        	<a href="/xadmin/alerts" class="btn btn-primary btn-sm" target="_blank">Alertas</a>
											@if($idSubUsuario!="0")
											<a href="/xadmin/alerts/alertasAgrupadasPorVehiculo" class="btn btn-primary btn-sm" target="_blank">Alertas por Vehículos</a>
											@endif
											@if (Auth::guard('web')->check())
				                        	<a href="/xadmin/monitors/controlMonitoreos" class="btn btn-primary btn-sm" target="_blank">Dashboard</a>
											@endif
				                        	<!--<button type="button" class="btn btn-primary btn-sm">Ver monitoreos</button>-->
											<a href="/xadmin/alerts/seguimientoalertas" class="btn btn-primary btn-sm" target="_blank">Seguimiento alertas</a>
											@if($idSubUsuario!="0")
											<a href="/xadmin/alerts/seguimientoAlertasAgrupadasPorMonitorista" class="btn btn-primary btn-sm" target="_blank">Reporte Alertas Agrupadas</a>
											<a href="/xadmin/alerts/reportesKpi" class="btn btn-primary btn-sm" target="_blank">KPI</a>
											@endif
				                        	@if (Auth::guard('web')->check())
				                        		
				                        
				                        		
											
												<a href="/xadmin/alerts/reportegerencial" class="btn btn-primary btn-sm" target="_blank">Reporte Gerencial</a>
												
											
												<a href="/xadmin/monitors/clienteMonitoreo" class="btn btn-primary btn-sm" target="_blank">Clientes monitoreo</a>
											@endif
				                       
				                        	<!--<button type="button" class="btn btn-primary btn-sm">Definición rutas</button>-->
											<!--<a href="/xadmin/monitors/reportes/" class="btn btn-primary btn-sm"  target="_blank" onclick="window.open('/xadmin/monitors/reportes/','newwindow','width=900,height=900'); return false;">Reportes generales</a>-->
				                        </td>	
				                    </tr>
				                </tbody>
                			</table>
                <div class="card-header">

				<table class="" id="tablaContadoresMonitoreos" border="0" name="tablaContadoresMonitoreos" width="100%">
							
								
							<tr>
								
								<td  align="left"><b>Monitoreos: </b></td>
								<td  align="left"><b>Sin parametrización de alertas: </b></td>
								<td  align="left"><b>Reportando: </b></td>
								<td  align="left"><b>No Reportando: </b></td>
								<td  align="left"><b>Iniciados: </b></td>
								<td  align="left"><b>No Iniciados: </b></td>
							</tr>
							<tr>
								
								
								<td align="left"><b><label class="form-check-label" id="contadorEnPantalla"></label></b></td>
								<td align="left" ><b><label class="form-check-label" id="contadorSinEventos"></b></label></td>
								<td align="left" ><b><label class="form-check-label" id="contadorReportando"></b></label></td>
								<td align="left"><b><label class="form-check-label" id="contadorNoReportando"></b></label></td>
								<td align="left"><b><label class="form-check-label" id="contadorIniciados"></b></label></td>
								<td align="left" ><b><label class="form-check-label" id="contadorNoIniciados"></b></label></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchSinEventos">
										 <label class="label-primary" for="switchSinEventos"></label>
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
                                         
										 <input class="form-check-input" type="checkbox" id="switchNoIniciados">
										 <label class="label-primary" for="switchNoIniciados"></label>
									</div>
								</td>
							</tr>
							
										
							
							
						
						</table>

				</div>

                <div class="card-body">
                    <div class="container-fluid">
	    				<div class="row justify-content-center">
							
							
	    					<table class="table table-sm table-hover table-striped" border="0">
	    						<tbody>
				                    <tr>
				                        
										<td width="10%">
				                        	<input class="form-control form-control-sm" type="text" onkeyup="buscaMonitoreosInput()" placeholder="Buscar..." id="inputBuscarMonitoreo" name="inputBuscarMonitoreo" >
				                        </td>

										<td width="15%">
											<input class="form-control form-control-sm" type="text"  id="txtRangoFechas" name="txtRangoFechas" value="{{ $fechaDesde }} - {{ $fechaHasta }}" >
										</td>
										
				                        <!--<td>
				                        	<input class="form-control form-control-sm" type="text" placeholder="Desde" id="fechaDesde" name="fechaDesde" value='{{ $fechaDesde }}'> 
				                        </td>

				                        
				                        <td>
				                        	<input class="form-control form-control-sm" id="fechaHasta" name="fechaHasta" type="text" placeholder="Hasta" value='{{ $fechaHasta }}'>
				                        </td>-->

										<!--<td>
				                        	<button type="button" class="btn btn-outline-primary btn-sm " id="btBuscarMonitoreos" name="btBuscarMonitoreos">Buscar por fechas</button>
				                        </td>-->
				                        
				                        
				                        <td style="text-align: center;">
				                        	<div class="form-group">
												<!--<label for="estado">Estado</label>-->
											    <select class="form-control-sm" id="estado">
											      <option value="A" selected>Activos</option>
											      <option value="I">Inactivos</option>
											      <option value="">Todos</option>
											    </select>
											 </div>
				                        </td>
										
				                        <td style="text-align: center;" width="20%">
											<!--<label for="selectBuscarPorTipoMonitoreo">Tipo</label>-->
				                        	<div class="form-group">
											    <select class="form-control-sm" id="selectBuscarPorTipoMonitoreo">
													@foreach($tiposMonitoreos as $tipoMonitoreo)
													<option value="{{$tipoMonitoreo->TipoMonitoreo}}">{{$tipoMonitoreo->Monitoreo}}</option>
													@endforeach
											      <!--<option value="1" selected>Individual</option>
											      <option value="2">Por Producto</option>-->
											      
											    </select>
											 </div>
				                        </td>
				                        <td style="text-align: center;">
											|
										</td>
										<td style="text-align: center;">
											<?php
												$imagenCrear='Imagenes/file_plus_menta.svg';
											?>
	                						<!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#creaMonitoreoModal">Crear</button>-->
	                						<a href="/xadmin/monitors/create" onclick="window.open('/xadmin/monitors/create','CrearMonitoreo','width=1500,height=900'); return false;"><img src="{{asset($imagenCrear)}}"  height="30" title="Crear Monitroeo"  ></a>

	                					</td>
										<td style="text-align: center;" width="5%"> 
											<div id="areaImagen" style="display: none;">
												<img src="{{asset('Imagenes/cargando.gif')}}" width="40"  height="40"  id="imagenBuscando" >
											</div>
										</td>
				                    </tr>
				                </tbody>
				            </table>

									
						
                			<table class="table table-condensed table-hover table-striped table-bordered" id="tablaMonitoreos" name="tablaMonitoreos" width="100%" >
                				<thead >
				                    <tr>
										<th width="6%" style="text-align: center;">Tipo</th>
										<th width="6%" style="{{$styleColumna}}">Usuario</th>
										<th width="6%" style="text-align: center;">VID</th>
										<th width="6%" style="text-align: center;">Reportando</th>
				                        <th width="6%" style="text-align: center;">CodSysHunter</th>
				                        <th width="4%" style="text-align: center;">Alias</th>
										
				                        <th width="12%" style="text-align: center;">Entidad</th>
				                        <th width="8%" style="text-align: center;">Desde</th>
				                        <th width="8%" style="text-align: center;">Hasta</th>
				                        <th width="3%" style="text-align: center;">Activo</th>
				                        <th width="16%" style="text-align: center;">Alertas parametrizadas</th>
				                        <th width="8%" style="text-align: center;">P. Acción Actual</th>
				                        <th width="6%" colspan="4" style="text-align: center;">Acciones</th>
										<!--<th width="8%">&nbsp;</th>
										<th width="8%" colspan="1">&nbsp;</th>
										<th width="6%" colspan="1">&nbsp;</th>-->
										
										
				                    </tr>
				                </thead>
								<?php
									$posicionHorizontal = 0;
								?>
				                <tbody id="tbodyMonitoreos" name="tbodyMonitoreos">
				                	 @foreach($monitors as $monitor)
				                	 <tr>
									 	<td style="text-align: center;">{{$monitor->DescripcionTipoMonitoreo}}</td>
										 <td style="{{$styleColumna}}">{{$monitor->NombreCompleto}}</th>
										 <td style="text-align: center;">{{$monitor->VID}}</td>
										
										 <?php
											if($monitor->Reportando==1)
											{
												$imagenMonitoreo = 'Imagenes/radio_green.svg';
												$textoReportando = 'Reportando';
											}
											else {
												$imagenMonitoreo = 'Imagenes/alert_triangle_yellow.svg';
												$textoReportando = 'No reportando';
											}

										 ?>
										 <td style="text-align: center;"><img src="{{asset($imagenMonitoreo)}}"  height="25" title="{{$textoReportando}}"  id="imagenBuscando" ><label hidden>{{$monitor->Reportando}}</label><label hidden>{{$textoReportando}}</label></td>
										 
				                        <td style="text-align: center;">{{$monitor->CodSysHunter}}</td>
				                        <td style="text-align: center;">{{$monitor->Alias}}</td>
										
										<td>{{ $monitor->entidad[0]->Entidades}}</td>
										
										
				                        
				                        <td style="text-align: center;">{{$monitor->FechaHoraInicio}}</td>
				                        <td style="text-align: center;">{{$monitor->FechaHoraFin}}</td>
				                        <td style="text-align: center;">{{$monitor->Estado}}</td>
				                        <!--<td>&nbsp;</td> era columna para modificar-->
				                        <!--<td>Asignar Copiar</td>-->
				                        <td id="tdAlertas">
											<form class="form-group" method="POST">
												<input type="hidden" class="form-control form-control-sm" id="muestraTodas_{{$monitor->IdMonitoreo}}" name="muestraTodas_{{$monitor->IdMonitoreo}}" value="NO" >
												<div id="areaAlertas_{{$monitor->IdMonitoreo}}">
												<?php
													$arregloAlertas = explode("%",$monitor->DetalleAlertas);
													$contadorAlertas = 0;
													foreach ($arregloAlertas as $alertaFila) 
													{
														$arregloFila = explode(";",$alertaFila);
														$idMonitoreo=$monitor->IdMonitoreo;
														if(isset($arregloFila[3]))
														{
															$contadorAlertas = $contadorAlertas + 1 ;
															//$idMonitoreo=$arregloFila[0];
															if($contadorAlertas<=6)
															{?>
																<fieldset class="form-group">
																<div class="form-check">
																	<!-- CheckAlerta_IdMonitoreo_IdAlerta -->
																	<input class="form-check-input" type="checkbox" value="{{$arregloFila[0]}}_{{$arregloFila[1]}}" id="CheckAlerta_{{$arregloFila[0]}}_{{$arregloFila[1]}}">
																	<label class="form-check-label" for="CheckAlerta_{{$arregloFila[0]}}_{{$arregloFila[1]}}">
																		<a href="/xadmin/monitors/editalert/{{$arregloFila[0]}}/{{$arregloFila[1]}}" onclick="window.open('/xadmin/monitors/editalert/{{$arregloFila[0]}}/{{$arregloFila[1]}}','modificar_{{$arregloFila[0]}}','width=1500,height=900'); return false;">{{$arregloFila[3]}}</a><!--<a href="/xadmin/monitors/deleteMonitorAlert/{{$arregloFila[0]}}/{{$arregloFila[1]}}" onclick="return confirm('¿Está seguro de eliminar la alerta?')"> [x]</a> -->
																	
																	</label>
																
																	
																</div> 
																</fieldset>
																<?php
															}
															?>
														<?php
														}
													}
													

												?>
												</div>
												</br>
												<?php
												if($contadorAlertas >6)
												{?>
													
													<button type="button"  class="btn btn-link btn-sm" id="btnMostrarTodasAlertas_{{$idMonitoreo}}" onclick="mostrarTodasAlertas('{{$idMonitoreo}}','{{$monitor->IdActivo}}')">Mostrar todas</button>
													</br>
													</br>
												<?php
												}

												if($contadorAlertas >0)
												{
												?>
												
												<!--<a href="btnEliminaAlerta_{{$idMonitoreo}}" class="btn btn-outline-primary  btn-sm prueba" id="btnEliminaAlerta_{{$idMonitoreo}}">Eliminar (Prueba)</a>-->
												<!--<button type="button" class="btnEliminaAlerta" id="btnEliminaAlerta1_{{$idMonitoreo}}">Eliminar</button>-->
													<button type="button"  class="btn btn-primary btn-sm" id="btnEliminaAlerta_{{$idMonitoreo}}" onclick="eliminarAlertas('{{$idMonitoreo}}')">Eliminar alerta(s)</button>
												<?php
												}
												?>
											</form>
										
										</td>
				                        <!--<td>Accion</td>-->
				                        <td>
											<?php
												$arregloPlanes = explode("%",$monitor->DetallePlan);
												foreach ($arregloPlanes as $planFila) {
													
													?>
													{{$planFila}}<br>
													<?php
												}
											?>
										</td>
										<!--<td style="text-align: center;">
												<?php
													$imagenInactivar = 'Imagenes/trash_red.svg';
												?>
												
												<a href="/xadmin/monitors/destroy/{{$monitor->IdActivo}}/{{$monitor->IdActivo}}/{{$monitor->FechaHoraInicio}}/{{$monitor->FechaHoraFin}}" onclick="return confirm('¿Está seguro de eliminar el monitoreo?')"><img src="{{asset($imagenInactivar)}}" title="Inactivar" style="height: 20px;"/></a>
										</td>-->
				                        <td style="text-align: center;">
											<?php
												$imagenSeguimiento = 'Imagenes/map_pin_verdeagua.svg';
												$imagenReportes = 'Imagenes/printer_green.svg';
											?>
											<a href="/xadmin/monitors/informes/{{$monitor->IdMonitoreo}}/{{$monitor->FechaHoraInicio}}/{{$monitor->FechaHoraFin}}/{{$monitor->Alias}}"  target="_blank" onclick="window.open('/xadmin/monitors/informes/{{$monitor->IdMonitoreo}}/{{$monitor->FechaHoraInicio}}/{{$monitor->FechaHoraFin}}/{{$monitor->Alias}}','newwindow','width=900,height=900'); return false;" ><img src="{{asset($imagenReportes)}}" title="Informes" style="height: 20px;"/></a>
										</td>
				                        <td style="text-align: center;" >
											<a href="https://www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P={{$monitor->Alias}}*{{$monitor->VID}}&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913" target="_blank" onclick="window.open('https:\/\/www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P={{$monitor->Alias}}*{{$monitor->VID}}&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913','{{$monitor->Alias}}','width=400,height=400, top=0, left={{$posicionHorizontal}}'); return false;"><img src="{{asset($imagenSeguimiento)}}" title="Seguimiento" style="height: 20px; align: center;"/></a></td>
										<td style="text-align: center;">
										<?php
												$imagenModificar = 'Imagenes/edit_orange.svg';
											?>
											<a href="/xadmin/monitors/edit/{{$monitor->IdMonitoreo}}"  onclick="window.open('/xadmin/monitors/edit/{{$monitor->IdMonitoreo}}','modificar_{{$monitor->IdMonitoreo}}','width=1500,height=900'); return false;"><img src="{{asset($imagenModificar)}}" title="Editar" style="height: 20px;"/></a></td>
										<?php
											$posicionHorizontal = $posicionHorizontal + 10;
											if($monitor->EstadoReal==1)
											{
												$clase = "btn btn-warning btn-sm";
												$textoBoton = "Detener";
												$imagenPlayDetener = 'Imagenes/stop_circle_red.svg';
												
											}else
											{
												if($monitor->DetalleAlertas!="")
												{
													$clase = "btn btn-info btn-sm";
													$textoBoton = "Iniciar";
													$imagenPlayDetener = 'Imagenes/play_blue.svg';
												}else
												{
													$clase = "";
													$textoBoton = "";
													$imagenPlayDetener = '';
												}
											}
										if($textoBoton=="")
										{?>
										<td><a href="" class="{{$clase}}">{{$textoBoton}}</a></td>
										<?php
										}else{
										?>
										<td><a href="" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('{{$idMonitoreo}}');"><img src="{{asset($imagenPlayDetener)}}" title="{{$textoBoton}}" style="height: 20px;"/></a><label hidden>{{$textoBoton}}</lable></td>
										<!--<td><button type="Button" class="{{$clase}}" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('{{$idMonitoreo}}');">{{$textoBoton}}</button></td>-->
										<?php
											}
										?>
										<!--<td><a href="/xadmin/monitors/destroy/{{$monitor->IdMonitoreo}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar el monitoreo?')">Eliminar</a></td	>-->
										
				                    </tr>
				                    @endforeach
				                    <!--<tr>
				                        <td>1002124967</td>
				                        <td>1002124967</td>
				                        <td>PAB-7126</td>
				                        <td>SARA DUDIBERY CORDONEZ FALCON, LEMA CORDONEZ ROBERTO CARLOS, LEMA CORDONEZ ROBERTO CARLOS, TIENDAS INDUSTRIALES ASOCIADAS</td>
				                        <td>13/08/2020 00:30:00</td>
				                        <td>15/08/2020 12:30:00</td>
				                        <td>SI</td>
				                        <td>&nbsp;</td>
				                        <td>Asignar Copiar</td>
				                        <td>Puertas abiertas</td>
				                        <td>Accion</td>
				                        <td>BASE CDN</td>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td	>
				                    </tr>-->
				                </tbody>
                			</table>
							<label >IP: {{$ipAddr}}</label>
	    				</div>
    				</div>
                </div>
            <!--</div>
        </div>
    </div>
</div>-->
@endsection
