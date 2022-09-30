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
    

     <!-- CSS only morph-->
    
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">-->
     <!-- TEMA DE BOOTSTRAP --> 
      <!--  <link rel="stylesheet" href="https://bootswatch.com/4/slate/bootstrap.css">-->
        <link rel="stylesheet" href="{{asset('Zephyr/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('Zephyr/bootstrap.css') }}">
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
    <script type="text/javascript" charset="utf8" src="{{asset('js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('js/dataTables.buttons.min.js')}}"></script>

    
    <script type="text/javascript" charset="utf8" src="{{asset('js/chart/chart.min.js')}}"></script>

    <script type="text/javascript" charset="utf8" src="{{asset('js/verimail.js')}}"></script>


    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/rowGroup.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/buttons.dataTables.min.css')}}">

    <!--<link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>

    <link href="https://nightly.datatables.net/rowgroup/css/rowGroup.dataTables.css?_=bc3763029fa6dfaf4c947ef25f079107.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/rowgroup/js/dataTables.rowGroup.js?_=bc3763029fa6dfaf4c947ef25f079107"></script>-->
    


  

    <script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

    <script type="text/javascript" src="{{asset('js/dragula.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">
    
       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">

    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> COMENTADO PARA VER QUE PASA-->
    <script type="text/javascript" src="{{asset('js/daterangepicker.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />
    
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


        #aplicacionesDisponibles {
        padding: 20px;
        background: #eee;
        margin-bottom: 20px;
        z-index: 1;
        border-radius: 10px;
        }

        #dropzone {
        padding: 20px;
        background: #eee;
        min-height: 100px;
        margin-bottom: 20px;
        z-index: 0;
        border-radius: 10px;
        }

        .activeAplicacion {
        outline: 1px solid red;
        }

        .hover {
        outline: 1px solid blue;
        }

        .drop-item {
        cursor: pointer;
        margin-bottom: 10px;
        background-color: rgb(255, 255, 255);
        padding: 5px 10px;
        border-radisu: 3px;
        border: 1px solid rgb(204, 204, 204);
        position: relative;
        }

        .drop-item .remove {
        position: absolute;
        top: 4px;
        right: 4px;
        }



@import url("https://fonts.googleapis.com/css?family=Arimo:400,700|Roboto+Slab:400,700");


p {
  font-family: "Roboto Slab", serif;
}

h4 {
  font-family: "Arimo", sans-serif;
  line-height: 1.3;
  color: black;
}


.add-task-container {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  width: 20rem;
  height: 5.3rem;
  margin: auto;
  background: #a8a8a8;
  border: #000013 0.2rem solid;
  border-radius: 0.2rem;
  padding: 0.4rem;
}

.main-container {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

.columns {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  margin: 1.6rem auto;
}

.column {
  width: 20.4rem;
  margin: 0 0.6rem;
  background: #a8a8a8;
  border: #000013 0.2rem solid;
  border-radius: 0.2rem;
}

.column-header {
  padding: 0.1rem;
  border-bottom: #000013 0.2rem solid;
}

.column-header h4 {
  text-align: center;
}

.servidoresDisponiblesColumn .column-header, .to-do-column .column-header {
  background: #ff872f;
  color: black;
}

.doing-column .column-header {
  background: #13a4d9;
  color: black;
}

.done-column .column-header {
  background: #15d072;
}

.servidoresRegistradosColumn .column-header, .trash-column .column-header {
  background: #3eb85e;
  color: black;
}

.task-list {
  min-height: 3rem;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

li {
  list-style-type: none;
}

.column-button {
  text-align: center;
  padding: 0.1rem;
}

.delete-button {
  background-color: #ff4444;
  margin: 0.1rem auto 0.6rem auto;
}

.delete-button:hover {
  background-color: #fa7070;
}

.task {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  vertical-align: middle;
  list-style-type: none;
  background: #fff;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
  margin: 0.4rem;
  height: 4rem;
  border: #000013 0.15rem solid;
  border-radius: 0.2rem;
  cursor: move;
  text-align: center;
  vertical-align: middle;
}

#taskText {
  background: #fff;
  border: #000013 0.15rem solid;
  border-radius: 0.2rem;
  text-align: center;
  font-family: "Roboto Slab", serif;
  height: 4rem;
  width: 7rem;
  margin: auto 0.8rem auto 0.1rem;
}

.task p {
  margin: auto;
}

/* Dragula CSS Release 3.2.0 from: https://github.com/bevacqua/dragula */

.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important;
  opacity: 0.8;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
  filter: alpha(opacity=80);
}

.gu-hide {
  display: none !important;
}

.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
}

