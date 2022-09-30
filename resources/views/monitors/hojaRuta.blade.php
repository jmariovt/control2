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
            font-size: 9px;
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
        @include('common.errors')
        @include('common.success')
            
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Hoja de ruta</div>

                                <div class="card-body">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            
                                            <form class="form-group" method="POST" action="/xadmin/monitors/storeHojaRuta">
                                            <input class="form-control form-control-sm" type="hidden"  id="txtIdMonitoreo" name="txtIdMonitoreo" value='{{$IdMonitoreo ?? "" }}'>
                                            <input class="form-control form-control-sm" type="hidden"  id="txtUsuario" name="txtUsuario" value='{{$Usuario  ?? "" }}'>
                                            <input class="form-control form-control-sm" type="hidden"  id="txtCliente" name="txtCliente" value='{{$Cliente  ?? "" }}'>
                                            <input class="form-control form-control-sm" type="hidden"  id="txtTipo" name="txtTipo" value='{{$Tipo  ?? "" }}'>
                                            <?php
                                            try {
                                                if($datosCliente[0]->IdMonitoreo=="")
                                                    {   $styleButtonExcel = "display: none;";
                                                        $styleDispositivos = "";
                                                        $styleButtonEliminar = "";
                                                    }else    
                                                    {   $styleButtonExcel = "";
                                                        $styleDispositivos = "display: none;";
                                                        $styleButtonEliminar = "display: none;";
                                                    }
                                            } catch (\Throwable $th) {
                                                $styleButtonExcel = "display: none;";
                                                $styleDispositivos = "display: none;";
                                                $styleButtonEliminar = "display: none;";
                                            }
                                                    
                                                ?>
                                            <div style="{{$styleButtonExcel}}" >
                                                <a href="/xadmin/monitors/exportHojaRuta/{{$datosCliente[0]->IdMonitoreo}}/{{$datosCliente[0]->UsuarioMonitoreoControl}}/{{$Cliente}}" class="btn btn-success btn-sm">Exportar Excel</a>
                                            </div>
                                            <div style="{{$styleButtonEliminar}}" >
                                                <a href="/xadmin/monitors/eliminarHojaRuta/{{$IdMonitoreo}}/{{$datosCliente[0]->UsuarioMonitoreoControl}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar la hoja de ruta?')">Eliminar</a>
                                            </div>
                                                @csrf
                                                <div class="form-group" id="nombreCliente" >
                                                    <label for="txtNombreCliente">Nombre del cliente</label>
                                                    <?php
                                                        
                                                    
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="txtNombreCliente" name="txtNombreCliente" value="{{$Cliente}}">    
                                                </div>
                                                
                                                <div class="form-group" id="dispositivos" style="{{$styleDispositivos}}" >
                                                    <label for="chkNumeroDispositivos">Dispositivos a asignar:</label>
                                                    <select class="form-control form-control-sm" id="chkNumeroDispositivos" name="chkNumeroDispositivos">
                                                        <option value='1' >1</option>
                                                        <option value='2' >2</option>
                                                    </select>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">Información Monitoreo</div>

                                                        <div class="card-body">
                                                            <table >
                                                                <tr >
                                                                    <td colspan="6"><label>Datos contenedor</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtContenedorNombre">Número:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContenedorNombre" value="{{$datosCliente[0]->Numero_Contenedor}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtContenedorPies">Pies:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContenedorPies" value="{{$datosCliente[0]->Pies_Contenedor}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtContenedorTipoCarga">Tipo de carga:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContenedorTipoCarga" value="{{$datosCliente[0]->TipoCarga_Contenedor}}">
                                                                    </td>
                                                                </tr>
                                                                <tr >
                                                                    <td colspan="6"><label>Datos vehiculo</label></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtVehiculoPlaca">Placa:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtVehiculoPlaca" value="{{$datosCliente[0]->Placa}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtVehiculoMarca">Marca:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtVehiculoMarca" value="{{$datosCliente[0]->Marca}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtVehiculoColor">Color:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtVehiculoColor" value="{{$datosCliente[0]->Color}}">
                                                                    </td>
                                                                </tr>
                                                                <tr >
                                                                    <td  colspan="6"><label>Nombre y celular del chofer</label></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtChoferNombre">Nombre:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtChoferNombre" value="{{$datosCliente[0]->Chofer_Nombre}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtVehiculoMarca">Celular:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtChoferCelular" value="{{$datosCliente[0]->Chofer_Celular}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6"><label>Nombre y celular del acompañante</label></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtAcompananteNombre">Nombre:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtAcompananteNombre" value="{{$datosCliente[0]->Acompanante_Nombre}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtAcompananteCelular">Celular:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtAcompananteCelular" value="{{$datosCliente[0]->Acompanante_Celular}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6"><label>Ruta a seguir</label></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <input type="text" class="form-control form-control-sm" name="txtRutaSeguir" value="{{$datosCliente[0]->Ruta_A_Seguir}}">    
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6"><label>Origen</label></td>
                                                                </tr>
                                                                <?php
                                                                    
                                                                    if($datosCliente[0]->IdMonitoreo=="")
                                                                    {
                                                                        
                                                                        $fechaInicio = $datosCliente[0]->Fecha_Inicio;
                                                                    }else{
                                                                        $fechaInicio = now()->format('d/m/Y H:i');
                                                                    }
                                                                ?>
                                                                       
                                                                            <tr>
                                                                                <td>
                                                                                    <label for="txtFechaHoraOrigen">Fecha y hora:</label>
                                                                                </td>
                                                                                <td colspan="1">
                                                                                    <input type="text" class="form-control form-control-sm" id="txtFechaHoraOrigen" name="txtFechaHoraOrigen" value="{{$fechaInicio}}">
                                                                                </td>
                                                                            </tr>
                                                                    
                                                                
                                                                <tr>
                                                                    <td>
                                                                    <label for="txtOrigenCiudadLugar">Ciudad y lugar:</label>
                                                                    </td>
                                                                    <td colspan="5">
                                                                        <?php
                                                                            try {
                                                                                $ciudadorigen = $datosCliente[0]->Ciudad_Origen;
                                                                                $direccionorigen = $datosCliente[0]->Direccion_Origen;
                                                                            } catch (ErrorException $ex) {
                                                                                $arreglo_temporal = explode ("-",$datosCliente[0]->Direccion_Origen);
                                                                                $ciudadorigen = $arreglo_temporal[0];
                                                                                $direccionorigen = $arreglo_temporal[1];
                                                                            }
                                                                        ?>
                                                                        <input type="text" class="form-control form-control-sm" name="txtOrigenCiudadLugar" value="{{$ciudadorigen}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    <label for="txtOrigenDireccion">Direccion:</label>
                                                                    </td>
                                                                    <td colspan="5">
                                                                        <input type="text" class="form-control form-control-sm" name="txtOrigenDireccion" value="{{$direccionorigen}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6"><label>Destino</label></td>
                                                                </tr>


                                                                <?php
                                                                    if($datosCliente[0]->IdMonitoreo=="")
                                                                    {
                                                                        
                                                                        $fechaFin = $datosCliente[0]->Fecha_Fin;
                                                                    }else{
                                                                        $fechaFin = now()->format('d/m/Y H:i');
                                                                    }
                                                                    
                                                                ?>
                                                                        
                                                                            <tr>
                                                                                <td>
                                                                                    <label for="txtFechaHoraDestino">Fecha y hora:</label>
                                                                                </td>
                                                                                <td colspan="1">
                                                                                    <input type="text" class="form-control form-control-sm" id="txtFechaHoraDestino" name="txtFechaHoraDestino" value="{{$fechaFin}}">
                                                                                </td>
                                                                            </tr>
                                                                      
                                                                

                                                                <tr>
                                                                    <td>
                                                                    <label for="txtDestinoCiudadLugar">Ciudad y lugar:</label>
                                                                    </td>
                                                                    <td colspan="5">
                                                                    <?php
                                                                            try {
                                                                                $ciudaddestino = $datosCliente[0]->Ciudad_Destino;
                                                                                $direcciondestino = $datosCliente[0]->Direccion_Destino;
                                                                            } catch (ErrorException $ex) {
                                                                                $arreglo_temporal = explode ("-",$datosCliente[0]->Direccion_Destino);
                                                                                $ciudaddestino = $arreglo_temporal[0];
                                                                                $direcciondestino = $arreglo_temporal[1];
                                                                            }
                                                                        ?>
                                                                        <input type="text" class="form-control form-control-sm" name="txtDestinoCiudadLugar" value="{{$ciudaddestino}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    <label for="txtDestinoDireccion">Direccion:</label>
                                                                    </td>
                                                                    <td colspan="5">
                                                                        <input type="text" class="form-control form-control-sm" name="txtDestinoDireccion" value="{{$direcciondestino}}">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    
                                                </div>  
                                                <div class="card">
                                                    <div class="card-header">Contactos Informar Recorridos</div>

                                                        <div class="card-body">
                                                        <div class="row justify-content-center">
                                                            <table > 

                                                                <?php
                                                                    $contactosNombre1="";
                                                                    $contactosMail1="";

                                                                    $contactosNombre2="";
                                                                    $contactosMail2="";

                                                                    $contactosNombre3="";
                                                                    $contactosMail3="";
                                                                    if(strlen($datosCliente[0]->A_Informar_Recorrido)>0)
                                                                    {
                                                                        if(substr($datosCliente[0]->A_Informar_Recorrido,0,1)=="%")
                                                                        {
                                                                            $temporal = explode ( "%" , $datosCliente[0]->A_Informar_Recorrido ) ;
                                                                            $contactosInformacionRecorrido = $temporal[1];
                                                                        }
                                                                        else
                                                                            $contactosInformacionRecorrido = explode ( "%" , $datosCliente[0]->A_Informar_Recorrido ) ;
                                                                        switch (sizeof($contactosInformacionRecorrido)) {
                                                                            case 1:
                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[0]);
                                                                                $contactosNombre1 = $arreglo_temporal[0];
                                                                                $contactosMail1 = $arreglo_temporal[1];;

                                                                                
                                                                                break;
                                                                            case 2:
                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[0]);
                                                                                $contactosNombre1=$arreglo_temporal[0];
                                                                                $contactosMail1=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[1]);
                                                                                $contactosNombre2=$arreglo_temporal[0];
                                                                                $contactosMail2=$arreglo_temporal[1];

                                                                        
                                                                                break;
                                                                            case 3:
                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[0]);
                                                                                $contactosNombre1=$arreglo_temporal[0];
                                                                                $contactosMail1=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[1]);
                                                                                $contactosNombre2=$arreglo_temporal[0];
                                                                                $contactosMail2=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $contactosInformacionRecorrido[2]);
                                                                                $contactosNombre1=$arreglo_temporal[0];
                                                                                $contactosMail1=$arreglo_temporal[1];
                                                                                break;
                                                                            default:
                                                                                # code...
                                                                                break;
                                                                        }
                                                                    }

                                                                ?>
                                                                <tr>
                                                                    <td colspan="6"><label>Contactos para informar del recorrido durante el monitoreo:</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtContactosNombre1">Nombre:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosNombre1" value="{{$contactosNombre1}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtContactosEmail1">Email:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosEmail1" value="{{$contactosMail1}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtContactosNombre2">Nombre:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosNombre2" value="{{$contactosNombre2}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtContactosEmail2">Email:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosEmail2" value="{{$contactosMail2}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtContactosNombre3">Nombre:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosNombre3" value="{{$contactosNombre3}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtContactosEmail3">Email:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtContactosEmail3" value="{{$contactosMail3}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        Información Adicional
                                                    
                                                    </div>

                                                        <div class="card-body">
                                                        <div class="row justify-content-center">
                                                            <table > 

                                                                <?php
                                                                    $lugar1="";
                                                                    $tiempo1="";

                                                                    $lugar2="";
                                                                    $tiempo2="";

                                                                    $lugar3="";
                                                                    $tiempo3="";

                                                                    $lugar4="";
                                                                    $tiempo4="";

                                                                    $lugar5="";
                                                                    $tiempo5="";

                                                                    if(strlen($datosCliente[0]->Paradas_Permitidas)>0)
                                                                    {
                                                                        if(substr($datosCliente[0]->Paradas_Permitidas,0,1)=="%")
                                                                        {
                                                                            $temporal = explode ( "%" , $datosCliente[0]->Paradas_Permitidas ) ;
                                                                            $paradasPermitidas = $temporal[1];
                                                                        }
                                                                        else
                                                                            $paradasPermitidas = explode ( "%" , $datosCliente[0]->Paradas_Permitidas ) ;
                                                                        switch (sizeof($paradasPermitidas)) {
                                                                            case 1:
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[0]);
                                                                                $lugar1 = $arreglo_temporal[0];
                                                                                $tiempo1 = $arreglo_temporal[1];;

                                                                                
                                                                                break;
                                                                            case 2:
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[0]);
                                                                                $lugar1=$arreglo_temporal[0];
                                                                                $tiempo1=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[1]);
                                                                                $lugar2=$arreglo_temporal[0];
                                                                                $tiempo2=$arreglo_temporal[1];

                                                                        
                                                                                break;
                                                                            case 3:
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[0]);
                                                                                $lugar1=$arreglo_temporal[0];
                                                                                $tiempo1=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[1]);
                                                                                $lugar2=$arreglo_temporal[0];
                                                                                $tiempo2=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[2]);
                                                                                $lugar3=$arreglo_temporal[0];
                                                                                $tiempo3=$arreglo_temporal[1];
                                                                                break;
                                                                            case 4:
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[0]);
                                                                                $lugar1=$arreglo_temporal[0];
                                                                                $tiempo1=$arreglo_temporal[1];
    
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[1]);
                                                                                $lugar2=$arreglo_temporal[0];
                                                                                $tiempo2=$arreglo_temporal[1];
    
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[2]);
                                                                                $lugar3=$arreglo_temporal[0];
                                                                                $tiempo3=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[3]);
                                                                                $lugar4=$arreglo_temporal[0];
                                                                                $tiempo4=$arreglo_temporal[1];
                                                                                break;
                                                                            case 5:
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[0]);
                                                                                $lugar1=$arreglo_temporal[0];
                                                                                $tiempo1=$arreglo_temporal[1];
    
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[1]);
                                                                                $lugar2=$arreglo_temporal[0];
                                                                                $tiempo2=$arreglo_temporal[1];
    
                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[2]);
                                                                                $lugar3=$arreglo_temporal[0];
                                                                                $tiempo3=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[3]);
                                                                                $lugar4=$arreglo_temporal[0];
                                                                                $tiempo4=$arreglo_temporal[1];

                                                                                $arreglo_temporal = explode("-", $paradasPermitidas[4]);
                                                                                $lugar5=$arreglo_temporal[0];
                                                                                $tiempo5=$arreglo_temporal[1];
                                                                                break;
                                                                            default:
                                                                                # code...
                                                                                break;
                                                                        }
                                                                    }

                                                                ?>

                                                            <tr>
                                                                    <td colspan="6"><label>Paradas Permitidas:</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalLugar1">Lugar:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalLugar1" value="{{$lugar1}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalTiempo1">Tiempo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalTiempo1" value="{{$tiempo1}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalLugar2">Lugar:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalLugar2" value="{{$lugar2}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalTiempo2">Tiempo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalTiempo2" value="{{$tiempo2}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalLugar3">Lugar:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalLugar3" value="{{$lugar3}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalTiempo3">Tiempo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalTiempo3" value="{{$tiempo3}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalLugar4">Lugar:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalLugar4" value="{{$lugar4}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalTiempo4">Tiempo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalTiempo4" value="{{$tiempo4}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalLugar5">Lugar:</label>
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalLugar5" value="{{$lugar5}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtInfoAdicionalTiempo5">Tiempo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtInfoAdicionalTiempo5" value="{{$tiempo5}}">
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        </div>
                                                   
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        Plan de Accion
                                                    
                                                    </div>

                                                        <div class="card-body">
                                                            <table > 
                                                                <tr >
                                                                    <td colspan="6"><label>En caso de eventualidades llamar a</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtPlanNombre1">Nombre:</label>
                                                                    </td>
                                                                    <td>
                                                                        <?php

                                                                            $nombreSeveridad0 = "";
                                                                            $nombreSeveridad1 = "";
                                                                            $nombreSeveridad2 = "";

                                                                            $celularSeveridad0 = "";
                                                                            $celularSeveridad1 = "";
                                                                            $celularSeveridad2 ="";

                                                                            $correoSeveridad0 = "";
                                                                            $correoSeveridad1 = "";
                                                                            $correoSeveridad2 = "";


                                                                            if($datosCliente[0]->IdMonitoreo=="")
                                                                                {

                                                                                }
                                                                            else    
                                                                                {

                                                                                }
                                        
                                                                            try {
                                                                                $nombreSeveridad0 = $datosCliente[0]->Nombre_Severidad_0;
                                                                                $nombreSeveridad1 = $datosCliente[0]->Nombre_Severidad_1;
                                                                                $nombreSeveridad2 = $datosCliente[0]->Nombre_Severidad_2;

                                                                                $celularSeveridad0 = $datosCliente[0]->Celular_Severidad_0;
                                                                                $celularSeveridad1 = $datosCliente[0]->Celular_Severidad_1;
                                                                                $celularSeveridad2 = $datosCliente[0]->Celular_Severidad_2;

                                                                                $correoSeveridad0 = $datosCliente[0]->Correo_Severidad_0;
                                                                                $correoSeveridad1 = $datosCliente[0]->Correo_Severidad_1;
                                                                                $correoSeveridad2 = $datosCliente[0]->Correo_Severidad_2;
                                                                                
                                                                            } catch (ErrorException $ex) {

                                                                                $contadorParaVerAQueCamposSeAsignan = 0;
                                                                                foreach ($planesAccion as $planAccion) {
                                                                                    switch ($contadorParaVerAQueCamposSeAsignan) {
                                                                                        case 0:
                                                                                            $nombreSeveridad0 = $planAccion->Detalle;
                                                                                            $arreglo_temporal = explode(" ",$planAccion->Observaciones);
                                                                                            $celularSeveridad0 = $arreglo_temporal[0];
                                                                                            $correoSeveridad0 = $arreglo_temporal[1];
                                                                                            break;
                                                                                        case 1:
                                                                                            $nombreSeveridad1 = $planAccion->Detalle;
                                                                                            $arreglo_temporal = explode(" ",$planAccion->Observaciones);
                                                                                            $celularSeveridad1 = $arreglo_temporal[0];
                                                                                            $correoSeveridad1 = $arreglo_temporal[1];
                                                                                            break;
                                                                                        case 2:
                                                                                            $nombreSeveridad2 = $planAccion->Detalle;
                                                                                            $arreglo_temporal = explode(" ",$planAccion->Observaciones);
                                                                                            $celularSeveridad2 = $arreglo_temporal[0];
                                                                                            $correoSeveridad2 = $arreglo_temporal[1];
                                                                                            break;
                                                                                        default:
                                                                                            # code...
                                                                                            break;
                                                                                    }
                                                                                    $contadorParaVerAQueCamposSeAsignan = $contadorParaVerAQueCamposSeAsignan + 1;
                                                                                }
                                                                                
                                                                                
                                                                            }
                                                                        ?>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanNombre1" value="{{$nombreSeveridad0}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCelular1">Celular:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCelular1" value="{{$celularSeveridad0}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCorreo1">Correo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCorreo1" value="{{$correoSeveridad0}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtPlanNombre2">Nombre:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanNombre2" value="{{$nombreSeveridad1}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCelular2">Celular:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCelular2" value="{{$celularSeveridad1}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCorreo2">Correo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCorreo2" value="{{$correoSeveridad1}}">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="txtPlanNombre3">Nombre:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanNombre3" value="{{$nombreSeveridad2}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCelular3">Celular:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCelular3" value="{{$celularSeveridad2}}">
                                                                    </td>
                                                                    <td>
                                                                        <label for="txtPlanCorreo3">Correo:</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm" name="txtPlanCorreo3" value="{{$correoSeveridad2}}">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                   
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <a href="/xadmin/monitors/clienteMonitoreo" class="btn btn-secondary">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary">Grabar y enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
    </div>
</body>

<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
<script type="text/javascript">
   
        $('#txtFechaHoraOrigen').datetimepicker({
            format: 'd/m/Y H:i',
            changeYear: true,
            minDate: 0,
            onShow: function(ct) {
                this.setOptions({
                    maxDate: $('#txtFechaHoraDestino').val() ? $('#txtFechaHoraDestino').val() : false
                    }) 
                }
            
            
        })

        $('#txtFechaHoraDestino').datetimepicker({
            format: 'd/m/Y H:i',
            onShow: function(ct) 
            {
                this.setOptions({
                    minDate: $('#txtFechaHoraOrigen').val() ? $('#txtFechaHoraOrigen').val() : false
                    }) 
            }
            
            
            
        })
        

        


   
</script>