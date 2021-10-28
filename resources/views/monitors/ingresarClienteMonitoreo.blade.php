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
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/clienteMonitoreo">Consultar, actualizar o eliminar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/asociarClienteMonitoreo">Asociar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @include('common.errors')
        @include('common.success')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Ingresar</div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <form class="form-group" method="POST" action="/xadmin/monitors/storeIngresarClienteMonitoreo">
                                        @csrf
                                            <div class="form-group">
                                                <select class="form-control-sm" id="selTipo">
                                                    <option selected value="0">Seleccione el tipo</option>
                                                    <option value="I">Interno</option>
                                                    <option value="E">Externo</option>
                                                    <option value="T">Tercero</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="grupoClienteCarseg" style="display: none;">
                                                <label for="clienteCarseg">Cliente CARSEG S.A.</label>
                                                <select class="form-control form-control-sm" id="selClienteCarseg" name="selClienteCarseg">
                                                    <option selected value="0">Seleccione una opción</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>

                                            <div class="form-group" id="grupoCedula">
                                                <label for="cedulaRUC">Cédula o RUC</label>
                                                <input type="text" class="form-control form-control-sm" id="txtCedulaRUC" name="txtCedulaRUC" value="{{ old('txtCedulaRUC') }}">
                                                <div id=cedulaList></div>
                                            </div>
                                            <div class="form-group" id="grupoNombre">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control form-control-sm" id="txtNombre" name="txtNombre" value="{{ old('txtNombre') }}">
                                            </div>

                                            <div class="form-group" id="grupoUsuario">
                                                <label for="usuario">Usuario:</label>
                                                <input type="text" class="form-control form-control-sm" id="txtUsuario" name="txtUsuario" value="{{ old('txtUsuario') }}">
                                            </div>
                                            <div class="form-group" id="grupoClave">
                                                <label for="clave">Contraseña:</label>
                                                <input type="text" class="form-control form-control-sm" id="txtClave" name="txtClave">
                                            </div>
                                            <div class="form-group" id="grupoEmail">
                                                <label for="email">Email:</label>
                                                <input type="text" class="form-control form-control-sm" id="txtEmail" name="txtEmail" value="{{ old('txtEmail') }}">
                                            </div>

                                            <div class="form-group" id="grupoValidoHasta" style="display: none;">
                                                <label for="validoHasta">Válido hasta</label>
                                                <input type="text" class="form-control form-control-sm" id="txtValidoHasta" name="txtValidoHasta" value="{{ old('txtValidoHasta') }}" autocomplete="off">
                                            </div>

                                            
                                            <button type="submit" class="btn btn-primary">Ingresar</button>

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
    </div>
                        
</body>


<script type='text/javascript'>

    $(document).ready(function()
    {

        // Cambia evento
        $('#selTipo').change(function()
        {
            // Tipo de cliente 
            var tipoCliente = $(this).val();

            switch (tipoCliente) {
                case 'I':  //Interno
                    $("#grupoValidoHasta").hide();
                    $("#grupoCedula").show();
                    $("#grupoClienteCarseg").hide();
                    break;
                case 'E':  //Externo
                    $("#grupoValidoHasta").show();
                    $("#grupoCedula").hide();
                    $("#grupoClienteCarseg").hide();
                    $("#txtNombre").val("");
                    $("#txtNombre").removeAttr('disabled');
                    break;
                case 'T':  //Tercero
                    $("#grupoValidoHasta").hide();
                    $("#grupoClienteCarseg").show();
                    $("#grupoCedula").hide();
                    $("#txtNombre").val("");
                    $("#txtNombre").removeAttr('disabled');
                    break;
            }

            $('#txtClave').val(randomPassword(10));
        });

        function randomPassword(size) {
            var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+?%^&)";
            //var size = 8;
            var i = 1;
            var ret = ""
            while ( i <= size ) {
                $max = chars.length-1;
                $num = Math.floor(Math.random()*$max);
                $temp = chars.substr($num, 1);
                ret += $temp;
                i++;
            }
            return ret;
        }


        // Cambia evento
        $('#selClienteCarseg').change(function()
        {
            // Tipo de cliente 
            var clienteCarseg = $(this).val();

            switch (clienteCarseg) {
                case 'SI':  
                    $("#grupoCedula").show();
                    break;
                case 'NO':  
                    $("#txtNombre").val("");
                    $("#txtNombre").removeAttr('disabled');
                    $("#grupoCedula").hide();
                    $("#txtCedulaRUC").val("");
                    break;
                
            }
        });
    });

</script>

<script type='text/javascript'>
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function()
    {
        $( "#txtCedulaRUC" ).autocomplete({
                source: function( request, response ) 
                {
                    
                    // Fetch data
                    $.ajax({
                        url:"{{route('monitors.getClienteMonitoreo')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                            
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                    },
                    select: function (event, ui) {
                        // Set selection
                        $('#txtCedulaRUC').val(ui.item.value); // display the selected text
                        $('#txtNombre').val(ui.item.label); // save selected id to input
                        //$("#txtNombre").attr('disabled', 'disabled');
                        //traeUltimosMonitoreos();
                        //traeProductos();
                        return false;
                    
                     }
        });  
        
        
    });

</script>

<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
<script type="text/javascript">
   
        $('#txtValidoHasta').datetimepicker({
            format: 'd/m/Y H:i',
            changeYear: true,
            minDate: 0,
            
            
            
        });
        

        


   
</script>