.gu-transit {
  opacity: 0.2;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
  filter: alpha(opacity=20);
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



<!-- JS, Popper.js, and jQuery -->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">

    <!-- Script Agregado para autocompletar-->
    <!--<script src="{{asset('jquery-3.3.1.min.js')}}" type="text/javascript"></script>-->

    <script type="text/javascript">
    $(document).ready(function(){
        $('.drag').draggable({ 
            appendTo: 'body',
            helper: 'clone'
        });

        $('#dropzone').droppable({
        activeClass: 'activeAplicacion',
        hoverClass: 'hover',
        accept: ":not(.ui-sortable-helper)", // Reject clones generated by sortable
        drop: function (e, ui) {
            //var $el = $('<div class="drop-item"><details><summary>' + ui.draggable.text() + '</summary></details></div>');
            //$el.append($('<button type="button" class="btn btn-default btn-xs remove"><span class="bi bi-trash"></span></button>').click(function () { $(this).parent().detach(); }));
            var $el = $('<div class="input-group mb-3"><input type="text" disabled class="form-control" value="'+ui.draggable.text()+'" aria-describedby="button-addon2">');
            $el.append($('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>').click(function () { $(this).parent().detach(); }));
            $(this).append($el);
        }
        }).sortable({
        items: '.drop-item',
        sort: function() {
            // gets added unintentionally by droppable interacting with sortable
            // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
            $( this ).removeClass( "active" );
        }
        });
    });
    </script>
    
    

    


</head>
<body>
    <div id="app">
       
                <nav class="navbar  navbar-expand-lg navbar-dark bg-primary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="">
                            {{ config('app.name', 'Laravel') }}
				<img src="{{asset('Imagenes/Ecuador40.png')}}" style="height: 20px;"/>
			</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">-->
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">
                                @guest
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/consultaGeneral">Consulta General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/consultaUsuariosCorreoCelular">Correos y Celulares</a>
                                    </li>
                                    <!--<li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/celularesEmails">Celulares y Emails</a>
                                    </li>-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/recorrido">Recorrido</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/consultaSMS">Mensajes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/consultaCorreosEnviados">Correos enviados</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/consultaReenvioDatos">Reenvío de datos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/reportesDisponibles">Reportes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/reenvioDatos">Servidores reenvío de datos</a>
                                    </li>
                                    <!--<li class="nav-item">
                                        <a class="nav-link" href="/xadmin/postventa/paths">Rutas</a>
                                    </li>-->
                                @endguest
                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                   
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
                                <div class="spinner-border text-light" role="status" id="spinnerPostVenta" style="display: none;">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </ul>
                        </div>
                    </div>
                </nav>
            
                <div class="container-fluid">
                    @yield('content')
            
                </div>
            
        
    </div>

    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->

    <!--<script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.selectlistactions.js')}}"></script>-->
    <script type="text/javascript" src="{{asset('js/jquery.selectlistactionspv.js')}}"></script>




<script type="text/javascript">
    $(document).ready(function(){
        $("ul.nav-tabs a").click(function (e) {
        e.preventDefault();  
            $(this).tab('show');
        });
    });
</script>

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

<style>     
        .green {
            color: black\9;
            background-color: #b6ff00\9;
        }
        .yellow {
            color: black\9;
            background-color: yellow\9;
        }
        .red {
            color: black\9;
            background-color: #e83636\9;
        }
        .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #b6ff00;
        }
        .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: yellow;
        }
        .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #e83636;
        }





        
    </style>






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
                var criterio = $("#consultaGeneralCriterio").val();
                var url = "";
                if(criterio=="5")
                {
                    console.log("Voy a buscar mediante VID.");
                    url = "{{route('assets.buscarPlacaConVid')}}";
                }
                else
                {
                    console.log("Voy a buscar mediante metodos anteriores.");
                    url = "{{route('postventa.datosUsuarioConsultar')}}";
                }
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: "json",
                    cache: false,
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
                console.log("Aquí debería borrar");
                // Set selection
                $('#consultaGeneralBuscar').val(ui.item.label); // display the selected 
                
                $("#to-do").find('li').remove(); // Aplicaciones Disponibles
                $("#trash").find('li').remove(); // Aplicaciones Seleccionadas
                
                
                $('#Usuario').val(''); 
                $('#IdUsuario').val(''); 
                $('#IdEntidad').val(''); 
                $('#UID').val(''); 
                $('#UsuarioSesion').val(''); 
                $('#consultaGeneralNombres').val('');
                $('#consultaGeneralCedularuc').val('');
                $('#consultaGeneralDireccion').val('');
                $('#consultaGeneralEmail').val('');
                $('#consultaGeneralConvencional').val('');
                $('#consultaGeneralCelular').val('');
                $('#consultaGeneralOperadora').val(''); 

                if ( $.fn.dataTable.isDataTable( '#UnidadesTabla' ) ) {
                    table = $('#UnidadesTabla').DataTable();
                    table.clear().draw();
                    table.destroy();
                }               

                if ( $.fn.dataTable.isDataTable( '#UnidadesCelularesEmail' ) ) {
                    table = $('#UnidadesCelularesEmail').DataTable();
                    table.clear().draw();
                    table.destroy();
                } 

                $('#dropzone button').remove(); 
                $('#dropzone div').remove(); 
                $('#aplicacionesDisponibles drag').remove();

                $("#tbodyCorreo").empty();
                $("#tbodyCelulares").empty();
            
                $('#spinnerPostVenta').show();

                var criterio = $("#consultaGeneralCriterio").val();
                var url = "";
                var valor = ui.item.label;
                
                if(criterio=="5")
                {
                    console.log("Buscare vid: "+valor);
                    $.ajax({
                        url: "{{route('postventa.traeEntidadesPorVid')}}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: CSRF_TOKEN,
                            search: valor
                        },
                        cache: false,
                        success: function(data1)
                        {
                            console.log(data1);
                            $('#spinnerPostVenta').hide();
                            $("#consultaGeneralSeleccionarEntidad").empty().append('<option value="0" selected>Elija entidad...</option>');
                            $('#consultaGeneralSeleccionarEntidad').prop("disabled",false); 
                            $.each(data1 , function( key, value ) {
                                //alert( key + ": " + value['IdEntidad'] );
                                var option = "<option value='"+value['IdEntidad']+"' >"+value['IdEntidad']+"</option>"; 
                                $("#consultaGeneralSeleccionarEntidad").append(option); 
                                });
                        }
                    });
                    
                }else
                {
                    console.log("Buscare dato: "+valor+" .Criterio: "+criterio);
                    datosConsultarDetalles(valor,criterio);
                }

                
                
                
                

                return false;
            }
        });

        $("#consultaGeneralCriterio").change(function(){
            var criterio = $(this).val();
            if(criterio!="5")
            {
                $("#consultaGeneralSeleccionarEntidad").empty().append('<option value="0" selected>Elija entidad...</option>');
                $('#consultaGeneralSeleccionarEntidad').prop("disabled",true); 
            }
        });


        $('#consultaGeneralSeleccionarEntidad').change(function(){
            console.log('Hola entidad');
            valor = $(this).val();
            $('#spinnerPostVenta').show();
            
                    
            $("#to-do").find('li').remove(); // Aplicaciones Disponibles
            $("#trash").find('li').remove(); // Aplicaciones Seleccionadas
            
            
            $('#Usuario').val(''); 
            $('#IdUsuario').val(''); 
            $('#IdEntidad').val(''); 
            $('#UID').val(''); 
            $('#UsuarioSesion').val(''); 
            $('#consultaGeneralNombres').val('');
            $('#consultaGeneralCedularuc').val('');
            $('#consultaGeneralDireccion').val('');
            $('#consultaGeneralEmail').val('');
            $('#consultaGeneralConvencional').val('');
            $('#consultaGeneralCelular').val('');
            $('#consultaGeneralOperadora').val(''); 

            if ( $.fn.dataTable.isDataTable( '#UnidadesTabla' ) ) {
                table = $('#UnidadesTabla').DataTable();
                table.clear().draw();
                table.destroy();
            }               

            if ( $.fn.dataTable.isDataTable( '#UnidadesCelularesEmail' ) ) {
                table = $('#UnidadesCelularesEmail').DataTable();
                table.clear().draw();
                table.destroy();
            } 

            $('#dropzone button').remove(); 
            $('#dropzone div').remove(); 
            $('#aplicacionesDisponibles drag').remove();

            $("#tbodyCorreo").empty();
            $("#tbodyCelulares").empty();
        
            datosConsultarDetalles(valor,"0");//gfcarsegsa
        });

        $('#consultaGeneralBuscar').on('keypress', function(e){
            if(e.which == 13)
            {
                console.log('Presionado enter');
                //$('#consultaGeneralBuscar').val(ui.item.label); // display the selected 
                
                $("#to-do").find('li').remove(); // Aplicaciones Disponibles
                $("#trash").find('li').remove(); // Aplicaciones Seleccionadas
                
                
                $('#Usuario').val(''); 
                $('#IdUsuario').val(''); 
                $('#IdEntidad').val(''); 
                $('#UID').val(''); 
                $('#UsuarioSesion').val(''); 
                $('#consultaGeneralNombres').val('');
                $('#consultaGeneralCedularuc').val('');
                $('#consultaGeneralDireccion').val('');
                $('#consultaGeneralEmail').val('');
                $('#consultaGeneralConvencional').val('');
                $('#consultaGeneralCelular').val('');
                $('#consultaGeneralOperadora').val(''); 

                if ( $.fn.dataTable.isDataTable( '#UnidadesTabla' ) ) {
                    table = $('#UnidadesTabla').DataTable();
                    table.clear().draw();
                    table.destroy();
                }               

                if ( $.fn.dataTable.isDataTable( '#UnidadesCelularesEmail' ) ) {
                    table = $('#UnidadesCelularesEmail').DataTable();
                    table.clear().draw();
                    table.destroy();
                } 

                $('#dropzone button').remove(); 
                $('#dropzone div').remove(); 
                $('#aplicacionesDisponibles drag').remove();

                $("#tbodyCorreo").empty();
                $("#tbodyCelulares").empty();
            
                $('#spinnerPostVenta').show();

                var criterio = $("#consultaGeneralCriterio").val();
                var url = "";
                var valor = $('#consultaGeneralBuscar').val();
                
                if(criterio=="5")
                {
                    console.log("Buscare vid: "+valor);
                    $.ajax({
                        url: "{{route('postventa.traeEntidadesPorVid')}}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: CSRF_TOKEN,
                            search: valor
                        },
                        cache: false,
                        success: function(data1)
                        {
                            console.log(data1);
                            $('#spinnerPostVenta').hide();
                            $("#consultaGeneralSeleccionarEntidad").empty().append('<option value="0" selected>Elija entidad...</option>');
                            $('#consultaGeneralSeleccionarEntidad').prop("disabled",false); 
                            $.each(data1 , function( key, value ) {
                                //alert( key + ": " + value['IdEntidad'] );
                                var option = "<option value='"+value['IdEntidad']+"' >"+value['IdEntidad']+"</option>"; 
                                $("#consultaGeneralSeleccionarEntidad").append(option); 
                                });
                        }
                    });
                    
                }else
                {
                    console.log("Buscare dato: "+valor+" .Criterio: "+criterio);
                    datosConsultarDetalles(valor,criterio);
                }
            }
                
            else    
                console.log('No fue presionado enter');
        });

        function datosConsultarDetalles(valor,criterio)
        {
            $.ajax({
                        url: "{{route('postventa.datosUsuarioConsultarDetalle')}}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: CSRF_TOKEN,
                            search: valor,
                            criterio: criterio
                        },
                        cache: false,
                        success: function(data1)
                        {
                            console.log("Responde: "+data1);
                            console.log(data1['contadores']);

                            $('#spinnerPostVenta').hide();
                            
                            if(data1['unidades'].length>0)
                            {
                                
                                entidades = data1['unidades'];
                                console.log('Unidades:')
                                console.log(entidades);
                            }else
                            {
                                entidades = [];
                            }
                            if(data1['emailsms'].length>0)
                            {
                                celularesEmails = data1['emailsms'];
                            }else
                            {
                                celularesEmails = [];
                            }


                            $("#NumeroRegistros").text(data1['contadores'].NumeroRegistros);
                            $("#VehiculosActivados").text(data1['contadores'].VehiculosActivados);
                            $("#VehiculosDesactivados").text(data1['contadores'].VehiculosDesactivados);
                            $("#DispositivosTransmitiendo").text(data1['contadores'].DispositivosTransmitiendo);
                            $("#DispositivosDesactivados").text(data1['contadores'].DispositivosDesactivados);
                            $("#SimActivas").text(data1['contadores'].SimActivas);
                            $("#SimDesactivadas").text(data1['contadores'].SimDesactivadas);

                            

                            $('#UID').val(data1['datosAdicionales'].uid); 
                            $('#UsuarioSesion').val(data1['datosAdicionales'].usuarioSesion); 

                            

                            if(data1['aplicaciones'].length>0)
                            {
                                aplicaciones = data1['aplicaciones'];
                                
                            }else
                            {
                                aplicaciones = [];
                            }

                            if(data1['aplicacionesTotales'].length>0)
                            {
                                aplicacionesTotales = data1['aplicacionesTotales'];
                                
                            }else
                            {
                                aplicacionesTotales = [];
                            }



                            console.log('aplicaciones '+aplicaciones.length);
                            console.log('aplicaciones totales '+aplicacionesTotales.length);
                            console.log(aplicacionesTotales);
                             
                            document.getElementById("trash").innerHTML = '';
                            for(var i=0; i<aplicaciones.length; i++)
                            {
                                name = $.trim(aplicaciones[i].Nombre);
                                id = aplicaciones[i].IdAplicacion;
                                
                                
                                document.getElementById("trash").innerHTML +=
                                '<li class="task" ><p>'+name+'; Cod.'+id+'</p></li>';
                                
                            }
                            var encontrado = false;
                            for(var j=0; j<aplicacionesTotales.length;j++)
                            {
                                nombre = $.trim(aplicacionesTotales[0][j].Nombre);
                                id = aplicacionesTotales[0][j].IdAplicacion;
                                console.log(nombre);
                                encontrado = false;
                                for(var h=0; h<aplicaciones.length&&!encontrado; h++)
                                {
                                    id2 = aplicaciones[h].IdAplicacion;
                                    console.log('IDs: '+id+' '+id2);
                                    if(id==id2)
                                    {
                                        encontrado = true;
                                    }
                                    
                                }
                                if(encontrado==false)
                                {
                                    document.getElementById("to-do").innerHTML +=
                                    '<li class="task" ><p>'+nombre+'; Cod.'+id+'</p></li>';
                                }else
                                {
                                    encontrado = false;
                                }

                            }

                            var valores = data1['detalle'][0];
                            console.log('Valores:');
                            console.log(valores);
                            var arregloValores =  valores.split(';');
                            $('#consultaGeneralNombres').val(arregloValores[1]);
                            $('#consultaGeneralCedularuc').val(arregloValores[0]);
                            $('#consultaGeneralDireccion').val(arregloValores[2]);
                            $('#consultaGeneralEmail').val(arregloValores[5]);
                            $('#consultaGeneralConvencional').val(arregloValores[4]);
                            $('#consultaGeneralCelular').val(arregloValores[3]);
                            $('#consultaGeneralOperadora').val(arregloValores[8]); 

                            $('#Usuario').val(arregloValores[6]); 
                            $('#IdUsuario').val(arregloValores[7]); 
                            $('#IdEntidad').val(arregloValores[0]);
                            console.log('Finaliza valores y vuelvo a imprimir unidades');
                            console.log(entidades);
                            

                            var collapsedGroups = {};
                            var top = '';
                            var table = $('#UnidadesTabla').DataTable( {
                                processing: true,
                                dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                                pageLength: 500,
                                lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                                data: entidades,
                                responsive: true,
                                language:{
                                    url:"../dataTables/lang/es-MX.json"
                                },
                                order: [[6, 'desc']],
                                columnDefs: [ {
                                    targets: 1,
                                    data: null,
                                    defaultContent: "<button>Click!</button>"
                                } ],
                                //rowGroup: {
                                //    dataSrc: ['Entidad','Estado']
                                //},
                                columns: [
                                    {data: 'LinkEditar',
                                        render: function ( data, type, row ) {
                                            console.log('Registro:');
                                            console.log(data);
                                            arregloUrl = data.split('_');
                                            url = 'modificarAlias/'+arregloUrl[0]+'/'+arregloUrl[1]+'/'+arregloUrl[2]+'/'+arregloUrl[3];

                                            imagenEditar = '../Imagenes/pen-to-square-solid.svg';
                                            debeBloquear = $('#debeBloquear').val();
                                            style = "";
                                            if(debeBloquear=="disabled")
                                                style = "pointer-events: none";
                                            return '<a href="'+url+'"  onclick="window.open(\''+url+'\',\'_blank\',\'width=700,height=500\'); return false;" style="'+style+'"><img src="'+imagenEditar+'" title="Editar" style="height: 20px;"/></a></td>';
                                        }
                                    },
                                    {data: 'LinkConfiguracion',
                                        render: function ( data, type, row ) {
                                            arregloUrl = data.split('_');
                                            url = 'editarConfiguracionActivo/'+arregloUrl[0]+'/'+arregloUrl[1]+'/'+arregloUrl[2];

                                            imagenConfiguracion = '../Imagenes/gear-solid.svg';
                                            debeBloquear = $('#debeBloquear').val();
                                            style = "";
                                            if(debeBloquear=="disabled")
                                                style = "pointer-events: none";
                                            return '<a href="'+url+'"  onclick="window.open(\''+url+'\',\'_blank\',\'width=700,height=500\'); return false;" style="'+style+'"><img src="'+imagenConfiguracion+'" title="Configuración" style="height: 20px;"/></a></td>';
                                            
                                            //return '<input type="button" onClick="buttonclick(event)" class="btn btn-secondary btn-sm" id="btn_' + data + '" value="Configuración"/>';
                                        }
                                    },
                                    {data: 'Estado'},
                                    {data: 'CodSysHunter'},
                                    {data: 'VID'},
                                    {data: 'Alias'},
                                    {data: 'Etiqueta'},
                                    {data: 'UltimoReporte'},
                                    {data: 'UltimoReporteServidor'},
                                    {data: 'Producto'},
                                    {data: 'Dispositivo'},
                                    {data: 'Entidad'},
                                    {data: 'Marca'},
                                    {data: 'Modelo'},
                                    {data: 'Chasis'},
                                    {data: 'Motor'},
                                    {data: 'Imei'},
                                    {data: 'Icc'},
                                    {data: 'EstadoSIM'},
                                    {data: 'ObservacionSIM'},
                                    {data: 'NumeroCelular'}
                                ]/*,
                                rowGroup: {
                                    dataSrc: ['Entidad', 'Estado'],
                                    startRender: function(rows, group, level) {
                                        var all;
                                        if (level === 0) {
                                            top = group;
                                            all = group;
                                        } else {
                                            if (!!collapsedGroups[top]) {
                                                return;
                                            }
                                            all = top + group;
                                            if (collapsedGroups[all] === undefined) {
                                                collapsedGroups[all] = true;
                                            }
                                        }

                                        var collapsed = !!collapsedGroups[all];

                                        rows.nodes().each(function(r) {
                                            r.style.display = collapsed ? 'none' : '';
                                            console.log('row:');
                                            console.log(r);
                                        });
                                    
                                        // Get the API instance
                                        var api = $( '#UnidadesTabla' ).DataTable();
                                    
                                        // Get the rowGroup dataSrc
                                        var dataSrc = api.rowGroup().dataSrc();
                                    
                                        // Get the column idx for the current level
                                        console.log('level: '+level);
                                        
                                        var idx = dataSrc[ level ];
                                        console.log('idx: '+idx);

                                    

                                        // Add category name to the <tr>. NOTE: Hardcoded colspan
                                        return $('<tr/>')
                                        .append('<td colspan="6">' + idx + ':' + group + ' (' + rows.count() + ')</td>')
                                        .attr('data-name', all).toggleClass('collapsed', collapsed);
                                    }
                                }*/
                            } );

                            
                                
                            
                            console.log('Pasó tabla de unidades');


                            console.log("Responde: "+data1);
                            
                            document.getElementById("guardarCelular").addEventListener("click",guardarCelular,false);
                            document.getElementById("guardarCorreo").addEventListener("click",guardarCorreo,false);
                            
                            
                            if(data1['emails'].length>0)
                            {
                                emails = data1['emails'];
                                console.log(emails);
                                var contador = 0;
                                $.each(emails, function(index,value){
                                    if(value.Email!='')
                                    {
                                        var propietario = value.Propietario.toString();
                                        propietario = propietario.replace(/\r\n/g, '');
                                        p = propietario.replace(/\s+/g, '');
                                        idPropietario = $.trim("EditarCorreoPropietario:"+value.idUsuario+":"+value.Email+":"+p);
                                        idCorreo = $.trim('EditarCorreoCorreo:'+value.idUsuario+':'+value.Email+':'+p);
                                        console.log(idCorreo);
                                        $('#tablaCorreos > tbody:last-child').append('<tr id="'+idCorreo+'"><td style="text-align: center;" id="'+idCorreo+'">'+value.Email+'</td><td id="'+idPropietario+'">'+value.Propietario+'</td><td><a id="EditarCorreo:'+value.idUsuario+':'+value.Email+':'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCorreo:'+value.idUsuario+':'+value.Email+':'+propietario+'" ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                        document.getElementById("EditarCorreo:"+value.idUsuario+':'+value.Email+':'+propietario).addEventListener("click",editarCorreo,false);
                                        document.getElementById("EliminarCorreo:"+value.idUsuario+':'+value.Email+':'+propietario).addEventListener("click",eliminarCorreo,false);
                                        
                                    }
                                    
                                });
                            }else
                            {
                                emails = [];
                            }

                            if(data1['celulares'].length>0)
                            {
                                celulares = data1['celulares'];
                                console.log(celulares);
                                $.each(celulares, function(index,value){
                                    if(value.Numero!='')
                                    {
                                        var propietario = value.Propietario.toString();
                                        propietario = propietario.replace(/\r\n/g, '');
                                        p = propietario.replace(/\s+/g, '');
                                        idPropietario = $.trim("EditarCelularPropietario:"+value.idUsuario+":"+value.Numero+":"+p);
                                        idCelular = $.trim('EditarCelularCelular:'+value.idUsuario+':'+value.Numero+':'+p);
                                        console.log(idCelular);
                                        $('#tablaCelulares > tbody:last-child').append('<tr id="'+idCelular+'"><td style="text-align: center;" id="'+idCelular+'">'+value.Numero+'</td><td id="'+idPropietario+'">'+value.Propietario+'</td><td>&nbsp</td><td><a id="EditarCelular_'+value.idUsuario+'_'+value.Numero+'_'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCelular_'+value.idUsuario+'_'+value.Numero+'_'+propietario+'"  ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                        document.getElementById("EditarCelular_"+value.idUsuario+'_'+value.Numero+'_'+propietario).addEventListener("click",editarCelular,false);
                                        document.getElementById("EliminarCelular_"+value.idUsuario+'_'+value.Numero+'_'+propietario).addEventListener("click",eliminarCelular,false);
                                        
                                    }
                                });
                                
                            }else
                            {
                                celulares = [];
                            }


                            var valores = data1['detalle'][0];
                            console.log(valores);
                            var arregloValores =  valores.split(';');
                            $('#celularesEmailNombres').val(arregloValores[1]);
                            $("#IdUsuario").val(arregloValores[7]);
                            console.log('IdUsuario: '+arregloValores[7]);
                            console.log(data1['datosAdicionales']);
                            $('#UID').val(data1['datosAdicionales'].uid); 
                            $('#UsuarioSesion').val(data1['datosAdicionales'].usuarioSesion); 


                            

                        }
                    });
        }

        function modificarAlias()
        {
            //'modificarAlias/'+convert(varchar,IdActivo)+'/'+convert(varchar,@IdUsuario)+'/'+Alias+'"'
        }


        function editarCelular()
        {
            console.log($(this).attr("id"));
            var nombreObjeto = $(this).attr("id");
            var arregloDatos = nombreObjeto.split("_");
            var idUsuario = arregloDatos[1];
            var numero = arregloDatos[2];
            var propietario = arregloDatos[3];
            console.log(propietario);
            $("#areaCelular").show();
            $("#nuevoCelularNumero").val(numero);
            $("#antiguoCelular").val(numero);
            $("#nuevoCelularPropietario").val(propietario);
            $('#nuevoCelularOperacion').val('E');
            $("#IdUsuario").val(idUsuario);

        }
        function eliminarCelular()
        {
            console.log("EliminarCelular: "+arguments.length);
            var nombreObjeto = $(this).attr("id");
            var arregloDatos = nombreObjeto.split("_");
            var IdUsuario = arregloDatos[1];
            var numero = arregloDatos[2];
            var propietario = arregloDatos[3];
            console.log("EliminarCelular: "+nombreObjeto);
            $.ajax({ 
                    url: "{{route('postventa.eliminarCelular')}}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        numero: numero,
                        idUsuario: IdUsuario
                    },
                    cache: false,
                    success: function(data1)
                    {
                        resultado = data1['Resultado'];
                        console.log(data1['Resultado']);
                        if(resultado=='OK')
                        {
                            
                            
                            p = propietario.replace(/\s+/g, '')

                            //idPropietario = $.trim("EditarCelularPropietario_"+IdUsuario+"_"+numero+"_"+p);
                            //idCelular = $.trim('EditarCelular_'+IdUsuario+'_'+numero+'_'+p);
                            idCelular = $.trim('EditarCelularCelular:'+IdUsuario+':'+numero+':'+p);
                            console.log(idCelular);
                            
                            $("td[id='"+idCelular+"']").text("");
                            $("td[id='"+idPropietario+"']").text("");

                            //$('table#tablaCelulares tr#'+idCelular+idPropietario).remove();
                            $("tr[id='"+idCelular+"'").remove();
                            
                            alert('Datos actualizados correctamente.');

                        }else
                            alert(resultado);
                    }
                });
        }
        function editarCorreo()
        {
            var nombreObjeto = $(this).attr("id");
            var arregloDatos = nombreObjeto.split(":");
            var idUsuario = arregloDatos[1];
            var correo = arregloDatos[2];
            var propietario = arregloDatos[3];
            
            $("#areaCorreo").show();
            $("#nuevoCorreoCorreo").val(correo);
            $("#antiguoCorreo").val(correo);
            $("#antiguoPropietario").val(propietario);
            $("#nuevoCorreoPropietario").val(propietario);
            $('#nuevoCorreoOperacion').val('E');
            $("#IdUsuario").val(idUsuario);
        }
        function eliminarCorreo()
        {
            console.log("EliminarCorreo: "+arguments.length);
            var nombreObjeto = $(this).attr("id");
            var arregloDatos = nombreObjeto.split(":");
            var idUsuario = arregloDatos[1];
            var correo = arregloDatos[2];
            var propietario = arregloDatos[3];
            console.log("EliminarCorreo: "+nombreObjeto);
            $.ajax({
                    url: "{{route('postventa.eliminarCorreo')}}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        correo: correo,
                        idUsuario: idUsuario
                    },
                    cache: false,
                    success: function(data1)
                    {
                        resultado = data1['Resultado'];
                        console.log(data1['Resultado']);
                        if(resultado=='OK')
                        {
                            
                            
                            p = propietario.replace(/\s+/g, '')
                            idPropietario = $.trim("EditarCorreoPropietario:"+idUsuario+":"+correo+":"+p);
                            idCorreo = $.trim('EditarCorreoCorreo:'+idUsuario+':'+correo+':'+p);

                            $("td[id='"+idCorreo+"']").text("");
                            $("td[id='"+idPropietario+"']").text("");
                            console.log(idCorreo);
                            $("tr[id='"+idCorreo+"'").remove();
                            //$(this).closest('tr').remove();
                            
                            alert('Datos actualizados correctamente.');

                        }else
                            alert(resultado);
                    }
                });
            
        }
        function guardarCorreo()
        {
            console.log("Guardar Correo");
            var correo = $("#nuevoCorreoCorreo").val();
            var propietario = $("#nuevoCorreoPropietario").val();
            var operacion = $('#nuevoCorreoOperacion').val();
            var antiguoCorreo = $("#antiguoCorreo").val();
            var IdUsuario = $("#IdUsuario").val();
            var antiguoPropietario = $("#antiguoPropietario").val();
            var url;
            switch (operacion) {
                case 'N': // Nuevo
                    url = "{{route('postventa.guardarNuevoCorreo')}}";
                    break;
            
                default: // Edicion
                    url = "{{route('postventa.guardarCorreoEdicion')}}";
                    break;
            }
            console.log(correo + ' - '+propietario +' - '+IdUsuario+' - '+antiguoCorreo);
            if(correo!="" && propietario!="")
            {
                var verimail = new Comfirm.AlphaMail.Verimail();
                verimail.verify(correo, function(status, message, suggestion){
                    console.log(status+' '+message+' '+suggestion);
                    if(status < 0){
                        // Incorrect syntax!
                        alert(message);
                        if(suggestion){
                            // But we might have a solution to this!
                            console.log("¿Quiso escribir " + suggestion + "?");
                        }
                    }else{
                        // Syntax looks great!
                        if(suggestion){
                            // But we're guessing that you misspelled something
                            console.log("¿Quiso escribir " + suggestion + "?");
                        }else{
                            $.ajax({
                                url: url,
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    _token: CSRF_TOKEN,
                                    correo: correo,
                                    propietario: propietario,
                                    IdUsuario: IdUsuario,
                                    antiguoCorreo: antiguoCorreo
                                },
                                cache: false,
                                success: function(data1)
                                {
                                    resultado = data1['Resultado'];
                                    console.log(data1['Resultado']);
                                    if(resultado=='OK')
                                    {
                                        // "EditarCorreo%"+value.idUsuario+'%'+value.Email+'%'+propietario 
                                        switch (operacion) {
                                            case 'N': // Nuevo
                                                p = propietario.replace(/\r\n/g, '');
                                                p = p.replace(/\s+/g, '');
                                                idPropietario = $.trim("EditarCorreoPropietario:"+IdUsuario+":"+correo+":"+p);
                                                idCorreo = $.trim('EditarCorreoCorreo:'+IdUsuario+':'+correo+':'+p);
                                                $('#tablaCorreos > tbody:last-child').append('<tr><td style="text-align: center;" id="'+idCorreo+'">'+correo+'</td><td id="'+idPropietario+'">'+propietario+'</td><td><a id="EditarCorreo:'+IdUsuario+':'+correo+':'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCorreo:'+IdUsuario+':'+correo+':'+propietario+'" ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                                document.getElementById("EditarCorreo:"+IdUsuario+':'+correo+':'+propietario).addEventListener("click",editarCorreo,false);
                                                document.getElementById("EliminarCorreo:"+IdUsuario+':'+correo+':'+propietario).addEventListener("click",eliminarCorreo,false);
                                                
                                                break;
                                        
                                            default: // Edicion
                                                p = antiguoPropietario.replace(/\s+/g, '')
                                                idPropietario = $.trim("EditarCorreoPropietario:"+IdUsuario+":"+antiguoCorreo+":"+p);
                                                idCorreo = $.trim('EditarCorreoCorreo:'+IdUsuario+':'+antiguoCorreo+':'+p);

                                                $("td[id='"+idCorreo+"']").text(correo);
                                                $("td[id='"+idPropietario+"']").text(propietario);
                                                break;
                                        }
                                        $("#areaCorreo").hide();
                                        alert('Datos actualizados correctamente.');
                                        

                                    }else
                                        alert(resultado);
                                }
                            });
                        }
                    }
                });
                
            }else{
                alert("Datos incompletos. Verifique por favor.");
            }

        }
        function guardarCelular()
        {
            console.log("Guardar Celular");
            var numero = $("#nuevoCelularNumero").val();
            var propietario = $("#nuevoCelularPropietario").val();
            var operacion = $('#nuevoCelularOperacion').val();
            var antiguoNumero = $("#antiguoNumero").val();
            var IdUsuario = $("#IdUsuario").val();
            var antiguoPropietario = $("#antiguoPropietarioCelular").val();
            var url;
            switch (operacion) {
                case 'N': // Nuevo
                    url = "{{route('postventa.guardarNuevoCelular')}}";
                    break;
            
                default: // Edicion
                    url = "{{route('postventa.guardarCelularEdicion')}}";
                    break;
            }
            //console.log(url);
            if(numero!="" && propietario!="")
            {
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        numero: numero,
                        propietario: propietario,
                        IdUsuario: IdUsuario,
                        antiguoNumero: antiguoNumero
                    },
                    cache: false,
                    success: function(data1)
                    {
                        resultado = data1['Resultado'];
                        console.log(resultado);
                        if(resultado=='OK')
                        {
                            switch (operacion) {
                                case 'N': // Nuevo
                                    
                                    p = propietario.replace(/\r\n/g, '');
                                    p = p.replace(/\s+/g, '');
                                    idPropietario = $.trim("EditarCelularPropietario:"+IdUsuario+":"+numero+":"+p);
                                    idCelular = $.trim('EditarCelularCelular:'+IdUsuario+':'+numero+':'+p);
                                    
                                    $('#tablaCelulares > tbody:last-child').append('<tr><td style="text-align: center;" id="'+idCelular+'">'+numero+'</td><td id="'+idPropietario+'">'+propietario+'</td><td>&nbsp</td><td><a id="EditarCelular_'+IdUsuario+'_'+numero+'_'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCelular_'+IdUsuario+'_'+numero+'_'+propietario+'"  ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                    document.getElementById("EditarCelular_"+IdUsuario+'_'+numero+'_'+propietario).addEventListener("click",editarCelular,false);
                                    document.getElementById("EliminarCelular_"+IdUsuario+'_'+numero+'_'+propietario).addEventListener("click",eliminarCelular,false);

                                    break;
                            
                                default: // Edicion
                                    p = antiguoPropietario.replace(/\s+/g, '')

                                    idPropietario = $.trim("EditarCelularPropietario:"+IdUsuario+":"+antiguoNumero+":"+p);
                                    idCelular = $.trim('EditarCelularCelular:'+IdUsuario+':'+antiguoNumero+':'+p);

                                    $("td[id='"+idCelular+"']").text(numero);
                                    $("td[id='"+idPropietario+"']").text(propietario);
                                    break;
                            }
                            $("#areaCelular").hide();
                            alert('Datos actualizados correctamente.');

                        }else
                            alert(resultado);
                    }
                });
            }else{
                alert("Datos incompletos. Verifique por favor.");
            }
        }

        
    });

    function buttonclick(event) {
            var id = event.target.id;
            console.log(id);
            arregloUrl = id.split('_');
            if(arregloUrl.length==4)
            {
                var url = 'modificarAlias/'+arregloUrl[1]+'/'+arregloUrl[2];    
            }else
            {
                var url = 'editarConfiguracionActivo/'+arregloUrl[1]+'/'+arregloUrl[2]+'/'+arregloUrl[3];
            }
            
            window.open(url, '_blank','width=700, height=500');
            
    }



    $("#switchTodos").change(function(){

        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        var buscar = $("#switchTodos").is(':checked');
        $("#switchActivos").prop("checked", false);
        $("#switchSuspendidos").prop("checked", false);
        $("#switchNoReportando").prop("checked", false);
        $("#switchSimCortadas").prop("checked", false);
        $('#spinnerPostVenta').show();

        muestraUnidadesCriterio('T');

    });

    $("#switchActivos").change(function(){

        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        var buscar = $("#switchActivos").is(':checked');
        $("#switchTodos").prop("checked", false);
        $("#switchSuspendidos").prop("checked", false);
        $("#switchNoReportando").prop("checked", false);
        $("#switchSimCortadas").prop("checked", false);
        $('#spinnerPostVenta').show();

        if(buscar==true)
            muestraUnidadesCriterio('A');
        else
            muestraUnidadesCriterio('T');

    });

    $("#switchSuspendidos").change(function(){

        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        var buscar = $("#switchSuspendidos").is(':checked');
        $("#switchActivos").prop("checked", false);
        $("#switchTodos").prop("checked", false);
        $("#switchNoReportando").prop("checked", false);
        $("#switchSimCortadas").prop("checked", false);
        $('#spinnerPostVenta').show();


        if(buscar==true)
            muestraUnidadesCriterio('S');
        else
            muestraUnidadesCriterio('T');

    }); //switchNoReportando switchSimCortadas

    $("#switchNoReportando").change(function(){

        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        var buscar = $("#switchNoReportando").is(':checked');
        $("#switchActivos").prop("checked", false);
        $("#switchTodos").prop("checked", false);
        $("#switchSuspendidos").prop("checked", false);
        $("#switchSimCortadas").prop("checked", false);
        $('#spinnerPostVenta').show();


        if(buscar==true)
            muestraUnidadesCriterio('NR');
        else
            muestraUnidadesCriterio('T');

    });

    $("#switchSimCortadas").change(function(){

        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        var buscar = $("#switchSimCortadas").is(':checked');
        $("#switchActivos").prop("checked", false);
        $("#switchTodos").prop("checked", false);
        $("#switchSuspendidos").prop("checked", false);
        $("#switchNoReportando").prop("checked", false);
        $('#spinnerPostVenta').show();


        if(buscar==true)
            muestraUnidadesCriterio('SC');
        else
            muestraUnidadesCriterio('T');

    });

    function muestraUnidadesCriterio(Criterio)
    {
        var IdUsuario = $("#IdUsuario").val();
        $.ajax({
            url: "{{route('postventa.unidadesUsuarioCriterio')}}",
            type: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                Criterio: Criterio,
                IdUsuario: IdUsuario
            },
            cache: false,
            success: function(data1)
            {
                //console.log(data1);
                $('#spinnerPostVenta').hide();
                
                if ( $.fn.dataTable.isDataTable( '#UnidadesTabla' ) ) {
                    table = $('#UnidadesTabla').DataTable();
                    table.clear().draw();
                    table.destroy();
                }  

                entidades = data1;
                console.log(entidades);

                var table = $('#UnidadesTabla').DataTable( {
                    processing: true,
                    dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                    pageLength: 500,
                    lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                    data: entidades,
                    responsive: true,
                    language:{
                        url:"../dataTables/lang/es-MX.json"
                    },
                    order: [[6, 'asc']],
                    columnDefs: [ {
                        targets: 1,
                        data: null,
                        defaultContent: "<button>Click!</button>"
                    } ],
                    //rowGroup: {
                    //    dataSrc: ['Entidad','Estado']
                    //},
                    columns: [
                        {data: 'LinkEditar',
                            render: function ( data, type, row ) {
                                arregloUrl = data.split('_');
                                
                                url = 'modificarAlias/'+arregloUrl[0]+'/'+arregloUrl[1]+'/'+arregloUrl[2]+'/'+arregloUrl[3];

                                imagenEditar = '../Imagenes/pen-to-square-solid.svg';
                                
                                return '<a href="'+url+'"  onclick="window.open(\''+url+'\',\'_blank\',\'width=700,height=500\'); return false;"><img src="'+imagenEditar+'" title="Editar" style="height: 20px;"/></a></td>';
                            }
                        },
                        {data: 'LinkConfiguracion',
                            render: function ( data, type, row ) {
                                arregloUrl = data.split('_');
                                url = 'editarConfiguracionActivo/'+arregloUrl[0]+'/'+arregloUrl[1]+'/'+arregloUrl[2];

                                imagenConfiguracion = '../Imagenes/gear-solid.svg';
                                
                                return '<a href="'+url+'"  onclick="window.open(\''+url+'\',\'_blank\',\'width=700,height=500\'); return false;"><img src="'+imagenConfiguracion+'" title="Configuración" style="height: 20px;"/></a></td>';
                                
                                //return '<input type="button" onClick="buttonclick(event)" class="btn btn-secondary btn-sm" id="btn_' + data + '" value="Configuración"/>';
                            }
                        },
                        {data: 'Entidad'},
                        {data: 'Estado'},
                        {data: 'CodSysHunter'},
                        {data: 'VID'},
                        {data: 'Alias'},
                        {data: 'Etiqueta'},
                        {data: 'Marca'},
                        {data: 'Modelo'},
                        {data: 'Chasis'},
                        {data: 'Motor'},
                        {data: 'UltimoReporte'},
                        {data: 'UltimoReporteServidor'},
                        
                        {data: 'Producto'},
                        {data: 'Dispositivo'},
                        
                        {data: 'Imei'},
                        {data: 'Icc'},
                        {data: 'EstadoSIM'},
                        {data: 'ObservacionSIM'},
                        {data: 'NumeroCelular'}
                    ]
                } );
            }
        });
    }

