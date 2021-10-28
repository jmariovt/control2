<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'XAdmin') }}</title>

    <!-- CSS only -->
    
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">-->
     <!-- TEMA DE BOOTSTRAP --> 
      <!--  <link rel="stylesheet" href="https://bootswatch.com/4/slate/bootstrap.css">-->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('js/jquery.datetimepicker.min.css') }}">

        <!-- JS, Popper.js, and jQuery -->
    
    <script src="{{asset('js/jquery-3.5.1.js')}}" type="text/javascript"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>-->
    <script src="{{asset('jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
    <script src="{{asset('js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <!-- Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">
       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">
    
    <!-- Este estilo es para la tabla principal de los montoreos -->
    <style type="text/css">
        .table-condensed{
            font-size: 14px;
            }
    </style>



    


</head>
<body>
    <div id="app" >
        

        <!--<main class="py-4">
            
        </main>-->
        <div class="container" >
        @if ($alertaSiendoAtendida=="1")
            <div class="alert alert-danger">
                <ul>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    
                        <li>Alerta ya está siendo atendida.</li>
                    
                </ul>
            </div>
        @endif

<form class="form-group" method="POST" action="/xadmin/alerts/store" id="storeAlerta">
	@csrf
    <div class="container-fluid">
        <div class="row justify-content-center">
            
                    <h1>{{$alerta->Placa}}</h1>
               
        </div>

        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" data-target=".multi-collapse" href="#" role="button" aria-expanded="true" aria-controls="clienteDispositivo alerta monitoreoyplan datosPlanAccion ultimasGestiones ingresoGestion">
                Mostrar/Ocultar todo
            </a>
        </div>
        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#clienteDispositivo" role="button" aria-expanded="true" aria-controls="clienteDispositivo">
            Cliente y dispositivo
            </a>
        </div>

        
            <div class="collapse multi-collapse" id="clienteDispositivo">
                <div class="container-fluid">	
                    <div class="row">
                        <div class="col-lg6" style="padding: 5px;">
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
                            <input type="hidden" class="form-control form-control-sm" id="mod" name="mod" value="{{$mod ?? ''}}">
                            
                        </div>
                        <div class="col" style="padding: 5px;">
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
       

        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#alertaArea" role="button" aria-expanded="true" aria-controls="alertaArea">
                Alerta
            </a>
        </div>
       
            <div class="collapse show multi-collapse" id="alertaArea">
                <div class="container-fluid">	
                    <div class="row">
                        <div class="col" style="padding: 5px;">
                            <label>Alerta</label>
                            <input type="text" class="form-control form-control-sm" id="alerta" name="alerta" value="{{$alerta->Nombre}}">
                            <label for="tipoAlerta">Tipo Alerta</label>
                            <input type="text" class="form-control form-control-sm" id="tipoAlerta" name="tipoAlerta" value="{{strtoupper($alerta->NombreAlerta)}}">
                            <label for="fechaOcurrencia">Fecha Ocurrencia</label>
                            <?php
                                //$fechaHoraOcurrencia = date('d/m/Y H:i:s',strtotime($alerta->FechaHoraOcurrencia));
                                $fechaO    = new DateTime($alerta->FechaHoraOcurrencia);
                                $fechaHoraOcurrencia = $fechaO->format('d/m/Y H:i:s');
                                
                            ?>
                            <input type="text" class="form-control form-control-sm" id="fechaOcurrencia" name="fechaOcurrencia" value="{{$fechaHoraOcurrencia}}">
                            <label for="nombreChofer">Nombre Chofer</label>
                            <input type="text" class="form-control form-control-sm" id="nombreChofer" name="nombreChofer" value="{{$infoAdicional->Chofer_Nombre}}">
                            
                        </div>
                        <div class="col" style="padding: 5px;">
                            <label for="fechaRegistro">Fecha Registro</label>
                            <?php
                                $fechaRegistro = date('d/m/Y H:i:s',strtotime($alerta->FechaHoraRegistro));
                            ?>
                            <input type="text" class="form-control form-control-sm" id="fechaRegistro" name="fechaRegistro" value="{{$fechaRegistro}}">
                            <label for="estadoAlarma">Estado Alarma</label>
                            <?php
                                if($mod=="0")
                                {
                                    $valorEstadoAlarma = $alerta->Tipo;
                                }else{
                                    $valorEstadoAlarma = $DatoMod->EstadoAlarma;
                                }
                            ?>
                            <input type="text" class="form-control form-control-sm" id="estadoAlarma" name="estadoAlarma" value="{{$alerta->Tipo}}">
                            <label for="direccion">Direccion</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" value="{{$alerta->DireccionAlerta}}">
                            <label for="celularChofer">Celular Chofer</label>
                            <input type="text" class="form-control form-control-sm" id="celularChofer" name="celularChofer" value="{{$infoAdicional->Chofer_Celular}}">
                        </div>
                        
                        
                    </div>
                    <div class="row">
                            <a class="btn btn-outline-primary btn-block" data-toggle="collapse" href="#alertasxAtender" role="button" aria-expanded="true" aria-controls="alertasxAtender">
                            Alertas por atender
                            </a>
                        </div>
                        <div class="collapse multi-collapse" id="alertasxAtender">
                            <div class="container-fluid">	
                                <table class="table table-condensed table-hover table-striped" id="tablaAlertasXAtender" name="tablaAlertasXAtender" width="100%" >
                                    <thead >
                                        <tr>
                                            <th width="25%">Fecha Ocurrencia</th>
                                            <th width="25%">Alerta</th>
                                            <th width="25%">Dirección</th>
                                            <th width="25%">Atender</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyMonitoreos" name="tbodyMonitoreos">
                                        @foreach($SecuenciasXAtender as $SecuenciaXAtender)
                                            <tr>
                                                <td>
                                                    {{$SecuenciaXAtender->FechaOcurrencia}}
                                                </td>
                                                <td>
                                                    {{$SecuenciaXAtender->Alerta}}
                                                </td>
                                                <td>
                                                    {{$SecuenciaXAtender->Direccion}}
                                                </td>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="{{$SecuenciaXAtender->Secuencia}}" id="CheckSecuencia_{{$SecuenciaXAtender->Secuencia}}" name="CheckSecuencia_{{$SecuenciaXAtender->Secuencia}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                </div>
            </div>
       

        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#monitoreoyplan" role="button" aria-expanded="false" aria-controls="monitoreoyplan">
                Monitoreo y Plan de acción
            </a>
        </div>
        
            <div class="collapse multi-collapse" id="monitoreoyplan">
                <div class="container-fluid">	
                    <div class="row">
                        <div class="col" style="padding: 5px;">
                            
                            <label for="fechaInicioMonitoreo">Fecha Inicio Monitoreo</label>
                            <?php
                                $fechaInicioMonitoreo = date('Y-m-d H:i:s',strtotime($alerta->FechaHoraInicio));
                            ?>
                            <input type="text" class="form-control form-control-sm" id="fechaInicioMonitoreo" name="fechaInicioMonitoreo" value="{{$fechaInicioMonitoreo}}">
                            <label for="lugarInicio">Lugar Inicio</label>
                            <input type="text" class="form-control form-control-sm" id="lugarInicio" name="lugarInicio" value="{{$infoAdicional->Direccion_Origen}}">
                            <label for="nombreChofer">Nombre Chofer</label>
                            <input type="text" class="form-control form-control-sm" id="nombreChofer" name="nombreChofer" value="{{$infoAdicional->Chofer_Nombre}}">
                            <label for="nombreAcompanante">Nombre Acompañante</label>
                            <input type="text" class="form-control form-control-sm" id="nombreAcompanante" name="nombreAcompanante" value="{{$infoAdicional->Acompanante_Nombre}}">
                        
                        </div>
                        <div class="col" style="padding: 5px;">
                            <label for="fechaFinMonitoreo">Fecha Fin Monitoreo</label>
                            <?php
                                $fechaFinMonitoreo = date('Y-m-d H:i:s',strtotime($alerta->FechaHoraFin));
                            ?>
                            <input type="text" class="form-control form-control-sm" id="fechaFinMonitoreo" name="fechaFinMonitoreo" value="{{$fechaFinMonitoreo}}">
                            <label for="lugarFin">Lugar Fin</label>
                            <input type="text" class="form-control form-control-sm" id="lugarFin" name="lugarFin" value="{{$infoAdicional->Direccion_Destino}}">
                            <label for="celularChofer">Celular Chofer</label>
                            <input type="text" class="form-control form-control-sm" id="celularChofer" name="celularChofer" value="{{$infoAdicional->Chofer_Celular}}">
                            <label for="celularAcompanante">Celular Acompañante</label>
                            <input type="text" class="form-control form-control-sm" id="celularAcompanante" name="celularAcompanante" value="{{$infoAdicional->Acompanante_Celular}}">
                        
                        </div>
                        <div class="col" style="padding: 5px;">
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

                                $paradas = explode ( "%" , $infoAdicional->Paradas_Permitidas);
                                $paradasPermitidas = "";
                                for($i=0; $i<sizeof($paradas);$i++)
                                {
                                    $paradasPermitidas = $paradasPermitidas . $paradas[$i]."\n";
                                }
                                
                            
                            
                            ?>
                            <textarea class="form-control form-control-sm" id="contactosRecorrido" name="contactosRecorrido" rows="5" value="{{$contactosRecorrido}}">{{$contactosRecorrido}}</textarea>
                            <label for="paradasPermitidas">Paradas Permititdas</label>
                            <textarea class="form-control form-control-sm" id="paradasPermitidas" name="paradasPermitidas" value="{{$paradasPermitidas}}" rows="5">{{$paradasPermitidas}}</textarea>
                            
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
       

        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#ultimasGestiones" role="button" aria-expanded="false" aria-controls="ultimasGestiones">
                Ultimas gestiones
            </a>
        </div>
        
            <div class="collapse multi-collapse" id="ultimasGestiones">
                <label for="datosUltimasGestiones">Datos Últimas Gestiones</label>
                <table class="table table-condensed table-hover table-striped" id="datosUltimasGestiones" name="datosUltimasGestiones">
                    <thead >
                        <tr>
                            <th>Fecha Ocurrencia</th>
                            <th>Fecha Gestion</th>
                            <th>Dirección</th>
                            <th>Alerta</th>
                            <th>Gestión Realizada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultaUltimasGestiones as $ultimasGestiones)
                        <tr>
                            <td>{{$ultimasGestiones->FechaOcurrencia}}</td>
                            <?php
                                $ultimasGestionesFechaGestion = date('d-m-Y H:i:s',strtotime($ultimasGestiones->FechaGestion));
                            ?>
                            <td>{{$ultimasGestionesFechaGestion}}</td>
                            <td>{{$ultimasGestiones->Calle}}</td>
                            <td>{{$ultimasGestiones->Alerta}}</td>
                            <td>{{$ultimasGestiones->Gestion}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        

        <div class="row">
            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#ingresoGestion" role="button" aria-expanded="true" aria-controls="ingresoGestion">
                Ingreso Gestión
            </a>
        </div>
        <div class="row">
            <div class="collapse show multi-collapse" id="ingresoGestion">
                <div class="container-lg">	
                    <div class="row">
                        <div class="col-lg6" style="padding: 5px;">
                            
                            <label for="fechaAccion">Fecha Gestión</label>
                            <?php
                                list($day,$time) = explode(" ",$fechaAccion);
                                list($d,$m,$y) = explode("/",$day);
                                list($h,$mm,$s) = explode(":",$time);
                                $timestamp = mktime($h,$mm,$s,$m,$d,$y);
                                $fechaAccion = date("Y-m-d H:i:s",$timestamp);
                                //$fechaAccion = date('Y-m-d H:i:s',strtotime($fechaAccion));
                            ?>
                            <input type="text" class="form-control form-control-sm" id="fechaAccion" name="fechaAccion" value="{{$fechaAccion}}">
                            
                            <label for="gestionRealizada">Gestión Realizada</label>
                            <?php
                                $valorGestion = "";
                                if($mod=="1")
                                {
                                    foreach ($DatoMod as $datom) {
                                        $arregloValorGestion = explode("\\",$datom->Gestion);
                                        $valorGestion = $arregloValorGestion[0];
                                    }
                                    
                                }
                            ?>
                            <textarea class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada" value="" rows="6">{{$valorGestion}}</textarea>
                            <!--<input type="text" class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada">-->
                            
                        
                        </div>
                        <div class="col-lg6" style="padding: 5px;">
                            <?php
                                if($mod==0)
                                    $estiloComboCambiaEstado = "";
                                else
                                    $estiloComboCambiaEstado = "display: none;";
                            ?>
                            <div style="{{$estiloComboCambiaEstado}}">
                                <label for="comboCambiarEstado">Cambiar Estado</label>
                                <select class="form-control form-control-sm" id="comboCambiarEstado" name="comboCambiarEstado">
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
                            </div>
                            <label for="comboMotivoAlerta">Motivo Alerta</label>
                            <select class="form-control form-control-sm" id="comboMotivoAlerta" name="comboMotivoAlerta">
                                @foreach($comboMotivoAlerta as $motivoAlerta)
                                    <option value='{{ $motivoAlerta->Codigo }}'>{{ $motivoAlerta->Descripcion}}</option>
                                @endforeach
                            </select>
                            <?php
                                if($mod==0)
                                    $estilochkAlarmaRepetida = "";
                                else
                                    $estilochkAlarmaRepetida="display: none;";
                            ?>
                            <div class="form-check" style="{{$estilochkAlarmaRepetida}}">
                                <input class="form-check-input" type="checkbox" value="" id="chkAlertaRepetida" name="chkAlertaRepetida">
                                <label class="form-check-label" for="chkAlertaRepetida">
                                    Alerta Repetida
                                </label>
                                
                                
                            </div>
                            
                            <?php
                                if($mod==0)
                                    $estilochkDatosIncorrectos = "";
                                else
                                    $estilochkDatosIncorrectos="display: none;";
                            ?>
                            <div class="form-check" style="{{$estilochkDatosIncorrectos}}">
                                <input class="form-check-input" type="checkbox" value="" id="chkDatosIncorrectos" name="chkDatosIncorrectos">
                                <label class="form-check-label" for="chkDatosIncorrectos">
                                    Datos Incorrectos
                                </label>
                                
                                
                            </div>
                            <?php
                                if($mod==0)
                                    $estilochkEnviarCaso = "";
                                else
                                    $estilochkEnviarCaso="display: none;";
                            ?>
                            <div class="form-check" style="{{$estilochkEnviarCaso}}">
                                <input class="form-check-input" type="checkbox" value="" id="chkEnviarCaso" name="chkEnviarCaso">
                                <label class="form-check-label" for="chkEnviarCaso">
                                    Enviar Caso
                                </label>
                                
                                
                            </div>
                            <?php
                                if($mod==0)
                                    $estilochkRobo = "display: none;";
                                else
                                    $estilochkRobo="";
                            ?>
                            <div class="form-check" id="AreaEsRobo" style="{{$estilochkRobo}}" >
                                <input class="form-check-input" type="checkbox" value="" id="ckhEsRobo" name="ckhEsRobo">
                                <label class="form-check-label" for="ckhEsRobo">
                                    Es Robo
                                </label>
                                
                                
                            </div>

                            <input type="hidden" class="form-control form-control-sm" id="latitud" name="latitud" value="{{$alerta->Latitud}}">
                            <input type="hidden" class="form-control form-control-sm" id="longitud" name="longitud" value="{{$alerta->Longitud}}">
                        
                        </div>
                        <?php
                            if($mod==0)
                            {   if ($mostrarChecksGestion)
                                {
                                    $styleCheksGestion="padding: 5px;";
                                }
                                else{
                                    $styleCheksGestion="padding: 5px;display: none;";
                                }
                            }else{
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
                        <?php
                            $apikey = 'AIzaSyCWCTbxQub4945rIbP2HUawjN2adUwCelc';
                        ?>
                        @if ($alertaSiendoAtendida=="0")
                            <button type="submit" class="btn btn-primary btn-sm" id="btnGuardarAlerta">Guardar</button>
                        @endif
                        <!--<a href="/xadmin/alerts/cancelar" class="btn btn-secondary btn-sm">Cancelar</a>-->
                        <!-- window.open('mapaalertas.html?lat=' + lat + '&lon=' + lon, '_blank', 'top=20,left=350,width=518,height=418,status=0,resizable=no,location=0,toolbar=0,directories=0'); -->
                        <!--<a href="http://maps.googleapis.com/maps/api/staticmap?size=600x600&key={{$apikey}}&center={{$alerta->Latitud}},{{$alerta->Longitud}}&zoom=17&maptype=hybrid&markers=color:yellow|label:S|{{$alerta->Latitud}},{{$alerta->Longitud}}&sensor=false" target="_blank" class="btn btn-secondary btn-sm">Ver Mapa</a>-->
                        <a href="" onclick="window.open('/xadmin/maps/show/{{$alerta->Latitud}}/{{$alerta->Longitud}}','{{$alerta->Placa}}','width=900,height=900'); return false;" class="btn btn-primary btn-sm" >Ver Mapa</a>
                        <a href="https://www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P={{$alerta->Placa}}*{{$alerta->VID}}&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913" class="btn btn-success btn-sm" target="_blank" onclick="window.open('https:\/\/www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P={{$alerta->Placa}}*{{$alerta->VID}}&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913','{{$alerta->Placa}}','width=900,height=900, top=0, left=0'); return false;">Seguimiento</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>
</div>
</div>
</body>

<script type="text/javascript">
$(document).ready(function(){
    function vermapa() {
               var apikey = 'AIzaSyCWCTbxQub4945rIbP2HUawjN2adUwCelc';
               //window.open('http://maps.googleapis.com/maps/api/staticmap?center=' + lat + ',' + lon + '&zoom=17&size=600x600&maptype=hybrid&markers=color:yellow|label:S|' + lat + ',' + lon + '&sensor=false&key=' + apikey + '', '_blank', 'top=20,left=350,width=600,height=600,status=0,resizable=no,location=0,toolbar=0,directories=0');
               window.open('mapaalertas.html?lat=' + lat + '&lon=' + lon, '_blank', 'top=20,left=350,width=518,height=418,status=0,resizable=no,location=0,toolbar=0,directories=0');
           }
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#chkAlertaRepetida").click(function(){
            if($(this).prop("checked") == true) {
                $("#gestionRealizada").val("ALERTA REPETIDA");
                $("#chkDatosIncorrectos").prop("checked", false);
                $("#chkEnviarCaso").prop("checked", false);
                $("#chkDatosIncorrectos").attr('disabled', 'disabled');
                $("#chkEnviarCaso").attr('disabled', 'disabled');
                $('#comboMotivoAlerta').val('0');
                $("#comboMotivoAlerta").attr('disabled', 'disabled');
                
              }
              else if($(this).prop("checked") == false) {
                $("#chkDatosIncorrectos").prop("checked", false);
                $("#chkEnviarCaso").prop("checked", false);
                $("#chkDatosIncorrectos").removeAttr('disabled');
                $("#chkEnviarCaso").removeAttr('disabled');
                $("#comboMotivoAlerta").removeAttr('disabled');
                $("#gestionRealizada").val("");
              }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#chkDatosIncorrectos").click(function(){
            if($(this).prop("checked") == true) {
                $("#gestionRealizada").val("DATOS INCORRECTOS");
                $("#chkAlertaRepetida").prop("checked", false);
                $("#chkEnviarCaso").prop("checked", false);
                $("#chkAlertaRepetida").attr('disabled', 'disabled');
                $("#chkEnviarCaso").attr('disabled', 'disabled');
                $('#comboMotivoAlerta').val('0');
                $("#comboMotivoAlerta").attr('disabled', 'disabled');
              }
              else if($(this).prop("checked") == false) {
                $("#chkAlertaRepetida").prop("checked", false);
                $("#chkEnviarCaso").prop("checked", false);
                $("#chkAlertaRepetida").removeAttr('disabled');
                $("#chkEnviarCaso").removeAttr('disabled');
                $("#comboMotivoAlerta").removeAttr('disabled');
                $("#gestionRealizada").val("");
              }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#chkEnviarCaso").click(function(){
            if($(this).prop("checked") == true) {
                $("#gestionRealizada").val("CASO ENVIADO");
                $("#chkAlertaRepetida").prop("checked", false);
                $("#chkDatosIncorrectos").prop("checked", false);
                $("#chkAlertaRepetida").attr('disabled', 'disabled');
                $("#chkDatosIncorrectos").attr('disabled', 'disabled');
                $('#comboMotivoAlerta').val('0');
                $("#comboMotivoAlerta").attr('disabled', 'disabled');
              }
              else if($(this).prop("checked") == false) {
                $("#chkAlertaRepetida").prop("checked", false);
                $("#chkDatosIncorrectos").prop("checked", false);
                $("#chkAlertaRepetida").removeAttr('disabled');
                $("#chkDatosIncorrectos").removeAttr('disabled');
                $("#comboMotivoAlerta").removeAttr('disabled');
                $("#gestionRealizada").val("");
              }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('a').on('mousedown', stopNavigate);

        $('a').on('mouseleave', function () {
            $(window).on('beforeunload', function(){
                    //return 'Are you sure you want to leave??';
                    var message = 'Are you sure you want to leave??';
                    console.log("Ha confirmado salir");
                    //actualizaAlertaCero();
                    return true;
                    if (confirm(message))
                    {
                        console.log("Ha confirmado salir");
                        actualizaAlertaCero();
                        alert("Prueba");
                        return true;
                    }    
                    else 
                    {
                        console.log("Se mantiene en la alerta");
                        return false;
                    }
            });
        });
    });

    function stopNavigate(){   
        
        $(window).off('beforeunload');
    }

    function actualizaAlertaCero()
    {
        // Fetch data
        $.ajax({
                    url:"{{route('alerts.updateAtendidoPor')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        Secuencia: $("#secuencia").val()
                        
                    
                    },
                    success: function( response ) {
                        
                        if(response['data'] != null)
                        {
                            
                            console.log("Ejecutado correctamente");
                            
                        }
                        
                        
                        
                        
                        //response( data );
                    }
                });
    }

</script>






<script type="text/javascript">
    $(document).ready(function(){

        $('#storeAlerta').submit(function() {
            
        var motivoAlerta = $("#comboMotivoAlerta option:selected").text();
        if (motivoAlerta=="" && !jQuery("#chkEnviarCaso").is(":checked") && !jQuery("#chkAlertaRepetida").is(":checked") && !jQuery("#chkDatosIncorrectos").is(":checked")  )
        {
            alert('Debe de Ingresar un Motivo de Alerta para Continuar');
            return false;
        }
        $(window).off('beforeunload');
        return true;
            
        });

    });

    

</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#comboMotivoAlerta").change(function(){
            $("#gestionRealizada").val($("#comboMotivoAlerta option:selected").text());
        });
        
    });
</script>

</html>