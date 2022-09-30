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
        <link rel="stylesheet" href="{{asset('cyborg/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('cyborg/bootstrap.css') }}">
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
                              <?php
                                $usuario = session('usuario');
                              ?>
                                @guest
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="/xadmin/monitors/hojasDeRutaClientes/admin/{{$usuario}}">Hojas de Ruta</a>
                                    </li>
                                    
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
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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

        $("#btn_Enviar").click(function(){
            $.ajax({
                    url:"{{route('hojasDeRutaCliente.send')}}",
                    type: 'post',
                    dataType: "json",
                    data: $("#updateHojaRutaForm").serialize(),//{
                      //_token: CSRF_TOKEN
                      
                    
                    //},
                    success: function( response ) {
                        //len = response['data'].length;
                        console.log(response);
                        alert(response);
                    }
            });
        });

        $('#chkActivos').change(function()
        {
            var placa = $('#chkActivos option:selected').text();
            console.log(placa);
            $('#txtVehiculoPlaca').val(placa);
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












</body>
</html>