</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnGrabarApps').click(function () {

            var Usuario = $('#Usuario').val(); 
            var IdUsuario = $('#IdUsuario').val();

            $('#spinnerPostVenta').show();
            console.log('IdUsuario: '+IdUsuario);
            var contadorAplicacionesSeleccionadas = 0;
            $("#trash p").each(function() {
                contadorAplicacionesSeleccionadas = contadorAplicacionesSeleccionadas + 1;
                console.log($(this).text());
            });
            console.log("Aplicaciones: "+contadorAplicacionesSeleccionadas);
            if(IdUsuario!="0")
            {

            
                $.ajax({
                        url:"{{route('postventa.eliminaAplicacionesUsuario')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            IdUsuario: IdUsuario
                        },
                        success: function( data ) {

                            console.log('Primero: '+data[0]);
                            $('#spinnerPostVenta').hide();
                            if(data[0]=='OK')
                            {
                                //$("#ListaAplicaciones option").each(function() {
                                $("#trash p").each(function() {
                                
                                    var arregloAplicacion = $(this).text().split('; Cod.');
                                    var IdAplicacion = arregloAplicacion[1];
                                    console.log(IdAplicacion);
                                    $.ajax({
                                            url:"{{route('postventa.grabarAplicacionUsuario')}}",
                                            type: 'post',
                                            dataType: "json",
                                            data: {
                                                _token: CSRF_TOKEN,
                                                IdAplicacion: IdAplicacion,
                                                Usuario: Usuario,
                                                IdUsuario: IdUsuario
                                            },
                                            success: function( data ) {
                                                console.log('Graba: '+ IdAplicacion +' '+ data[0]);
                                                
                                            }
                                    });
                                    
                                });
                            }
                            
                        }
                });
            }



            
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnEncerar').click(function () {
            $('#consultaGeneralBuscar').val('');
            $('#consultaGeneralNombres').val('');
            $('#consultaGeneralCedularuc').val('');
            $('#consultaGeneralDireccion').val('');
            $('#consultaGeneralEmail').val('');
            $('#consultaGeneralConvencional').val('');
            $('#consultaGeneralCelular').val('');
            $('#consultaGeneralOperadora').val(''); 

            $('#Usuario').val(''); 
            $('#IdUsuario').val('0'); 
            $('#IdEntidad').val(''); 
            $('#UID').val(''); 
            $('#UsuarioSesion').val(''); 
            
            $("#to-do").find('li').remove(); // Aplicaciones Disponibles
            $("#trash").find('li').remove(); // Aplicaciones Seleccionadas

            $("#NumeroRegistros").text("0");
            $("#VehiculosActivados").text("0");
            $("#VehiculosDesactivados").text("0");
            $("#DispositivosTransmitiendo").text("0");
            $("#DispositivosDesactivados").text("0");
            $("#SimActivas").text("0");
            $("#SimDesactivadas").text("0");

            if ( $.fn.dataTable.isDataTable( '#UnidadesTabla' ) ) {
                        table = $('#UnidadesTabla').DataTable();
                        table.clear().draw();
                    } 
          

            if ( $.fn.dataTable.isDataTable( '#UnidadesCelularesEmail' ) ) {
                        table = $('#UnidadesCelularesEmail').DataTable();
                        table.clear().draw();
                    } 
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnActualizarDatos').click(function () {

            var IdEntidad = $('#IdEntidad').val();
            var IdUsuario = $('#IdUsuario').val();
            var consultaGeneralEmail = $('#consultaGeneralEmail').val();
            var consultaGeneralCelular = $('#consultaGeneralCelular').val();
            if((consultaGeneralEmail!=""||consultaGeneralCelular!="")) 
            {
                $('#spinnerPostVenta').show();

                $.ajax({
                    url:"{{route('postventa.actualizarDatos')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        IdEntidad: IdEntidad,
                        IdUsuario: IdUsuario,
                        Email: consultaGeneralEmail,
                        Celular: consultaGeneralCelular
                    },
                    success: function( data ) {
                        console.log(data);
                        $('#spinnerPostVenta').hide();
                        if(data[0]=="OK")
                            alert('Datos actualizados correctamente');
                        else
                            alert("SE HA PRODUCIDO UN ERROR: "+data[0]);
                    }
                });
            }else
            {
                alert("No hay datos ingresados. Por favor verifique.");
            }
            
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

        $( "#consultaGeneralCelular" ).autocomplete({
            minLength: 10,
            source: function( request, response ) 
            {
                console.log("Holaaaa. Manda a buscar operadora");
                $.ajax({
                    url:"{{route('postventa.buscaOperadora')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function( data ) {
                        console.log(data.Op);
                        $("#consultaGeneralOperadora").val(data.Op);
                    }
                });

            },
            select: function (event, ui) {

            }
        });
    });
