@extends('layouts.app')

@section('content')
@include('common.success')



<form class="form-group" method="POST" action="/xadmin/alerts/update/">
	@csrf
<div class="container">

<div class="row">
    <a class="btn btn-primary btn-block" data-toggle="collapse" data-target=".multi-collapse" href="#" role="button" aria-expanded="false" aria-controls="clienteDispositivo alerta monitoreoyplan datosPlanAccion ultimasGestiones ingresoGestion">
        Mostrar/Ocultar todo
    </a>
</div>
<div class="row">
    <a class="btn btn-primary btn-block" data-toggle="collapse" href="#clienteDispositivo" role="button" aria-expanded="false" aria-controls="clienteDispositivo">
    Cliente y dispositivo
    </a>
</div>

<div class="row">
    <div class="collapse multi-collapse" id="clienteDispositivo">
        <div class="container">	
	        <div class="row">
	            <div class="col-sm-6" style="padding: 5px;">
                    <label>Datos dispositivo</label>
                    <p>
                    <label for="vid">VID</label>
                    <input type="text" class="form-control form-control-sm" id="vid" name="vid" value="{{$alerta->VID}}">
                    <label for="vid">CodSysHunter</label>
                    <input type="text" class="form-control form-control-sm" id="csh" name="csh" value="{{$alerta->CodSysHunter}}">
                    <label for="nivelCarga">Nivel de carga</label>
                    <input type="text" class="form-control form-control-sm" id="nivelCarga" name="nivelCarga" value="{{$alerta->NivelBateria}}" >
                    <label for="placaCliente">Placa</label>
                    <input type="text" class="form-control form-control-sm" id="placaCliente" name="placaCliente" value="{{$alerta->Placa}}">
                    <label for="modeloCliente">Modelo</label>
                    <input type="text" class="form-control form-control-sm" id="modeloCliente" name="modeloCliente" value="{{$alerta->Modelo}}">
                    <label for="marcaCliente">Marca</label>
                    <input type="text" class="form-control form-control-sm" id="marcaCliente" name="marcaCliente" value="{{$alerta->Marca}}">
                    <input type="hidden" class="form-control form-control-sm" id="IdActivo" name="IdActivo" value="{{$alerta->IdActivo}}">
                    <input type="hidden" class="form-control form-control-sm" id="IdMonitoreo" name="IdMonitoreo" value="{{$alerta->IdMonitoreo}}">
                    <input type="hidden" class="form-control form-control-sm" id="IdAlerta" name="IdAlerta" value="{{$alerta->IdAlerta}}">
                    <input type="hidden" class="form-control form-control-sm" id="Producto" name="Producto" value="{{$alerta->Producto}}">
                    <input type="hidden" class="form-control form-control-sm" id="TipoDispositivo" name="TipoDispositivo" value="{{$alerta->TipoDispositivo}}">
                    <input type="hidden" class="form-control form-control-sm" id="secuencia" name="secuencia" value="{{$secuencia}}">
                    <input type="hidden" class="form-control form-control-sm" id="chasis" name="chasis" value="{{$alerta->chasis}}">
                    <input type="hidden" class="form-control form-control-sm" id="motor" name="motor" value="{{$alerta->motor}}">
                    <input type="hidden" class="form-control form-control-sm" id="id_estado" name="id_estado" value="{{$alerta->id_estado}}">
                    <input type="hidden" class="form-control form-control-sm" id="descripcion_estado" name="descripcion_estado" value="{{$alerta->descripcion_estado}}">
                    
                </div>
                <div class="col-sm-6" style="padding: 5px;">
                    <label>Datos Cliente</label>
                    <p>
                    <label for="nombreCliente">Nombre</label>
                    <input type="text" class="form-control form-control-sm" id="nombreCliente" name="nombreCliente" value="{{$alerta->NombreCompleto}}">
                    <label for="direccionCliente">Direccion</label>
                    <input type="text" class="form-control form-control-sm" id="direccionCliente" name="direccionCliente" value="{{$alerta->Direccion}}">
                    <label for="correoCliente">Correo</label>
                    <input type="text" class="form-control form-control-sm" id="correoCliente" name="correoCliente" value="{{$alerta->Email}}">
                    
                    <label for="telefonosCliente">Telefonos</label>
                    <?php 
                        if((substr($alerta->Celular,0,4)==="0000") && (substr($alerta->Convencional,0,4)==="0000"))
                            {
                                $telefonosCliente = "NO DISPONIBLE";
                            }elseif(substr($alerta->Celular,0,4)==="0000")
                            {
                                $telefonosCliente = $alerta->Convencional;
                            }elseif(substr($alerta->Convencional,0,4)==="0000")
                            {
                                $telefonosCliente = $alerta->Celular;
                            }else{
                                $telefonosCliente = $alerta->Convencional . " " . $alerta->Celular;
                            }
                     ?>
                    <input type="text" class="form-control form-control-sm" id="telefonosCliente" name="telefonosCliente" value="{{$telefonosCliente}}">
                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <a class="btn btn-primary btn-block" data-toggle="collapse" href="#alerta" role="button" aria-expanded="false" aria-controls="alerta">
    Alerta
    </a>
