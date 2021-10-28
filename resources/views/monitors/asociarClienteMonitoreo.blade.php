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
        <!--<nav class="navbar navbar-expand-lg navbar-light bg-light">-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <!--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">-->
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/ingresarClienteMonitoreo">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/xadmin/monitors/clienteMonitoreo">Consultar, actualizar o eliminar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Asociar</a>
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
                        <div class="card-header">Asociar</div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <form class="form-group" method="POST" action="/xadmin/monitors/storeAsociarClienteMonitoreo">
                                            @csrf
                                            <div class="form-group" id="grupoTercero" >
                                                <label for="chkTercero">Tercero:</label>
                                                <select class="form-control form-control-sm" id="chkTercero" name="chkTercero">
                                                    @foreach($terceros as $tercero)
                                                    <option value='{{$tercero->Codigo}}' >{{ $tercero->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                                <label >Asociar a</label>
                                            
                                            <div class="form-group" id="grupoCliente" >
                                                <label for="chkCliente">Cliente:</label>
                                                <select class="form-control form-control-sm" id="chkCliente" name="chkCliente">
                                                     @foreach($clientes as $cliente)
                                                    <option value='{{$cliente->Codigo}}' >{{ $cliente->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                                <label >En su monitoreo</label>
                                            
                                            <div class="form-group" id="grupoMonitoreo" >
                                                <label for="chkMonitoreo">Monitoreo:</label>
                                                <select class="form-control form-control-sm" id="chkMonitoreo" name="chkMonitoreo">
                                                    <option value='0' selected ></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="tercero" name="tercero"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="tipoCliente" name="tipoCliente"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="cliente" name="cliente"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="IdMonitoreo" name="IdMonitoreo"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="terceroNombre" name="terceroNombre"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="clienteNombre" name="clienteNombre"  >
                                                
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control form-control-sm" id="textoMonitoreo" name="textoMonitoreo"  >
                                                
                                            </div>
                                            <button type="submit" class="btn btn-primary">Asociar</button>
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
<script type='text/javascript'>

    $(document).ready(function()
    {

        // Cambia cliente
        $('#chkCliente').change(function()
        {
                //alert('hola');
                var cliente = $(this).val();
                var codCliente = cliente.split("&");
                $("#cliente").val(codCliente[0]);
                $("#tipoCliente").val(codCliente[1]);
                $("#clienteNombre").val($("#chkCliente option:selected").text());
                //alert(codCliente[0]);
                // Encera eventos
                $('#chkMonitoreo').find('option').remove();
                // AJAX request 
                $.ajax({
                    url: '/xadmin/monitors/getMonitoreosActivosXCliente/'+codCliente[0],
                    type: 'get',
                    dataType: 'json',
                    success: function(response)
                    {

                        var len = 0;
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                        }

                        

                        if(len > 0)
                        {
                            var option = "<option value='0' selected></option>"; 
                            $("#chkMonitoreo").append(option); 
                            // Le datos y crea <option >
                            for(var i=1; i<len; i++)
                            {

                                var id = response['data'][i].Codigo;
                                var name = response['data'][i].Descripcion;
                                var option = "<option value='"+id+"'>"+name+"</option>"; 
                                $("#chkMonitoreo").append(option); 
                            }
                            opts = $('#chkMonitoreo option').map(function () {
                                    return [[this.value, $(this).text()]];
                            });
                        }

                    }
                });
        });
    });

</script>

<script type='text/javascript'>

    $(document).ready(function()
    {

        // Cambia cliente
        $('#chkMonitoreo').change(function()
        {
            $("#IdMonitoreo").val($(this).val());
            $("#textoMonitoreo").val($("#chkMonitoreo option:selected").text());
        });
    });
</script>

<script type='text/javascript'>

    $(document).ready(function()
    {

        // Cambia cliente
        $('#chkTercero').change(function()
        {
            $("#tercero").val($(this).val());
            $("#terceroNombre").val($("#chkTercero option:selected").text());
        });
    });
</script>