</script>


<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#btConsultaSMS" ).click(function(){

                var buscar = $("#smsBuscar").val();
                var opcionBusqueda = $(".sms:checked").val();
                var buscarTiposDeMensajes = $("#verMensajes").val();
                var consultaSmsFechas = $("#consultaSmsFechas").val();
                console.log('Fechas: '+consultaSmsFechas);

                console.log(opcionBusqueda);
                console.log(buscarTiposDeMensajes);


                $('#spinnerPostVenta').show();
                
                if(buscar == null)
                    buscar = '';
                

                if (buscar=="" )
                {
                    alert('Verifique los datos ingresados para Continuar');
                    $('#spinnerPostVenta').hide();
                    return false;
                }else{
                    //$("#areaImagen").show();
                    $("#tbodyMensajes").empty();
                }
                console.log("Va a buscar SMSPostVenta");


                $.ajax({
                    url:"{{route('postventa.buscarSMSpv')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        buscar: buscar,
                        opcionBusqueda: opcionBusqueda,
                        buscarTiposDeMensajes: buscarTiposDeMensajes,
                        consultaSmsFechas: consultaSmsFechas
                        
                    
                    },
                    success: function( response ) 
                    {
                        console.log('hola');
                        console.log(response);
                        $('#spinnerPostVenta').hide();

                        //$("#areaImagen").hide();
                        $("#tbodyMensajes").empty();

                        

                        
                        var len = 0;
                        if(response != null)
                        {
                            len = response.length;
                            console.log("Trajo "+len+" alertas");
                            $("#tbodyMensajes").empty();
                        }
                        
                        if(len==0)
                        {
                            
                            $('#tablaMensajes > tbody:last-child').append('<tr><td colspan="5">No hay resultados a mostrar</td></tr>');
                        }
                        
                        for(var i=0; i<len; i++)
                        {
                            
                            if(buscarTiposDeMensajes==="EX")
                            {
                                var fecha = response[i].Fecha;
                                fecha = fecha.slice(0,19);
                                var celular = response[i].Celular;
                                var mensaje = response[i].Mensaje;
                                var longitud = response[i].Longitud;
                                var estado = response[i].Estado;
                            }else
                            {
                                var fecha = response[i].FechaHora;
                                fecha = fecha.slice(0,19);
                                var celular = response[i].MIN;
                                var mensaje = response[i].MSJ;
                                var longitud = mensaje.length;

                                var partesMensaje = mensaje.split(" ");
                                var estado = "";
                                if(longitud <= 10 || partesMensaje.length != 2)
                                    estado = "Revisar";
                                else
                                    estado = "OK";
                            }    
                            
                            
                            
                            $('#tablaMensajes > tbody:last-child').append('<tr><td>'+fecha+'</td><td>'+celular+'</td><td>'+mensaje+'</td><td>'+longitud+'</td><td>'+estado+'</td></tr>');


                        }
                        
                        //response( data );
                        
                    }
                });
                
           
        });
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.drag').draggable({ 
        appendTo: 'body',
        helper: 'clone'
    });

    $('#dropzone').droppable({
        activeClass: 'activeAplicacion',
        hoverClass: 'hover',
        accept: ":not(.ui-sortable-helper)", // Reject clones generated by sortable
        drop: function (e, ui) {
            //var $el = $('<div class="drop-item"><details><summary>' + ui.draggable.text() + '</summary></details></div>');
            //$el.append($('<button type="button" class="btn btn-default btn-xs remove"><span class="bi bi-trash"></span></button>').click(function () { $(this).parent().detach(); }));
            var texto= ui.draggable.text();
            codigo = $.trim(texto.split('; Cod.')[1]);
            var encontrado = 0;
            console.log('Hola '+codigo);
            $('#dropzone > div').children('input').each(function(){
                comparar = $.trim($(this).val().split('; Cod.')[1]);
                console.log(comparar);
                if(codigo == comparar)
                    encontrado=1;
            });
            if(encontrado==0)
            {
                var $el = $('<div class="input-group mb-3"><input type="text" disabled class="form-control" value="'+ui.draggable.text()+'" aria-describedby="button-addon2">');
                $el.append($('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>').click(function () { $(this).parent().detach(); }));
                $(this).append($el);
            }
            
        }
        }).sortable({
            items: '.drop-item',
            sort: function() {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $( this ).removeClass( "active" );
            }
    });

});

