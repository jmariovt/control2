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

    

    <style type="text/css"> 
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
    </style>

    <style type="text/css">
            .material-switch > input[type="checkbox"] {
            display: none;   
        }

        .material-switch > label {
            cursor: pointer;
            height: 0px;
            position: relative; 
            width: 40px;  
        }

        .material-switch > label::before {
            background: rgb(0, 0, 0);
            box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            content: '';
            height: 16px;
            margin-top: -8px;
            position:absolute;
            opacity: 0.3;
            transition: all 0.4s ease-in-out;
            width: 40px;
        }
        .material-switch > label::after {
            background: rgb(255, 255, 255);
            border-radius: 16px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            content: '';
            height: 24px;
            left: -4px;
            margin-top: -8px;
            position: absolute;
            top: -4px;
            transition: all 0.3s ease-in-out;
            width: 24px;
        }
        .material-switch > input[type="checkbox"]:checked + label::before {
            background: inherit;
            opacity: 0.5;
        }
        .material-switch > input[type="checkbox"]:checked + label::after {
            background: rgb(60,179,113);
            left: 20px;
        }


        .row1{
            margin-top:40px;
            padding: 0 10px;
        }

        .clickable{
            cursor: pointer;   
        }

        .panel-heading span {
            margin-top: -20px;
            font-size: 15px;
        }
    </style>

<style>
        /* Modify the background color */
          
        .alert-custom {
            background-color: #fdfd96;
        }
        .alert-red-custom {
            background-color: red;
        }
        .bg-custom {
            background-color: gray;
        }
        /* Modify brand and text color */
          
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: green;
        }
    </style>


