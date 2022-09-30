<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xadmin') }}</title>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
    

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
<!--    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <!-- Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    

       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">
    
    <!-- Este estilo es para la tabla principal de los montoreos -->
    <style type="text/css">
        .table-condensed{
            font-size: 12px;
            }
    </style>

    <style type="text/css">
        .bg-card-orange {
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>

<!-- JS, Popper.js, and jQuery -->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">

    <!-- Script Agregado para autocompletar-->
    <!--<script src="{{asset('jquery-3.3.1.min.js')}}" type="text/javascript"></script>-->
    

    


</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/ingresarClienteMonitoreo">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Consultar, actualizar o eliminar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/asociarClienteMonitoreo">Asociar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @include('common.success')
        <div class="container-fluid">
        <input class="form-control form-control-sm" type="text" onkeyup="buscaClientesMonitoreosInput()" placeholder="Buscar..." id="inputBuscarClientesMonitoreo" name="inputBuscarClientesMonitoreo" >
        <table class="table table-condensed table-hover table-striped table-bordered" id="tablaMonitoreos" name="tablaMonitoreos">
        <form class="form-group" method="POST" action="">
                				<thead >
				                    <tr>
										<th>ID</th>
				                        <th>Cliente</th>
				                        <th>Email</th>
				                        <th>Tipo</th>
				                        <th>Estado</th>
				                        <th>Válido hasta</th>
				                        <th>Activos</th>
				                        <!--<th colspan="1">&nbsp;</th> era columna para modificar-->
				                        <!--<th>Alertas</th> la asignacion se la realiza en la creacion-->
				                        <th>Activos asignados</th>
				                        <!--<th>P. Acción</th> la accion sera asignada en la creacion-->
				                        <th>Asociado A</th>
				                        <th>Env. Correo</th>
										<th>Hojas de Ruta</th>
										<th>Reportes</th>
                                        <th>&nbsp;</th>
                                        <!--<th>&nbsp;</th>-->
                                        <th>&nbsp;</th>
										
				                    </tr>
				                </thead>
				                <tbody id="tbodyMonitoreos" name="tbodyMonitoreos">
                                    @foreach($clientes as $cliente)
				                	 <tr>
									 	<td>{{$cliente->Id}}</td>
				                        <td>{{$cliente->Cliente}}</td>
				                        <td>{{$cliente->Email}}</td>
										
										<td>{{$cliente->Tipo}}</td>
										
										
				                        
				                        <td>
                                        
                                        
                                        
                                            

                                            <?php
                                                    if($cliente->Estado=="A ") //Se encontró un espacio después del caracter
                                                    {
                                                        $selectedA = "selected";
                                                        $selectedI = "";
                                                    }else
                                                    {
                                                        $selectedA = "";
                                                        $selectedI = "selected";
                                                    }
                                                    $idHtmlEstado = "estado_".$cliente->UsuarioControl;
                                                        
                                                ?>
                                                    <select class="form-control-sm" id="{{$idHtmlEstado}}">
                                                        <option value="A " {{$selectedA}}>A</option>
                                                        <option value="I " {{$selectedI}}>I</option>
                                                    </select>
                                        
                                        
                                        </td>
				                        <td>
                                            <?php

                                                if($cliente->FechaFin=="NO APLICA")
                                                 {

                                                    ?>
                                                    {{$cliente->FechaFin}}
                                                    <?php
                                                 }else
                                                 { $idHtmlFechaFin = $cliente->UsuarioControl;
                                                    $fechaFin = substr($cliente->FechaFin, 0, 16);
                                                    ?>
                                                    <input type="text" class="datetimepicker" id="{{$idHtmlFechaFin}}" value="{{$fechaFin}}" autocomplete="off">
                                                    <?php
                                                 }
                                                ?>
                                        </td>
				                        <td>
                                        
                                                    <?php
                                                        if($cliente->Activos!='N/A')
                                                         {   ?>
                                                                <a href="/xadmin/monitors/asignarActivo/{{$cliente->UsuarioControl}}" class="" target="_blank" onclick="window.open('/xadmin/monitors/asignarActivo/{{$cliente->UsuarioControl}}','newwindow','width=900,height=900'); return false;">{{$cliente->Activos}}</a>
                                                            <?php
                                                         }else    
                                                          {  ?>
                                                            {{$cliente->Activos}}
                                                            <?php
                                                          }

                                                    ?>
                                        </td>
				                        <!--<td>&nbsp;</td> era columna para modificar-->
				                        <!--<td>Asignar Copiar</td>-->
				                        <td>
										

                                        <?php
											$detalleActivos = explode("%",$cliente->DetalleActivos);
											foreach ($detalleActivos as $detalleActivo) {
												$arregloActivo = explode(";",$detalleActivo);
												
												if(isset($arregloActivo[1]))
												{?>
													{{$arregloActivo[2]}} - {{$arregloActivo[3]}} <a href="/xadmin/monitors/deleteActivo/{{$arregloActivo[0]}}/{{$cliente->UsuarioControl}}" onclick="return confirm('¿Está seguro de eliminar el activo?')"> [x]</a><br>
												<?php
												}
											}
										?>
							
										
										
										
										</td>
				                        <!--<td>Accion</td>-->
				                        <td>
                                            {{$cliente->DetalleAsociados}}
										</td>
				                        <td>
                                            
                                            <?php
                                                if($cliente->EnviarCorreo=='1')
                                                {
                                                    $enviarCorreo="SI";
                                                    $selectedSi = "selected";
                                                    $selectedNo = "";
                                                }
                                                else
                                                {
                                                    $enviarCorreo="NO";
                                                    $selectedSi = "";
                                                    $selectedNo = "selected";
                                                }
                                                $idHtmlEnviarCorreo = "enviarCorreo_".$cliente->UsuarioControl;
                                                    
                                            ?>
                                                <select class="form-control-sm" id="{{$idHtmlEnviarCorreo}}">
											      <option value="1" {{$selectedSi}}>SI</option>
											      <option value="0" {{$selectedNo}}>NO</option>
											      
											    </select>
                                            
                                        </td	>
				                        <td> 
                                            
                                            <?php
                                                $detalleHojasRuta = explode("%",$cliente->DetalleHojaRuta);
                                                foreach ($detalleHojasRuta as $detalleHojaRuta) {
                                                    $arregloHojaRuta = explode(";",$detalleHojaRuta);
                                                    if(isset($arregloHojaRuta[4]))
                                                    {?>
                                                        <a href="/xadmin/monitors/mostrarHojaRuta/{{$arregloHojaRuta[0]}}/{{$arregloHojaRuta[1]}}/{{$arregloHojaRuta[2]}}/{{$arregloHojaRuta[3]}}" >{{$arregloHojaRuta[4]}}</a></br>
                                                    <?php
                                                    }
                                                }

                                            ?>
                                        
                                        
                                        </td	>
										<td><a href="/xadmin/monitors/reportesClienteMonitoreo/{{$cliente->UsuarioControl}}" class="btn btn-primary btn-sm" target="_blank" onclick="window.open('/xadmin/monitors/reportesClienteMonitoreo/{{$cliente->UsuarioControl}}','reportesClienteMonitoreo','width=900,height=900'); return false;">Reportes</a></td	>
                                        <td><button type="button"  class="btn btn-outline-primary btn-sm" id="btnActualizarCliente" onclick="actualizarUsuario('{{$cliente->UsuarioControl}}')">Actualizar</button></td	>
                                        <!--<td><a href="/xadmin/monitors/borrarCliente/{{$cliente->UsuarioControl}}" class="btn btn-secondary btn-sm">Eliminar</a></td	>-->
                                        <td><a href="/xadmin/monitors/enviarMailUsuario/{{$cliente->UsuarioControl}}" class="btn btn-secondary btn-sm">Correo</a></td	>
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
        </form>
        </table>
            
        </div>
    </div>
                        
</body>

<script type="text/javascript">
    function buscaClientesMonitoreosInput()
    {
        console.log('Hola');
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarClientesMonitoreo");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            for(j=0;j<14;j++)
            {
                if(continua==1)
                {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            continua=0;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            
        }
    }
</script>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){


        /*$( "#btnActualizarCliente" ).click(function(){
            
            
            
            
            $.ajax({
                url:"{{route('monitors.actualizarCliente')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    validoHasta: $("#txtBuscarActivo").val(),
                    usuario: $("#txtUsuario").val(),
                    estado: $("#").val(),
                    enviarCorreo: $("#").val()
                        
                    
                    },
                    success: function( response ) {
                        console.log("Asignó activo");
                        alert("Asignó activo correctamente");
                        window.close();
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                            console.log("Trajo "+len+" datos");
                            
                        }
                    }
                });
        });*/


        
    });

    function actualizarUsuario(usuario)
        {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var confirmacion = confirm('¿Está seguro de actualizar el cliente '+ usuario +'?');
            if(confirmacion)
            {
                console.log('Se desea actualizar');
                if (document.getElementById(usuario) == null) {
                    var fechaFin = "";
                }else{    
                    var fechaFin = document.getElementById(usuario).value;
                }
                    var estado = document.getElementById("estado_" + usuario).value;
                    var enviarCorreo = document.getElementById("enviarCorreo_" + usuario).value;

                      $.ajax({
                          url: "{{route('monitors.actualizarCliente')}}",
                          type: "POST",
                          dataType: "json",
                          data: {   _token: CSRF_TOKEN, 
                                    usuario : usuario , 
                                    estado : estado, 
                                    validoHasta : fechaFin , 
                                    enviarCorreo: enviarCorreo 
                                },
                          success: function(response) 
                          {
                                console.log("Asignó activo");
                                console.log(response);
                                
                                if(response['data'] != null)
                                {
                                    len = response['data'].length;
                                    console.log("Trajo "+len+" datos");
                                    alert(response['data'].resultado);
                                }

                          }
                      });
                
            }else{
                console.log('No se desea actualizar');
            }
        }



</script>

<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
<script type="text/javascript">
   
        $('.datetimepicker').datetimepicker({
            format: 'd/m/Y H:i',
            changeYear: true,
            minDate: 1,
            /*onShow: function(ct) {
                this.setOptions({
                    maxDate: $('.datetimepicker').val() ? $('.datetimepicker').val() : false
                    }) 
                },*/
            /*onChange: function(ct){
                var txtTo = ct.date.add(2)
                $('.datetimepicker').val(txtTo.format('d/m/Y H:i'))
            }*/
            
        })
</script>