</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnIngresarGeoSys').click(function () {

            var IdEntidad = $('#IdEntidad').val();
            var IdUsuario = $('#IdUsuario').val();
            var Usuario = $('#Usuario').val();
            var consultaGeneralEmail = $('#consultaGeneralEmail').val();
            var consultaGeneralCelular = $('#consultaGeneralCelular').val();
            var uid = $('#UID').val(); 
            var usuarioSesion = $('#UsuarioSesion').val(); 

            var link = 'http://www2.huntermonitoreo.com/geotestdev/LoginV3.aspx?TIME=';

            if(IdUsuario=='')
                alert('Debe consultar un usuario para poder continuar');
            else
                window.open(link+uid+'&CTIME=' +usuarioSesion,'_blank');

            
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnRestablecerClave').click(function () {

            var IdEntidad = $('#IdEntidad').val();
            var IdUsuario = $('#IdUsuario').val();
            var Usuario = $('#Usuario').val();
            var consultaGeneralEmail = $('#consultaGeneralEmail').val();
            var consultaGeneralCelular = $('#consultaGeneralCelular').val();
            var uid = $('#UID').val(); 
            var usuarioSesion = $('#UsuarioSesion').val(); 

            console.log("uid: "+uid);

            

            if(IdUsuario==='' || IdEntidad==='')
            {   
                console.log('Debe de consultar un usuario para poder continuar'); 
                alert('Debe de consultar un usuario para poder continuar');
            }
            else
            {
                $.ajax({
                    url:"{{route('postventa.restablecerClave')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        uid: uid,
                        usuarioSesion: usuarioSesion
                      
                        
                    
                    },
                    success: function( response ) 
                    {
                        alert(response);
                        console.log("Contraseña nueva enviada con exito al usuario solicitado");
                        console.log(response);
                    }
                });
            }
                //window.open(link+uid+'&CTIME=' +usuarioSesion,'_blank');

            
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
   
   $('#fechaDesdeUnidadesSinReportar').datetimepicker({
            format: 'd/m/Y',// 00:00:00',//'Ymd H:i:s',
            changeYear: false,
            minDate: 1//,
           
            
        })
        $('#fechaHastaUnidadesSinReportar').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd/m/Y',// 23:50:00',//'Ymd H:i:s',
           
            
        })

        $('#txtRangoFechasRecorrido').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "autoUpdateInput": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true
            //"startDate": moment().startOf('minute'),
            //"minDate": moment().startOf('day').add(-1,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            //"maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#txtRangoFechasUnidadesSinReportar').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "opens": 'center',
            "startDate": moment().startOf('day').add(-1,'day'),
            "endDate": moment(),
            "maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#txtRangoFechasConsumoSMS').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "opens": 'center',
            //"startDate": moment().startOf('day').add(-1,'day'),
            //"endDate": moment(),
            "maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });

        $('#txtRangoFechasRegistrosRecorrido').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "autoUpdateInput": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true
            //"startDate": moment().startOf('minute'),
            //"minDate": moment().startOf('day').add(-1,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            //"maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#txtRangoFechasBuscarCorreosEnviados').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "maxSpan": {
                "days": 7,
                "hours": 23,
                "minutes": 59,
                "seconds": 59
            },
            "autoUpdateInput": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true,
            //"minDate": moment().startOf('day').add(-7,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            "maxDate":  moment()
            
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });

        
        $('#txtRangoFechasconsultaReenvioDatos').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "autoUpdateInput": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true,
            "minDate": moment().startOf('day').add(-7,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            "maxDate":  moment()
            
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#consultaSmsFechas').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY HH:mm:ss",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "maxSpan": {
                "days": 7//,
                //"hours": 23,
                //"minutes": 59,
                //"seconds": 59
            },
            "autoUpdateInput": true,
            "autoApply": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true,
            //"minDate": moment().startOf('day').add(-7,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            "maxDate":  moment()
            
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm:ss') + ' to ' + end.format('DD-MM-YYYY hh:mm:ss'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#txtRangoFechasComandosEnviados').daterangepicker({
            "locale": {
                "format": "YYYYMMDD HH:mm:ss",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "maxSpan": {
                "days": 3,
                "hours": 23,
                "minutes": 59,
                "seconds": 59
            },
            "autoUpdateInput": true,
            "autoApply": true,
            "timePicker": true,
            "opens": 'center',
            "timePicker24Hour": true,
            //"minDate": moment().startOf('day').add(-7,'day'),
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            "maxDate":  moment()
            
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm:ss') + ' to ' + end.format('DD-MM-YYYY hh:mm:ss'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });







</script>

<script type="text/javascript">
   
   $('#fechaDesdeConsumoSMS').datetimepicker({
            format: 'd/m/Y',// 00:00:00',//'Ymd H:i:s',
            changeYear: false,
            minDate: 1//,
           
            
        })
        $('#fechaHastaConsumoSMS').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd/m/Y',// 23:50:00',//'Ymd H:i:s',
           
            
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
                url:"{{route('assets.buscarPlacaConVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    buscar: 2
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            // Set selection
            $('#unidadBuscar').val(ui.item.label); // display the selected text
            $('#unidadPlaca').val(ui.item.value); // save selected id to input

            $.ajax({
                url:"{{route('assets.buscarUidConVidpv')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    vid: ui.item.label
                    
                },
                success: function( data ) {
                    console.log('uid: '+ data['uid']);
                    $('#uid').val(data['uid']);
                    
                }
            });
            
            return false;
        }
  });
});
</script>  