</head>
<body>
    <div id="app" >
        
    @if(session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
       
        <div class="container" >

            
                    <div class="container"  id="columnaAlertas">

                        <table class="" id="tablaContadoresMonitoreos" border="0" name="tablaContadoresMonitoreos" width="100%">
							
								
							<tr>
								
								<td  align="center"><label class="form-check-label text-white"><b>&nbsp;</b>Total:</label></td>
								<td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
								
							</tr>
							<tr>
								
								
                                <td align="center"><h3><span class="badge rounded-pill text-dark bg-white" id="contadorAlertas">{{$totalContador}}</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-success" id="contadorAtendiendose">{{$totalVerdes}}</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-dark alert-custom" id="contadorAmarillas">{{$totalAmarillas}}</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-warning" id="contadorNaranjas">{{$totalNaranjas}}</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-danger" id="contadorRojas">{{$totalRojas}}</span></h3></td>
								
								
							</tr>
                            
                            <!--<tr>
								<td>&nbsp;</td>
								<td>
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchAtendiendose">
										 <label class="label-primary" for="switchAtendiendose"></label>
									</div>
								</td>
								
								<td>
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchAmarillas">
										 <label class="label-primary" for="switchAmarillas"></label>
									</div>
								</td>
								
								<td> 
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchNaranjas">
										 <label class="label-primary" for="switchNaranjas"></label>
									</div>
								</td>
                                <td> 
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchRojas">
										 <label class="label-primary" for="switchRojas"></label>
									</div>
								</td>
							</tr>-->
                                
							
										
							
							
						
						</table>



                        <?php
                            $idUsuario = session('idUsuario');
                            $idSubUsuario = session('idSubUsuario');
                            $idCategoria = session('idCategoria');

                            $contador = 0;
                            $cantidadVehiculos = sizeof($alertasVehiculo);
                            $keys = array_keys($alertasVehiculo);
                            
                            while ($contador < $cantidadVehiculos) {
                                $key = $keys[$contador];
                                $alertaVehiculo = $alertasVehiculo[$key];
                                $alertaVehiculoTotales = $alertasVehiculoTotales[$key];
                                $cantidadAlertas = 0;
                                $vehiculoSecuencias="";
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <?php
                                            $etiqueta_temp = preg_replace('/\s+/', '', $key);
                                            $etiqueta = preg_replace('/\p{P}/','',$etiqueta_temp);
                                            $label = $key.' - Alertas: '.$cantidadAlertas;
                                            $vehiculoSecuencias = $key;
                                            $cantidadVerdes1 = $alertaVehiculoTotales['verdes'];
                                            $cantidadAmarillas1 = $alertaVehiculoTotales['amarillas'];
                                            $cantidadNaranjas1 = $alertaVehiculoTotales['naranjas'];
                                            $cantidadRojas1 = $alertaVehiculoTotales['rojas'];
                                        ?>
                                        @foreach($alertaVehiculo as $alerta)
                                            <?php 
                                                $cantidadAlertas ++; 
                                                $vehiculoSecuencias = $vehiculoSecuencias.";".$alerta->Secuencia;
                                                
                                            ?>
                                        @endforeach
                                        <div class="row" id="tarjetaAlertas">
                                            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#{{$etiqueta}}" role="button" aria-expanded="true" aria-controls="{{$etiqueta}}" style="margin: 10px;">
                                            {{$key}} <span class="badge rounded-pill text-white bg-success">{{$cantidadVerdes1}}</span> <span class="badge rounded-pill text-dark alert-custom">{{$cantidadAmarillas1}}</span> <span class="badge rounded-pill text-white bg-warning">{{$cantidadNaranjas1}}</span> <span class="badge rounded-pill text-white bg-danger">{{$cantidadRojas1}}</span>
                                            </a>
                                        </div>

                                        <form class="form-group" method="POST" action="/xadmin/alerts/storeGroup" id="storeAlerta">
                                        @csrf

                                        <div class="collapse multi-collapse" id="{{$etiqueta}}">
                                            <div class="row bg-custom" id="alertas">
                                            
                                            <!-- INICIA SECCION DE GESTION  -->
                                            	
                                                <!--<div class="row" style="margin: 5px;">
                                                    <div class="col-lg">
                                                        
                                                        <label for="fechaAccion">Fecha Gestión</label>
                                                        <?php
                                                           
                                                            
                                                        ?>
                                                        <input type="text" class="form-control form-control-sm" id="fechaAccion" name="fechaAccion" value="{{$fechaAccion}}">
                                                        <input type="hidden" class="form-control form-control-sm" id="vehiculoSecuencias" name="vehiculoSecuencias" value="{{$vehiculoSecuencias}}">
                                                        
                                                        <label for="gestionRealizada">Gestión Realizada</label>
                                                        <?php
                                                            $valorGestion = "";
                                                            
                                                        ?>
                                                        <textarea class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada" value="" rows="6">{{$valorGestion}}</textarea>
                                                        
                                                        
                                                    
                                                    </div>
                                                    <div class="col-lg" >
                                                        <?php
                                                            
                                                                $estiloComboCambiaEstado = "";
                                                            
                                                        ?>
                                                        <div style="{{$estiloComboCambiaEstado}}">
                                                            <label for="comboCambiarEstado">Cambiar Estado</label>
                                                            <select class="form-control form-control-sm" id="comboCambiarEstado" name="comboCambiarEstado">
                                                                <option value="NO ALARMADO" selected>NO ALARMADO</option>
                                                                <option value="AMARILLO">AMARILLO</option>
                                                                <option value="NARANJA">NARANJA</option>
                                                                <option value="3">ROJO</option>
                                                            
                                                                
                                                            </select>
                                                        </div>
                                                        <label for="comboMotivoAlerta">Motivo Alerta</label>
                                                        <select class="form-control form-control-sm" id="comboMotivoAlerta" name="comboMotivoAlerta">
                                                            @foreach($comboMotivoAlerta as $motivoAlerta)
                                                                <option value='{{ $motivoAlerta->Codigo }}'>{{ $motivoAlerta->Descripcion}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php
                                                            
                                                                $estilochkAlarmaRepetida = "";
                                                            
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkAlarmaRepetida}}">
                                                            <input class="form-check-input" type="checkbox" value="" id="chkAlertaRepetida" name="chkAlertaRepetida">
                                                            <label class="form-check-label" for="chkAlertaRepetida">
                                                                Alerta Repetida
                                                            </label>
                                                            
                                                            
                                                        </div>
                                                        
                                                        <?php
                                                            
                                                                $estilochkDatosIncorrectos = "";
                                                            
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkDatosIncorrectos}}">
                                                            <input class="form-check-input" type="checkbox" value="" id="chkDatosIncorrectos" name="chkDatosIncorrectos">
                                                            <label class="form-check-label" for="chkDatosIncorrectos">
                                                                Datos Incorrectos
                                                            </label>
                                                            
                                                            
                                                        </div>
                                                        <?php
                                                            
                                                                $estilochkEnviarCaso = "";
                                                           
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkEnviarCaso}}">
                                                            <input class="form-check-input" type="checkbox" value="" id="chkEnviarCaso" name="chkEnviarCaso">
                                                            <label class="form-check-label" for="chkEnviarCaso">
                                                                Enviar Caso
                                                            </label>
                                                            
                                                            
                                                        </div>

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
                                                    
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sm" id="btnGuardarAlerta">Guardar</button>
                                                    </div>
                                                </div> -->
                                                
                                            
                                       


                                            <!-- FIN SECCION DE GESTION -->

                                                @foreach($alertaVehiculo as $alerta)
                                                
                                                        
                                                        <?php
                                                            $revisadoPor="";
                                                            $luzAlarma = "";
                                                            if($alerta->EstadoAlarma=='')
                                                            {
                                                                $clase = "card text-center text-dark alert-custom  mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                            }
                                                            
                                                            if($alerta->EstadoAlarma==0)
                                                            {
                                                                $clase = "card text-center text-dark alert-custom  mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                            }
                                                                
                                                            
                                                            if($alerta->EstadoAlarma==1)
                                                            {
                                                                $clase = "card text-center text-dark alert-custom mb-3";
                                                                $claseTitulo="card-title text-warning bg-dark";
                                                            }
                                                                
                                                            if($alerta->EstadoAlarma==2)
                                                            {
                                                                //$clase = "card text-center text-dark  alert-custom mb-3";
                                                                $clase = "card text-center text-dark bg-warning mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                                            }
                                                                
                                                            if($alerta->EstadoAlarma==5)
                                                            {
                                                                $clase = "card text-center text-dark bg-danger mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                                            }

                                                            if($alerta->SiendoAtendida==1)
                                                            {
                                                                $revisadoPor="Siendo atendida";
                                                                $clase = "card text-center text-white bg-success mb-3";
                                                            }
                                                        ?>
                                                        <div class="col-sm" id="tarjetasAlertas" name="tarjetasAlertas">
                                                            <div class="{{$clase}}" style="width: 15rem; margin-top: 20px;">
                                                                <!--<div class="card-header"><img src="{{asset($luzAlarma)}}"  style="height: 30px; width:30px" class="card-img-top" alt="Alerta"></div>
                                                                <div class="card-header">
                                                                    {{$alerta->VID}}
                                                                </div>-->
                                                                <div class="card-body">
                                                                    <?php
                                                                        $vid = substr($alerta->VID, 0, 15);
                                                                    ?>
                                                                    <p class="card-text"><b>{{$vid}}</b></p>
                                                                    <?php
                                                                        $evento = substr($alerta->Evento, 0, 21);
                                                                        $client_id = "";
                                                                        $html_client_id = "----------";
                                                                        
                                                                        
                                                                    ?>
                                                                    @if($idSubUsuario!="0" )
                                                                        <?php 
                                                                        if($alerta->client_id!=NULL)
                                                                        {    
                                                                            $client_id = $alerta->client_id;
                                                                            $html_client_id = "ID Cliente: ".$client_id;
                                                                        }
                                                                        ?>
                                                                        <p class="card-text"><b>{{$html_client_id}}</b></p>
                                                                    @endif
                                                                    
                                                                    <p class="{{$claseTitulo}}"><b>{{$evento}}</b></p>
                                                                    <?php
                                                                        $fechaHoraRegistro = date('d/m/Y H:i:s',strtotime($alerta->FechaHoraRegistro));
                                                                    ?>
                                                                    <p class="card-text"><b>{{$fechaHoraRegistro}}</b></p>

                                                                    <?php
                                                                        
                                                                            if($alerta->SiendoAtendida==1)
                                                                                $enlace = "";
                                                                            else
                                                                            {    $enlace = "/xadmin/alerts/show"."/".$alerta->Secuencia;

                                                                                ?>
                                                                                <a href="" class="btn btn-outline-primary text-dark btn-sm"  onclick="window.open('{{$enlace}}','{{$alerta->Secuencia}}','width=900,height=900'); return false;">Ver alerta</a>
                                                                                <?php
                                                                            }
                                                                        
                                                                            
                                                                        
                                                                    ?>
                                                                    
                                                                    <p class="card-text"><small class="text-green"><b>{{$revisadoPor}}</b></small></p>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>



                                                
                                                @endforeach
                                            </div>
                                        </div>
                                        </form>

                                    </div>
                                    <?php
                                        if($contador+1>=$cantidadVehiculos)
                                            break;
                                        $key = $keys[$contador+1];
                                        $alertaVehiculo = $alertasVehiculo[$key];
                                        $alertaVehiculoTotales = $alertasVehiculoTotales[$key];
                                        $cantidadAlertas = 0;
                                        $vehiculoSecuencias="";
                                        
                                    ?>
                                    <div class="col-md-6" >

                                    



                                        
                                        <?php
                                            $etiqueta_temp = preg_replace('/\s+/', '', $key);
                                            $etiqueta = preg_replace('/\p{P}/','',$etiqueta_temp);
                                            $label = $key.' - Alertas: '.$cantidadAlertas;
                                            $vehiculoSecuencias=$key;
                                            $cantidadVerdes2 = $alertaVehiculoTotales['verdes'];
                                            $cantidadAmarillas2 = $alertaVehiculoTotales['amarillas'];
                                            $cantidadNaranjas2 = $alertaVehiculoTotales['naranjas'];
                                            $cantidadRojas2 = $alertaVehiculoTotales['rojas'];
                                        ?>
                                        @foreach($alertaVehiculo as $alerta)
                                            <?php 
                                                $cantidadAlertas ++; 
                                                $vehiculoSecuencias = $vehiculoSecuencias.";".$alerta->Secuencia;
                                                
                                            ?>
                                        @endforeach
                                        <div class="row" id="tarjetaAlertas">
                                            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#{{$etiqueta}}" role="button" aria-expanded="true" aria-controls="{{$etiqueta}}" style="margin: 10px;">
                                            {{$key}} <span class="badge rounded-pill text-white bg-success">{{$cantidadVerdes2}}</span> <span class="badge rounded-pill text-dark alert-custom">{{$cantidadAmarillas2}}</span> <span class="badge rounded-pill text-white bg-warning">{{$cantidadNaranjas2}}</span> <span class="badge rounded-pill text-white bg-danger">{{$cantidadRojas2}}</span>
                                            </a>
                                        </div>
                                        <form class="form-group" method="POST" action="/xadmin/alerts/storeGroup" id="storeAlerta">
                                        @csrf
                                        <div class="collapse multi-collapse" id="{{$etiqueta}}">
                                            <div class="row bg-custom" id="alertas">


                                            <!-- INICIA SECCION DE GESTION  -->
                                            
                                                <!-- <div class="row" style="margin: 5px;">
                                                    <div class="col-lg" >
                                                        
                                                        <label for="fechaAccion">Fecha Gestión</label>
                                                        <?php
                                                            
                                                            
                                                        ?>
                                                        <input type="text" class="form-control form-control-sm" id="fechaAccion" name="fechaAccion" value="{{$fechaAccion}}">
                                                        <input type="hidden" class="form-control form-control-sm" id="vehiculoSecuencias" name="vehiculoSecuencias" value="{{$vehiculoSecuencias}}">
                                                        
                                                        <label for="gestionRealizada">Gestión Realizada</label>
                                                        <?php
                                                            $valorGestion = "";
                                                            
                                                        ?>
                                                        <textarea class="form-control form-control-sm" id="gestionRealizada" name="gestionRealizada" value="" rows="6">{{$valorGestion}}</textarea>
                                                        
                                                        
                                                    
                                                    </div>
                                                    <div class="col-lg" >
                                                        <?php
                                                            
                                                                $estiloComboCambiaEstado = "";
                                                            
                                                        ?>
                                                        <div style="{{$estiloComboCambiaEstado}}">
                                                            <label for="comboCambiarEstado">Cambiar Estado</label>
                                                            <select class="form-control form-control-sm" id="comboCambiarEstado" name="comboCambiarEstado">
                                                                <option value="NO ALARMADO" selected>NO ALARMADO</option>
                                                                <option value="AMARILLO">AMARILLO</option>
                                                                <option value="NARANJA">NARANJA</option>
                                                                <option value="3">ROJO</option>
                                                            
                                                                
                                                            </select>
                                                        </div>
                                                        <label for="comboMotivoAlerta">Motivo Alerta</label>
                                                        <select class="form-control form-control-sm" id="comboMotivoAlerta" name="comboMotivoAlerta">
                                                            @foreach($comboMotivoAlerta as $motivoAlerta)
                                                                <option value='{{ $motivoAlerta->Codigo }}'>{{ $motivoAlerta->Descripcion}}</option>
                                                            @endforeach
                                                        </select>
                                                        <?php
                                                            
                                                                $estilochkAlarmaRepetida = "";
                                                            
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkAlarmaRepetida}}">
                                                            <input class="form-check-input" type="checkbox" value="1" id="chkAlertaRepetida" name="chkAlertaRepetida">
                                                            <label class="form-check-label" for="chkAlertaRepetida">
                                                                Alerta Repetida
                                                            </label>
                                                            
                                                            
                                                        </div>
                                                        
                                                        <?php
                                                            
                                                                $estilochkDatosIncorrectos = "";
                                                            
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkDatosIncorrectos}}">
                                                            <input class="form-check-input" type="checkbox" value="1" id="chkDatosIncorrectos" name="chkDatosIncorrectos">
                                                            <label class="form-check-label" for="chkDatosIncorrectos">
                                                                Datos Incorrectos
                                                            </label>
                                                            
                                                            
                                                        </div>
                                                        <?php
                                                            
                                                                $estilochkEnviarCaso = "";
                                                           
                                                        ?>
                                                        <div class="form-check" style="{{$estilochkEnviarCaso}}">
                                                            <input class="form-check-input" type="checkbox" value="" id="chkEnviarCaso" name="chkEnviarCaso">
                                                            <label class="form-check-label" for="chkEnviarCaso">
                                                                Enviar Caso
                                                            </label>
                                                            
                                                            
                                                        </div>

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
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sm" id="btnGuardarAlerta">Guardar</button>
                                                     </div>
                                                    
                                                </div> -->
                                                
                                           


                                            <!-- FIN SECCION DE GESTION -->




                                                @foreach($alertaVehiculo as $alerta)
                                                
                                                        
                                                        <?php
                                                            $revisadoPor="";
                                                            $luzAlarma = "";
                                                            if($alerta->EstadoAlarma=='')
                                                            {
                                                                $clase = "card text-center text-dark alert-custom  mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                            }
                                                            
                                                            if($alerta->EstadoAlarma==0)
                                                            {
                                                                $clase = "card text-center text-dark alert-custom  mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                            }
                                                                
                                                            
                                                            if($alerta->EstadoAlarma==1)
                                                            {
                                                                $clase = "card text-center text-dark alert-custom mb-3";
                                                                $claseTitulo="card-title text-warning bg-dark";
                                                            }
                                                                
                                                            if($alerta->EstadoAlarma==2)
                                                            {
                                                                //$clase = "card text-center text-dark  alert-custom mb-3";
                                                                $clase = "card text-center text-dark bg-warning mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                                            }
                                                                
                                                            if($alerta->EstadoAlarma==5)
                                                            {
                                                                $clase = "card text-center text-dark bg-danger mb-3";
                                                                $claseTitulo="card-title text-dark";
                                                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                                            }

                                                            if($alerta->SiendoAtendida==1)
                                                            {
                                                                $revisadoPor="Siendo atendida";
                                                                $clase = "card text-center text-white bg-success mb-3";
                                                            }
                                                        ?>
                                                        <div class="col-sm" id="tarjetasAlertas" name="tarjetasAlertas">
                                                            <div class="{{$clase}}" style="width: 15rem; margin-top: 20px;">
                                                                <!--<div class="card-header"><img src="{{asset($luzAlarma)}}"  style="height: 30px; width:30px" class="card-img-top" alt="Alerta"></div>
                                                                <div class="card-header">
                                                                    {{$alerta->VID}}
                                                                </div>-->
                                                                <div class="card-body">
                                                                    <?php
                                                                        $vid = substr($alerta->VID, 0, 15);
                                                                    ?>
                                                                    <p class="card-text"><b>{{$vid}}</b></p>
                                                                    <?php
                                                                        $evento = substr($alerta->Evento, 0, 21);
                                                                        $client_id = "";
                                                                        $html_client_id = "----------";
                                                                        
                                                                        
                                                                    ?>
                                                                    @if($idSubUsuario!="0" )
                                                                        <?php 
                                                                        if($alerta->client_id!=NULL)
                                                                        {    
                                                                            $client_id = $alerta->client_id;
                                                                            $html_client_id = "ID Cliente: ".$client_id;
                                                                        }
                                                                        ?>
                                                                        <p class="card-text"><b>{{$html_client_id}}</b></p>
                                                                    @endif
                                                                    
                                                                    <p class="{{$claseTitulo}}"><b>{{$evento}}</b></p>
                                                                    <?php
                                                                        $fechaHoraRegistro = date('d/m/Y H:i:s',strtotime($alerta->FechaHoraRegistro));
                                                                    ?>
                                                                    <p class="card-text"><b>{{$fechaHoraRegistro}}</b></p>

                                                                    <?php
                                                                        
                                                                            if($alerta->SiendoAtendida==1)
                                                                                $enlace = "";
                                                                            else
                                                                            {    $enlace = "/xadmin/alerts/show"."/".$alerta->Secuencia;

                                                                                ?>
                                                                                <a href="" class="btn btn-outline-primary text-dark btn-sm"  onclick="window.open('{{$enlace}}','{{$alerta->Secuencia}}','width=900,height=900'); return false;">Ver alerta</a>
                                                                                <?php
                                                                            }
                                                                        
                                                                            
                                                                        
                                                                    ?>
                                                                    
                                                                    <p class="card-text"><small class="text-green"><b>{{$revisadoPor}}</b></small></p>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>



                                                
                                                @endforeach
                                            </div>
                                        </div>
                                        </form>

                                    </div>
                                </div>
                                <?php
                                $contador = $contador + 2;
                            }
                        ?>

                        
                    </div>
               
                    
              
        </div>
    </div>

    <script type="text/javascript">

    $(document).ready(function(){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        setInterval(function()
            {
                window .location.reload();
                //recargadatos();
                
            }, 60000);
        
        function recargadatos()
        {
            //window .location.reload();
            console.log("Hola");

            $.ajax({
                url:"{{route('alerts.alertasAgrupadasPorVehiculoPost')}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN
                    
                
                },
                success: function( response ) 
                {
                    if(response != null)
                    {
                        
                        len = response['alertasVehiculoTotales'].length;
                        console.log("Trajo "+len+" datos");
                        console.log(response['alertasVehiculoTotales']);
                        
                        
                        
                    }
                    
                }
            });
            
        }

        $("#switchAtendiendose").change(function(){

            var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
            $("#switchAmarillas").prop("checked", false);
            $("#switchNaranjas").prop("checked", false);
            $("#switchRojas").prop("checked", false);

            muestraAtendiendose();

        });


        function muestraAtendiendose()
        {
            var table, tr, td, i, txtValue, contador=0, contadorNoIniciados=0, filter, cards,divCuerpo,parrafos,p,texto, divRaiz;
            var buscar = $("#switchAtendiendose").is(':checked');
            
            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("a");

            

            for (i = 0; i < cards.length; i++) 
                cards[i].style.display = "";

            console.log("as: "+cards.length);

            tarjetas = table.getElementsByTagName("div");
            console.log("tarjetas: "+tarjetas.length);
            

            for (i = 0; i < cards.length; i++) 
            {
                spans = cards[i].getElementsByTagName("span");

               
                if(spans.length=="4")
                {
                    console.log("spans: "+spans[0].innerText);
                    cantidad = spans[0].innerText;
                    if (cantidad==0 && buscar==true)
                    {
                        cards[i].style.display = "none";
                    }else
                    {
                        cards[i].style.display = "";
                    }
                }
            }

            
        }


        $("#switchAmarillas").change(function(){

        
            $("#switchAtendiendose").prop("checked", false);
            $("#switchNaranjas").prop("checked", false);
            $("#switchRojas").prop("checked", false);

            muestraAmarillas();

        });

        function muestraAmarillas()
        {
            var table, tr, td, i, txtValue, contador=0, contadorNoIniciados=0, filter, cards,divCuerpo,parrafos,p,texto, divRaiz;
            var buscar = $("#switchAmarillas").is(':checked');

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("a");

            for (i = 0; i < cards.length; i++) 
                cards[i].style.display = "";

            console.log("as: "+cards.length);

            for (i = 0; i < cards.length; i++) 
            {
                spans = cards[i].getElementsByTagName("span");
                if(spans.length=="4")
                {
                    console.log("spans: "+spans[1].innerText);
                    cantidad = spans[1].innerText;
                    if (cantidad==0 && buscar==true)
                    {
                        cards[i].style.display = "none";
                    }else
                    {
                        cards[i].style.display = "";
                    }
                }
            }




            


        }


        $("#switchNaranjas").change(function(){

            console.log("Hola naranjas");

            var table, tr, td, i, txtValue, contador=0, filter;

            $("#switchAtendiendose").prop("checked", false);
            $("#switchAmarillas").prop("checked", false);
            $("#switchRojas").prop("checked", false);

            muestraNaranjas();

        });

        function muestraNaranjas()
        {
            var table, tr, td, i, txtValue, contador=0, contadorNoIniciados=0, filter, cards,divCuerpo,parrafos,p,texto, divRaiz;
            var buscar = $("#switchNaranjas").is(':checked');
            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("a");

            for (i = 0; i < cards.length; i++) 
                cards[i].style.display = "";

            console.log("as: "+cards.length);

            for (i = 0; i < cards.length; i++) 
            {
                spans = cards[i].getElementsByTagName("span");
                if(spans.length=="4")
                {
                    console.log("spans: "+spans[2].innerText);
                    cantidad = spans[2].innerText;
                    if (cantidad==0 && buscar==true)
                    {
                        cards[i].style.display = "none";
                    }else
                    {
                        cards[i].style.display = "";
                    }
                }
            }

        }

        $("#switchRojas").change(function(){

            console.log("Hola rojas");

            var table, tr, td, i, txtValue, contador=0, filter;
            //input = document.getElementById("inputBuscarMonitoreo");
            //filter = input.value.toUpperCase();
            $("#switchAtendiendose").prop("checked", false);
            $("#switchAmarillas").prop("checked", false);
            $("#switchNaranjas").prop("checked", false);

            muestraRojas();

        });

        function muestraRojas()
        {
            var table, tr, td, i, txtValue, contador=0, contadorNoIniciados=0, filter, cards,divCuerpo,parrafos,p,texto, divRaiz;
            var buscar = $("#switchRojas").is(':checked');

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("a");

            for (i = 0; i < cards.length; i++) 
                cards[i].style.display = "";

            console.log("as: "+cards.length);

            for (i = 0; i < cards.length; i++) 
            {
                spans = cards[i].getElementsByTagName("span");
                if(spans.length=="4")
                {
                    console.log("spans: "+spans[3].innerText);
                    cantidad = spans[3].innerText;
                    if (cantidad==0 && buscar==true)
                    {
                        cards[i].style.display = "none";
                    }else
                    {
                        cards[i].style.display = "";
                    }
                }
            }


        }
        
        
    });
    </script>
</body>
</html>

