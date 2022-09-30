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
    <link rel="stylesheet" href="{{asset('slate/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('slate/bootstrap.css') }}">
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

    <style>
        

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
								
								<td align="center" ><label class="form-check-label text-white"><b>&nbsp;</b>Alertas:</label></td>
                                <td align="center" ><label class="form-check-label text-white"><b>&nbsp;</b>Vehículos:</label></td>
								<td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
								
							</tr>
							<tr>
								
								
                                <td align="center"><h4><label class="form-check-label text-white" id="contadorAlertas">{{$totalContador}}</label></h4></td>
                                <td align="center"><h4><label class="form-check-label text-white" id="contadorVehiculos">{{$totalVehiculos}}</label></h4></td>
                                <td><h4><span class="badge rounded-pill text-white bg-success" id="contadorAtendiendose" data-toggle="tooltip" data-placement="top" title="Atendiéndose">{{$totalVerdes}}</span></h4></td>
                                <td><h4><span class="badge rounded-pill text-dark alert-custom" id="contadorAmarillas" data-bs-toggle="tooltip" data-bs-placement="top" title="Prioridad baja">{{$totalAmarillas}}</span></h4></td>
                                <td><h4><span class="badge rounded-pill text-white bg-warning" id="contadorNaranjas" data-bs-toggle="tooltip" data-bs-placement="top" title="Prioridad media">{{$totalNaranjas}}</span></h4></td>
                                <td><h4><span class="badge rounded-pill text-white bg-danger" id="contadorRojas" data-bs-toggle="tooltip" data-bs-placement="top" title="Prioridad alta">{{$totalRojas}}</span></h4></td>
								
								
							</tr>
                            
                            <tr>
								<td>&nbsp;</td>
                                <td>&nbsp;</td>
								<td  >
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchAtendiendose">
										 <label class="label-primary" for="switchAtendiendose"></label>
									</div>
								</td>
								
								<td >
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchAmarillas">
										 <label class="label-primary" for="switchAmarillas"></label>
									</div>
								</td>
								
								<td > 
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchNaranjas">
										 <label class="label-primary" for="switchNaranjas"></label>
									</div>
								</td>
                                <td > 
									<div class="material-switch">
                                         
										 <input class="form-check-input" type="checkbox" id="switchRojas">
										 <label class="label-primary" for="switchRojas"></label>
									</div>
								</td>
							</tr>
                                
							
										
							
							
						
						</table>
                        

                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-control-sm" id="selectGrupos">
                                    <option value="0" SELECTED>TODOS LOS GRUPOS</option>
                                    @foreach($gruposUsuario as $grupoUsuario)
                                    
                                        <option value="{{$grupoUsuario->IdGrupo}}">{{$grupoUsuario->Grupo}}</option>
                                    @endforeach
                                    
                                    
                                </select>
                                <input class="form-control form-control-sm" type="text" onkeyup="buscaAlertasInput()" placeholder="Buscar" id="txtBuscarVehiculo">
                            </div>
                        </div>
                        <div class="row" id="alertasRaiz">
                        <?php
                            $idUsuario = session('idUsuario');
                            $idSubUsuario = session('idSubUsuario');
                            $idCategoria = session('idCategoria');

                            $contador = 0;
                            $cantidadVehiculos = sizeof($alertasVehiculo);
                            $keys = array_keys($alertasVehiculo);
                            
                            while ($contador < $cantidadVehiculos) 
                            {
                                $key = $keys[$contador];
                                $alertaVehiculo = $alertasVehiculo[$key];
                                $alertaVehiculoTotales = $alertasVehiculoTotales[$key];
                                $cantidadAlertas = 0;
                                $vehiculoSecuencias="";
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        
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
                                        <!--<div class="row" id="tarjetaAlertas">
                                            <a class="btn btn-primary btn-block" data-toggle="collapse" href="#{{$etiqueta}}" role="button" aria-expanded="true" aria-controls="{{$etiqueta}}" style="margin: 10px;">
                                            {{$key}} <span class="badge rounded-pill text-white bg-success">{{$cantidadVerdes1}}</span> <span class="badge rounded-pill text-dark alert-custom">{{$cantidadAmarillas1}}</span> <span class="badge rounded-pill text-white bg-warning">{{$cantidadNaranjas1}}</span> <span class="badge rounded-pill text-white bg-danger">{{$cantidadRojas1}}</span>
                                            </a>
                                        </div>-->

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item" id="accordion-item">
                                                <h2 class="accordion-header" id="heading{{$etiqueta}}">
                                                    <button class="accordion-button collapsed text-center" type="button"  data-toggle="collapse" style="font-size : 20px;" data-target="#{{$etiqueta}}" aria-expanded="false" aria-controls="{{$etiqueta}}">
                                                    {{substr($key,0,7)}} &nbsp<span class="badge rounded-pill text-white bg-success">{{$cantidadVerdes1}}</span>&nbsp<span class="badge rounded-pill text-dark alert-custom">{{$cantidadAmarillas1}}</span>&nbsp<span class="badge rounded-pill text-white bg-warning">{{$cantidadNaranjas1}}</span>&nbsp<span class="badge rounded-pill text-white bg-danger">{{$cantidadRojas1}}</span>
                                                    </button>
                                                </h2>
                                                <div id="{{$etiqueta}}" class="accordion-collapse collapse" aria-labelledby="heading{{$etiqueta}}" data-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        
                                                        <div class="row bg-custom" id="alertas">
                                                        
                                                        
                                                            <?php
                                                                $valorGestion = "";
                                                                $estiloComboCambiaEstado = "";
                                                                $estilochkAlarmaRepetida = "";
                                                                $estilochkDatosIncorrectos = "";
                                                                $estilochkEnviarCaso = "";
                                                            
                                                            ?>
                                                        
                                            
                                    


                                                            <!-- FIN SECCION DE GESTION -->

                                                            @foreach($alertaVehiculo as $alerta)
                                                
                                                        
                                                            <?php
                                                                $revisadoPor="";
                                                                $luzAlarma = "";
                                                                if($alerta->EstadoAlarma=='')
                                                                {
                                                                    $clase = "card text-center text-dark alert-custom mb-3";
                                                                    $claseTitulo="card-title text-dark";
                                                                }
                                                                
                                                                if($alerta->EstadoAlarma==0)
                                                                {
                                                                    $clase = "card text-center text-dark alert-custom mb-3";
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
                                                </div>
                                            </div>
                                        </div>



                                        <!--<form class="form-group" method="POST" action="/xadmin/alerts/storeGroup" id="storeAlerta">
                                        @csrf

                                        <div class="collapse multi-collapse" id="{{$etiqueta}}">
                                            
                                        </div>
                                        </form>-->

                                    </div>

                                    

                                    





                                    
                                </div>
                                <?php
                                $contador = $contador + 1;
                            }
                        ?>

                        </div>
                    </div>
               
                    
              
        </div>
    </div>

    <script type="text/javascript">
    $(document).on('click', '.panel-heading span.clickable', function(e){
        console.log("hola");
        var $this = $(this);
        if(!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            
        }
    });
    </script>
    
    <script type="text/javascript">

        function buscaAlertasInput()
        {
            console.log('Hola');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtBuscarVehiculo");
            filter = input.value.toUpperCase();

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("button");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;
                var nombre = cards[i].id;
                var nombreEtiqueta = nombre.substring(0,7);
                console.log("nombreEtiqueta: "+nombreEtiqueta);

                texto = cards[i].innerText;
                console.log("texto: "+texto);
                textoExtraido = texto.substring(0,7);

                if(textoExtraido.toUpperCase().indexOf(filter) > -1)
                {
                    cards[i].style.display = "";
                    continua=0;
                }else
                {
                    cards[i].style.display = "none";
                }
            }
        }



    

    $(document).ready(function(){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        setInterval(function()
            {
                //window .location.reload();
                recargadatos();
                
                
            }, 63000);

        $("#selectGrupos").change(function(){
            recargadatos();
            
        });
        
        function recargadatos()
        {
            //window .location.reload();
            console.log("Hola");
            var grupo = $("#selectGrupos").val();

            $("#alertasRaiz").empty();

            $('#contadorAlertas').text("0");
            $('#contadorVehiculos').text("0");
            $('#contadorAmarillas').text("0");
            $('#contadorNaranjas').text("0");
            $('#contadorRojas').text("0");
            $("#contadorAtendiendose").text("0");

            $.ajax({
                url:"{{route('alerts.alertasAgrupadasPorVehiculoPost')}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    grupo: grupo
                    
                
                },
                success: function( response ) 
                {
                    if(response != null)
                    {
                        //console.log(response);
                        cantidadVehiculos = Object.keys(response['alertasVehiculo']).length;// response['alertasVehiculo'].length;
                        console.log("Trajo "+cantidadVehiculos+" vehiculos");
                        //console.log(response['alertasVehiculoTotales']);
                        $("#alertasRaiz").empty();

                        $('#contadorAlertas').text(response['alertasTotales'][0]);
                        $('#contadorVehiculos').text(cantidadVehiculos);
                        $('#contadorAmarillas').text(response['alertasTotales'][2]);
                        $('#contadorNaranjas').text(response['alertasTotales'][3]);
                        $('#contadorRojas').text(response['alertasTotales'][4]);
                        $("#contadorAtendiendose").text(response['alertasTotales'][1]);
                        
                        //for(var i=0; i<cantidadVehiculos; i++)
                        //{
                        //    html = html+'</br>Carro';
                        //}
                        html = '<div class="row"><div class="col-md-12">';
                        $.each(response['alertasVehiculo'], function(key, value) {
                            etiqueta_temp = key.replace(/\s/g, '');
                            etiqueta = etiqueta_temp.replace(/\./g,'');
                            cantidadVerdes = response['alertasVehiculoTotales'][key]['verdes'];
                            cantidadAmarillas = response['alertasVehiculoTotales'][key]['amarillas'];
                            cantidadNaranjas = response['alertasVehiculoTotales'][key]['naranjas'];
                            cantidadRojas = response['alertasVehiculoTotales'][key]['rojas'];
                            html = html+'<div class="accordion" id="accordionExample">'
                            +'<div class="accordion-item" id="accordion-item">'
                            +'<h2 class="accordion-header" id="heading'+etiqueta+'">'
                            +'<button class="accordion-button collapsed text-center" type="button"  data-toggle="collapse" style="font-size : 20px;" data-target="#'+etiqueta+'" aria-expanded="false" aria-controls="'+etiqueta+'">'
                            +key.substring(0,7)+' &nbsp<span class="badge rounded-pill text-white bg-success">'+cantidadVerdes+'</span>&nbsp<span class="badge rounded-pill text-dark alert-custom">'+cantidadAmarillas+'</span>&nbsp<span class="badge rounded-pill text-white bg-warning">'+cantidadNaranjas+'</span>&nbsp<span class="badge rounded-pill text-white bg-danger">'+cantidadRojas+'</span>'
                            +'</button>'
                            +'</h2>'
                            +'<div id="'+etiqueta+'" class="accordion-collapse collapse" aria-labelledby="heading'+etiqueta+'" data-parent="#accordionExample" style="">'
                            +'<div class="accordion-body">'
                            +'<div class="row bg-custom" id="alertas">';
                            $.each(value, function(key2, value2) {
                                var revisadoPor="";
                                
                                
                                if(value2.EstadoAlarma=='')
                                {
                                    var clase = 'card text-center text-dark alert-custom mb-3';
                                    var claseTitulo='card-title text-dark';
                                   
                                }


                                if(value2.EstadoAlarma==0 && key2.SiendoAtendida!=1)
                                {
                                    var clase = 'card text-center text-dark alert-custom mb-3';
                                    var claseTitulo='card-title text-dark';
                                    
                                }
                                
                            
                                if(value2.EstadoAlarma==1 && key2.SiendoAtendida!=1)
                                {
                                    var clase = 'card text-center text-dark alert-custom mb-3';
                                    var claseTitulo='card-title text-warning bg-dark';
                                    
                                }
                                    
                                if(value2.EstadoAlarma==2 && key2.SiendoAtendida!=1)
                                {
                                    var clase = 'card text-center text-dark bg-warning mb-3';
                                    var claseTitulo='card-title text-dark';
                                   
                                    
                                }
                                    
                                if(value2.EstadoAlarma==5 && key2.SiendoAtendida!=1)
                                {
                                    var clase = 'card text-center text-dark bg-danger mb-3';
                                    var claseTitulo='card-title text-dark';
                                    
                                    
                                }

                                

                                if(value2.SiendoAtendida==1)
                                {
                                    revisadoPor='Siendo atendida';
                                    var clase = "card text-center text-white bg-success mb-3";
                                   
                                }

                                var vid = value2.VID;
                                console.log('vid: '+value2.VID);
                                var evento = value2.Evento;
                                var vid_2 = vid.substring(0,15);
                                var evento_2 = evento;//.substring(0,21);
                                var fecha = value2.FechaHoraRegistro;
                                var fechaHoraRegistro = fecha.slice(0,19);
                                var secuencia = value2.Secuencia;
                                var client_id = value2.client_id;

                                if(client_id == null)
                                    client_id = '';

                                var textoVentana = "";
                                var textoBoton = "";

                                if(value2.SiendoAtendida==1)
                                    textoVentana = "";
                                else
                                {   
                                    textoVentana = "window.open('/xadmin/alerts/show/"+secuencia+"/"+client_id+"','"+secuencia+"','width=900,height=900'); return false;";
                                    textoBoton ='<a href="" class="btn btn-outline-primary text-dark btn-sm" onclick="'+textoVentana+'">Ver alerta</a>';
                                }


                                var htm_client_id = '';
                                var client_id = '----------';

                                //if(idSubUsuario!='0')
                                //{
                                if(value2.client_id != null)
                                {
                                    client_id = value2.client_id;
                                    htm_client_id = '<p class="card-text"><b>ID Cliente: '+client_id+'</b></p>';
                                }else
                                {
                                    htm_client_id = '<p class="card-text"><b>'+client_id+'</b></p>';
                                }

                               
                                arregloEvento = evento_2.split(" - ");
                                if(arregloEvento.length==2)
                                    evento_2 = arregloEvento[1];
                                //}else
                                //{
                                //    var evento_2 = evento.substring(0,21);
                                //}
                                html = html + '<div class="col-sm" id="tarjetasAlertas"><div class="'+clase+'" style="width: 15rem; margin-top: 20px;"><div class="card-body"><p class="card-text"><b>'+vid_2+'</b></p>'+htm_client_id+'<p class="'+claseTitulo+'"><b>'+evento_2+'</b></p><p class="card-text"><b>'+fechaHoraRegistro+'</b></p>'+textoBoton+'<p class="card-text"><small class="text-green"><b>'+revisadoPor+'</b></small></p></div></div></div>';

                            });
                            html = html+'</div></div></div>'
                            +'</div></div>';

                        });
                        html = html+'</div></div>';
                        $('#alertasRaiz').append(html);
                        muestraSwitches();
                    }else
                    {
                        $('#alertasRaiz').append('<div class="col-sm"><br><p>No hay resultados</p></div>');
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
            
            console.log('Hola atendiendose');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtBuscarVehiculo");
            filter = input.value.toUpperCase();

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("h2");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;
                var nombre = cards[i].id;
                
                var nombreEtiqueta = nombre.substring(7);
                console.log("nombre: "+nombreEtiqueta);

                spans = cards[i].getElementsByTagName("span");

                texto = spans[0].innerText; // Amarillas

                if(texto==="0"&& buscar==true)
                {
                    cards[i].style.display = "none";
                    continua=0;
                }else
                {
                    cards[i].style.display = "";
                    
                    table2 = document.getElementById(nombreEtiqueta);
                    cards2 = table2.getElementsByTagName("div");
 
                    for (j = 0; j < cards2.length; j++) 
                    {
                         

                        if(cards2[j].id==="tarjetasAlertas")
                        {
                            divRaiz = cards2[j].getElementsByTagName("div");
                            //console.log(divRaiz[0].getAttribute('class'));        
                            clase = divRaiz[0].getAttribute('class');
                            if(clase==="card text-center text-white bg-success mb-3")
                            {    
                                console.log("HA SIDO ENCOTRADO");
                                cards2[j].style.display = "";
                            }
                            else
                            {
                                if(buscar==true)
                                    cards2[j].style.display = "none";
                                else
                                    cards2[j].style.display = "";
                            }
                            
                        
                        }
                        
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

            console.log('Hola amarillas');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtBuscarVehiculo");
            filter = input.value.toUpperCase();

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("h2");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;
                var nombre = cards[i].id;
                
                var nombreEtiqueta = nombre.substring(7);
                console.log("nombre: "+nombreEtiqueta);

                spans = cards[i].getElementsByTagName("span");

                texto = spans[1].innerText; // Amarillas

                if(texto==="0"&& buscar==true)
                {
                    cards[i].style.display = "none";
                    continua=0;
                }else
                {
                    cards[i].style.display = "";
                    
                    table2 = document.getElementById(nombreEtiqueta);
                    cards2 = table2.getElementsByTagName("div");
 
                    for (j = 0; j < cards2.length; j++) 
                    {
                         

                        if(cards2[j].id==="tarjetasAlertas")
                        {
                            divRaiz = cards2[j].getElementsByTagName("div");
                            //console.log(divRaiz[0].getAttribute('class'));        
                            clase = divRaiz[0].getAttribute('class');
                            if(clase==="card text-center text-dark alert-custom mb-3")
                            {    
                                console.log("HA SIDO ENCOTRADO");
                                cards2[j].style.display = "";
                            }
                            else
                            {
                                if(buscar==true)
                                    cards2[j].style.display = "none";
                                else
                                    cards2[j].style.display = "";
                            }
                            
                        
                        }
                        
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
            
            console.log('Hola naranjas');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtBuscarVehiculo");
            filter = input.value.toUpperCase();

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("h2");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;
                var nombre = cards[i].id;
                
                var nombreEtiqueta = nombre.substring(7);
                console.log("nombre: "+nombreEtiqueta);

                spans = cards[i].getElementsByTagName("span");

                texto = spans[2].innerText; // Naranjas

                if(texto==="0"&& buscar==true)
                {
                    cards[i].style.display = "none";
                    continua=0;
                }else
                {
                    cards[i].style.display = "";
                    
                    table2 = document.getElementById(nombreEtiqueta);
                    cards2 = table2.getElementsByTagName("div");
 
                    for (j = 0; j < cards2.length; j++) 
                    {
                         

                        if(cards2[j].id==="tarjetasAlertas")
                        {
                            divRaiz = cards2[j].getElementsByTagName("div");
                            //console.log(divRaiz[0].getAttribute('class'));        
                            clase = divRaiz[0].getAttribute('class');
                            if(clase==="card text-center text-dark bg-warning mb-3")
                            {    
                                console.log("HA SIDO ENCOTRADO");
                                cards2[j].style.display = "";
                            }
                            else
                            {
                                if(buscar==true)
                                    cards2[j].style.display = "none";
                                else
                                    cards2[j].style.display = "";
                            }
                            
                        
                        }
                        
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

            console.log('Hola rojas');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtBuscarVehiculo");
            filter = input.value.toUpperCase();

            table = document.getElementById("columnaAlertas");
            cards = table.getElementsByTagName("h2");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;
                var nombre = cards[i].id;
                
                var nombreEtiqueta = nombre.substring(7);
                console.log("nombre: "+nombreEtiqueta);

                spans = cards[i].getElementsByTagName("span");

                texto = spans[3].innerText;

                if(texto==="0"&& buscar==true)
                {
                    cards[i].style.display = "none";
                    continua=0;
                }else
                {
                    cards[i].style.display = "";
                    
                    table2 = document.getElementById(nombreEtiqueta);
                    cards2 = table2.getElementsByTagName("div");
 
                    for (j = 0; j < cards2.length; j++) 
                    {
                         

                        if(cards2[j].id==="tarjetasAlertas")
                        {
                            divRaiz = cards2[j].getElementsByTagName("div");
                            //console.log(divRaiz[0].getAttribute('class'));        
                            clase = divRaiz[0].getAttribute('class');
                            if(clase==="card text-center text-dark bg-danger mb-3")
                            {    
                                console.log("HA SIDO ENCOTRADO");
                                cards2[j].style.display = "";
                            }
                            else
                            {
                                if(buscar==true)
                                    cards2[j].style.display = "none";
                                else
                                    cards2[j].style.display = "";
                            }
                            
                        
                        }
                        
                    }
                }
            }


        }

        function muestraSwitches()
    {
        var buscarAmarillas = $("#switchAmarillas").is(':checked');
        var buscarAtendiendose = $("#switchAtendiendose").is(':checked');
        var buscarNaranjas = $("#switchNaranjas").is(':checked');
        var buscarRojas = $("#switchRojas").is(':checked');

        if(buscarAmarillas==true)
        {
            muestraAmarillas();
        }else
        {
            if(buscarAtendiendose==true)
            {
                muestraAtendiendose();
            }else
            {
                if(buscarNaranjas==true)
                {
                    muestraNaranjas();
                }else
                {
                    if(buscarRojas==true)
                    {    
                        muestraRojas();
                    }
                }
                
            }
            
        }
        
    }
        
                
    });


    </script>
</body>
</html>