<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#vidBuscarComandosEnviados" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        {
            
            // Fetch data
            $.ajax({
                url:"{{route('assets.buscarPlacaConVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    buscar: 2
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            // Set selection
            $('#vidBuscarComandosEnviados').val(ui.item.label); // display the selected text
            //$('#vidBuscarComandosEnviados').val(ui.item.value); // save selected id to input

            
            
            return false;
        }
  });
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#btnConsultarRegistrosRecorrido').click(function () {
        
            $('#spinnerPostVenta').show();

            var uid = $('#unidadBuscar').val();
            var fechas = $('#txtRangoFechasRegistrosRecorrido').val();
            var arreglo = fechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesde').val();
            var fechaHasta = arreglo[1];//$('#fechaHasta').val();
            var placa = $('#unidadPlaca').val();

            if(uid=='')
            {    
                alert('Debe consultar un vehículo para poder continuar');
                $('#spinnerPostVenta').hide();
            }
            else
            {
                var diff = Math.abs(new Date(fechaHasta) - new Date(fechaDesde));
                diff = diff / (1000 * 60);
                console.log("Diferencia de fechas: "+diff);
                if(diff>1440)
                {    
                    alert('El Intervalo Maximo de Tiempo para el recorrido es de 24 horas');
                    $('#spinnerPostVenta').hide();
                }
                else
                {
                    var mensaje = 'Al solicitar estos registros del vehículo '+ placa + ' el cliente será informado sobre esta consulta. ¿Desea continuar?';
                    if(confirm(mensaje))
                    {
                        $.ajax({
                        url:"{{route('postventa.ActivoRecorridoConsultar')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            uid: uid,
                            placa: placa,
                            fechaDesde: fechaDesde,
                            fechaHasta: fechaHasta
                        },
                        success: function( data ) {
                            $('#spinnerPostVenta').hide();
                            console.log(data);
                            registros = data[0];
                            if ( $.fn.dataTable.isDataTable( '#RegistrosRecorridoTabla' ) ) 
                            {
                                table = $('#RegistrosRecorridoTabla').DataTable();
                                table.clear().draw();
                                table.destroy();
                            }  
                            $('#RegistrosRecorridoTabla').DataTable( {
                                dom: 'Bfrtip',
                                buttons: [
                                    'excel'
                                ],
                                processing: true,
                                data: registros,
                                responsive: true,
                                dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                                pageLength: 100,
                                lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                                language:{
                                    url:"../dataTables/lang/es-MX.json"
                                },
                                order: [[2, 'desc']],
                                columns: [
                                    {data: 'T1'},
                                    {data: 'T2'},
                                    {data: 'FechaHora (-5)'},
                                    {data: 'FechaHoraRecibido'},
                                    {data: 'FechaHoraServidor'},
                                    {data: 'FechaHoraGPS'},
                                    {data: 'FechaHoraRTC'},
                                    {data: 'Id'},
                                    {data: 'Evento'},
                                    {data: 'Latitud'},
                                    {data: 'Longitud'},
                                    {data: 'Altitud'},
                                    {data: 'Velocidad (km/h)'},
                                    {data: 'Rumbo'},
                                    {data: 'NumeroSatelites'},
                                    {data: 'EstadoGPS'},
                                    {data: 'Odometro (m)'},
                                    {data: 'ConfiguracionIO'},
                                    {data: 'EstadoIO'},
                                    {data: 'EventoEntrada'},
                                    {data: 'Nombre Evento'},
                                    {data: 'Calle'},
                                    {data: 'EstadoIgnicion'},
                                    {data: 'NivelBateria'},
                                    {data: 'VoltajeBateria'},
                                    {data: 'EA1'},
                                    {data: 'EA2'},
                                    {data: 'EA3'},
                                    {data: 'SA1'},
                                    {data: 'SA2'},
                                    {data: 'SA3'},
                                    {data: 'Horometro (s)'},
                                    {data: 'VoltajeAlimentacion'},
                                    {data: 'DriverID'},
                                    {data: 'VelocidadOBD'},
                                    {data: 'rpmOBD'},
                                    {data: 'PosicionAceleradorOBD'},
                                    {data: 'OdometroOBD'},
                                    {data: 'OdometroViajeOBD'},
                                    {data: 'NivelGasolinaOBD'},
                                    {data: 'CombustibleRestanteOBD'},
                                    {data: 'EngraneTransmisionOBD'},
                                    {data: 'TemperaturaRefrigeranteOBD'},
                                    {data: 'IndiceGasolinaOBD'},
                                    {data: 'VoltajeAlimentacionOBD'},
                                    {data: 'EstadoSeñalesGiroOBD'},
                                    {data: 'GasolinaConsumidaPorViajeOBD'},
                                    {data: 'IndicadoresOBD'},
                                    {data: 'DTC'},
                                    {data: 'Origen'}
                                ]
                            } );

                            
                            }
                        });
                    }else{
                        $('#spinnerPostVenta').hide();
                    }
                    
                }

                     
                

                
            }

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnLimpiarRegistrosRecorrido').click(function () {
            $('#unidadBuscar').val('');
            $('#idActivo').val('');
            $('#uid').val('');
            $('#unidadPlaca').val('');
           
            if ( $.fn.dataTable.isDataTable( '#RegistrosRecorridoTabla' ) ) 
            {
                table = $('#RegistrosRecorridoTabla').DataTable();
                table.clear().draw();
            } 
          

            
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnConsultarUnidadesSinReportar').click(function () {
            $('#spinnerPostVenta').show();
            rangoFechas = $("#txtRangoFechasUnidadesSinReportar").val();
            console.log(rangoFechas);
            var arreglo = rangoFechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesdeUnidadesSinReportar').val();
            var fechaHasta = arreglo[1];//$('#fechaHastaUnidadesSinReportar').val();
            console.log('Desde: '+fechaDesde+' Hasta: '+fechaHasta);

            //var diff = Math.abs(new Date(fechaHasta) - new Date(fechaDesde));
            //diff = diff / (1000 * 60);
            //console.log("Diferencia de fechas: "+diff);
                
            $.ajax({
                url:"{{route('postventa.UnidadesSinReportarConsultar')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    fechaDesde: fechaDesde,
                    fechaHasta: fechaHasta
                },
                success: function( data ) {
                    console.log(data);
                    $('#spinnerPostVenta').hide();
                    registros = data[0];
                    if ( $.fn.dataTable.isDataTable( '#UnidadesSinReportarTabla' ) ) 
                    {
                        table = $('#UnidadesSinReportarTabla').DataTable();
                        table.clear().draw();
                        table.destroy();
                    }  
                    $('#UnidadesSinReportarTabla').DataTable( {
                        dom: 'Bfrtip',
                            buttons: [
                                    'excel'
                                ],
                        processing: true,
                        data: registros,
                        //dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                        pageLength: 100,
                        lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                        responsive: true,
                        language:{
                            url:"../dataTables/lang/es-MX.json"
                        },
                        order: [[2, 'desc']],
                        columns: [
                            {data: 'CODIGO_SYSHUNTER'},
                            {data: 'VID'},
                            {data: 'ULTIMOREPORTE'},
                            {data: 'IDENTIFICACION'},
                            {data: 'PROPIETARIO'},
                            {data: 'ESTADO_COBERTURA'},
                            {data: 'ACTUALIZACION'},
                            {data: 'CIUDAD'},
                            {data: 'EJECUTIVA'},
                            {data: 'CELULAR'},
                            {data: 'CELULARES'},
                            {data: 'FIN_COBERTURA'},
                            {data: 'ESTADO_CARTERA'},
                            {data: 'PLACA'},
                            {data: 'MARCA'},
                            {data: 'PRODUCTO'},
                            {data: 'MODELO_DISPOSITIVO'},
                            {data: 'NUMERO_SIM_CARD'},
                            {data: 'OPERADORA_CELULAR'},
                            {data: 'NUMERO_CELULAR'},
                            {data: 'SERIE_DISPOSITIVO'},
                            {data: 'CORREOS_ELECTRONICOS'}
                        ]/*,
                        initComplete: function () {
                            this.api()
                                .columns()
                                .every(function () {
                                    var column = this;
                                    var select = $('<select><option value=""></option></select>')
                                        .appendTo($(column.footer()).empty())
                                        .on('change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                
                                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        });
                
                                    column
                                        .data()
                                        .unique()
                                        .sort()
                                        .each(function (d, j) {
                                            select.append('<option value="' + d + '">' + d + '</option>');
                                        });
                                });
                        }*/
                    });

                
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnLimpiarUnidadesSinReportar').click(function () {
            $('#fechaDesdeUnidadesSinReportar').val('');
            $('#fechaHastaUnidadesSinReportar').val('');
            $('#txtRangoFechasUnidadesSinReportar').val('');

           
           
            if ( $.fn.dataTable.isDataTable( '#UnidadesSinReportarTabla' ) ) 
            {
                table = $('#UnidadesSinReportarTabla').DataTable();
                table.clear().draw();
            } 
            
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnConsultarUnidadesSinEntidad').click(function () {
            $('#spinnerPostVenta').show();
            
            $.ajax({
                url:"{{route('postventa.UnidadesSinEntidadConsultar')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN
                    
                },
                success: function( data ) {
                    console.log(data);
                    registros = data[0];
                    $('#spinnerPostVenta').hide();
                    if ( $.fn.dataTable.isDataTable( '#UnidadesSinEntidadTabla' ) ) 
                    {
                        table = $('#UnidadesSinEntidadTabla').DataTable();
                        table.clear().draw();
                        table.destroy();
                    }  
                    $('#UnidadesSinEntidadTabla').DataTable( {
                        processing: true,
                        data: registros,
                        dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                        pageLength: 100,
                        lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                        responsive: true,
                        language:{
                            url:"../dataTables/lang/es-MX.json"
                        },
                        order: [[3, 'desc']],
                        columns: [
                            {data: 'Alias'},
                            {data: 'CodSysHunter'},
                            {data: 'VID'},
                            {data: 'Estado'},
                            {data: 'UltimoReporte'},
                            {data: 'UltimoReporteServidor'},
                            {data: 'Observaciones'},
                            {data: 'FechaIngreso'}
                        ]
                    });

                
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnConsultarEntidadesSinUsuario').click(function () {
            $('#spinnerPostVenta').show();
            
            $.ajax({
                url:"{{route('postventa.EntidadesSinUsuarioConsultar')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN
                    
                },
                success: function( data ) {
                    console.log(data);
                    $('#spinnerPostVenta').hide();
                    registros = data[0];
                    if ( $.fn.dataTable.isDataTable( '#EntidadesSinUsuarioTabla' ) ) 
                    {
                        table = $('#EntidadesSinUsuarioTabla').DataTable();
                        table.clear().draw();
                        table.destroy();
                    }  
                    $('#EntidadesSinUsuarioTabla').DataTable( {
                        processing: true,
                        data: registros,
                        dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                        pageLength: 100,
                        lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                        responsive: true,
                        language:{
                            url:"../dataTables/lang/es-MX.json"
                        },
                        order: [[2, 'desc']],
                        columns: [
                            {data: 'idEntidad'},
                            {data: 'TipoEntidad'},
                            {data: 'Nombre'},
                            {data: 'Direccion'},
                            {data: 'TelefonoConvencional'},
                            {data: 'TelefonoCelular'},
                            {data: 'Estado'},
                            {data: 'UsuarioIngreso'},
                            {data: 'UnidadesAsociadas'}
                        ]
                    });

                
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        let barChart;

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnConsultarConsumoSMS').click(function () {
            $('#spinnerPostVenta').show();
            var fechas = $('#txtRangoFechasConsumoSMS').val();
            var arreglo = fechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesdeConsumoSMS').val();
            var fechaHasta = arreglo[1];//$('#fechaHastaConsumoSMS').val();
            var celular = $('#celularBuscar').val();

            if(celular==''){
                alert('Debe especificar un número de teléfono celular para poder continuar');
            }
            else{
                $.ajax({
                    url:"{{route('postventa.ConsumoSMSConsultar')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta,
                        celular: celular
                        
                    },
                    success: function( data ) {
                        console.log(data);
                        registros = data[0];
                        $('#spinnerPostVenta').hide();
                        if ( $.fn.dataTable.isDataTable( '#ConsumoSMSTabla' ) ) 
                        {
                            table = $('#ConsumoSMSTabla').DataTable();
                            table.clear().draw();
                            table.destroy();
                        }  
                        $('#ConsumoSMSTabla').DataTable( {
                            processing: true,
                            data: registros,
                            dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                            pageLength: 100,
                            lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                            responsive: true,
                            language:{
                                url:"../dataTables/lang/es-MX.json"
                            },
                            order: [[2, 'desc']],
                            columns: [
                                {data: 'CANTIDAD'},
                                {data: 'PROPIETARIO'},
                                {data: 'ESTADO',
                                    render: function ( data, type, row ) {
                                        //console.log(row);
                                        datos = row['DATOS'];
                                        arregloDatos = datos.split('_');
                                        return '<a href="/xadmin/postventa/detalleSMS/'+datos+'" onclick="window.open(\'/xadmin/postventa/detalleSMS/'+datos+'_'+data+'\',\'_blank\',\'width=700,height=500\'); return false;" >'+data+'</a>';
                                    }
                                }
                            ]
                        });

                        datos = [];
                        $.each(registros, function(index,value){
                            datos.push(value.CANTIDAD);
                        });

                        // Gráfico
                        
                        var popCanvas = $("#popChart");
                        if(barChart){
                            barChart.destroy();
                        }
                        barChart = new Chart(popCanvas, {
                            type: 'bar',
                            data: {
                                labels: ["Filtrados","Enviados"],
                                datasets: [{
                                    label: 'SMS recibidos por Celular',
                                    data: datos,
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.6)',
                                        'rgba(54, 162, 235, 0.6)'
                                        //'rgba(255, 159, 64, 0.6)'
                                        
                                    ]
                                }]
                            }
                        });
                    
                    }
                });
            }
            
        });


        $('#btnConsultarComandosEnviados').click(function () {
            $('#spinnerPostVenta').show();
            var fechas = $('#txtRangoFechasComandosEnviados').val();
            var arreglo = fechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesdeConsumoSMS').val();
            var fechaHasta = arreglo[1];//$('#fechaHastaConsumoSMS').val();
            var vid = $('#vidBuscarComandosEnviados').val();

            if(vid==''){
                alert('Debe especificar vid para poder continuar');
            }
            else{
                $.ajax({
                    url:"{{route('postventa.ConsultarComandos')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta,
                        vid: vid
                        
                    },
                    success: function( data ) {
                        console.log(data);
                        registros = data[0];
                        $('#spinnerPostVenta').hide();
                        if ( $.fn.dataTable.isDataTable( '#ComandosEnviadosTabla' ) ) 
                        {
                            table = $('#ComandosEnviadosTabla').DataTable();
                            table.clear().draw();
                            table.destroy();
                        }  
                        $('#ComandosEnviadosTabla').DataTable( {
                            processing: true,
                            data: registros,
                            dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                            pageLength: 100,
                            lengthMenu: [
                                    [10, 25, 50, 100, 500, -1],
                                    [10, 25, 50, 100, 500, 'Todas'],
                                ],
                            responsive: true,
                            language:{
                                url:"../dataTables/lang/es-MX.json"
                            },
                            order: [[2, 'desc']],
                            columns: [
                                {data: 'FechaHora',
                                        render: function ( data, type, row ) {
                                            try{
                                                fecha = data.substr(0,19);
                                            }catch(error)
                                            {
                                                fecha = '';
                                            }
                                            
                                            
                                            return fecha;
                                            
                                            
                                        }
                                },
                                {data: 'FechaHoraEnviado',
                                        render: function ( data, type, row ) {
                                            try {
                                                fecha = data.substr(0,19);    
                                            } catch (error) {
                                                fecha = '';
                                            }
                                            
                                            
                                            return fecha;
                                            
                                            
                                        }
                                },
                                {data: 'vid'},
                                {data: 'TIPO'},
                                {data: 'PDU'}
                            ]
                        });

                        

                        
                    
                    }
                });
            }
            
        });



        $('#btnLimpiarConsumoSMS').click(function () {
            $('#celularBuscar').val('');
            //$('#fechaHastaUnidadesSinReportar').val('');
           
           
            if ( $.fn.dataTable.isDataTable( '#ConsumoSMSTabla' ) ) 
            {
                table = $('#ConsumoSMSTabla').DataTable();
                table.clear().draw();
            } 
            if(barChart){
                barChart.destroy();
            }
            
        });

    });
</script>


<!-- RECORRIDO -->
<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#recorridoUnidad" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        {
            placa=request.term;
            console.log(placa);
            if(placa.toUpperCase()!="")
            {
                console.log("va a buscar placa: "+request.term);
                $.ajax({
                    url:"{{route('assets.buscarActivoConVIdpv')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                        console.log(data);
                    }
                });
            }else
            {
                console.log("sin placa");
                buscaUIDSinPlaca();
            }
            
        },
            select: function (event, ui) {
            // Set selection
            $('#recorridoUnidad').val(ui.item.label); // display the selected 
            console.log("Placa: "+ui.item.placa);
            $('#recorridoPlaca').val(ui.item.placa);
            buscaVID();
            //$('#recorridoVid').val(ui.item.vid); // save selected id to input
            //console.log('Hola '+ui.item.vid)
            return false;
        }
  });
  function buscaVID()
  {
    $('#spinnerPostVenta').show();
    $.ajax({
                url:"{{route('assets.buscarVidpv')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    placa: $('#recorridoPlaca').val()
                },
                success: function( response ) 
                {
                    $('#spinnerPostVenta').hide();
                    if(response['vid'] != null)
                    {
                        //var IdMonitoreo = response['data'][i].IdMonitoreo;
                        len = response['vid'].length;
                        console.log(response['vid']);
                        console.log(response['uid']);
                        $('#recorridoVid').val(response['vid']);
                        $('#recorridoUid').val(response['uid']);
                        //location.reload();
                        //alert(response['data'].resultado);
                        
                    }
                            
                }
        });
  }
  function buscaUIDSinPlaca()
  {
      console.log("VID: "+$('#recorridoVid').val());
      $('#spinnerPostVenta').show();
    $.ajax({
                url:"{{route('assets.buscarUidConVidpv')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    vid: $('#recorridoVid').val()
                },
                success: function( response ) 
                {
                    $('#spinnerPostVenta').hide();
                    if(response['uid'] != null)
                    {
                        //var IdMonitoreo = response['data'][i].IdMonitoreo;
                        len = response['uid'].length;
                        console.log("Trajo "+len+" datos");
                        //console.log(response['vid']);
                        console.log(response['uid']);
                        //$('#recorridoVid').val(response['vid']);
                        $('#recorridoUid').val(response['uid']);
                        //location.reload();
                        //alert(response['data'].resultado);
                        
                    }
                            
                }
        });
  }

  $('#btBuscarRecorrido').click(function () {
            var placa =  $('#recorridoUnidad').val();
            if(placa=="")
            {
                $('#recorridoPlaca').val("S/P");
                buscaUIDSinPlaca();
            }
            MostrarReporteCustom();


        });



        function MostrarReporteCustom() {
            var VID = $('#recorridoVid').val();
            var vUID = $('#recorridoUid').val();
            var Placa = $('#recorridoPlaca').val();
            var fechas = $('#txtRangoFechasRecorrido').val();
            var arreglo = fechas.split(" - ");
            var Inicial = arreglo[0];//$('#recorridoFechaDesde').val();
            var Final = arreglo[1];//$('#recorridoFechaHasta').val();

            //if (VID == '' || vUID == '' || Inicial == '' || Final == '') {
            //    alert('No se puede generar el reporte, datos incompletos');
            //    return false;
            //}

            window.open('http://24hm.net/GeoTest/Paginas/Recorrido.aspx?TIME=' + vUID + '&ID=' + VID + '&P=' + Placa + '&I=CUS&T=CUS&INI=' + Inicial + '&FIN=' + Final + '&ctrl=1&FHS=1', 'vnRecorridoXA', 'status=0,left=230,top=5,fullscreen=no,width=940,height=660,menubar=no,resizable=0,titlebar=0,scrollbars=vertical', true);
            VID = null; Placa = null; Inicial = null; Final = null; Formato = null;

            return false;
        }



});
</script>

