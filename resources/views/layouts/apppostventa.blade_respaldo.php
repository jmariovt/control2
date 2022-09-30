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
        <link rel="stylesheet" href="{{asset('css2/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('css2/bootstrap.css') }}">
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

    <script type="text/javascript" charset="utf8" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('js/dataTables.rowGroup.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.css')}}">


    <link rel="stylesheet" href="{{asset('jqwidgets/styles/jqx.base.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('jqwidgets/styles/jqx.darkblue.css')}}" type="text/css" />
    <script type="text/javascript" src="{{asset('jqwidgets/jqxcore.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxbuttons.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxscrollbar.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxmenu.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.grouping.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.selection.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxdata.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxlistbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxdropdownlist.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.columnsresize.js')}}"></script> 
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.filter.js')}}"></script> 
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('jqwidgets/jqxdata.export.js')}}"></script>
    <script type="text/javascript" src="{{asset('jqwidgets/jqxgrid.export.js')}}"></script> 



 
   


    

       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">
    
    <!-- Este estilo es para la tabla principal de los montoreos -->
    <style type="text/css">
        .table-condensed{
            font-size: 11px;
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
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/xadmin/postventa/consultaGeneral">Consulta General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Celulares y Emails</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/xadmin/postventa/recorrido">Recorrido</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/xadmin/postventa/consultaSMS">Consulta de SMS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Rutas</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('registerer'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->Nombre }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!--<main class="py-4">
            
        </main>-->
        <div class="container-fluid">
            @yield('content')
            
        </div>
    </div>

    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->

    <!--<script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.selectlistactions.js')}}"></script>-->


</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $(".nav-tabs a.nav-link").click(function(){
            
            $(this).addClass("active");
            var x = $(this).attr("id");
            $(".nav-tabs a.nav-link").each(function(){
                var y = $(this).attr("id");
                if (x == y) {}
                else $(this).removeClass("active");
	        });


            var x = $(this).attr("href");
            x = x.replace("#", "");
            $(".tab-content .tab-pane").each(function(){
                var y = $(this).attr("id");
                if (x == y) $(this).addClass("active show");
                else $(this).removeClass("active show");
	        });
        });
    });
</script>



