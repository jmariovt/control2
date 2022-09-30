<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xadmin') }}</title>

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
    <script src="{{asset('js/jquery.highlight-5.js')}}" type="text/javascript"></script>
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



    


</head>

<body>
    <div id="app" >
        

        <!--<main class="py-4">
            
        </main>-->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        

                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <form class="form-group" method="POST" action="/xadmin/alerts/exportSeguimientoAlertas">
                                    @csrf
                                    <?php
                                        $idSubUsuario = session('idSubUsuario');
                                    ?>
                                        <input type="hidden" class="form-control form-control-sm" id="idSubUsuario" name="idSubUsuario" value="{{$idSubUsuario}}">
                                        <table class="table table-primary table-sm">
                                        <!-- 'motivosAlerta','agentes','productos','dispositivos' -->
                                            <tbody>
                                                <tr>
                                                    <td align="right"><font size=2>Buscar:</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text" placeholder="Unidad" id="unidadBuscar" name="unidadBuscar" value="{{ old('unidadBuscar')}}">
                                                        <input class="form-control form-control-sm" type="hidden"  id="idActivo" name="idActivo" value="{{ old('idActivo')}}" >
                                                        
                                                        <!--<div class="form-group">
                                                            <label for="buscarPor">Buscar por</label>
                                                            <select class="form-control form-control-sm" id="buscarPor">
                                                                <option value="0">Placa</option>
                                                                <option value="1">CodSysHunter</option>
                                                                <option value="2">VID</option>
                                                                <option value="3">Chasis</option>
                                                                <option value="4">Motor</option>
                                                            </select>
                                                        </div>-->
                                                    </td>
                                                    <td align="right"><font size=2>Desde</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text" placeholder="Desde" id="fechaDesde" name="fechaDesde" value="{{$fechaDesde}}" autocomplete="off">
                                                    </td>

                                                    <td align="right"><font size=2>Hasta</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" id="fechaHasta" name="fechaHasta" type="text" placeholder="Hasta" value="{{$fechaHasta}}" autocomplete="off">
                                                    </td>

                                                    <td align="right"><font size=2>Motivo alerta</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="motivoAlerta">
                                                                @foreach($motivosAlerta as $motivoAlerta)
                                                                    <option value="{{$motivoAlerta->Codigo}}">{{$motivoAlerta->Descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td align="right"><font size=2>Agente</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="agente" name="agente">
                                                                @foreach($agentes as $agente)
                                                                    <!--<option value="{{$agente->Descripcion}}">{{$agente->Descripcion}}</option>-->
                                                                    <?php
                                                                        $nombreUsuario = session('nombre');
                                                                        $idUsuario = session('idUsuario');
                                                                        $idSubUsuario = session('idSubUsuario');
                                                                        $idCategoria = session('idCategoria');
                                                                        $perfil = session('perfil');

                                                                        if($idSubUsuario=="0")
                                                                        {
                                                                    ?>
                                                                        <option value="{{$agente->Descripcion}}">{{$agente->Descripcion}}</option>
                                                                        <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            if($idCategoria=="9" || (strpos($perfil,'1002')!==false) )
                                                                            {
                                                                                
                                                                        ?>
                                                                                <option value="{{$agente->Descripcion}}">{{$agente->Descripcion}}</option>
                                                                        <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                Log::info('Mariolog: Comparar nombreUsuario y agente '.$nombreUsuario.' agente: '.$agente->Descripcion);
                                                                                if($nombreUsuario==$agente->Descripcion || strpos($agente->Descripcion,$nombreUsuario)!==false)
                                                                                {
                                                                        ?>
                                                                                <option value="{{$agente->Descripcion}}">{{$agente->Descripcion}}</option>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Producto</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="producto">
                                                                @foreach($productos as $producto)
                                                                    <option value="{{$producto->Descripcion}}">{{$producto->Descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Dispositivo</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="dispositivo">
                                                                @foreach($dispositivos as $dispositivo)
                                                                    <option value="{{$dispositivo->Descripcion}}">{{$dispositivo->Descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Tipo Alerta</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="tipoAlerta">
                                                                <option value="0" selected>Todos</option>
                                                                <option value="1">Monitoreo</option>
                                                                <option value="3">Producto</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if($idSubUsuario=="0")
                                                <tr>
                                                    <td align="right"><font size=2>Alertas repetidas</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="alertasRepetidas">
                                                                <option value="" selected></option>
                                                                <option value="SI">SI</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Casos enviados</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="casosEnviados">
                                                                <option value="" selected></option>
                                                                <option value="SI">SI</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Robos</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="robos">
                                                                <option value="" selected></option>
                                                                <option value="SI">SI</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Datos Incorrectos</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="datosIncorrectos">
                                                                <option value="" selected></option>
                                                                <option value="SI">SI</option>
                                                                <option value="NO">NO</option>  
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="8" align="center">
                                                        <button type="button" class="btn btn-outline-primary btn-sm " id="btSeguimientoAlertaBuscar" name="btSeguimientoAlertaBuscar">Buscar</button>
                                                        <button type="submit" class="btn btn-outline-success btn-sm " id="btSeguimientoAlertaBuscar" name="btSeguimientoAlertaBuscar">Exportar</button>
                                                        <!--<a href="/xadmin/alerts/pruebaSeguimientoAlertas" class="btn btn-outline-primary btn-sm">Pruebasss</a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" align="center">
                                                        <div id="areaImagen" style="display: none;">
                                                            <img src="{{asset('Imagenes/cargando.gif')}}" width="40"  height="40"  id="imagenBuscando" >
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    
                                        <table class="table table-primary table-sm">
                                        
                                            <tbody>
                                                <tr>
                                                    <td align="right"><font size=2>Total alertas generadas</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="totalAlertasGeneradas" name="totalAlertasGeneradas" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Total alertas atendidas</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="totalAlertasContestadas" name="totalAlertasContestadas" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Promedio alertas atendidas</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promedioAlertasContestadas" name="promedioAlertasContestadas" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Tiempo respuesta promedio</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="tiempoRespuestaPromedio" name="tiempoRespuestaPromedio" value=''>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"<font size=2>Prom. robos</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promRobos" name="promRobos" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Prom. casos enviados</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promCasosEnviados" name="promCasosEnviados" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Prom. repetidas</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promRepetidas" name="promRepetidas" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Prom. datos incorrectos</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promDatosIncorrectos" name="promDatosIncorrectos" value=''>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right" ><font size=2>Total alertas atendidas por agentes</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="totalAlertasContestadasAgente" name="totalAlertasContestadasAgente" value=''>
                                                    </td>
                                                    <td align="right"><font size=2>Prom. alertas atendidas x agentes</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promAlertasContestadasAgente" name="promAlertasContestadasAgente" value=''>
                                                    </td>
                                                    <td align="right" ><font size=2>Prom. alertas total contestadas x agente</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text"  id="promAlertasTotalContestadasAgente" name="promAlertasTotalContestadasAgente" value=''>
                                                    </td>
                                                    
                                                </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                    <table class="table table-condensed table-hover table-striped" id="tablaAlertas" name="tablaAlertas" width="100%" >
                                        <thead >
                                            <tr>
                                                <th width="8%">Nombre Cliente</th>
                                                @if($idSubUsuario=="0")
                                                    <th width="8%">VID</th>
                                                    <th width="8%">CodSysHunter</th>
                                                @endif
                                                <th width="8%">Alias</th>
                                                @if($idSubUsuario=="0")
                                                    <th width="12%">Producto</th>
                                                    <th width="8%">Dispositivo</th>
                                                @endif
                                                <th width="8%">Alerta</th>
                                                <th width="8%">Estado de Alerta</th>
                                                <th width="4%">Fecha Ocurrencia</th>
                                                <th width="16%">Fecha Gestion</th>
                                                <th width="8%">Agente Gestión</th>
                                                <th width="8%">Gestión</th>
                                                <th width="8%">Motivo Alerta</th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyAlertas" name="tbodyAlertas">
                                            <tr>
                                                <td colspan="13">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</body>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#btSeguimientoAlertaBuscar" ).click(function(){

                // SIN USAR
           
                console.log($("#tipoAlerta").val());

                $('#totalAlertasGeneradas').val('');
                $('#totalAlertasContestadas').val('');
                $('#promedioAlertasContestadas').val('');
                $('#tiempoRespuestaPromedio').val('');
                $('#promRobos').val('');
                $('#promCasosEnviados').val('');
                $('#promRepetidas').val('');
                $('#promDatosIncorrectos').val('');
                $('#totalAlertasContestadasAgente').val('');
                $('#promAlertasContestadasAgente').val('');
                $('#promAlertasTotalContestadasAgente').val('');
               

                var fechaDesde = $("#fechaDesde").val();
                var fechaHasta = $("#fechaHasta").val();
                var tipoAlerta = $("#tipoAlerta").val();
                var unidadBuscar = $("#unidadBuscar").val();
                var idActivo = $("#idActivo").val();

                if(unidadBuscar=="")
                    idActivo = "0";

                

                agente = $("#agente").val();
                producto = $("#producto").val();
                dispositivo = $("#dispositivo").val();
                motivoAlerta = $("#motivoAlerta").val();
                var alertasRepetidas = $("#alertasRepetidas").val();
                var casosEnviados = $("#casosEnviados").val();
                var robos = $("#robos").val();
                var datosIncorrectos=  $("#datosIncorrectos").val()

                if(fechaDesde == null)
                    fechaDesde = '';
                if(fechaHasta == null)
                    fechaHasta = '';
                if(tipoAlerta == null)
                    tipoAlerta = '';
                if(unidadBuscar == null)
                    unidadBuscar = '';
                if(idActivo == null)
                    idActivo = '';
                if(agente == null || agente == 'TODOS')
                    agente = '';
                if(producto == null)
                    producto = '';
                if(dispositivo == null)
                    dispositivo = '';
                if(motivoAlerta == null)
                    motivoAlerta = '';
                if(alertasRepetidas == null)
                    alertasRepetidas = '';
                if(casosEnviados == null)
                    casosEnviados = '';
                if(robos == null)
                    robos = '';
                if(datosIncorrectos == null)
                    datosIncorrectos = '';
                if(unidadBuscar == null)
                    unidadBuscar = '';

                console.log('Buscar IdActivo: '+idActivo);
                if (fechaDesde=="" || fechaHasta=="" )
                {
                    alert('Verifique los datos ingresados para Continuar');
                    return false;
                }else{
                    $("#areaImagen").show();
                    $("#tbodyAlertas").empty();
                }



                $.ajax({
                    url:"{{route('alerts.seguimientoAlertasBuscar')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta,
                        tipoAlerta: tipoAlerta,
                        unidadBuscar: unidadBuscar,
                        idActivo: idActivo,
                        agente: agente,
                        producto: producto,
                        dispositivo: dispositivo,
                        motivoAlerta: motivoAlerta,
                        alertasRepetidas: alertasRepetidas,
                        casosEnviados: casosEnviados,
                        robos: robos,
                        datosIncorrectos: datosIncorrectos
                        
                    
                    },
                    success: function( response ) 
                    {
                        console.log('hola');
                        console.log(response);
                        $("#areaImagen").hide();
                        $("#alertas").empty();

                        $('#totalAlertasGeneradas').val(response['totalAlertas']);
                        $('#totalAlertasContestadas').val(response['totalAlertasResueltas']);
                        $('#promedioAlertasContestadas').val(response['promedioAlertasContestadas']);
                        $('#tiempoRespuestaPromedio').val(response['tiempoRespuestaPromedio']);
                        $('#promRobos').val(response['alertasRobos']);
                        $('#promCasosEnviados').val(response['alertasCasosEnviados']);
                        $('#promRepetidas').val(response['alertasRepetidas']);
                        $('#promDatosIncorrectos').val(response['alertasDatosIncorrectos']);
                        $('#totalAlertasContestadasAgente').val(response['totalAlertasXAgente']);
                        $('#promAlertasContestadasAgente').val(response['promedioAlertasContestadasXAgente']);
                        $('#promAlertasTotalContestadasAgente').val(response['promedioAlertasTotalesXAgente']);

                        var sp = response['sp'];
                        console.log('SP: '+sp);

                        
                        var len = 0;
                        if(response['alertas'] != null)
                        {
                            len = response['alertas'].length;
                            console.log("Trajo "+len+" alertas");
                            $("#tbodyAlertas").empty();
                        }
                        
                        if(len==0)
                        {
                            
                            $('#tablaAlertas > tbody:last-child').append('<tr><td>No hay resultados a mostrar</td></tr>');
                        }
                        
                        for(var i=0; i<len; i++)
                        {

                            


                            /*if(response['data'][i].EstadoAlarma==0)
                            {
                                var clase = 'card text-center text-dark alert-custom  mb-3';
                                var claseTitulo='card-title text-dark';
                            }
                            
                           
                            if(response['data'][i].EstadoAlarma==1)
                            {
                                var clase = 'card text-center text-dark alert-custom mb-3';
                                var claseTitulo='card-title text-warning bg-dark';
                            }
                                
                            if(response['data'][i].EstadoAlarma==2)
                            {
                                var clase = 'card text-center text-dark  alert-custom mb-3';
                                var claseTitulo='card-title text-danger bg-dark';
                            }
                                
                            if(response['data'][i].EstadoAlarma==5)
                            {
                                var clase = 'card text-center text-dark bg-danger mb-3';
                                var claseTitulo='card-title text-dark';
                            }

                            var vid = response['alertas'][i].VID;
                            var evento = response['alertas'][i].Evento;
                            var vid_2 = vid.substring(0,15);
                            var evento_2 = evento.substring(0,21);
                            var fechaHoraRegistro = response['data'][i].FechaHoraRegistro;
                            var secuencia = response['data'][i].Secuencia;

                            
                            $('#alertas').append('<div class="col-sm"><div class="'+clase+'" style="width: 15rem; margin-top: 20px;"><div class="card-header">'+vid_2+'</div><div class="card-body"><p class="'+claseTitulo+'">'+evento_2+'</p><p class="card-text">'+fechaHoraRegistro+'</p><a href="/xadmin/alerts/show/'+secuencia+'" class="btn btn-outline-primary" target="_blank" onclick="window.open(\'/xadmin/alerts/show/'+secuencia+'\',\'newwindow\',\'width=900,height=900\'); return false;">Ver alerta</a></div><div class="card-footer"><small class="text-success">'+revisadoPor+'</small></div></div></div>');
                        */
                            var nombreCliente = response['alertas'][i].NombreCliente;
                            var vid = response['alertas'][i].VID;
                            var codSysHunter = response['alertas'][i].CodSysHunter;
                            var alias = response['alertas'][i].Alias;
                            var producto = response['alertas'][i].Producto;
                            var dispositivo = response['alertas'][i].Dispositivo;
                            var alerta = response['alertas'][i].Alerta;
                            var estadoAlarma = response['alertas'][i].EstadoAlarma;
                            var fechaOcurrencia = response['alertas'][i].FechaOcurrencia;
                            var fechaGestion = response['alertas'][i].FechaGestion;
                            var nombreAgente = response['alertas'][i].NombreAgente;
                            var gestion = response['alertas'][i].Gestion;
                            var motivoAlerta = response['alertas'][i].MotivoAlerta;

                            //var idSubUsuario = response['alertas'][i].idSubUsuario;
                            var idSubUsuario = $('#idSubUsuario').val();

                           
                            
                            if(idSubUsuario=="0")
                            {
                                htmlvid_csh = '<td>'+vid+'</td><td>'+codSysHunter+'</td>';
                                htmlproducto_dispositivo = '<td>'+producto+'</td><td>'+dispositivo+'</td>'; 
                               
                            }else
                            {
                               

                                vid = '';
                                codSysHunter = '';
                                htmlvid_csh = '';
                                htmlproducto_dispositivo = '';
                            }
                            
                            $('#tablaAlertas > tbody:last-child').append('<tr><td>'+nombreCliente+'</td>'+htmlvid_csh+'<td>'+alias+'</td>'+htmlproducto_dispositivo+'<td>'+alerta+'</td><td>'+estadoAlarma+'</td><td>'+fechaOcurrencia+'</td><td>'+fechaGestion+'</td><td>'+nombreAgente+'</td><td>'+gestion+'</td><td>'+motivoAlerta+'</td></tr>');


                        }
                        
                        //response( data );
                        
                    }
                });
                
           
        });
    });
</script>

<script type="text/javascript" src="{{asset('js/jquery.selectlistactions.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>

<script type="text/javascript">
   
        $('#fechaDesde').datetimepicker({
            format: 'd/m/Y H:i:00',// 00:00:00',//'Ymd H:i:s',
            changeYear: false,
            minDate: 1//,
            //onShow: function(ct) {
            //    this.setOptions({
            //        maxDate: $('#fechaHasta').val() ? $('#fechaHasta').val() : false
            //        }) 
            //    }
            
            
        })
        $('#fechaHasta').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd/m/Y H:i:59',// 23:50:00',//'Ymd H:i:s',
            //onShow: function(ct) 
            //{
            //    this.setOptions({
            //        minDate: $('#fechaDesde').val() ? $('#fechaDesde').val() : false
            //        }) 
            //}
            
        })

</script>



<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#unidadBuscar" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        {
            
            // Fetch data
            $.ajax({
                url:"{{route('assets.buscarActivoConId')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    buscar: $("#buscarPor").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
            select: function (event, ui) {
            // Set selection
            $('#unidadBuscar').val(ui.item.label); // display the selected text
            $('#idActivo').val(ui.item.value); // save selected id to input
            console.log('IdActivo: '+ui.item.value);
            
            return false;
        }
  });
});
</script>