</div>
<div class="row">
    <div class="collapse multi-collapse" id="alerta">
        <div class="container-lg">	
	        <div class="row">
	            <div class="col-lg6" style="padding: 5px;">
                    <label>Alerta</label>
                    <input type="text" class="form-control form-control-sm" id="alerta" name="alerta" value="{{$alerta->Nombre}}">
                    <label for="tipoAlerta">Tipo Alerta</label>
                    <input type="text" class="form-control form-control-sm" id="tipoAlerta" name="tipoAlerta" value="{{$alerta->NombreAlerta}}">
                    <label for="fechaOcurrencia">Fecha Ocurrencia</label>
                    <input type="text" class="form-control form-control-sm" id="fechaOcurrencia" name="fechaOcurrencia" value="{{$alerta->FechaHoraOcurrencia}}">
                    
                </div>
                <div class="col-lg6" style="padding: 5px;">
                    <label for="fechaRegistro">Fecha Registro</label>
                    <input type="text" class="form-control form-control-sm" id="fechaRegistro" name="fechaRegistro" value="{{$alerta->FechaHoraRegistro}}">
                    <label for="estadoAlarma">Estado Alarma</label>
                    <input type="text" class="form-control form-control-sm" id="estadoAlarma" name="estadoAlarma" value="{{$alerta->Tipo}}">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" value="{{$alerta->DireccionAlerta}}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <a class="btn btn-primary btn-block" data-toggle="collapse" href="#monitoreoyplan" role="button" aria-expanded="false" aria-controls="monitoreoyplan">
    Monitoreo y Plan de acción
    </a>
