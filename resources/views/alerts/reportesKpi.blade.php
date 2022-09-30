<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EGadmin') }}</title>

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
                                    <table class="table table-primary table-sm">
                                        <!-- 'motivosAlerta','agentes','productos','dispositivos' -->
                                        <form class="form-group" method="POST" action="/xadmin/alerts/exportAlertasPorMonitorista">
                                            @csrf
                                            <tbody>
                                                <tr>
                                                    <td align="right"><font size=2>Desde</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="text" placeholder="Desde" id="fechaDesde" name="fechaDesde" value="{{$fechaDesde}}" autocomplete="off">
                                                    </td>

                                                    <td align="right"><font size=2>Hasta</font></td>
                                                    <td>
                                                        <input class="form-control form-control-sm" id="fechaHasta" name="fechaHasta" type="text" placeholder="Hasta" value="{{$fechaHasta}}" autocomplete="off">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><font size=2>Agente</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                        <input class="form-control form-control-sm" id="kpiPlaca" name="kpiPlaca" type="text" placeholder="Placa"  autocomplete="off">
                                                        </div>
                                                    </td>
                                                    <td align="right"><font size=2>Grupos</font></td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control-sm" id="grupo" name="grupo">
                                                                @foreach($grupos as $grupo)
                                                                    <option value="{{$grupo->Descripcion}}">{{$grupo->Descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                        <td colspan="5" align="center">
                                                            <button type="button" class="btn btn-outline-primary btn-sm " id="btSeguimientoAlertaBuscarAgrupados" name="btSeguimientoAlertaBuscarAgrupados">Buscar</button>
                                                            <button type="submit" class="btn btn-outline-success btn-sm " id="btSeguimientoAlertaExportarAgrupados" name="btSeguimientoAlertaExportarAgrupados">Exportar</button>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="center">
                                                            <div id="areaImagen" style="display: none;">
                                                                <img src="{{asset('Imagenes/cargando.gif')}}" width="40"  height="40"  id="imagenBuscando" >
                                                            </div>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </form>
                                    </table>
                                    <?php
                                        $idSubUsuario = session('idSubUsuario');
                                    ?>

                                    <table class="table table-condensed table-hover table-striped" id="tablaAlertas" name="tablaAlertas" width="100%" >
                                        <thead >
                                            <tr>
                                                <th width="5%">Viajes</th>
                                               
                                                <th width="4%">Clientes Plan.</th>
                                                
                                                <th width="4%">Salida del CD</th>
                                                <th width="4%">Hora Visita 1er Cliente</th>
                                                <th width="4%">Stem Ida</th>
                                                <th width="4%">Tiempo en ruta</th>
                                                <th width="4%">Tiempo promedio de respuesta real</th>
                                                <th width="4%">Paradas no plan</th>
                                                <th width="4%">Visita ultimo cliente</th>
                                                <th width="4%">Stem retorno</th>
                                                <th width="4%">Retorno CD</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyAlertas" name="tbodyAlertas">
                                            <tr>
                                                <td colspan="13">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div id="jqxgrid">
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

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function(){
        var entidades;
        var celularesEmails;
        //var tablaUnidades = $("#tablaUnidades tbody");

        $( "#btSeguimientoAlertaBuscarAgrupados" ).click(function(){
            var fechaDesde = $("#fechaDesde").val();
            var fechaHasta = $("#fechaHasta").val();
            var agente = $("#agente").val();
            var grupo = $("#grupo").val();

            if (fechaDesde=="" || fechaHasta=="" )
            {
                alert('Verifique los datos ingresados para Continuar');
                return false;
            }
            $.ajax({
                    url:"{{route('alerts.seguimientoAlertasBuscarAgrupados')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta,
                        agente: agente,
                        grupo: grupo
                    },
                    success: function( response ) 
                    {
                        $("#tbodyAlertas").empty();
                        console.log('hola');
                        console.log(response);
                        //len = response['data'].length;
                        //console.log("Trajo "+len+" alertas");
                        $.each(response , function(index, val) { 
                            //console.log(val);
                            $.each(val,function(index, valor) { 
                                //console.log(index);
                                if(typeof valor['A'] == "undefined"){
                                    valor['A']="0";
                                    }
                                if(typeof valor['TP'] == "undefined"){
                                    valor['TP']="0";
                                    }
                                if(typeof valor['APO'] == "undefined"){
                                    valor['APO']="0";
                                    }
                                if(typeof valor['NA'] == "undefined"){
                                    valor['NA']="0";
                                    }
                                if(typeof valor['EFICIENCIA'] == "undefined"){
                                    //valor['EFICIENCIA']="0.00%";
                                    }
                                if(typeof valor['EFICACIA'] == "undefined"){
                                    //valor['EFICACIA']="0.00%";
                                    }
                                if(index.length>0)
                                    $('#tablaAlertas > tbody:last-child').append('<tr><td>'+index+'</td><td>'+valor['G']+'</td><td>'+valor['A']+'</td><td>'+valor['APO']+'</td><td>'+valor['NA']+'</td><td>10</td><td>'+valor['TP']+'</td><td>'+valor['EFICIENCIA']+'</td><td>'+valor['EFICACIA']+'</td></tr>');
                            });
                        });



                    }
                });
        });
    });
</script>

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