<script type="text/javascript">
   
        $('#recorridoFechaDesde').datetimepicker({
            format: 'd/m/Y H:i',
            changeYear: false,
            //minDate: 1,
            onShow: function(ct) {
                this.setOptions({
                    //maxDate: $('#recorridoFechaHasta').val() ? $('#recorridoFechaHasta').val() : false
                    }) 
                }
            
            
        })
        $('#recorridoFechaHasta').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd/m/Y H:i',
            onShow: function(ct) 
            {
                this.setOptions({
                    //minDate: $('#recorridoFechaDesde').val() ? $('#recorridoFechaDesde').val() : false
                    }) 
            }
            
            
        })

</script>

<!-- FIN RECORRIDO -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#CorreosEnviadosTabla').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#RegistrosRecorridoTabla').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#UnidadesTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#UnidadesCelularesEmail').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#UnidadesSinReportarTabla').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#UnidadesSinEntidadTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        $('#EntidadesSinUsuarioTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
        
        $('#ConsultaReenvioDatosTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });

        $('#ConsultaCorreoCelularTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });

        $('#ComandosEnviadosTabla').DataTable( {
            processing: true,
            responsive: true,
            language:{
                url:"../dataTables/lang/es-MX.json"
            }
        });
    });
</script>

<script type="text/javascript">
    function buscaRutasInput()
    {
        
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarRuta");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbodyRutas");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        /*for (i = 0; i < tr.length; i++) 
        {
            
            
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
               
            
        }*/
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            for(j=0;j<=1;j++)
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
    function buscaGeocercaRutas()
    {
        console.log('Hola');
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarGeocercaRutas");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbodyRutasGeocerca");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            for(j=0;j<=1;j++)
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
        var entidades;
        var celularesEmails;
        //var tablaUnidades = $("#tablaUnidades tbody");

        $( "#celularesEmailBuscar" ).autocomplete({
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
                        cache: false,
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
                    console.log("Aquí debería borrar");
                    // Set selection
                    $('#celularesEmailBuscar').val(ui.item.label); // display the selected 
                    
                    $('#Usuario').val(''); 
                    $('#IdUsuario').val(''); 
                    $('#IdEntidad').val(''); 
                    $('#UID').val(''); 
                    $('#UsuarioSesion').val(''); 
                    $("#tbodyCorreo").empty();
                    $("#tbodyCelulares").empty();
                    

                    
                

                    $.ajax({
                        url: "{{route('postventa.datosUsuarioConsultarDetalle2')}}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            _token: CSRF_TOKEN,
                            search: ui.item.value,
                            criterio: $("#consultaGeneralCriterio").val()
                        },
                        cache: false,
                        success: function(data1)
                        {
                            console.log("Responde: "+data1);
                            
                            document.getElementById("guardarCelular").addEventListener("click",guardarCelular,false);
                            document.getElementById("guardarCorreo").addEventListener("click",guardarCorreo,false);
                            
                            
                            if(data1['emails'].length>0)
                            {
                                emails = data1['emails'];
                                console.log(emails);
                                $.each(emails, function(index,value){
                                    if(value.Email!='')
                                    {
                                        var propietario = value.Propietario.toString();
                                        propietario = propietario.replace(/\r\n/g, '');
                                        console.log('Email: '+propietario);
                                        $('#tablaCorreos > tbody:last-child').append('<tr><td style="text-align: center;">'+value.Email+'</td><td>'+value.Propietario+'</td><td><a id="EditarCorreo_'+value.idUsuario+'_'+value.Email+'_'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCorreo_'+value.idUsuario+'_'+value.Email+'_'+propietario+'" ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                        document.getElementById("EditarCorreo_"+value.idUsuario+'_'+value.Email+'_'+propietario).addEventListener("click",editarCorreo,false);
                                        document.getElementById("EliminarCorreo_"+value.idUsuario+'_'+value.Email+'_'+propietario).addEventListener("click",eliminarCorreo,false);
                                        
                                    }
                                    
                                });
                            }else
                            {
                                emails = [];
                            }

                            if(data1['celulares'].length>0)
                            {
                                celulares = data1['celulares'];
                                console.log(celulares);
                                $.each(celulares, function(index,value){
                                    if(value.Numero!='')
                                    {
                                        var propietario = value.Propietario.toString();
                                        propietario = propietario.replace(/\r\n/g, '');
                                        console.log(propietario);
                                        $('#tablaCelulares > tbody:last-child').append('<tr><td style="text-align: center;">'+value.Numero+'</td><td>'+value.Propietario+'</td><td>&nbsp</td><td><a id="EditarCelular_'+value.idUsuario+'_'+value.Numero+'_'+propietario+'"><img src="../Imagenes/pen-to-square-solid.svg"  title="Editar"  style="height: 20px;"/></a></td><td><a id="EliminarCelular_'+value.idUsuario+'_'+value.Numero+'_'+propietario+'"  ><img src="../Imagenes/trash-can-solid.svg"  title="Eliminar"  style="height: 20px;"/></a></td>');
                                        document.getElementById("EditarCelular_"+value.idUsuario+'_'+value.Numero+'_'+propietario).addEventListener("click",editarCelular,false);
                                        document.getElementById("EliminarCelular_"+value.idUsuario+'_'+value.Numero+'_'+propietario).addEventListener("click",eliminarCelular,false);
                                        
                                    }
                                });
                                
                            }else
                            {
                                celulares = [];
                            }


                            var valores = data1['detalle'][0];
                            console.log(valores);
                            var arregloValores =  valores.split(';');
                            $('#celularesEmailNombres').val(arregloValores[1]);
                            $("#IdUsuario").val(arregloValores[7]);
                            console.log('IdUsuario: '+arregloValores[7]);
                            console.log(data1['datosAdicionales']);
                            $('#UID').val(data1['datosAdicionales'].uid); 
                            $('#UsuarioSesion').val(data1['datosAdicionales'].usuarioSesion); 

                        }
                    });
                    
                    
                    

                    return false;
                }
                
        });
        // pegar aqui
        
        
    });



    
</script>

<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        let barChart;

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnNuevoCelular').click(function () {
            dato = $("#celularesEmailBuscar").val();
            if(dato!="")
            {
                console.log("Crear celular");
                $("#areaCelular").show();
                $("#nuevoCelularNumero").val("");
                $("#nuevoCelularPropietario").val("");
                $('#nuevoCelularOperacion').val('N');
            }else
            {
                alert("Debe buscar un usuario para continuar.")
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        let barChart;

        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnNuevoCorreo').click(function () {
            dato = $("#celularesEmailBuscar").val();
            if(dato!="")
            {   
                console.log("Crear correo");
                $("#areaCorreo").show();
                $("#nuevoCorreoCorreo").val("");
                $("#nuevoCorreoPropietario").val("");
                $('#nuevoCorreoOperacion').val('N');
            }else
            {
                alert("Debe buscar un usuario para continuar.")
            }
        });
    });
</script>

<script type="text/javascript">
    /* Custom Dragula JS */
dragula([
  document.getElementById("to-do"),
  document.getElementById("trash")
]);
removeOnSpill: false
  .on("drag", function(el) {
    el.className.replace("ex-moved", "");
  })
  .on("drop", function(el) {
    el.className += "ex-moved";
  })
  .on("over", function(el, container) {
    container.className += "ex-over";
  })
  .on("out", function(el, container) {
    container.className.replace("ex-over", "");
  });

/* Vanilla JS to add a new task */
function addTask() {
  /* Get task text from input */
  var inputTask = document.getElementById("taskText").value;
  /* Add task to the 'To Do' column */
  document.getElementById("to-do").innerHTML +=
    "<li class='task'><p>" + inputTask + "</p></li>";
  /* Clear task text from input after adding task */
  document.getElementById("taskText").value = "";
}

/* Vanilla JS to delete tasks in 'Trash' column */
function emptyTrash() {
  /* Clear tasks from 'Trash' column */
  document.getElementById("trash").innerHTML = "";
}
</script>


<script type="text/javascript">
    /* Custom Dragula JS */
dragula([
  document.getElementById("to-do2"),
  document.getElementById("trash2")
]);
removeOnSpill: false
  .on("drag", function(el) {
    el.className.replace("ex-moved", "");
  })
  .on("drop", function(el) {
    el.className += "ex-moved";
  })
  .on("over", function(el, container) {
    container.className += "ex-over";
  })
  .on("out", function(el, container) {
    container.className.replace("ex-over", "");
  });

/* Vanilla JS to add a new task */
function addTask() {
  /* Get task text from input */
  var inputTask = document.getElementById("taskText").value;
  /* Add task to the 'To Do' column */
  document.getElementById("to-do2").innerHTML +=
    "<li class='task'><p>" + inputTask + "</p></li>";
  /* Clear task text from input after adding task */
  document.getElementById("taskText").value = "";
}

/* Vanilla JS to delete tasks in 'Trash' column */
function emptyTrash() {
  /* Clear tasks from 'Trash' column */
  document.getElementById("trash2").innerHTML = "";
}
</script>








<!-- REENVIO DE DATOS POR UNIDAD -->

<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#vidReenvioDatosBuscar" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        {
            
            // Fetch data
            $.ajax({
                url:"{{route('assets.buscarPlacaConVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    buscar: 2
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
            select: function (event, ui) {
            // Set selection
            $('#vidReenvioDatosBuscar').val(ui.item.label); // display the selected text
            $('#reenvioDatosPlaca').val(ui.item.value); // save selected id to input
            $('#spinnerPostVenta').show();
            $.ajax({
                url:"{{route('assets.buscarDatosReenvioDatosConVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    vid: ui.item.label,
                    placa: ui.item.value
                    
                },
                success: function( data ) {
                    $('#spinnerPostVenta').hide();
                    console.log('reporte: '+ data['reporte']);
                    $('#reenvioDatosUltimoReporte').val(data['reporte']);
                    $('#reenvioDatosProtocolo').val(data['protocolo']);


                    if(data['servidoresRegistrados'].length>0)
                    {
                        servidoresRegistrados = data['servidoresRegistrados'];
                        
                    }else
                    {
                        servidoresRegistrados = [];
                    }

                    if(data['servidoresDisponibles'].length>0)
                    {
                        servidoresDisponibles = data['servidoresDisponibles'];
                        
                    }else
                    {
                        servidoresDisponibles = [];
                    }



                    console.log('servidores registrados '+servidoresRegistrados.length);
                    console.log('servidores disponibles'+servidoresDisponibles.length);
                    console.log(servidoresDisponibles);
                        
                    document.getElementById("trash").innerHTML = '';
                    for(var i=0; i<servidoresRegistrados.length; i++)
                    {
                        //name = $.trim(servidoresRegistrados[i].Nombre);
                        id = servidoresRegistrados[i].idServidor;

                        for(var k=0;k<servidoresDisponibles.length;k++)
                        {
                            if(servidoresRegistrados[i].idServidor==servidoresDisponibles[k].idServidor)
                                name=servidoresDisponibles[k].NombreServidor;
                        }
                        
                        
                        document.getElementById("trash").innerHTML +=
                        '<li class="task" ><p>'+name+'; Cod.'+id+'</p></li>';
                        
                    }
                    var encontrado = false;
                    for(var j=0; j<servidoresDisponibles.length;j++)
                    {
                        nombre = $.trim(servidoresDisponibles[j].NombreServidor);
                        id = servidoresDisponibles[j].idServidor;
                        console.log(nombre);
                        encontrado = false;
                        for(var h=0; h<servidoresRegistrados.length&&!encontrado; h++)
                        {
                            id2 = servidoresRegistrados[h].idServidor;
                            console.log('IDs Servidores: '+id+' '+id2);
                            if(id==id2)
                            {
                                encontrado = true;
                            }
                            
                        }
                        if(encontrado==false)
                        {
                            document.getElementById("to-do").innerHTML +=
                            '<li class="task" ><p>'+nombre+'; Cod.'+id+'</p></li>';
                        }else
                        {
                            encontrado = false;
                        }

                    }





                }
            });
            
            return false;
        }
  });
});
</script>


<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnGrabarCambios').click(function () {
            placa = $("#reenvioDatosPlaca").val();
            vid = $("#vidReenvioDatosBuscar").val();
            if(placa!="")
            {
                console.log("Grabar cambios en Reenvío de Datos");
                //$("#areaCelular").show();
                //$("#nuevoCelularNumero").val("");
                //$("#nuevoCelularPropietario").val("");
                //$('#nuevoCelularOperacion').val('N');
                var contadorServidoresRegistrados = 0;
                $("#trash p").each(function() {
                    contadorServidoresRegistrados = contadorServidoresRegistrados + 1;
                    console.log($(this).text());
                });
                console.log("Servidores registrados: "+contadorServidoresRegistrados);
                $('#spinnerPostVenta').show();
                $.ajax({
                    url:"{{route('postventa.eliminaServidoresUnidad')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        vid: vid
                    },
                    success: function( data ) {
                        
                        console.log('Primero: '+data[0]);

                        if(data[0]=='OK')
                        {
                            //$("#ListaAplicaciones option").each(function() {
                            $("#trash p").each(function() {
                            
                                var arregloServidores = $(this).text().split('; Cod.');
                                var idServidor = arregloServidores[1];
                                console.log(idServidor);
                                $.ajax({
                                        url:"{{route('postventa.grabarServidoresUnidad')}}",
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            idServidor: idServidor,
                                            vid: vid
                                        },
                                        success: function( data ) {
                                            console.log('Graba: '+ idServidor +' '+ data[0]);
                                            
                                        }
                                });
                                
                            });
                            $('#spinnerPostVenta').hide();
                        }
                        
                    }
                });
            }else
            {
                alert("Debe buscar una unidad para continuar.")
            }


        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnLimpiarReenvioDatos').click(function () {
            $('#vidReenvioDatosBuscar').val('');
            $('#reenvioDatosPlaca').val('');
            $('#reenvioDatosUltimoReporte').val('');
            $('#reenvioDatosProtocolo').val('');
           
           
            
            $("#to-do").find('li').remove(); // Servidores Disponibles
            $("#trash").find('li').remove(); // Servidores Registrados

            
        });
    });
</script>


<!-- REENVIO DE DATOS POR USUARIO -->
<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnLimpiarReenvioDatosPorUsuario').click(function () {
            $('#usuarioReenvioDatosBuscar').val('');
            $('#reenvioDatosNombres').val('');
            
           
            
            $("#to-do2").find('li').remove(); // Servidores Disponibles
            $("#trash2").find('li').remove(); // Servidores Registrados

            
        });
    });
</script>


<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#usuarioReenvioDatosBuscar" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        { 
            
            // Fetch data
            $.ajax({
                url:"{{route('postventa.datosUsuarioConsultar')}}",
                        type: 'post',
                        dataType: "json",
                        cache: false,
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            criterio: '4'
                        },
                success: function( data ) {
                    response( data );
                }
            });
        },
            select: function (event, ui) {
            // Set selection
            $('#usuarioReenvioDatosBuscar').val(ui.item.label); // display the selected text
            console.log(ui.item.label);
            console.log(ui.item.value);
            $('#spinnerPostVenta').show();
            
            $.ajax({
                url: "{{route('postventa.datosUsuarioConsultarDetalleConServidores')}}",
                type: 'post',
                dataType: 'json',
                data: {
                    _token: CSRF_TOKEN,
                    search: ui.item.value,
                    criterio: '4'
                },
                cache: false,
                success: function(data)
                {
                    
                    $('#spinnerPostVenta').hide();
                    console.log(data);
                    if(data['servidoresRegistrados'].length>0)
                    {
                        servidoresRegistrados = data['servidoresRegistrados'];
                        
                    }else
                    {
                        servidoresRegistrados = [];
                    }

                    if(data['servidoresDisponibles'].length>0)
                    {
                        servidoresDisponibles = data['servidoresDisponibles'];
                        
                    }else
                    {
                        servidoresDisponibles = [];
                    }



                    console.log('servidores registrados '+servidoresRegistrados.length);
                    console.log('servidores disponibles'+servidoresDisponibles.length);
                    console.log(servidoresDisponibles);
                        
                    document.getElementById("trash2").innerHTML = '';
                    for(var i=0; i<servidoresRegistrados.length; i++)
                    {
                        //name = $.trim(servidoresRegistrados[i].Nombre);
                        id = servidoresRegistrados[i].idServidor;

                        for(var k=0;k<servidoresDisponibles.length;k++)
                        {
                            if(servidoresRegistrados[i].idServidor==servidoresDisponibles[k].idServidor)
                                name=servidoresDisponibles[k].NombreServidor;
                        }
                        
                        
                        document.getElementById("trash2").innerHTML +=
                        '<li class="task" ><p>'+name+'; Cod.'+id+'</p></li>';
                        
                    }
                    var encontrado = false;
                    for(var j=0; j<servidoresDisponibles.length;j++)
                    {
                        nombre = $.trim(servidoresDisponibles[j].NombreServidor);
                        id = servidoresDisponibles[j].idServidor;
                        console.log(nombre);
                        encontrado = false;
                        for(var h=0; h<servidoresRegistrados.length&&!encontrado; h++)
                        {
                            id2 = servidoresRegistrados[h].idServidor;
                            console.log('IDs Servidores: '+id+' '+id2);
                            if(id==id2)
                            {
                                encontrado = true;
                            }
                            
                        }
                        if(encontrado==false)
                        {
                            document.getElementById("to-do2").innerHTML +=
                            '<li class="task" ><p>'+nombre+'; Cod.'+id+'</p></li>';
                        }else
                        {
                            encontrado = false;
                        }

                    }


                    var valores = data['detalle'][0];
                    console.log(valores);
                    var arregloValores =  valores.split(';');
                    $('#reenvioDatosNombres').val(arregloValores[1]);
                    $('#IdUsuario').val(arregloValores[7]);





                }
            });
            
            return false;
        }
  });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#btConsultaCorreosEnviados').click(function (){
            buscar = $("#correosBuscar").val();
            var fechas = $('#txtRangoFechasBuscarCorreosEnviados').val();
            var arreglo = fechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesde').val();
            var fechaHasta = arreglo[1];//$('#fechaHasta').val();
            $('#spinnerPostVenta').show();
            console.log("Inicia ejecucion ConsultaCorreosEnviados");
            
            $.ajax({
                    url:"{{route('postventa.consultaCorreosEnviadosPost')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        buscar: buscar,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta
                    },
                    success: function( data ) {
                        console.log("Ha terminado ejecucion ConsultaCorreosEnviados");
                        console.log(data);
                        $('#spinnerPostVenta').hide();
                        if ( $.fn.dataTable.isDataTable( '#CorreosEnviadosTabla' ) ) 
                        {
                            table = $('#CorreosEnviadosTabla').DataTable();
                            table.clear().draw();
                            table.destroy();
                        } 
                        registros = data[0];
                         
                        $('#CorreosEnviadosTabla').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                    'excel'
                                ],
                            processing: true,
                            data: registros,
                            //dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                            pageLength: 100,
                            lengthMenu: [
                                        [10, 25, 50, 100, 500, -1],
                                        [10, 25, 50, 100, 500, 'Todas'],
                                    ],
                            responsive: true,
                            language:{
                                url:"../dataTables/lang/es-MX.json"
                            },
                            order: [[0, 'desc']],
                            columns: [
                                //{data: 'FechaHoraEnviado'},
                                {data: 'FechaHoraEnviado',
                                        render: function ( data, type, row ) {
                                            fecha = data.substr(0,19);
                                            
                                            return '<span style="color:black">'+fecha+'</span>';
                                            
                                            
                                        }
                                    },
                                {data: 'TO',
                                    render: function ( data, type, row ) {
                                            
                                            
                                            return '<span style="color:black">'+data+'</span>';
                                            
                                            
                                        }
                                },
                                //{data: 'CC'},
                                //{data: 'BCC'},
                                {data: 'Subject',
                                    render: function ( data, type, row ) {
                                            
                                            
                                            return '<span style="color:black">'+data+'</span>';
                                            
                                            
                                        }
                                }
                            ]
                        });
                    }
                });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        $( "#consultaReenvioDatosBuscar" ).autocomplete({
            minLength: 3,
            source: function( request, response ) 
            {
                
                // Fetch data
                $.ajax({
                    url:"{{route('assets.buscarPlacaConVid')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                        buscar: 2
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                console.log(ui.item.label);
                $('#consultaReenvioDatosBuscar').val(ui.item.label); // display the selected text
                return false;
            }
        });


        $('#btConsultaReenvioDatos').click(function (){
            buscar = $("#consultaReenvioDatosBuscar").val();
            var fechas = $('#txtRangoFechasconsultaReenvioDatos').val();
            var arreglo = fechas.split(" - ");
            var fechaDesde = arreglo[0];//$('#fechaDesde').val();
            var fechaHasta = arreglo[1];//$('#fechaHasta').val();
            $('#spinnerPostVenta').show();
            
            $.ajax({
                    url:"{{route('postventa.consultaReenvioDatosPost')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        buscar: buscar,
                        fechaDesde: fechaDesde,
                        fechaHasta: fechaHasta
                    },
                    success: function( data ) {
                        console.log(data);
                        $('#spinnerPostVenta').hide();
                        if ( $.fn.dataTable.isDataTable( '#ConsultaReenvioDatosTabla' ) ) 
                        {
                            table = $('#ConsultaReenvioDatosTabla').DataTable();
                            table.clear().draw();
                            table.destroy();
                        } 
                        registros = data[0];
                         
                        $('#ConsultaReenvioDatosTabla').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                    'excel'
                                ],
                            processing: true,
                            data: registros,
                            //dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                            pageLength: 100,
                            lengthMenu: [
                                        [10, 25, 50, 100, 500, -1],
                                        [10, 25, 50, 100, 500, 'Todas'],
                                    ],
                            responsive: true,
                            language:{
                                url:"../dataTables/lang/es-MX.json"
                            },
                            order: [[0, 'desc']],
                            columns: [
                                //{data: 'FechaHoraEnviado'},
                                {data: 'FechaHora',
                                        render: function ( data, type, row ) {
                                            
                                            

                                            try
                                            {
                                                fecha = data.substr(0,19);
                                            }catch(error)
                                            {
                                                fecha = '';
                                            }
                                            
                                            return fecha;
                                            
                                            
                                        }
                                    },
                                {data: 'FechaHoraTransaccion',
                                        render: function ( data, type, row ) {
                                            fecha = data.substr(0,19);
                                            
                                            return fecha;
                                            
                                            
                                        }
                                    },
                                {data: 'Evento'},
                                {data: 'Destino'},
                                {data: 'Respuesta'}
                            ]
                        });
                    }
                });
        }); 

        $('#btConsultaCorreoCelular').click(function (){
            buscar = $("#consultaCorreoCelularBuscar").val();
            
            $('#spinnerPostVenta').show();
            
            $.ajax({
                    url:"{{route('postventa.consultaUsuariosCorreoCelularPost')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        buscar: buscar
                        
                    },
                    success: function( data ) {
                        console.log(data);
                        $('#spinnerPostVenta').hide();
                        if ( $.fn.dataTable.isDataTable( '#ConsultaCorreoCelularTabla' ) ) 
                        {
                            table = $('#ConsultaCorreoCelularTabla').DataTable();
                            table.clear().draw();
                            table.destroy();
                        } 
                        registros = data[0];
                         
                        $('#ConsultaCorreoCelularTabla').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                    'excel'
                                ],
                            processing: true,
                            data: registros,
                            //dom: '<"top"lifp>rt<"bottom"ifp><"clear">',
                            pageLength: 100,
                            lengthMenu: [
                                        [10, 25, 50, 100, 500, -1],
                                        [10, 25, 50, 100, 500, 'Todas'],
                                    ],
                            responsive: true,
                            language:{
                                url:"../dataTables/lang/es-MX.json"
                            },
                            order: [[0, 'desc']],
                            columns: [
                                {data: 'IdEntidad'},
                                {data: 'Usuario'},
                                {data: 'Nombre'},
                                {data: 'Email'},
                                {data: 'TelefonoCelular'}
                            ]
                        });
                    }
                });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#btnGrabarCambiosPorUsuario').click(function () {
            usuario = $("#usuarioReenvioDatosBuscar").val();
            idUsuario = $("#IdUsuario").val();
            $('#spinnerPostVenta').show();
            if(idUsuario!="")
            {
                console.log("Grabar cambios en Reenvío de Datos Por Usuario");
                //$("#areaCelular").show();
                //$("#nuevoCelularNumero").val("");
                //$("#nuevoCelularPropietario").val("");
                //$('#nuevoCelularOperacion').val('N');
                var contadorServidoresRegistrados = 0;
                $("#trash2  p").each(function() {
                    contadorServidoresRegistrados = contadorServidoresRegistrados + 1;
                    console.log($(this).text());
                });
                console.log("Servidores registrados por usuario: "+contadorServidoresRegistrados);

                $.ajax({
                    url:"{{route('postventa.eliminaServidoresPorUsuario')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        idUsuario: idUsuario
                    },
                    success: function( data ) {

                        console.log('Primero: '+data[0]);

                        if(data[0]=='OK')
                        {
                            //$("#ListaAplicaciones option").each(function() {
                            $("#trash2 p").each(function() {
                            
                                var arregloServidores = $(this).text().split('; Cod.');
                                var idServidor = arregloServidores[1];
                                console.log(idServidor);
                                $.ajax({
                                        url:"{{route('postventa.grabarServidoresPorUsuario')}}",
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            idServidor: idServidor,
                                            idUsuario: idUsuario
                                        },
                                        success: function( data ) {
                                            console.log('Graba: '+ idServidor +' '+ data[0]);
                                            
                                        }
                                });
                                
                            });
                            $('#spinnerPostVenta').hide();
                        }
                        
                    }
                });
            }else
            {
                alert("Debe buscar un usuario para continuar.")
            }


        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var tabla = $('#DetalleSMSTabla').DataTable();

        $('#DetalleSMSTabla tbody').on('click', 'tr', function () {
            var data = tabla.row(this).data();
            var numero = $('#detalleSMSNumero').val();
            var fechaDesde = $('#detalleSMSFechaDesde').val();
            var fechaHasta = $('#detalleSMSFechaHasta').val();
            var tipo = $('#detalleSMSTipo').val();
            var datos = numero+'_'+fechaDesde+'_'+fechaHasta+'_'+tipo;
            window.open('/xadmin/postventa/detalleSMSvid/'+datos+'_'+data[0],'_blank',width=700,height=500); 
            //alert('You clicked on ' + data[2] + "'s row");
        });

        $('#DetalleSMSTablaVid').DataTable();
        
    });
</script>




</body>
</html>