</div>
<div class="row">
    <div class="collapse multi-collapse" id="monitoreoyplan">
        <div class="container-lg">	
	        <div class="row">
	            <div class="col-lg6" style="padding: 5px;">
                    
                    <label for="fechaInicioMonitoreo">Fecha Inicio Monitoreo</label>
                    <input type="text" class="form-control form-control-sm" id="fechaInicioMonitoreo" name="fechaInicioMonitoreo" value="{{$alerta->FechaHoraInicio}}">
                    <label for="lugarInicio">Lugar Inicio</label>
                    <input type="text" class="form-control form-control-sm" id="lugarInicio" name="lugarInicio" value="{{$infoAdicional->Direccion_Origen}}">
                    <label for="nombreChofer">Nombre Chofer</label>
                    <input type="text" class="form-control form-control-sm" id="nombreChofer" name="nombreChofer" value="{{$infoAdicional->Chofer_Nombre}}">
                    <label for="nombreAcompanante">Nombre Acompañante</label>
                    <input type="text" class="form-control form-control-sm" id="nombreAcompanante" name="nombreAcompanante" value="{{$infoAdicional->Acompanante_Nombre}}">
                
                </div>
                <div class="col-lg6" style="padding: 5px;">
                    <label for="fechaFinMonitoreo">Fecha Fin Monitoreo</label>
                    <input type="text" class="form-control form-control-sm" id="fechaFinMonitoreo" name="fechaFinMonitoreo" value="{{$alerta->FechaHoraFin}}">
                    <label for="lugarFin">Lugar Fin</label>
                    <input type="text" class="form-control form-control-sm" id="lugarFin" name="lugarFin" value="{{$infoAdicional->Direccion_Destino}}">
                    <label for="celularChofer">Celular Chofer</label>
                    <input type="text" class="form-control form-control-sm" id="celularChofer" name="celularChofer" value="{{$infoAdicional->Chofer_Celular}}">
                    <label for="celularAcompanante">Celular Acompañante</label>
                    <input type="text" class="form-control form-control-sm" id="celularAcompanante" name="celularAcompanante" value="{{$infoAdicional->Acompanante_Celular}}">
                
                </div>
                <div class="col-lg6" style="padding: 5px;">
                    <label for="rutaSeguir">Ruta a Seguir</label>
                    <input type="text" class="form-control form-control-sm" id="rutaSeguir" name="rutaSeguir" value="{{$infoAdicional->Ruta_A_Seguir}}">
                    <label for="contactosRecorrido">Contactos Recorrido</label>
                    <?php 
                        $recorrido = explode ( "%" , $infoAdicional->A_Informar_Recorrido );
                        $contactosRecorrido = "";
                        for($i=0; $i<count($recorrido);$i++)
                        {
                            $contactosRecorrido = $contactosRecorrido . $recorrido[$i]."\n";
                        }

                        $paradas = explode ( "%" , $infoAdicional->Paradas_Permitidas );
                        $paradasPermitidas = "";
                        for($i=0; $i<count($paradas);$i++)
                        {
                            $paradasPermitidas = $paradasPermitidas . $paradas[$i]."\n";
                        }
                        
                    
                    
                    ?>
                    <textarea class="form-control form-control-sm" id="contactosRecorrido" name="contactosRecorrido" rows="5" value="{{$contactosRecorrido}}"></textarea>
                    <label for="paradasPermitidas">Paradas Permitidas</label>
                    <textarea class="form-control form-control-sm" id="paradasPermitidas" name="paradasPermitidas" value="{{$paradasPermitidas}}" rows="5"></textarea>
                    
                </div>
            </div>
        </div>
        <label for="datosPlanAccion">Datos Plan Accion</label>
        <table class="table table-condensed table-hover table-striped" id="datosPlanAccion" name="datosPlanAccion">
            <thead >
                <tr>
                    <th>Severidad</th>
                    <th>Detalle</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                        @foreach($consultaPlanDeAccion as $planDeAccion)
                        <tr>
                            <td>{{$planDeAccion->Grado}}</td>
                            <td>{{$planDeAccion->Detalle}}</td>
                            <td>{{$planDeAccion->Observacion}}</td>
                        </tr>
                        @endforeach
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
  <a class="btn btn-primary btn-block" data-toggle="collapse" href="#ultimasGestiones" role="button" aria-expanded="false" aria-controls="ultimasGestiones">
    Ultimas gestiones
    </a>
