@extends('layouts.app')

@section('content')
@include('common.success')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Asignación de monitoreo</div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
	    					<table class="table table-sm table-hover table-striped">
	    						<tbody>
				                    <tr>
				                        <td >Buscar:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" placeholder="Desde">
				                        </td>
				                        <td>
				                        	<div class="form-group">
											    <select class="form-control-sm" id="exampleFormControlSelect1">
											      <option>00</option>
											      <option>01</option>
											      <option>01</option>
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
				                        </td>
				                        <td>
				                        	<div class="form-group">
											    <select class="form-control-sm" id="exampleFormControlSelect1">
											      <option>00</option>
											      <option>10</option>
											      <option>20</option>
											      <option>30</option>
											      <option>40</option>
											      <option>50</option>
											    </select>
											 </div>
				                        </td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" placeholder="Hasta">
				                        </td>
				                        <td>
				                        	<div class="form-group">
											    <select class="form-control-sm" id="exampleFormControlSelect1">
											      <option>00</option>
											      <option>01</option>
											      <option>01</option>
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
				                        </td>
				                        <td>
				                        	<div class="form-group">
											    <select class="form-control-sm" id="exampleFormControlSelect1">
											      <option>00</option>
											      <option>10</option>
											      <option>20</option>
											      <option>30</option>
											      <option>40</option>
											      <option>50</option>
											    </select>
											 </div>
				                        </td>
				                        <td >Estado</td>
				                        <td>
				                        	<div class="form-group">
											    <select class="form-control-sm" id="exampleFormControlSelect1">
											      <option value="A">Activos</option>
											      <option value="I">Inactivos</option>
											      <option value="">Todos</option>
											    </select>
											 </div>
				                        </td>
				                        <td>
				                        	<button type="button" class="btn btn-outline-primary btn-sm ">Buscar</button>
				                        </td>
				                    </tr>
				                </tbody>
				            </table>
				            <table class="table table-sm ">
	    						<tbody>
				                    <tr>
				                        
				                        <td>
				                        	<button type="button" class="btn btn-primary ">Ver alertas</button>
				                        
				                        	<button type="button" class="btn btn-primary ">Ver monitoreos</button>
				                        
				                        	<button type="button" class="btn btn-primary ">Control monitoreos</button>
				                        
				                        	<button type="button" class="btn btn-primary ">Seguimiento alertas</button>
				                        </td>
				                        <td>
				                        	<button type="button" class="btn btn-primary ">Clientes monitoreo</button>
				                       
				                        	<button type="button" class="btn btn-primary ">Definición rutas</button>
				                        </td>	
				                    </tr>
				                </tbody>
                			</table>
                			
                			
	                			<table >
	                				<tr>
	                					<td>
	                						<!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#creaMonitoreoModal">Crear</button>-->
	                						<a href="/monitors/create" class="btn btn-primary btn-sm">Crear</a>

	                					</td>
	                					<!--<td>
	                						<button type="button" class="btn btn-warning btn-sm">Modificar</button>
	                					</td>
	                					<td>
	                						<button type="button" class="btn btn-danger btn-sm">Eliminar</button>
	                					</td>-->
	                				</tr>
	                			</table>


                			
                			<table class="table table-condensed table-hover table-striped">
                				<thead class="thead-dark">
				                    <tr>
				                        <th>VID</th>
				                        <th>CodSysHunter</th>
				                        <th>Alias</th>
				                        <th>Entidad</th>
				                        <th>Desde</th>
				                        <th>Hasta</th>
				                        <th>Activo</th>
				                        <th colspan="1">&nbsp;</th>
				                        <th>Alertas</th>
				                        <th>Alertas asignadas</th>
				                        <th>P. Acción</th>
				                        <th>P. Acción Actual</th>
				                        <th>Informe</th>
				                        <th colspan="1">&nbsp;</th>
				                    </tr>
				                </thead>
				                <tbody>
				                	 @foreach($monitors as $monitor)
				                	 <tr>
				                        <td>1002124967</td>
				                        <td>{{$monitor->CodSysHunter}}</td>
				                        <td>{{$monitor->Alias}}</td>
				                        <td>SARA DUDIBERY CORDONEZ FALCON, LEMA CORDONEZ ROBERTO CARLOS, LEMA CORDONEZ ROBERTO CARLOS, TIENDAS INDUSTRIALES ASOCIADAS</td>
				                        <td>{{$monitor->FechaHoraInicio}}</td>
				                        <td>{{$monitor->FechaHoraFin}}</td>
				                        <td>{{$monitor->Estado}}</td>
				                        <td>&nbsp;</td>
				                        <td>Asignar Copiar</td>
				                        <td>Puertas abiertas</td>
				                        <td>Accion</td>
				                        <td>BASE CDN</td>
				                        <td>&nbsp;</td>
				                        <td>&nbsp;</td	>
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

	    				</div>
    				</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection