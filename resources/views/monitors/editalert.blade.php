@extends('layouts.app')

@section('content')
@include('common.errors')
<!-- Modal -->
											
											      
											      
<form class="form-group" method="POST" action="/xadmin/monitors/updatealert">
	@csrf
	<div class="modal-body">
	<div class="container-lg">	
	<div class="row">
	<div class="col-lg6">										       	
		<div class="form-group">
			<label for="buscarPor">Buscar por</label>
			<select class="form-control form-control-sm" id="buscarPor" disabled>
				<option value="0">Placa</option>
				<option value="1">CodSysHunter</option>
				<option value="2">VID</option>
				<option value="3">Chasis</option>
				<option value="4">Motor</option>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control form-control-sm" id="alias" name="alias" placeholder="Unidad a buscar" value="{{$datos[0]->Alias}}" disabled >
			<div id=aliasList></div>
		</div>
		<div class="form-group">
			<input type="hidden" class="form-control form-control-sm" id="idActivo" name="idActivo" placeholder="Unidad a buscar" value="{{$datos[0]->IdActivo}}" >
			
		</div>
		<div class="form-group">
			<input type="hidden" class="form-control form-control-sm" id="IdAlerta" name="IdAlerta"  value="{{$alerta[0]->IdAlerta}}" >
			
		</div>
		<div class="form-group">
			<input type="hidden" class="form-control form-control-sm" id="accion" name="accion"  value="{{$accion}}" >
			
		</div>
		<div class="form-group">
			<input type="hidden" class="form-control form-control-sm" id="evento" name="evento"  value="{{$alerta[0]->Evento}}" >
			
		</div>
		<div class="form-group">
					<label for="producto">Monitoreo nuevo o Monitoreos anteriores</label>
					<select class="form-control form-control-sm" id="monitoreos" name="monitoreos" disabled>
					
						<option value="0">Nuevo monitoreo</option>
					</select>
				</div>
		<div class="form-group">
			<?php
				$datosFechaHoraInicio = date('d-m-Y H:i',strtotime($datos[0]->FechaHoraInicio));
			?>
			<input type='text' id='FechaHoraInicio' class="form-control form-control-sm" name="FechaHoraInicio" placeholder="Fecha Hora Inicio" autocomplete="off" value="{{$datosFechaHoraInicio}}" disabled/>
		</div>
		<div class="form-group">
			<?php
				$datosFechaHoraFin = date('d-m-Y H:i',strtotime($datos[0]->FechaHoraFin));
			?>
			<input type='text' id="FechaHoraFin" class="form-control form-control-sm" name="FechaHoraFin" placeholder="Fecha Hora Fin" autocomplete="off" value="{{$datosFechaHoraFin}}" disabled />
		</div>
		<div class="form-group">
			<label for="Estado">Activo</label>
			<select class="form-control form-control-sm" id="Estado" name="Estado">
                <?php
                    $selectedA="";
                    $selectedI="";
                    if($datos[0]->Estado=="A")
                        $selectedA = "selected";
                    else
                        $selectedI = "selected";
                ?>
				<option value="A" {{$selectedA}}>SI</option>
				<option value="I" {{$selectedI}}>NO</option>
			</select>
		</div>
		<!--<div class="form-group">
			<input type='text' id="TipoMonitoreo" class="form-control" name="TipoMonitoreo" placeholder="Tipo de Alerta" />
		</div>-->
		<div class="form-group">
			<input type="hidden" class="form-control form-control-sm" id="IdMonitoreo" name="IdMonitoreo" placeholder="Unidad a buscar" value="{{$IdMonitoreo}}" >
			
		</div>
		<div class="form-group">
			<label for="producto">Producto</label>
			<select class="form-control form-control-sm" id="producto" name="producto">
						
				
				@foreach($products as $product)
         			<option value='{{ $product->Codigo }}' selected>{{ $product->Descripcion }}</option>
       			@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="TipoMonitoreo">Tipo de Alerta</label>
			<select class="form-control form-control-sm" id="TipoMonitoreo" name="TipoMonitoreo">
				
				@foreach($typesAlerts as $typeAlert)
					<?php
						if($alerta[0]->TipoAlerta==$typeAlert->Codigo)
							$tipoAlertaSeleccionado = "selected";
						else
							$tipoAlertaSeleccionado = "";
			
					?>
         			<option value='{{ $typeAlert->Codigo }}' {{$tipoAlertaSeleccionado}}>{{ $typeAlert->Descripcion }}</option>
       			@endforeach
				<!--<option value="1">Evento</option>
				<option value="3">Geocerca In</option>
				<option value="4">Geocerca Out</option>
				<option value="2">Kilometraje</option>
				<option value="6">Multicriterio</option>-->
			</select>
		</div>
		
		

	</div>	
	<div class="col-lg6" style="margin-left: 20px;">
		<div class="container-lg">
			
				
			
			
			
			<?php
				if($alerta[0]->TipoAlerta==1 || $alerta[0]->TipoAlerta==6)
					$styleAreaAlertas = "";
				else
					$styleAreaAlertas = "display: none;";
			?>
			<label for="AreaAlertas" id="labelAlertas" style="{{$styleAreaAlertas}}" >Eventos</label>
			<div class="row" id="AreaAlertas" style="{{$styleAreaAlertas}}">
				
			    <div class="col-lg2">
			      	<div class="subject-info-box-1">
					  <div class="form-group">
					  	<input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="eventoAbuscar" placeholder="Buscar">
					  	<select style="width: 250px;padding: 5px;"  id="ListaAlertas" name="ListaAlertas" class="form-control form-control-sm"   >
						  @foreach($eventos as $evento)
						  	@if($evento)
								<?php
									if($evento->Codigo==$alerta[0]->Evento)
										$selected = 'selected';
									else
										$selected = '';
									if($evento->Codigo!="-1")
									{
								?>
										<option style='font-size:0.7em;' value='{{$evento->Codigo}};{{$evento->Descripcion}}' {{$selected}}>{{$evento->Codigo}};{{$evento->Descripcion}}</option>
									<?php
									}
									?>
						  	@endif
						  @endforeach
						    <!--<option value=0>Opcion1</option>
							<option value=1>Quito</option>
							<option value=2>Guayaquil</option>
							<option value=3>Manta</option>
							<option value=3>Mancora</option>-->
						</select>
					  </div>
					</div>
			    </div>
			    <div class="col-lg2" style="display: none;">
			      	<div class="subject-info-arrows text-center" style="padding: 5px;">
						<input type='button' id='btnAllRight' value='>>' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnRight' value='>' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnLeft' value='<' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnAllLeft' value='<<' class="btn btn-secondary btn-sm" />
					</div>
			    </div>
			    <div class="col-lg2" style="display: none;">
					
					<div class="subject-info-box-2">
						<div class="form-group">
							<select style="width: 250px;padding: 5px;" multiple="multiple" id="ListaAlertasSeleccionadas" name="ListaAlertasSeleccionadas[]" class="form-control form-control-sm" size="5" data-select="true">
										
							</select>
						</div>
					</div>		
					
			    </div>
			</div>
			
			<?php
				if($alerta[0]->TipoAlerta==3 || $alerta[0]->TipoAlerta==4 || $alerta[0]->TipoAlerta==6)
					$styleAreaGeocerca = "";
				else
					$styleAreaGeocerca = "display: none;";
			?>
			<label for="AreaGeocercas" id="labelGeocercas" style="{{$styleAreaGeocerca}}" >Geocercas</label>
			<div class="row" id="AreaGeocercas" style="{{$styleAreaGeocerca}}">
				<div class="col-lg2">
					<div class="subject-info-box-1">
						<div class="form-group">
							<input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="geocercaAbuscar" placeholder="Buscar">
							<select style="width: 300px;" multiple="multiple" id="ListaGeocercas" name="ListaGeocercas" class="form-control form-control-sm" size="5" searchable="Buscar..." >
								@foreach($geoCercas as $geoCerca)
									@if($geoCerca)
										<?php
											if($alerta[0]->IdGeocerca==$geoCerca->Codigo)
												$selectedGeocerca="selected";
											else
												$selectedGeocerca="";
										?>
										<option style='font-size:0.7em;' value='{{ $geoCerca->Codigo }};{{ $geoCerca->Descripcion }}' {{$selectedGeocerca}}>{{ $geoCerca->Codigo }};{{ $geoCerca->Descripcion }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					
				</div>
				<div class="col-lg2" style="display: none;">
					<div class="subject-info-arrows text-center" style="padding: 5px;">
						<input type='button' id='btnAllRightGC' value='>>' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnRightGC' value='>' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnLeftGC' value='<' class="btn btn-secondary btn-sm" /><br />
						<input type='button' id='btnAllLeftGC' value='<<' class="btn btn-secondary btn-sm" />
					</div>
				</div>
				<div class="col-lg2" style="display: none;">
					<div class="subject-info-box-2">
						<div class="form-group">
								<select style="width: 250px;padding: 5px;" multiple="multiple" id="ListaGeocercasSeleccionadas" name="ListaGeocercasSeleccionadas[]" class="form-control form-control-sm" size="5" data-select="true">
											
								</select>
						</div>
					</div>
				</div>
			</div>

			<?php
				if($alerta[0]->TipoAlerta==2 || $alerta[0]->TipoAlerta==6)
					$styleAreaEspecificaciones = "";
				else
					$styleAreaEspecificaciones = "display: none;";
			?>
			<div  id="AreaEspecificaciones" style="{{$styleAreaEspecificaciones}}" >
				<div class="row" style="padding: 5px;">
					<div class="col">
						<label>A los</label>
					</div>
					<div class="col">
						<input type='text' value="0" id="Kilometros" class="form-control form-control-sm" name="kilometros" autocomplete="off" value="{{$alerta[0]->Kilometraje}}" />
					</div>
					<div class="col">
						<label>Kms.</label>
					</div>
				</div>
				<div class="row" style="padding: 5px;">
					<div class="col">
						<label>Alertar antes de</label>
					</div>
					<div class="col">
						<input type='text' value="0" id="PorcentajeAnticipacion" class="form-control form-control-sm" name="PorcentajeAnticipacion"  autocomplete="off" value="{{$alerta[0]->PorcentajeAnticipacion}}" />
					</div>
					<div class="col">
						<label>%</label>
					</div>
				</div>

				<div class="row" style="padding: 5px;">
					<div class="col">
						<label>Desde / Hasta</label>
					</div>
					<div class="col" style="align-items: right;">
						<select class="form-control form-control-sm" id="HoraDesde" name="HoraDesde">
							<option selected>00</option>
							<option>01</option>
							<option>02</option>
							<option>03</option>
							<option>04</option>
							<option>05</option>
							<option>06</option>
							<option>07</option>
							<option>08</option>
							<option>09</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
							<option>13</option>
							<option>14</option>
							<option>15</option>
							<option>16</option>
							<option>17</option>
							<option>18</option>
							<option>19</option>
							<option>20</option>
							<option>21</option>
							<option>22</option>
							<option>23</option>
						</select>
					</div> 
					<div class="col" style="align-items: left;">
						<select class="form-control form-control-sm" id="MinutoDesde" name="MinutoDesde">
							<option selected>00</option>
							<option>05</option>
							<option>10</option>
							<option>15</option>
							<option>20</option>
							<option>25</option>
							<option>30</option>
							<option>35</option>
							<option>40</option>
							<option>45</option>
							<option>50</option>
						</select>
					</div>
					<div class="col" style="align-items: center;">
						<label> / </label>
					</div>
					<div class="col" style="align-items: right;">
						<select class="form-control form-control-sm" id="HoraHasta" name="HoraHasta">
							<option>00</option>
							<option>01</option>
							<option>02</option>
							<option>03</option>
							<option>04</option>
							<option>05</option>
							<option>06</option>
							<option>07</option>
							<option>08</option>
							<option>09</option>
							<option>10</option>
							<option>11</option>
							<option>12</option>
							<option>13</option>
							<option>14</option>
							<option>15</option>
							<option>16</option>
							<option>17</option>
							<option>18</option>
							<option>19</option>
							<option>20</option>
							<option>21</option>
							<option>22</option>
							<option selected>23</option>
						</select>
					</div>
					<div class="col" style="align-items: left;">
						<select class="form-control form-control-sm" id="MinutoHasta" name="MinutoHasta">
							<option>00</option>
							<option>05</option>
							<option>10</option>
							<option>15</option>
							<option>20</option>
							<option>25</option>
							<option>30</option>
							<option>35</option>
							<option>40</option>
							<option>45</option>
							<option selected>50</option>
						</select>
					</div>
					<div class="col">
						<label>HH:mm</label>
					</div>
				</div>

				<div class="row" style="padding: 5px;">
					<div class="col">
						<label>Limite de velocidad</label>
					</div>
					<div class="col">
						<input type='text' value="0" id="LimiteVelocidad" class="form-control form-control-sm" name="LimiteVelocidad"  autocomplete="off" value="{{$alerta[0]->LimiteVelocidad}}" />
					</div>
					<div class="col">
						<label>Km/H</label>
					</div>
				</div>
				<div class="row" style="padding: 5px;">
					<div class="col">
						<label>Despacho (Ruta)</label>
					</div>
					<div class="col">
						<input type='text' id="Despacho" class="form-control form-control-sm" name="Despacho"  autocomplete="off" disabled />
					</div>
					<div class="col">
						<label>&nbsp</label>
					</div>
				</div>
			</div>


			<div class="row" style="padding: 5px;">
				
					<div class="text-center" >
						<button type="button" class="btn btn-primary  btn-sm" id="agregarEvento" name="agregarEvento" style="padding: 1px;">Agregar alerta</button>
						<button type="button" class="btn btn-danger  btn-sm" id="eliminarEvento" name="eliminarEvento" style="padding: 1px;">Eliminar alerta</button>
					</div>
				
			</div>
			<div class="row">
				<div class="col-lg3">
					<div class="form-group">
						<div class="col">
									<select style="width: 450px;" multiple="multiple" id="ListaEventos" name="ListaEventos[]" class="form-control form-control-sm" size="4" data-select="true" >
												
									</select>
						</div>
					</div>
				</div>
			</div>



			
			
			
		</div>
		<div class="clearfix"></div>
	
	
		
	</div>
	</div>
	</div>
	</div>
	<div class="modal-footer">
		<a href="" onclick="window.close();" class="btn btn-secondary">Cancelar</a>
		<button type="submit" class="btn btn-primary">Guardar</button>
	</div>
</form>

   


											    	
@endsection