</div>
<div class="row">
    <div class="collapse multi-collapse" id="ultimasGestiones">
        <label for="datosUltimasGestiones">Datos Últimas Gestiones</label>
        <table class="table table-condensed table-hover table-striped" id="datosUltimasGestiones" name="datosUltimasGestiones">
            <thead >
                <tr>
                    <th>Fecha Ocurrencia</th>
                    <th>Fecha Gestion</th>
                    <th>Alerta</th>
                    <th>Gestión Realizada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultaUltimasGestiones as $ultimasGestiones)
                <tr>
                    <td>{{$ultimasGestiones->FechaOcurrencia}}</td>
                    <td>{{$ultimasGestiones->FechaGestion}}</td>
                    <td>{{$ultimasGestiones->Alerta}}</td>
                    <td>{{$ultimasGestiones->Gestion}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>

<div class="row">
  <a class="btn btn-primary btn-block" data-toggle="collapse" href="#ingresoGestion" role="button" aria-expanded="false" aria-controls="ingresoGestion">
    Ingreso Gestión
    </a>
</div>
<div class="row">
    <div class="collapse multi-collapse" id="ingresoGestion">
        <div class="container-lg">	
	        <div class="row">
	            <div class="col-lg6" style="padding: 5px;">
                    
                    <label for="fechaAccion">Fecha Gestión</label>
                    <input type="text" class="form-control form-control-sm" id="fechaAccion" name="fechaAccion" value="{{$fechaAccion}}">
                    
                    <label for="gestionRealizada">Gestión Realizada</label>
                    <textarea class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada" value="" rows="6"></textarea>
                    <!--<input type="text" class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada">-->
                    
                
                </div>
                <div class="col-lg6" style="padding: 5px;">
                    <label for="comboCambiarEstado">Cambiar Estado</label>
                    <select class="form-control form-control-sm" id="comboCambiarEstado">
                    <?php
                        switch ($alerta->Tipo) {
                            case 'AMARILLO': ?>
                                <option value="NO ALARMADO" >NO ALARMADO</option>
                                <option value="AMARILLO" selected>AMARILLO</option>
                                <option value="NARANJA">NARANJA</option>
                                <option value="3">ROJO</option>
                            <?php    break;
                            case 'NARANJA': ?>
                                <option value="NO ALARMADO" >NO ALARMADO</option>
                                <option value="AMARILLO">AMARILLO</option>
                                <option value="NARANJA" selected>NARANJA</option>
                                <option value="3">ROJO</option>
                            <?php    break;
                            case 'ROJO': ?>
                                <option value="NO ALARMADO">NO ALARMADO</option>
                                <option value="AMARILLO">AMARILLO</option>
                                <option value="NARANJA">NARANJA</option>
                                <option value="3" selected>ROJO</option>
                            <?php    break;
                            default: ?>
                                <option value="NO ALARMADO" selected>NO ALARMADO</option>
                                <option value="AMARILLO">AMARILLO</option>
                                <option value="NARANJA">NARANJA</option>
                                <option value="3">ROJO</option>
                            <?php    
                                break;
                        }
                    ?>
                       
                        
                    </select>
                    <label for="comboMotivoAlerta">Motivo Alerta</label>
                    <select class="form-control form-control-sm" id="comboMotivoAlerta" name="comboMotivoAlerta">
                        @foreach($comboMotivoAlerta as $motivoAlerta)
                            <option value='{{ $motivoAlerta->Codigo }}'>{{ $motivoAlerta->Descripcion}}</option>
                        @endforeach
                    </select>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkAlertaRepetida" name="chkAlertaRepetida">
                        <label class="form-check-label" for="chkAlertaRepetida">
                            Alerta Repetida
                        </label>
                        
                        
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkDatosIncorrectos" name="chkDatosIncorrectos">
                        <label class="form-check-label" for="chkDatosIncorrectos">
                            Datos Incorrectos
                        </label>
                        
                        
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="ckhEnviarCaso" name="ckhEnviarCaso">
                        <label class="form-check-label" for="ckhEnviarCaso">
                            Enviar Caso
                        </label>
                        
                        
                    </div>

                    <div class="form-check" id="AreaEsRobo" style="display: none;" >
                        <input class="form-check-input" type="checkbox" value="" id="ckhEsRobo" name="ckhEsRobo">
                        <label class="form-check-label" for="ckhEsRobo">
                            Es Robo
                        </label>
                        
                        
                    </div>

                    <input type="hidden" class="form-control form-control-sm" id="latitud" name="latitud" value="{{$alerta->Latitud}}">
                    <input type="hidden" class="form-control form-control-sm" id="longitud" name="longitud" value="{{$alerta->Longitud}}">
                
                </div>
                <?php
                    if ($mostrarChecksGestion)
                    {
                        $styleCheksGestion="padding: 5px;";
                    }
                    else{
                        $styleCheksGestion="padding: 5px;display: none;";
                    }
                ?>
                <div class="col-lg6" style={{$styleCheksGestion}}>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkDetenido" name="chkDetenido">
                        <label class="form-check-label" for="chkDetenido">
                            Detenido
                        </label>
                        
                        
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="chkLlamada" name="chkLlamada">
                        <label class="form-check-label" for="chkLlamada">
                            Llamada
                        </label>
                        
                        
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="ckhNovedad" name="ckhNovedad">
                        <label class="form-check-label" for="ckhNovedad">
                            Novedad
                        </label>
                        
                        
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
		        <a href="/xadmin/monitors" class="btn btn-secondary btn-sm">Cancelar</a>
		        <button type="button" class="btn btn-secondary btn-sm">Ver Mapa</button>
	        </div>
        </div>
    </div>
</div>


</div>
</form>
@endsection