<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        var entidades;
        var celularesEmails;
        //var tablaUnidades = $("#tablaUnidades tbody");

        $( "#consultaGeneralBuscar" ).autocomplete({
            minLength: 3,
                source: function( request, response ) 
                {
                    console.log("Holaaa criterio: "+$("#consultaGeneralCriterio").val());
                    console.log("Holaaa search: "+request.term);
                    // Fetch data
                    $.ajax({
                        url:"{{route('postventa.datosUsuarioConsultar')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            criterio: $("#consultaGeneralCriterio").val()
                        },
                        success: function( data ) {
                            
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    console.log("Holaaa55 "+ui.item.value+" "+ui.item.label);
                    //console.log(entidades[0]);
                    //console.log(entidades[0].Entidad);
                    
                    // Set selection
                    $('#consultaGeneralBuscar').val(ui.item.label); // display the selected text
                    $('#consultaGeneralDatosEncontrados').val(ui.item.value); // save selected id to input
                    var valores = ui.item.value;
                    /*var arregloValores =  valores.split(';');
                    $('#consultaGeneralNombres').val(arregloValores[1]);
                    $('#consultaGeneralCedularuc').val(arregloValores[0]);
                    $('#consultaGeneralDireccion').val(arregloValores[2]);
                    $('#consultaGeneralEmail').val(arregloValores[5]);
                    $('#consultaGeneralConvencional').val(arregloValores[4]);
                    $('#consultaGeneralCelular').val(arregloValores[3]);
                    $('#consultaGeneralOperadora').val(arregloValores[8]); */

                    //$("#tbodyUnidades").empty();
                    //tablaUnidades.empty();

                    var registros = 0;//entidades.length;
                    console.log("Trajo "+registros+" registros");
                    if(registros==0)
                    {
                            
                        //$('#tablaUnidades > tbody:last-child').append('<tr><td colspan="12">No hay resultados a mostrar</td></tr>');
                        //tablaUnidades.append('<tr><td colspan="12">No hay resultados a mostrar</td></tr>');
                    }


                    /*$.ajax({
                        url:"{{route('postventa.datosUsuarioConsultar')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            criterio: $("#consultaGeneralCriterio").val()
                        },
                        success: function( data ) {
                            if(data['unidades'].length>0)
                            {
                                
                                entidades = data['unidades'];
                            }
                            if(data['emailsms'].length>0)
                            {
                                celularesEmails = data['emailsms'];
                            }
                            response( data );
                        }
                    });*/




                    /*for ( index = 0; index < registros; index++) {
                        vid = entidades[index].VID;
                        placa = entidades[index].Alias;
                        entidad = entidades[index].Entidad;
                        marca = entidades[index].Marca;
                        modelo = entidades[index].Modelo;
                        ultimoReporteGps = entidades[index].UltimoReporte;
                        ultimoReporteServidor = entidades[index].UltimoReporteServidor;
                        producto = entidades[index].Producto;
                        dispositivo = entidades[index].Dispositivo;
                        codsyshunter = entidades[index].CodSysHunter;

                                            
                        
                    }*/

                    /*var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'VID'},
                            {name: 'Alias'},
                            {name: 'Entidad'},
                            {name: 'Marca'},
                            {name: 'Modelo'},
                            {name: 'UltimoReporteGPS'},
                            {name: 'UltimoReporteServidor'},
                            {name: 'Producto'},
                            {name: 'Dispositivo'},
                            {name: 'CodSysHunter'},
                            {name: 'Estado'},
                        ],
                        localdata: entidades
                    };
                    var dataAdapter = new $.jqx.dataAdapter(source);
                    $("#jqxgrid").jqxGrid({
                            source: dataAdapter,
                            width: 1810,
                            groupable: true,
                            sortable: true,
                            columnsresize: true,
                            columns: [
                                {text: 'VID', datafield: 'VID', width: 100},
                                {text: 'Alias', datafield: 'Alias', width: 80},
                                {text: 'Entidad', datafield: 'Entidad', width: 260},
                                {text: 'Marca', datafield: 'Marca', width: 80},
                                {text: 'Modelo', datafield: 'Modelo', width: 250},
                                {text: 'Ultimo Reporte GPS', datafield: 'UltimoReporteGPS', width: 200},
                                {text: 'Ultimo Reporte Servidor', datafield: 'UltimoReporteServidor', width: 200},
                                {text: 'Producto', datafield: 'Producto', width: 140},
                                {text: 'Dispositivo', datafield: 'Dispositivo', width: 200},
                                {text: 'CodSysHunter', datafield: 'CodSysHunter', width: 150},
                                {text: 'Estado', datafield: 'Estado', width: 150}
                                
                            ]
                        });

                        var source2 =
                        {
                            datatype: "json",
                            datafields: [
                                {name: 'Tipo'},
                                {name: 'Dato'},
                                {name: 'Propietario'},
                                {name: 'Operadora'}
                            ],
                            localdata: celularesEmails
                        };
                        var dataAdapter2 = new $.jqx.dataAdapter(source2);
                        $("#jqxgrid_celularesmail").jqxGrid({
                            source: dataAdapter2,
                            width: 1810,
                            groupable: true,
                            sortable: true,
                            columnsresize: true,
                            columns: [
                                {text: 'Tipo', datafield: 'Tipo', width: 450},
                                {text: 'Numero / Email', datafield: 'Dato', width: 450},
                                {text: 'Propietario', datafield: 'Propietario', width: 450},
                                {text: 'Operadora', datafield: 'Operadora', width: 460}
                                
                                
                            ]
                        });*/

                    return false;
                }
        });
    });
</script>