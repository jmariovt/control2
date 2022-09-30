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
<!--    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <!-- Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> COMENTADO PARA VER QUE PASA-->
    <script type="text/javascript" src="{{asset('js/daterangepicker.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />


    

       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">
    
    <!-- Este estilo es para la tabla principal de los montoreos -->
    <style type="text/css">
        .table-condensed{
            font-size: 11px;
            }
        .optgroup { font-size:20px; }
    </style>

    <style type="text/css">
        .bg-card-orange {
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>
    
    <style type="text/css">
        .highlight { background-color: green; }
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
    </style>

    <!-- JS, Popper.js, and jQuery -->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">

   
    


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark">-->
        <!--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">-->
            <div class="container-fluid">
                <!--<a class="navbar-brand" href="{{ url('/home') }}">-->
                <a class="navbar-brand" href="">
                    {{ config('app.name', 'Laravel') }}
			<img src="{{asset('Imagenes/Ecuador40.png')}}" style="height: 20px;"/>
		</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                        @if (Auth::guard('web')->check() || Auth::guard('websubusers')->check())
                            @if (Auth::guard('web')->check())
                                <li class="nav-item">
                                    <a class="nav-link" href="/xadmin/puntos">Puntos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/xadmin/geofences">Geocercas</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="/xadmin/monitors">Monitoreos</a>
                            </li>
                            @if (Auth::guard('web')->check())
                                <li class="nav-item">
                                    <a class="nav-link" href="/xadmin/monitors/recorrido">Recorrido</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/xadmin/monitors/consultaSMS">Consulta de SMS</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link" href="#">Asig. Monit. x Producto</a>
                                </li>-->
                                <li class="nav-item">
                                    <a class="nav-link" href="/xadmin/paths">Rutas</a>
                                </li>
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Auth::guard('web')->check() || Auth::guard('websubusers')->check())
                            <li class="nav-item dropdown">
                                    <?php
                                        if(Auth::guard('web')->check())
                                        {
                                            $Nombre = Auth::guard('web')->user()->Nombre;
                                            $logout = 'logout';
                                        }
                                        else
                                        {
                                            $Nombre = session('nombre');//Auth::guard('websubusers')->user()->Nombre;
                                            $logout = 'extlogout';
                                        }
                                    ?>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ $Nombre }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route($logout) }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route($logout) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                            </li>
                        @else
                            <li class="nav-item">
                            <!--<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>-->
                                <a class="nav-link" href="">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('registerer'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        
                            
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

       
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    


</body>
</html>

<!--<script>
    $(document).ready(function(){
        $('#alias').keyup(function(){
            var query = $(this).val();
            var buscarPor = $('#buscarPor').val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('assets.getAssets')}}",
                    method:"POST",
                    data:{query:query,_token:_token},
                    success:function(data)
                    {
                        $('#aliasList').fadeIn();
                        $('#aliasList').html(data);
                    }
                });
            }
        });
    });
</script>-->
<!-- Script -->


<script type="text/javascript">
    function buscaMonitoreosInput()
    {
        console.log('Hola');
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarMonitoreo");
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
                            //$('td').removeHighlight().highlight(filter);
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

    $(document).ready(function(){
        setInterval(function()
            {
                actualizaContadores();
                
            }, 300);
        
        setInterval(function()
            {
                //location.reload();
                //actualizaContadores();
                
            }, 10000);
        
        
    });

    window.onload = function() {
        if(document.getElementById("tbodyMonitoreos")){
            console.log('Page Monitoreos is loaded');
            if(localStorage["soloporiniciar"] == "1"){
                console.log('Mostrar solo por iniciar');
                localStorage.setItem("soloporiniciar", "0");
                //muestraSoloNoIniciados();
            }
        }
        if(document.getElementById("FechaHoraInicioFin")){
            var fechaIni = $('#FechaHoraInicio').val();
            var fechaFin = $('#FechaHoraFin').val();
            //$('#FechaHoraInicioFin').data('daterangepicker').setStartDate(fechaIni);
            //$('#FechaHoraInicioFin').data('daterangepicker').setEndDate(fechaFin);
        }
    };

    function actualizaContadores()
    {
        //console.log('Entra a actualizar contadores');
        //actualizaReportando();
        if(document.getElementById("tbodyMonitoreos")){
            if(localStorage["update"] == "1"){
                location.reload();
                localStorage.setItem("update", "0");
            }
            actualizaIniciados();
            actualizaEnPantalla();
            actualizaSinEventosAsignados();
            actualizaReportando();
        }
    }

    function actualizaReportando()
    {
        //console.log('Hola');
        var table, tr, td, i, txtValue, reportando=0, noReportando=0;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            
                
                    td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        txtValue =  td.textContent ;//|| td.innerText;
                        if (txtValue.slice(0,1)=="1") {
                            //tr[i].style.display = "";
                            reportando++;
                        } else {
                            //tr[i].style.display = "none";
                            noReportando++;
                        }
                    }
                
            
            
        }
        $("#contadorReportando").text(reportando);
        $("#contadorNoReportando").text(noReportando);
    }

    function actualizaIniciados()
    {
        //console.log('Verifica Iniciados');
        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            
                
                    td = tr[i].getElementsByTagName("td")[15];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        //console.log(txtValue);
                        if (txtValue=="Detener") {
                            
                            contadorIniciados++;
                        } else {
                            contadorNoIniciados++;
                        }
                    }
                
            
            
        }
        $("#contadorIniciados").text(contadorIniciados);
        $("#contadorNoIniciados").text(contadorNoIniciados);
    }

    function actualizaEnPantalla()
    {
        //console.log('Verifica En Pantalla');
        var table, tr, td, i, txtValue, contador=0, filter;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");
        
        // Loop through all table rows, and hide those who don't match the search query
        
            var continua = 1;
            for(i=0;i<tr.length;i++)
            {
                td = tr[i].getElementsByTagName("td")[0];
                if(td)
                    contador++;
            }
            //contador = tr.length;
            $("#contadorEnPantalla").text(contador);
                
        
    }

    function actualizaSinEventosAsignados()
    {
        var table, tr, td, i, txtValue, contador=0, filter;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");
        
        // Loop through all table rows, and hide those who don't match the search query
        
            var continua = 1;
            for(i=0;i<tr.length;i++)
            {
                td = tr[i].getElementsByTagName("td")[10];
                if(td)
                {
                    txtValue = td.innerText;
                    //console.log(txtValue.length);
                    if(txtValue.length<=1)
                        contador++;
                }
                    
            }
            //contador = tr.length;
            $("#contadorSinEventos").text(contador);
    }

    $("#switchNoIniciados").change(function(){
        var buscar = $("#switchNoIniciados").is(':checked');
        if(buscar==true)     
            console.log("Hola no inciados "+buscar);
        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        $("#switchSinEventos").prop("checked", false);
        $("#switchNoReportando").prop("checked", false);
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) 
            tr[i].style.display = "";
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            
                
            td = tr[i].getElementsByTagName("td")[15];
            if (td) {
                txtValue = td.textContent || td.innerText;
                //console.log(txtValue);
                if (txtValue=="Detener") 
                {
                    if(buscar==true)      
                        tr[i].style.display = "none";
                    else
                        tr[i].style.display = "";
                } else {
                    tr[i].style.display = "";
                }
            }
                
            
            
        }
    });
    $("#switchNoReportando").change(function(){

        var buscar = $("#switchNoReportando").is(':checked');
        if(buscar==true)     
            console.log("Hola no reportando "+buscar);
        var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
        $("#switchSinEventos").prop("checked", false);
        $("#switchNoIniciados").prop("checked", false);
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) 
            tr[i].style.display = "";
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            var continua = 1;
            
                td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        txtValue =  td.textContent ;//|| td.innerText;
                        if (txtValue.slice(0,1)=="1") {
                            if(buscar==true)      
                                tr[i].style.display = "none";
                            else
                                tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "";
                        }
                    }
            
                
            
            
        }
    });
    $("#switchSinEventos").change(function(){

        console.log("Hola sin eventos");
        var buscar = $("#switchSinEventos").is(':checked');
        var table, tr, td, i, txtValue, contador=0, filter;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        $("#switchNoReportando").prop("checked", false);
        $("#switchNoIniciados").prop("checked", false);
        table = document.getElementById("tbodyMonitoreos");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) 
            tr[i].style.display = "";
        // Loop through all table rows, and hide those who don't match the search query
        
            var continua = 1;
            for(i=0;i<tr.length;i++)
            {
                td = tr[i].getElementsByTagName("td")[10];
                if(td)
                {
                    txtValue = td.innerText;
                    //console.log(txtValue.length);
                    if(txtValue.length>1)
                    {   if(buscar==true)      
                            tr[i].style.display = "none";
                        else
                            tr[i].style.display = "";
                    }else
                        tr[i].style.display = "";
                }
                    
            }

    });

</script>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){


        $( "#txtProducto" ).autocomplete({
                source: function( request, response ) 
                {
                    
                    // Fetch data
                    $.ajax({
                        url:"{{route('products.buscarNombreProducto')}}",
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
                        $('#txtProducto').val(ui.item.label); // display the selected text
                        
                        return false;
                    }
        });
    });
</script>


<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){


    $( "#aliasMonitoreosAnteriores" ).autocomplete({
        source: function( request, response ) 
        {
            var idUsuario = $("#idUsuario").val();
            var idSubUsuario = $("#idSubUsuario").val();
            // Fetch data
            $.ajax({
                url:"{{route('assets.buscarActivoConId')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    idUsuario: idUsuario,
                    idSubUsuario: idSubUsuario
                },
                success: function( data ) {
                    response( data );
                }
            });
            },
            select: function (event, ui) {
            // Set selection
            $('#aliasMonitoreosAnteriores').val(ui.item.label); // display the selected text
            $('#idActivoAux').val(ui.item.value); // save selected id to input
            traeUltimosMonitoreos2();
            //traeProductos2();
            return false;
        }
  });

  $( "#alias" ).autocomplete({
        source: function( request, response ) 
        {
            var idUsuario = $("#idUsuario").val();
            var idSubUsuario = $("#idSubUsuario").val();
            // Fetch data
            $.ajax({
                url:"{{route('assets.buscarActivoConId')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                    idUsuario: idUsuario,
                    idSubUsuario: idSubUsuario
                },
                success: function( data ) {
                    response( data );
                }
            });
            },
            select: function (event, ui) {
            // Set selection
            $('#alias').val(ui.item.label); // display the selected text
            $('#idActivo').val(ui.item.value); // save selected id to input
            traeUltimosMonitoreos();
            traeProductos();
            return false;
        }
  });

  function traeUltimosMonitoreos() { 
    console.log("Holaaa"); 
    var IdActivo = $("#idActivo").val();
    // AJAX request 
    $.ajax({
                url: '/xadmin/monitors/getLastMonitors/'+IdActivo,
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
                        $('#monitoreos').find('option').remove();
                        // Le datos y crea <option >
                        var option = "<option value='0'>Elija un monitoreo anterior</option>";
                        $("#monitoreos").append(option);
                        for(var i=0; i<len; i++)
                        {

                            var idMonitoreo = response['data'][i].IdMonitoreo;
                            var horaInicio = response['data'][i].FechaHoraInicio;
                            var horaFin = response['data'][i].FechaHoraFin;

                            var option = "<option value='"+idMonitoreo+"'>"+idMonitoreo+"; "+horaInicio+"; "+horaFin+"</option>"; 

                            $("#monitoreos").append(option); 
                        }
                    }

                }
            });
  }


  function traeUltimosMonitoreos2() { 
    console.log("Holaaa"); 
    var IdActivo = $("#idActivoAux").val();
    // AJAX request 
    $.ajax({
        url: '/xadmin/monitors/getLastMonitors/'+IdActivo,
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
                $('#monitoreos').find('option').remove();
                // Le datos y crea <option >
                var option = "<option value='0'>Elija un monitoreo anterior</option>";
                $("#monitoreos").append(option);
                for(var i=0; i<len; i++)
                {

                    var idMonitoreo = response['data'][i].IdMonitoreo;
                    var horaInicio = response['data'][i].FechaHoraInicio;
                    var horaFin = response['data'][i].FechaHoraFin;

                    var option = "<option value='"+idMonitoreo+"'>"+idMonitoreo+"; "+horaInicio+"; "+horaFin+"</option>"; 

                    $("#monitoreos").append(option); 
                }
            }

        }
    });
  }

    function traeProductos() 
    {
        var IdActivo = $("#idActivo").val();

        // Encera productos
        $('#producto').find('option').remove();

        // AJAX request 
        $.ajax({
            url: '/xadmin/monitors/getProductByAsset/'+IdActivo,
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
                    // Le datos y crea <option >
                    for(var i=0; i<len; i++)
                    {

                        var id = response['data'][i].Codigo;
                        var name = response['data'][i].Descripcion;

                        var option = "<option value='"+id+"' selected>"+name+"</option>"; 

                        $("#producto").append(option); 

                        traeEventos();
                    }
                }

            }
        });
    }

    function traeEventos()
    {
        // Tipo de monitoreo 
        var IdProductoDispositivo = $("#producto").val();
        $('#Alias').val(IdProductoDispositivo);

        var accion = $("#accion").val();
        var evento = $("#evento").val();
        
        // Encera eventos
        $('#ListaAlertas').find('option').remove();
        //$('#ListaAlertasSeleccionadas').find('option').remove();

        // AJAX request 
        $.ajax({
            url: '/xadmin/monitors/getEventProduct/'+IdProductoDispositivo,
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
                    // Le datos y crea <option > 
                    for(var i=0; i<len; i++)
                    {

                        var id = response['data'][i].Codigo;
                        var name = response['data'][i].Descripcion;

                        if(id!="-1")
                        {
                            if(accion == "MOD" && id==evento)
                                var option = "<option style='font-size:14px;' value='"+id+";"+name+"' selected>"+id+";"+name+"</option>"; 
                            else
                                var option = "<option style='font-size:14px;' value='"+id+";"+name+"'>"+id+";"+name+"</option>"; 
                        }


                        $("#ListaAlertas").append(option); 
                    }
                    opts = $('#ListaAlertas option').map(function () {
                            return [[this.value, $(this).text()]];
                    });
                }

            }
        });
    }

});
</script>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        //$( "#btBuscarMonitoreos" ).click(function(){
        $('#estado').change(function(){
            var fechas = $("#txtRangoFechas").val();
            var arregloFechas = fechas.split(" - ");
            var fechaDesde = arregloFechas[0];
            var fechaHasta = arregloFechas[1];
            buscarMonitoreos(fechaDesde, fechaHasta);
           
        });
        $('#selectBuscarPorTipoMonitoreo').change(function(){
            var fechas = $("#txtRangoFechas").val();
            var arregloFechas = fechas.split(" - ");
            var fechaDesde = arregloFechas[0];
            var fechaHasta = arregloFechas[1];
            buscarMonitoreos(fechaDesde, fechaHasta);
           
        });

        $('#txtRangoFechas').daterangepicker({
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
            buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });

        function buscarMonitoreos(fechaDesde, fechaHasta)
        {
            console.log('Hola');
            $("#areaImagen").show();
                $("#tbodyMonitoreos").empty();
                var fechas = $("#txtRangoFechas").val();
                var arregloFechas = fechas.split(" - ");
                //var fechaDesde = arregloFechas[0];
                //var fechaHasta = arregloFechas[1];
                console.log('Fechas para buscar');
                console.log(fechaDesde);
                console.log(fechaHasta);

                // Fetch data
                $.ajax({
                    url:"{{route('monitors.findMonitors')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                    _token: CSRF_TOKEN,
                    fechaDesde: fechaDesde,//$("#fechaDesde").val(),
                    fechaHasta: fechaHasta,//$("#fechaHasta").val(),
                    horaDesde: $("#horaDesde").val(),
                    horaHasta: $("#horaHasta").val(),
                    minutoDesde: $("#minutoDesde").val(),
                    minutoHasta: $("#minutoHasta").val(),
                    estado: $("#estado").val(),
                    tipo: $("#selectBuscarPorTipoMonitoreo").val()
                    
                    },
                    success: function( response ) {
                        len = response['data'].length;


                        var idUsuario = $("#idUsuario").val();
                        var idSubUsuario = $("#idSubUsuario").val();
                        var idCategoria = $("#idCategoria").val();

                        if(idSubUsuario=="0")
                        {
                            styleColumna = "display: none;";
                        }else
                        {
                            if(idCategoria=="9") //Es Supervisor
                            {
                                styleColumna = "text-align: center;";
                            }else{
                                styleColumna = "display: none;";
                            }
                        }

                        $("#areaImagen").hide();
                        if(response['data'] != null)
                        {
                            
                            console.log("Trajo "+len+" datos");
                            $("#tbodyMonitoreos").empty();
                        }else
                         {   $('#tablaMonitoreos > tbody:last-child').append('<tr><td colspan="12">No hay resultados a mostrar</td></tr>');
                         }
                        //$('#tablaMonitoreos tr:last').after('<tr><th>VID</th><th>CodSysHunter</th><th>Alias</th><th>Entidades</th><th>FechaHoraInicio</th><th>FechaHoraFin</th><th>Estado</th><th>Alertas asignadas</th><th>P. Acción Actual</th><th>Informe</th><th colspan="1">&nbsp;</th	></tr>');
                        var posicionHorizontal = 0;
                        for(var i=0; i<len; i++)
                        {
                            var IdMonitoreo = response['data'][i].IdMonitoreo;
                            var VID = response['data'][i].VID;
                            var Reportando = response['data'][i].Reportando;
                            var CodSysHunter = response['data'][i].CodSysHunter;
                            var Alias = response['data'][i].Alias;
                            var Entidades = response['data'][i].entidad[0].Entidades;
                            var FechaHoraInicio = response['data'][i].FechaHoraInicio;
                            var FechaHoraFin = response['data'][i].FechaHoraFin;
                            var Estado = response['data'][i].Estado;
                            var DetalleAlertas = response['data'][i].DetalleAlertas;
                            var DetallePlan = response['data'][i].DetallePlan;
                            var IdActivo = response['data'][i].IdActivo;
                            var EstadoReal = response['data'][i].EstadoReal;
                            var DescripcionTipoMonitoreo = response['data'][i].DescripcionTipoMonitoreo;
                            var NombreCompleto = response['data'][i].NombreCompleto;
                            var arregloAlertas = DetalleAlertas.split('%');
                            //console.log('cantidad alertas: '+arregloAlertas.length);

                            var htmAlertas = '';
                            var contadorAlertas = 0;
                            for(var j = 0; j < arregloAlertas.length; j++){
                                
                                var arregloFila = arregloAlertas[j].split(';');
                                
                                for(var ind = 0; ind < arregloFila.length; ind++){
                                    if(ind==3)
                                    {
                                        contadorAlertas = contadorAlertas + 1;
                                        if(contadorAlertas<=6)
                                        {
                                            //console.log('Alerta: '+arregloFila[3]);
                                            //htmAlertas_respaldo = htmAlertas + '<a href="/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'">'+arregloFila[3]+'</a><a href="/xadmin/monitors/deleteMonitorAlert/'+arregloFila[0]+'/'+arregloFila[1]+'" onclick="return confirm(\'¿Está seguro?\')"> [x]</a><br>';
                                            htmAlertas = htmAlertas + '<fieldset class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" value="'+arregloFila[0]+'_'+arregloFila[1]+'" id="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><label class="form-check-label" for="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><a href="/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'" onclick="window.open(\'/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'\',\'modificar_'+arregloFila[0]+'\',\'width=1500,height=900\'); return false;" >'+arregloFila[3]+'</a></label></div></fieldset>';
                                        }
                                    }
                                }
                                
                            }
                            var htmBotonMostrarAlertas = "";
                            if(contadorAlertas > 6)
                            {
                                htmBotonMostrarAlertas = '<button type="button"  class="btn btn-link btn-sm" id="btnMostrarTodasAlertas_'+IdMonitoreo+'" onclick="mostrarTodasAlertas(\''+IdMonitoreo+'\',\''+IdActivo+'\')">Mostrar todas</button></br></br>';
                            }

                            if(contadorAlertas > 0)
                            {
                                htmBotonEliminarAlertas = '<button type="button"  class="btn btn-primary btn-sm" id="btnEliminaAlerta_'+IdMonitoreo+'" onclick="eliminarAlertas(\''+IdMonitoreo+'\')">Eliminar alerta(s)</button>';
                            }else
                            {
                                htmBotonEliminarAlertas = '';
                            }
                            //console.log('Sale de for');

                            var arregloPlanes = DetallePlan.split('%');
                            //console.log('cantidad planes: '+arregloPlanes.length);

                            var htmPlanes = '';
                            for(var j = 0; j < arregloPlanes.length; j++){
                                
                                
                                       // console.log('Plan: '+arregloPlanes[j]);
                                        htmPlanes = htmPlanes + arregloPlanes[j]+'<br>';
                                  
                                
                            }
                            //console.log('Sale de for');
                            var iniciarDetener = "";

                            if(EstadoReal==1)
							{
								clase = "btn btn-warning btn-sm";
								textoBoton = "Detener";
                                imagenPlayDetener = 'Imagenes/stop_circle_red.svg';
								iniciarDetener = '<td><a href="" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('+IdMonitoreo+');"><img src="'+imagenPlayDetener+'" title="'+textoBoton+'" style="height: 20px;" /></a><label hidden>'+textoBoton+'</label></td>';

							}else
							{
								if(arregloAlertas.length>1)
								{
								    clase = "btn btn-info btn-sm";
									textoBoton = "Iniciar";
                                    imagenPlayDetener = 'Imagenes/play_blue.svg';
                                    iniciarDetener = '<td><a href="" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('+IdMonitoreo+');"><img src="'+imagenPlayDetener+'" title="'+textoBoton+'" style="height: 20px;" /></a><label hidden>'+textoBoton+'</label></td>';
                                    //iniciarDetener = '<td><button type="Button" class="'+clase+'" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('+IdMonitoreo+');">'+textoBoton+'</button></td>';

								}else
								{
									clase = "";
									textoBoton = "";
                                    iniciarDetener = '<td><a href="" class="'+clase+'" >'+textoBoton+'</a></td>';
								}
							}

                            //var iniciarDetener = '<td><button type="Button" class="'+clase+'" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('+IdMonitoreo+');">'+textoBoton+'</button></td>';
                            var imagenReportando="";
                            var textoReportando = "";
                            if(Reportando=="1")
                            {
                                imagenReportando="Imagenes/radio_green.svg";
                                textoReportando = "Reportando";
                            }
                            else
                            {
                                imagenReportando = "Imagenes/alert_triangle_yellow.svg";
                                textoReportando = "No reportando";
                            }
                            imagenSeguimiento = 'Imagenes/map_pin_verdeagua.svg';
                            imagenModificar = 'Imagenes/edit_orange.svg';
                            imagenReportes = 'Imagenes/printer_green.svg';

                            $('#tablaMonitoreos > tbody:last-child').append('<tr><td style="text-align: center;">'+DescripcionTipoMonitoreo+'</td><td style="'+styleColumna+'">'+NombreCompleto+'</td><td style="text-align: center;">'+VID+'</td> <td width="8%" style="text-align: center;"><img src="'+imagenReportando+'" height="25" title="'+textoReportando+'"  id="imagenBuscando" ><label hidden>'+Reportando+'</label><label hidden>'+textoReportando+'</label></td>  <td style="text-align: center;">'+CodSysHunter+'</td><td style="text-align: center;">'+Alias+'</td><td>'+Entidades+'</td><td style="text-align: center;">'+FechaHoraInicio+'</td><td style="text-align: center;">'+FechaHoraFin+'</td><td style="text-align: center;">'+Estado+'</td><td id="tdAlertas"><form class="form-group" method="POST"><input type="hidden" class="form-control form-control-sm" id="muestraTodas_'+IdMonitoreo+'" name="muestraTodas_'+IdMonitoreo+'" value="NO"><div id="areaAlertas_'+IdMonitoreo+'">'+htmAlertas+'</div></br>'+htmBotonMostrarAlertas+htmBotonEliminarAlertas+'</form></td><td>'+htmPlanes+'</td> <td><a href="/xadmin/monitors/informes/'+IdMonitoreo+'/'+FechaHoraInicio+'/'+FechaHoraFin+'/'+Alias+'"  target="_blank" onclick="window.open(\'/xadmin/monitors/informes/'+IdMonitoreo+'/'+FechaHoraInicio+'/'+FechaHoraFin+'/'+Alias+'\',\'newwindow\',\'width=900,height=900\'); return false;" ><img src="'+imagenReportes+'" title="Informes"  style="height: 20px;"/></a></td><td style="text-align: center;"><a href="https://www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P='+Alias+'*'+VID+'&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913"  target="_blank" onclick="window.open(\'https:\/\/www.huntermonitoreo.com/Geo/Paginas/SeguimientoVA.aspx?P='+Alias+'*'+VID+'&TIME=A22EFEE5-A978-4C4B-AC69-1643DEA1E913\',\''+Alias+'\',\'width=400,height=400, top=0, left='+posicionHorizontal+'\'); return false;"><img src="'+imagenSeguimiento+'" title="Seguimiento"  style="height: 20px; align: center;"/></a></td><td><a href="/xadmin/monitors/edit/'+IdMonitoreo+'" onclick=\'window.open("/xadmin/monitors/edit/'+IdMonitoreo+'","modificar_'+IdMonitoreo+'",width=1500,height=900); return false;\' ><img src="'+imagenModificar+'"  title="Editar"  style="height: 20px;"/></a></td>'+iniciarDetener+'</tr>');

                            
                            //Deshacer hasta aqui
                            //$('#tablaMonitoreos > tbody:last-child').append(DetallePlan+'</td><td>&nbsp;</td><td>&nbsp;</td	></tr>');


                        }
                        
                        //response( data );
                    }
                });
            
        }

        $('#FechaHoraInicioFinCreate').daterangepicker({
            "locale": {
                "format": "DD-MM-YYYY HH:mm",
                "separator": " / ",
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
            "startDate": moment().startOf('minute'),
            "minDate": moment().startOf('day').add(-1,'day'),
            "endDate": moment().startOf('minute').add(+1440,'minute')
            //"maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });


        $('#FechaHoraInicioFinEdit').daterangepicker({
            "locale": {
                "format": "DD-MM-YYYY HH:mm",
                "separator": " / ",
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
            //"startDate": moment().startOf('minute'),
            "minDate": moment().startOf('day').add(-1,'day')//,
            //"endDate": moment().startOf('minute').add(+1440,'minute')
            //"maxDate":  moment()
            
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY hh:mm') + ' to ' + end.format('DD-MM-YYYY hh:mm'));
            //buscarMonitoreos(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
            
        });
    });
</script>



<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        //$( "#btBuscarMonitoreos" ).click(function(){
        $('#selectTipoDeMonitoreo').change(function(){
                var tipoDeMonitoreo = $(this).val();
                console.log(tipoDeMonitoreo);
                $("#txtProducto").val('');
                $("#alias").val('');
                switch (tipoDeMonitoreo) {
                    case '1':
                        $("#areaAlias").show();
                        $("#areaProductos").hide();
                        $("#areaEntidades").hide();
                        $("#areaMarcas").hide();
                        
                        break;
                    case '2':
                        $("#areaAlias").hide();
                        $("#areaProductos").show();
                        $("#areaEntidades").hide();
                        $("#areaMarcas").hide();
                        
                        break;
                    case '3':
                        $("#areaAlias").hide();
                        $("#areaProductos").show();
                        $("#areaEntidades").hide();
                        $("#areaMarcas").hide();
                        
                        break;
                    case '4':
                        $("#areaAlias").hide();
                        $("#areaProductos").show();
                        $("#areaEntidades").show();
                        $("#areaMarcas").show();
                        
                        break;
                    default:
                        break;
                }

                $("#areaImagen").show();
                $("#tbodyMonitoreos").empty();
                // Fetch data
                
           
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#FechaHoraInicio').change(function(){
            $('#cambiaFechaHoraInicio').val('SI');
            //alert('Hola');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#FechaHoraFin').change(function(){
            $('#cambiaFechaHoraFin').val('SI');
            //alert('Hola');
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#FechaHoraInicioFinCreate').change(function(){
            $('#cambiaFechaHoraInicioFin').val('SI');
            //alert('Hola');
        });
    });
</script>


<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        
    });
    
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#storeMonitor').submit(function() {

            var alias = $("#alias").val();
            var fechaHoraInicioFin = $("#FechaHoraInicioFinCreate").val();
            //var fechaHoraFin = $("#FechaHoraFin").val();
            
            var tipoMonitoreo = $("#TipoMonitoreo option:selected").val();
            var eventos = $("#ListaEventos option:selected").text();
            var planesAccion = $("#ListaPlanesDeAccion option:selected").text();

            var haCambiadoFechaInicioFin  = $("#cambiaFechaHoraInicioFin").val();
            //var haCambiadoFechaFin  = $("#cambiaFechaHoraFin").val();

            //e.preventDefault();

            if (alias=="" || fechaHoraInicioFin==""  || eventos=="" )//|| planesAccion==""
            {
                alert('Verifique los datos ingresados para Continuar');
                return false;
            }else
            {
                if(haCambiadoFechaInicioFin == "NO" )
                {   
                    if(confirm("Ud no ha modificado las fechas, ¿desea continuar?"))
                    {  
                        localStorage.setItem("update", "1");
                        //this.submit();
                        //window.close();
                        return true;
                    }
                    else
                        return false;
                }
            }
            //window.close();
            localStorage.setItem("update", "1");
            return true;
            
        });


    });

    

</script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#updateMonitor').submit(function() {

            var alias = $("#alias").val();
            var fechaHoraInicioFinEdit = $("#FechaHoraInicio").val();
            //var fechaHoraFin = $("#FechaHoraFin").val();
            
            var tipoMonitoreo = $("#TipoMonitoreo option:selected").val();
            var eventos = $("#ListaEventos option:selected").text();
            var planesAccion = $("#ListaPlanesDeAccion option:selected").text();

            var haCambiadoFechaInicio  = $("#cambiaFechaHoraInicio").val();
            var haCambiadoFechaFin  = $("#cambiaFechaHoraFin").val();

            //e.preventDefault();

            if (alias=="" || fechaHoraInicioFinEdit=="" )
            {
                alert('Verifique los datos ingresados para Continuar');
                return false;
            }else
            {
                 
                        localStorage.setItem("update", "1");
                        //this.submit();
                        //window.close();
                        return true;
                   
            }
            //window.close();
            localStorage.setItem("update", "1");
            return true;
            
        });



        


    });

    

</script>




<script type='text/javascript'>

    $(document).ready(function()
    {

        // Cambia evento
        $('#monitoreos').change(function()
        {
            var IdMonitoreo = $(this).val();
            if(IdMonitoreo!=0)
            {
                console.log("Entra "+IdMonitoreo);
                // Encera eventos
                $('#ListaAlertas').find('option').remove();
                //$('#ListaAlertasSeleccionadas').find('option').remove();

                // AJAX request 
                $.ajax({
                    url: '/xadmin/monitors/getEventsMonitor/'+IdMonitoreo,
                    type: 'get',
                    dataType: 'json',
                    success: function(response)
                    {

                        var len = 0;
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                        }

                        
                        console.log("Trajo eventos");
                        console.log("Registros: "+len);
                        console.log(response['data']);
                        if(len > 0)
                        {
                            // Le datos y crea <option >
                            for(var i=0; i<len; i++)
                            {

                                var evento = response['data'][i].evento;
                                var name = response['data'][i].Nombre;
                                var tipo = response['data'][i].tipoAlerta;
                                var IdGeocerca = response['data'][i].IdGeocerca;
                                var Kilometraje = response['data'][i].Kilometraje;
                                var PorcentajeAnticipacion = response['data'][i].PorcentajeAnticipacion;
                                var LimiteVelocidad = response['data'][i].LimiteVelocidad;

                                switch (tipo) {
                                    case "1":
                                        var option = "<option style='font-size:14px;' value='"+evento+";"+name+"'>"+evento+";"+name+"</option>"; 
                                        $("#ListaAlertas").append(option);
                                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+tipo+';'+evento+';'+name+';0;0;0;0;0;0;0;0;0">'+tipo+';'+ evento+';'+name+';0;0;0;0;0;0;0;0;0</option>');
                                        break;
                                    case "2":
                                        //var option = "<option style='font-size:0.7em;' value='"+tipo+";0;0;0;0'>"+evento+";"+name+"</option>"; 
                                        break;
                                    case "3":
                                        //var option = "<option style='font-size:14px;' value='"+IdGeocerca+";"+name+"'>"+IdGeocerca+";"+name+"</option>"; 
                                        var option = "<option style='font-size:14px;' value='"+IdGeocerca+";"+name+"'>"+name+"</option>"; 
                                        $("#ListaGeocercas").append(option);
                                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+tipo+';0;0;'+IdGeocerca+';'+name+';0;0;0;0;0;0;0">'+tipo+';0;0;'+IdGeocerca+';'+name+';0;0;0;0;0;0;0</option>');
                                        break;
                                    case "4":
                                        //var option = "<option style='font-size:14px;' value='"+IdGeocerca+";"+name+"'>"+IdGeocerca+";"+name+"</option>"; 
                                        var option = "<option style='font-size:14px;' value='"+IdGeocerca+";"+name+"'>"+name+"</option>"; 
                                        $("#ListaGeocercas").append(option);
                                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+tipo+';0;0;'+IdGeocerca+';'+name+';0;0;0;0;0;0;0">'+tipo+';0;0;'+IdGeocerca+';'+name+';0;0;0;0;0;0;0</option>');
                                        break;
                                    case "6":
                                        
                                        break;
                                    default:
                                        break;
                                }
                                

                                
                                
                            }

                            $('#ListaEventos option').prop('selected', true);


                            //opts = $('#ListaAlertasSeleccionadas option').map(function () {
                            opts = $('#ListaAlertas option').map(function () {
                                return [[this.value, $(this).text()]];
                            });

                            /***
                                * ESTRUCTURA:
                                * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
                            **/


                            //PRUEBA PARA PONER LOS EVENTOS AUTOMATICAMENTE
                            var TipoMonitoreo = $('#TipoMonitoreo').val();
                            $("#ListaAlertas option").each(function() {
                                
                                var valor = $(this).val();
                                //$('#ListaEventos').append('<option style="font-size:0.7em;" value="1;'+valor+';0;0;0;0;0;0;0;0;0">1;'+ valor+';0;0;0;0;0;0;0;0;0</option>');
                            });
                            $("#ListaGeocercas option:selected").each(function() {
                        
                                var valor = $(this).val();
                                //$('#ListaEventos').append('<option style="font-size:0.7em;" value="'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0">'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0</option>');
                                
                            });
                            $('#ListaEventos option').prop('selected', true);
                            //FIN

                        }

                    }
                });
                $('#ListaPlanesDeAccion').find('option').remove();
                $.ajax({
                    url: '/xadmin/plans/getPlansMonitor/'+IdMonitoreo,
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
                            if(confirm("¿Desea agregar los Planes de Acción?"))
                            {

                            
                                // Le datos y crea <option >
                                for(var i=1; i<len; i++)
                                {

                                    var severidad = response['data'][i].Tipo;
                                    var detalle = response['data'][i].Detalle;
                                    var observaciones = response['data'][i].Observaciones;

                                    var option = '<option style="font-size:14px;" value="'+severidad+';'+detalle+';'+observaciones+'">'+severidad+'; '+detalle+'; '+observaciones+'</option>'; 

                                    $("#ListaPlanesDeAccion").append(option); 
                                }
                                $('#ListaPlanesDeAccion option').prop('selected', true);
                            }
                        }

                    }
                });
            }else{
                $('#ListaAlertas').find('option').remove();
                //$('#ListaPlanesDeAccion').find('option').remove();
            }
        });
    });
</script>


<!-- Script -->
<script type='text/javascript'>

$(document).ready(function()
{

    // Cambia evento
    $('#TipoMonitoreo').change(function()
    {

        // Tipo de monitoreo 
        var TipoMonitoreo = $(this).val();
        //alert(TipoMonitoreo);

        //var IdActivo = $("#idActivo").val();


        //if(!$("#alias").val())
        //{
        //    alert("Debe ingresar unidad");
        //}else
        //{
            
            
            switch (TipoMonitoreo) {
                case '1':  //Evento
                    

                    $("#AreaAlertas").show();
                    $("#labelAlertas").show();
                    $("#AreaEspecificaciones").hide();
                    $("#AreaGeocercas").hide();
                    $("#labelGeocercas").hide();

                    break;
                case '2':  //Kilometraje
                    $("#AreaAlertas").hide();
                    $("#labelAlertas").hide();
                    $("#AreaEspecificaciones").show();
                    $("#AreaGeocercas").hide();
                    $("#labelGeocercas").hide();
                    $("#LimiteVelocidad").val('0')
                    $("#LimiteVelocidad").attr('disabled', 'disabled');
                    $("#HoraDesde").attr('disabled', 'disabled');
                    $("#MinutoDesde").attr('disabled', 'disabled');
                    $("#HoraHasta").attr('disabled', 'disabled');
                    $("#MinutoHasta").attr('disabled', 'disabled');
                    $("#Despacho").attr('disabled', 'disabled');

                    $("#Kilometros").removeAttr('disabled');
                    $("#Kilometros").val('0');
                    $("#PorcentajeAnticipacion").removeAttr('disabled');
                    $("#PorcentajeAnticipacion").val('0');

                    break;
                case '3':  //Geocerca IN
                    $("#AreaAlertas").hide();
                    $("#labelAlertas").hide();
                    $("#AreaEspecificaciones").hide();
                    $("#AreaGeocercas").show();
                    $("#labelGeocercas").show();
                    $("#Kilometros").val('0');
                    $("#Kilometros").attr('disabled', 'disabled');
                    $("#PorcentajeAnticipacion").val('0');
                    $("#PorcentajeAnticipacion").attr('disabled', 'disabled');
                    $("#LimiteVelocidad").val('0');
                    $("#LimiteVelocidad").attr('disabled', 'disabled');
                    $("#HoraDesde").attr('disabled', 'disabled');
                    $("#MinutoDesde").attr('disabled', 'disabled');
                    $("#HoraHasta").attr('disabled', 'disabled');
                    $("#MinutoHasta").attr('disabled', 'disabled');
                    $("#Despacho").attr('disabled', 'disabled');

                    break;
                case '4':  //Geocerca OUT
                    $("#AreaAlertas").hide();
                    $("#labelAlertas").hide();
                    $("#AreaEspecificaciones").hide();
                    $("#AreaGeocercas").show();
                    $("#labelGeocercas").show();
                    $("#Kilometros").val('0');
                    $("#Kilometros").attr('disabled', 'disabled');
                    $("#PorcentajeAnticipacion").val('0');
                    $("#PorcentajeAnticipacion").attr('disabled', 'disabled');
                    $("#LimiteVelocidad").val('0');
                    $("#LimiteVelocidad").attr('disabled', 'disabled');
                    $("#HoraDesde").attr('disabled', 'disabled');
                    $("#MinutoDesde").attr('disabled', 'disabled');
                    $("#HoraHasta").attr('disabled', 'disabled');
                    $("#MinutoHasta").attr('disabled', 'disabled');
                    $("#Despacho").attr('disabled', 'disabled');

                    break;
                case '6':  //Multicriterio
                    $("#AreaAlertas").show();
                    $("#labelAlertas").show();
                    $("#AreaEspecificaciones").show();
                    $("#AreaGeocercas").show();
                    $("#labelGeocercas").show();
                    $("#Kilometros").val('0');
                    $("#Kilometros").attr('disabled', 'disabled');
                    $("#PorcentajeAnticipacion").val('0');
                    $("#PorcentajeAnticipacion").attr('disabled', 'disabled');
                    
                    $("#LimiteVelocidad").val('0');
                    $("#LimiteVelocidad").removeAttr('disabled');
                    $("#HoraDesde").removeAttr('disabled');
                    $("#MinutoDesde").removeAttr('disabled');
                    $("#HoraHasta").removeAttr('disabled');
                    $("#MinutoHasta").removeAttr('disabled');
                    $("#Despacho").attr('disabled', 'disabled');

                    break;
                default:
                    alert("Debe escoger una opcion.");
                    break;
            }
            
        //}
        
    });

});

</script>

<!-- Script -->



<script type="text/javascript">
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function mostrarTodasAlertas(idMonitoreo,idActivo)
    {
        if($('#muestraTodas_'+idMonitoreo).val()=="NO")
        {
            //alert("Seleccione al menos una alerta "+idMonitoreo);
            $.ajax({
                url:"{{route('monitors.mostrarTodasAlertas')}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    idMonitoreo: idMonitoreo,
                    idActivo: idActivo
                
                },
                success: function( response ) 
                {
                    if(response != null)
                    {
                        
                        len = response.length;
                        console.log("Trajo "+len+" datos");
                        
                        var htmAlertas = "";
                        var idMonitoreo = "";
                        for (index = 6; index < len; index++) {
                            console.log(response[index]['alerta']);
                            alerta = response[index]['alerta'];

                            var arregloFila = alerta.split(';');
                        
                            for(var ind = 0; ind < arregloFila.length; ind++){
                                if(ind==3)
                                {
                                    idMonitoreo = arregloFila[0];
                                    if($('#CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]).length <=0)
                                    {
                                        console.log('Alerta: '+arregloFila[3]);
                                        
                                        htmAlertas = htmAlertas + '<fieldset class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" value="'+arregloFila[0]+'_'+arregloFila[1]+'" id="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><label class="form-check-label" for="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><a href="/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'" onclick="window.open(\'/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'\',\'modificar_'+arregloFila[0]+'\',\'width=1500,height=900\'); return false;"  >'+arregloFila[3]+'</a></label></div></fieldset>';
                                    }
                                }
                            }
                            
                        }
                        document.getElementById("areaAlertas_"+idMonitoreo).innerHTML += htmAlertas;
                        $('#muestraTodas_'+idMonitoreo).val("SI");
                        $("#btnMostrarTodasAlertas_"+idMonitoreo).html("Mostrar menos");
                        
                    }
                    
                }
            });
        }else{
            $('#areaAlertas_'+idMonitoreo).empty();
            $.ajax({
                        url:"{{route('monitors.mostrarTodasAlertas')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            idMonitoreo: idMonitoreo,
                            idActivo: idActivo
                        
                        },
                        success: function( response ) 
                        {
                            if(response != null)
                            {
                                
                                len = response.length;
                                console.log("Trajo "+len+" datos");
                                
                                var htmAlertas = "";
                                var idMonitoreo = "";
                                for (index = 0; index < 6; index++) {
                                    console.log(response[index]['alerta']);
                                    alerta = response[index]['alerta'];

                                    var arregloFila = alerta.split(';');
                                
                                    for(var ind = 0; ind < arregloFila.length; ind++){
                                        if(ind==3)
                                        {
                                            idMonitoreo = arregloFila[0];
                                            if($('#CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]).length <=0)
                                            {
                                                console.log('Alerta: '+arregloFila[3]);
                                                
                                                htmAlertas = htmAlertas + '<fieldset class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" value="'+arregloFila[0]+'_'+arregloFila[1]+'" id="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><label class="form-check-label" for="CheckAlerta_'+arregloFila[0]+'_'+arregloFila[1]+'"><a href="/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'" onclick="window.open(\'/xadmin/monitors/editalert/'+arregloFila[0]+'/'+arregloFila[1]+'\',\'modificar_'+arregloFila[0]+'\',\'width=1500,height=900\'); return false;"  >'+arregloFila[3]+'</a></label></div></fieldset>';
                                            }
                                        }
                                    }
                                    
                                }
                                document.getElementById("areaAlertas_"+idMonitoreo).innerHTML += htmAlertas;
                                $('#muestraTodas_'+idMonitoreo).val("NO");
                                $("#btnMostrarTodasAlertas_"+idMonitoreo).html("Mostrar todas");
                                
                            }
                            
                        }
            });

        }
    }

    function eliminarAlertas(idMonitoreo)
        {
            var alertasParaBorrar = new Array();

            $("#tdAlertas input[type=checkbox]:checked").each(function () {

                alertasParaBorrar.push(this.value);

            });

            if (alertasParaBorrar.length > 0) {

                var confirmacion = confirm('¿Está seguro de eliminar la(s) alerta(s) seleccionada(s)?');
                if(confirmacion)
                {
                    // Fetch data
                    $.ajax({
                        url:"{{route('monitors.deleteMonitorAlert')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            alertas: alertasParaBorrar
                        
                        },
                        success: function( response ) {
                            if(response['data'] != null)
                            {
                                //var IdMonitoreo = response['data'][i].IdMonitoreo;
                                len = response['data'].length;
                                console.log("Trajo "+len+" datos");
                                console.log(response['data'].resultado);
                                location.reload();
                                alert(response['data'].resultado);
                                
                            }
                            
                        }
                    });
                }




            }else   
                alert("Seleccione al menos una alerta");
        } 


    $(document).ready(function(){

        //$('.btnEliminaAlerta').click(function(){      ESTA NO SE EJECUTA
        function eliminarAlertas(idMonitoreo)
        {
            var alertasParaBorrar = new Array();

            $("#tdAlertas input[type=checkbox]:checked").each(function () {

                alertasParaBorrar.push(this.value);

            });

            if (alertasParaBorrar.length > 0) {

                var confirmacion = confirm('¿Está seguro de eliminar la(s) alerta(s) seleccionada(s)?');
                if(confirmacion)
                {
                    // Fetch data
                    $.ajax({
                        url:"{{route('monitors.deleteMonitorAlert')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            alertas: alertasParaBorrar
                        
                        },
                        success: function( response ) {
                            if(response['data'] != null)
                            {
                                //var IdMonitoreo = response['data'][i].IdMonitoreo;
                                len = response['data'].length;
                                console.log("Trajo "+len+" datos");
                                console.log(response['data'].resultado);
                                location.reload();
                                alert(response['data'].resultado);
                                
                            }
                            
                        }
                    });
                }




            }else   
                alert("Seleccione al menos una alerta");
        }    
        //});
	});
</script>


<script type='text/javascript'>

$(document).ready(function()
{

    // Cambia evento
    $('#producto').change(function()
    {

        // Tipo de monitoreo 
        var IdProductoDispositivo = $(this).val();
        $('#Alias').val(IdProductoDispositivo);

        var accion = $("#accion").val();
        var evento = $("#evento").val();
        
        // Encera eventos
        $('#ListaAlertas').find('option').remove();
        //$('#ListaAlertasSeleccionadas').find('option').remove();

        // AJAX request 
        $.ajax({
            url: '/xadmin/monitors/getEventProduct/'+IdProductoDispositivo,
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
                    // Le datos y crea <option >
                    for(var i=1; i<len; i++)
                    {

                        var id = response['data'][i].Codigo;
                        var name = response['data'][i].Descripcion;

                        if(accion == "MOD" && id==evento)
                            var option = "<option style='font-size:14px;' value='"+id+";"+name+"' selected>"+id+";"+name+"</option>"; 
                        else
                            var option = "<option style='font-size:14px;' value='"+id+";"+name+"'>"+id+";"+name+"</option>"; 


                        $("#ListaAlertas").append(option); 
                    }
                    opts = $('#ListaAlertas option').map(function () {
                            return [[this.value, $(this).text()]];
                    });
                }

            }
        });
        
        
    });

});

</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#agregarEvento').click(function () {

            
            var TipoMonitoreo = $('#TipoMonitoreo').val();
            
            /*AdicionarParametros("@TipoAlerta", Me._IdTipoAlerta)
                            AdicionarParametros("@Nombre", Me._Nombre)
                            AdicionarParametros("@Descripcion", Me._Descripcion)
                            AdicionarParametros("@IdTipoDispositivo", Me._IdTipoDispositivo)
                            AdicionarParametros("@Evento", Me._Evento)
                            AdicionarParametros("@IdGeocerca", Me._IdGeocerca)
                            AdicionarParametros("@Kilometraje", _Kilometraje)
                            AdicionarParametros("@PorcentajeAnticipacion", _Porcentaje)
                            AdicionarParametros("@IdUsuario", _IdUsuario)
                            AdicionarParametros("@IdProducto", _IdProducto)
                            AdicionarParametros("@HoraDesde", _HoraDesde)
                            AdicionarParametros("@HoraHasta", _HoraHasta)
                            AdicionarParametros("@LimiteVelocidad", _LimiteVelocidad)
                            AdicionarParametros("@DentroGeo", If(_DentroGeo, 1, 0))
                            AdicionarParametros("@IdDespacho", _IdDespacho)
                            AdicionarParametros("@idGrupoGeo", _IdGrupoGeo) */
            
            var kilometraje = $('#Kilometros').val();
            var porcentaje = $('#PorcentajeAnticipacion').val();
            var limiteVelocidad = $('#LimiteVelocidad').val();
            var horaDesde = $('#HoraDesde').val();
            var minutoDesde = $('#MinutoDesde').val();
            var horaHasta = $('#HoraHasta').val();
            var minutoHasta = $('#MinutoHasta').val();

            /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
            **/


            switch (TipoMonitoreo) {
                case '1':
                    //EVENTO
                    //var AlertasSeleccionadas = $("#ListaAlertasSeleccionadas option");
                    var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                    lista = new Array();
                    $("#ListaAlertas option:selected").each(function() {
                        
                        var valorTemp = $(this).val();
                        var valor = valorTemp.replace(/"/g, "");
                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+valor+';0;0;0;0;0;0;0;0;0">'+ TipoMonitoreo+';'+valor+';0;0;0;0;0;0;0;0;0</option>');
                    });
                    $('#ListaEventos option').prop('selected', true);
                    break;
                case '2':
                    //KILOMETRAJE
                    if( kilometraje ) {
                        if(porcentaje)
                        {
                            $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';0;0;0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';0;0;0;0">'+ TipoMonitoreo+';0;0;0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';0;0;0;0</option>')
                            $('#ListaEventos option').prop('selected', true);
                        }else
                        {
                            alert("Ingrese porcentaje.");
                        }
                
                    }else{
                        alert("Ingrese kilometraje.");
                    }
                    $('#Kilometros').val("0");
                    $('#PorcentajeAnticipacion').val("0");
                    break;
                case '3':
                    //GEOCERCA IN
                    var GeocercasSeleccionadas = $("#ListaGeocercas option:selected");
                    lista = new Array();
                    $("#ListaGeocercas option:selected").each(function() {
                        
                        var valor = $(this).val();
                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0">'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0</option>');
                        $('#ListaEventos option').prop('selected', true);
                    });
                    
                    break;
                case '4':
                    //GEOCERCA OUT
                    var GeocercasSeleccionadas = $("#ListaGeocercas option:selected");
                    lista = new Array();
                    $("#ListaGeocercas option:selected").each(function() {
                        
                        var valor = $(this).val();
                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0">'+TipoMonitoreo+';0;0;'+valor+';0;0;0;0;0;0;0</option>');
                        $('#ListaEventos option').prop('selected', true);
                    });
                    break;
                case '5':
                    
                    break;
                case '6':
                    //MULTICRITERIO
                    var GeocercasSeleccionadas = $("#ListaGeocercas option:selected");
                    //alert(GeocercasSeleccionadas.length);
                    lista = new Array();
                    if(GeocercasSeleccionadas.length>0)
                    {
                        $("#ListaGeocercas option:selected").each(function() {
                        
                            var geocerca = $(this).val();
                            //$('#ListaEventos').append('<option style="font-size:0.7em;" value="'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+'">'+valor+';0;0;0</option>');
                            var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                            if(AlertasSeleccionadas.length>0)
                            {
                                $("#ListaAlertas option:selected").each(function() {
                            
                                    var alerta = $(this).val();
                                    $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+alerta+';'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';'+alerta+';'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                                });
                            }else{
                                $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';0;0;'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';0;0;'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                            }
                            $('#ListaEventos option').prop('selected', true);
                            
                        });
                    }else{
                        var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                            if(AlertasSeleccionadas.length>0)
                            {
                                $("#ListaAlertas option:selected").each(function() {
                            
                                    var alerta = $(this).val();
                                    $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+alerta+';0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';'+alerta+';0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                                });
                                $('#ListaEventos option').prop('selected', true);
                            }
                    }
                    
                    
                    break;
                default:
                    
                    break;
            }

   
            
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {

        $('#ListaAlertas').dblclick(function () {

            
            var TipoMonitoreo = $('#TipoMonitoreo').val();
            
            /*AdicionarParametros("@TipoAlerta", Me._IdTipoAlerta)
                            AdicionarParametros("@Nombre", Me._Nombre)
                            AdicionarParametros("@Descripcion", Me._Descripcion)
                            AdicionarParametros("@IdTipoDispositivo", Me._IdTipoDispositivo)
                            AdicionarParametros("@Evento", Me._Evento)
                            AdicionarParametros("@IdGeocerca", Me._IdGeocerca)
                            AdicionarParametros("@Kilometraje", _Kilometraje)
                            AdicionarParametros("@PorcentajeAnticipacion", _Porcentaje)
                            AdicionarParametros("@IdUsuario", _IdUsuario)
                            AdicionarParametros("@IdProducto", _IdProducto)
                            AdicionarParametros("@HoraDesde", _HoraDesde)
                            AdicionarParametros("@HoraHasta", _HoraHasta)
                            AdicionarParametros("@LimiteVelocidad", _LimiteVelocidad)
                            AdicionarParametros("@DentroGeo", If(_DentroGeo, 1, 0))
                            AdicionarParametros("@IdDespacho", _IdDespacho)
                            AdicionarParametros("@idGrupoGeo", _IdGrupoGeo) */
            
            

            /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
            **/


            switch (TipoMonitoreo) {
                case '1':
                    //EVENTO
                    //var AlertasSeleccionadas = $("#ListaAlertasSeleccionadas option");
                    var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                    lista = new Array();
                    $("#ListaAlertas option:selected").each(function() {
                        
                        var valor = $(this).val();
                        $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+valor+';0;0;0;0;0;0;0;0;0">'+ TipoMonitoreo+';'+valor+';0;0;0;0;0;0;0;0;0</option>');
                    });
                    $('#ListaEventos option').prop('selected', true);
                    break;
                case '2':
                    //KILOMETRAJE
                    
                    break;
                case '3':
                    //GEOCERCA IN
                    
                    break;
                case '4':
                    //GEOCERCA OUT
                    
                    break;
                case '5':
                    
                    break;
                case '6':
                    //MULTICRITERIO
                    var GeocercasSeleccionadas = $("#ListaGeocercas option:selected");
                    //alert(GeocercasSeleccionadas.length);
                    lista = new Array();
                    if(GeocercasSeleccionadas.length>0)
                    {
                        $("#ListaGeocercas option:selected").each(function() {
                        
                            var geocerca = $(this).val();
                            //$('#ListaEventos').append('<option style="font-size:0.7em;" value="'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+'">'+valor+';0;0;0</option>');
                            var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                            if(AlertasSeleccionadas.length>0)
                            {
                                $("#ListaAlertas option:selected").each(function() {
                            
                                    var alerta = $(this).val();
                                    $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+alerta+';'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';'+alerta+';'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                                });
                            }else{
                                $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';0;0;'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';0;0;'+geocerca+';'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                            }
                            $('#ListaEventos option').prop('selected', true);
                            
                        });
                    }else{
                        var AlertasSeleccionadas = $("#ListaAlertas option:selected");
                            if(AlertasSeleccionadas.length>0)
                            {
                                $("#ListaAlertas option:selected").each(function() {
                            
                                    var alerta = $(this).val();
                                    $('#ListaEventos').append('<option style="font-size:14px;" value="'+TipoMonitoreo+';'+alerta+';0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'">'+TipoMonitoreo+';'+alerta+';0;0;'+kilometraje+';'+porcentaje+';'+limiteVelocidad+';'+horaDesde+';'+minutoDesde+';'+horaHasta+';'+minutoHasta+'</option>');
                                });
                                $('#ListaEventos option').prop('selected', true);
                            }
                    }
                    
                    
                    break;
                default:
                    
                    break;
            }

   
            
        });
    });
</script>





<script type="text/javascript">
    $(document).ready(function () {

        $('#eliminarEvento').click(function () {
            var selectedOpts = $("#ListaEventos option:selected");
            if (selectedOpts.length == 0) {
                alert("Seleccione al menos una alerta.");
                e.preventDefault();
            }
            $(selectedOpts).remove();
            //e.preventDefault();
            $('#ListaEventos option').prop('selected', true);
            
            
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {

        $('#agregarAccion').click(function () {
            var severidad = $('#Tipo').val();
            var detalle = $('#Detalle').val();
            var observaciones = $('#Observaciones').val(); 

            switch (severidad) {
                case '0':
                    severidad = 'Amarillo';
                    break;
                case '1':
                    severidad = 'Naranja';
                    break;
                default:
                    severidad = 'Rojo';
                    break;
            }

            if( detalle ) {
                if(observaciones)
                {
                    $('#ListaPlanesDeAccion').append('<option style="font-size:14px;" value="'+severidad+';'+detalle+';'+observaciones+'">'+severidad+';'+detalle+';'+observaciones+'</option>')
                    $('#ListaPlanesDeAccion option').prop('selected', true);
                }else
                {
                    alert("Ingrese plan de accion.");
                }
                
            }else{
                alert("Ingrese plan de accion.");
            }
            $('#Observaciones').val("");
            $('#Detalle').val("");
            
            
            
            
        });
    });
</script>





<script type="text/javascript">
    $(document).ready(function () {

        $('#eliminarAccion').click(function () {
            var selectedOpts = $("#ListaPlanesDeAccion option:selected");
            if (selectedOpts.length == 0) {
                alert("Seleccione al menos una accion.");
                //e.preventDefault();
            }
            $(selectedOpts).remove();
            //e.preventDefault();
            $('#ListaPlanesDeAccion option').prop('selected', true);
            
            
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#buscarEvento').click(function () {

            var evento = $('#eventoAbuscar').val();
            alert(evento);
            $('#ListaAlertas')
                .find('evento')
                .prop("selected",true);
            
                //$("div.id_100 select").val("val2");
        });
    });
</script>
<script type="text/javascript" src="{{asset('js/jquery.selectlistactions.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function () {
        $('#FechaHoraInicio').datetimepicker({
            format: 'd-m-Y H:i',
            changeYear: false,
            minDate: 0,
            onShow: function(ct) {
                this.setOptions({
                    //maxDate: $('#FechaHoraFin').val() ? $('#FechaHoraFin').val() : false
                    }) 
                },
            onChange: function(ct){
                var txtTo = ct.date.add(2)
                $('#FechaHoraFin').val(txtTo.format('d-m-Y'))
            }
            
        })
        $('#FechaHoraFin').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd-m-Y H:i',
            onShow: function(ct) 
            {
                this.setOptions({
                    minDate: $('#FechaHoraInicio').val() ? $('#FechaHoraInicio').val() : false
                    }) 
                }
            
        })

    });


   
</script>

<script type="text/javascript">
   
        $('#fechaDesde').datetimepicker({
            format: 'd/m/Y',
            changeYear: false,
            minDate: 1,
            onShow: function(ct) {
                this.setOptions({
                    maxDate: $('#fechaHasta').val() ? $('#fechaHasta').val() : false
                    }) 
                }
            
            
        })
        $('#fechaHasta').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'd/m/Y',
            onShow: function(ct) 
            {
                this.setOptions({
                    minDate: $('#fechaDesde').val() ? $('#fechaDesde').val() : false
                    }) 
            }
            
        })

</script>

<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#txtCliente" ).autocomplete({
    source: function( request, response ) 
    {
      // Fetch data
      $.ajax({
        url:"{{route('alerts.getCustomers')}}",
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
       $('#txtCliente').val(ui.item.label); // display the selected text
       //$('#idActivo').val(ui.item.value); // save selected id to input
       //traeUltimosMonitoreos();
       //Aquí cambio el html de la pagina
       return false;
    }
  });
});
</script>

<script type="text/javascript">
    opts = $('#ListaAlertas option').map(function () {
        return [[this.value, $(this).text()]];
    });

    //style='font-size:0.7em;'


    $('#eventoAbuscar').keyup(function () {
        
        var rxp = new RegExp($('#eventoAbuscar').val(), 'i');
        var optlist = $('#ListaAlertas').empty();
        opts.each(function () {
            if (rxp.test(this[1])) {
                optlist.append($('<option/>').attr('value', this[0]).attr('style','font-size:14px').text(this[1]));
            } else{
                optlist.append($('<option/>').attr('value', this[0]).attr('style','font-size:14px').text(this[1]).addClass("hidden"));
            }
        });
        $(".hidden").toggleOption(false);
    });

    optsGeocerca = $('#ListaGeocercas option').map(function () {
        return [[this.value, $(this).text()]];
    });

    var contadorGeocercasEncontradas = 0;
    
    $('#geocercaAbuscar').keyup(function () {

        var textoGeocercas = $('#geocercaAbuscar').val();
        var ultimoCaracter = textoGeocercas.substr (textoGeocercas.length - 1);

        var arregloGeocercas = textoGeocercas.split(";");
        
        var optlist = $('#ListaGeocercas').empty();
        

        for(i=0;i<arregloGeocercas.length;i++)
        {
        
        
            var rxp = new RegExp(arregloGeocercas[i], 'i');
            if(ultimoCaracter==";")
                optlist = $('#ListaGeocercas').empty();
            //var rxp = new RegExp($('#geocercaAbuscar').val(), 'i');
       
            
            optsGeocerca.each(function () {
                
                if (rxp.test(this[1])) {
                    optlist.append($('<option/>').attr('value', this[0]).attr('style','font-size:14px').text(this[1]));
                    
                } else{
                    optlist.append($('<option/>').attr('value', this[0]).attr('style','font-size:14px').text(this[1]).addClass("hidden"));
                }
                
            });
            $(".hidden").toggleOption(false);
        }
            
            
        
       
        
        
    });

    jQuery.fn.toggleOption = function( show ) {
    jQuery( this ).toggle( show );
    if( show ) {
        if( jQuery( this ).parent( 'span.toggleOption' ).length )
            jQuery( this ).unwrap( );
    } else {
        if( jQuery( this ).parent( 'span.toggleOption' ).length == 0 )
            jQuery( this ).wrap( '<span class="toggleOption" style="display: none;" />' );
    }
};
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

<script type="text/javascript">

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){

  $( "#recorridoUnidad" ).autocomplete({
        minLength: 3,
        source: function( request, response ) 
        {
            placa=request.term;
            if(placa.toUpperCase()!="S/P")
            {
                $.ajax({
                    url:"{{route('assets.buscarActivoConVId')}}",
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
            }else
            {
                console.log("sin placa");
                buscaUIDSinPlaca();
            }
            
        },
            select: function (event, ui) {
            // Set selection
            $('#recorridoUnidad').val(ui.item.label); // display the selected text
            buscaVID();
            //$('#recorridoVid').val(ui.item.vid); // save selected id to input
            //console.log('Hola '+ui.item.vid)
            return false;
        }
  });
  function buscaVID()
  {
    $.ajax({
                url:"{{route('assets.buscarVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    placa: $('#recorridoUnidad').val()
                },
                success: function( response ) 
                {
                            if(response['vid'] != null)
                            {
                                //var IdMonitoreo = response['data'][i].IdMonitoreo;
                                len = response['vid'].length;
                                console.log("Trajo "+len+" datos");
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
    $.ajax({
                url:"{{route('assets.buscarUidConVid')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    vid: $('#recorridoVid').val()
                },
                success: function( response ) 
                {
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
});
</script>


<script type="text/javascript">
    $(document).ready(function () {

        $('#btBuscarRecorrido').click(function () {
            MostrarReporteCustom();


        });



        function MostrarReporteCustom() {
            var VID = $('#recorridoVid').val();
            var vUID = $('#recorridoUid').val();
            var Placa = $('#recorridoUnidad').val();
            var Inicial = $('#recorridoFechaDesde').val();
            var Final = $('#recorridoFechaHasta').val();

            //if (VID == '' || vUID == '' || Inicial == '' || Final == '') {
            //    alert('No se puede generar el reporte, datos incompletos');
            //    return false;
            //}

            window.open('http://www.huntermonitoreo.com/GeoTest/Paginas/Recorrido.aspx?TIME=' + vUID + '&ID=' + VID + '&P=' + Placa + '&I=CUS&T=CUS&INI=' + Inicial + '&FIN=' + Final + '&ctrl=1&FHS=1', 'vnRecorridoXA', 'status=0,left=230,top=5,fullscreen=no,width=940,height=660,menubar=no,resizable=0,titlebar=0,scrollbars=vertical', true);
            VID = null; Placa = null; Inicial = null; Final = null; Formato = null;

            return false;
        }
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

                console.log(opcionBusqueda);
                console.log(buscarTiposDeMensajes);


                
                if(buscar == null)
                    buscar = '';
                

                if (buscar=="" )
                {
                    alert('Verifique los datos ingresados para Continuar');
                    return false;
                }else{
                    $("#areaImagen").show();
                    $("#tbodyMensajes").empty();
                }



                $.ajax({
                    url:"{{route('monitors.buscarSMS')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        buscar: buscar,
                        opcionBusqueda: opcionBusqueda,
                        buscarTiposDeMensajes: buscarTiposDeMensajes
                        
                    
                    },
                    success: function( response ) 
                    {
                        console.log('hola');
                        console.log(response);
                        
                        $("#areaImagen").hide();
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
                            
                            
                            
                            
                            $('#tablaMensajes > tbody:last-child').append('<tr><td>'+fecha+'</td><td>'+celular+'</td><td>'+mensaje+'</td><td>'+longitud+'</td><td>'+estado+'</td></tr>');


                        }
                        
                        //response( data );
                        
                    }
                });
                
           
        });
    });
</script>

<!-- COPIADO DE controlmonitoreos -->
<script type="text/javascript">
    function confirmaraccion(idmonitoreo) 
    {
            var esDeTIA = ActivoTIA(idmonitoreo);
            
            
            
    }

    function ActivoTIA(idMonitoreo1)
    {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var result = "0";
        var alertasPendientes = 0;
        console.log("idmonitoreo= "+idMonitoreo1);
        activo = -1;
         $.ajax({
             type: "post",
             url: "{{route('assets.ActivoTIA')}}",
             dataType: "json",
             data: {
                 idmonitoreo : idMonitoreo1 , 
                 _token: CSRF_TOKEN 
                },
             
             
             success: function (response) {
                if(response['data'] != null)
                {
                    activo = response['data'][0].Activo;
                    result = response['data'][0].Resultado;

                    console.log("Es de tia "+result);
                    console.log("Activo: "+activo); 

                    var estado = 0, estadoReal = 0, fechaInicio = "";
                    if(response['estado']!=null)
                    {
                        console.log(response['estado']);
                        estado = response['estado'][0].estado;
                        estadoReal = response['estado'][0].EstadoReal;
                        fechaInicio = response['estado'][0].FechaHoraInicioReal;
                        console.log("Estado: "+estado+". EstadoReal: "+estadoReal+". FechaInicio: "+fechaInicio); 
                        if(estado=="A"&&fechaInicio!=null&&estadoReal==1)
                        {
                            console.log("Se va a finalizar monitoreo");
                        }else
                        {
                            console.log("Se va a iniciar monitoreo");
                        }
                    }
                    if(response['caidas']!=null)
                    {
                        alertasPendientes = response['caidas'];
                        console.log("Alertas pendientes: "+alertasPendientes);
                    }

                    if (result == '1')
                    {
                        console.log("Activo: "+activo); 
                        if (confirm(" ¿ Desea crear el monitoreo automático para TIA con las alertas de Apertura/Cierre de puertas e Ignición Off:  ? Activo: "+activo+", Monitoreo: "+idMonitoreo1)) {
                            crearMonitoreoAutomatico(activo, idMonitoreo1);
                        }
                        if (confirm(" ¿ Realmente desea iniciar o detener el monitoreo ? ")){
                            if(estado=="A"&&fechaInicio!=null&&estadoReal==1)
                            {
                                console.log("Se está finalizando monitoreo");
                                
                                console.log("Alertas pendientes: "+alertasPendientes);
                                if(alertasPendientes>=1)
                                {
                                    var mensaje = " Monitoreo tiene "+ alertasPendientes + " alerta(s) pendiente(s) por gestionar. ¿ Desea finalizar de todas formas ? ";
                                    if(confirm(mensaje))
                                    {
                                        
                                        controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                        location.reload();
                                    }else
                                    {
                                        //window.location.replace("alerts");
                                        //$('<a href="/xadmin/alerts"  ></a>')[0].click();
                                    }
                                }else
                                {
                                    controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                    location.reload();
                                }
                            }else  
                            {
                                console.log("Se está inciando el monitoreo");
                                controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                location.reload();
                            }
                            
                            //controlarMonitoreo(idMonitoreo1);
                            //location.reload();
                        }
                        
                    }else
                    {
                        if (confirm(" ¿ Realmente desea iniciar o detener el monitoreo ?")) {
                            if(estado=="A"&&fechaInicio!=null&&estadoReal==1)
                            {
                                console.log("Se está finalizando monitoreo");
                                
                                console.log("Alertas pendientes: "+alertasPendientes);
                                if(alertasPendientes>=1)
                                {
                                    var mensaje = " Monitoreo tiene "+ alertasPendientes + " alerta(s) pendiente(s) por gestionar. ¿ Desea finalizar de todas formas ? ";
                                    if(confirm(mensaje))
                                    {
                                        controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                        location.reload();
                                    }else
                                    {
                                        //window.location.replace("alerts");
                                        //$('<a href="/xadmin/alerts" ></a>')[0].click();
                                    }
                                }else
                                {
                                    controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                    location.reload();
                                }
                            }else  
                            {
                                console.log("Se está inciando el monitoreo");
                                controlarMonitoreo(idMonitoreo1,alertasPendientes);
                                location.reload();
                            }
                            //controlarMonitoreo(idMonitoreo1);
                            //location.reload();
                        } 
                    }
                    


                }

             }
         });
         //return result;
    }

    function muestraSoloNoIniciados()
    {
        
        //if(buscar==true)  
        //{
            console.log("Hola no inciados ");
            var table, tr, td, i, txtValue, contadorIniciados=0, contadorNoIniciados=0, filter;
            $("#switchSinEventos").prop("checked", false);
            $("#switchNoReportando").prop("checked", false);
            $("#switchNoIniciados").prop("checked", true);
            var buscar = $("#switchNoIniciados").is(':checked');
            //input = document.getElementById("inputBuscarMonitoreo");
            //filter = input.value.toUpperCase();
            table = document.getElementById("tbodyMonitoreos");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) 
                tr[i].style.display = "";
            
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) 
            {
                var continua = 1;
                
                    
                td = tr[i].getElementsByTagName("td")[14];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    //console.log(txtValue);
                    if (txtValue=="Detener") 
                    {
                        if(buscar==true)      
                            tr[i].style.display = "none";
                        else
                            tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "";
                    }
                }
                    
                
                
            }
        //}   
            
    }

   

    


    function crearMonitoreoAutomatico(idactivo, monitoreoOriginal) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         var result = 0, msg = '';
         console.log("entra a crear monitoreo automatico");
         $.ajax({
            url: "{{route('monitors.crearMonitoreoAutomaticoTIA')}}",
             type: "post",
             dataType: "json",
             data: {
                _token : CSRF_TOKEN,
                 idactivo : idactivo , 
                 monitoreoOriginal :  monitoreoOriginal
                  
                },
             
             
             success: function (response) {
                console.log("algo respondio OK111");
                if(response['data'] != null)
                {
                    console.log("algo respondio OK");
                    console.log(response['data'].resultado);
                }
             }
             
             
         });
         //return result;
     }


     function controlarMonitoreo(idMonitoreo,alertasPendientes) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         var result = 0, msg = '';
         console.log("entra a controlar monitoreo");
         $.ajax({
             type: "post",
             url: "{{route('monitors.controlarMonitoreo')}}",
             dataType: "json",
             data: {
                IdMonitoreo : idMonitoreo , 
                alertasPendientes : alertasPendientes ,
                _token : CSRF_TOKEN 
                },
             
             
             success: function (response) {
                
                if(response['data'] != null)
                {
                    console.log(response['data'].resultado);
                    var mostrarSoloIniciados = $("#switchNoIniciados").is(':checked');
                    //if(mostrarSoloIniciados=="true")
                    localStorage.setItem("soloporiniciar", "1");
                    alert(response['data'].resultado);
                }
             }
             
             
         });
         //return result;
     }




</script>

<script type="text/javascript">
    function buscaGeocercasInput()
    {
        
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarGeocerca");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbodyGeocercas");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            
            
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
               
            
        }
    }
</script>

<script type="text/javascript">
    function buscaPuntosInput()
    {
        
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("inputBuscarPunto");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbodyPuntos");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) 
        {
            
            
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
               
            
        }
    }
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

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        //$( "#btBuscarMonitoreos" ).click(function(){
        $('#comboMarca').change(function(){
            $("#tbodyReporteAlertas").empty();
            $("#tbodyReporteHorasMayorAtencion").empty();
            $("#tbodyReporteMayorMotivoAlertas").empty();
            

            var anio = $('#anio').val();
            var marca = $('#comboMarca').val();

            $("#labelReporteGerencial").text("ALERTAS "+marca);

            console.log('holaaa');
            if(anio!="0" && marca!="0")
            {
                $.ajax({
                    url: "{{route('alerts.consultaReportesGerenciales')}}",
                    type: "post",
                    dataType: "json",
                    data: {
                        _token : CSRF_TOKEN,
                        anio : anio , 
                        marca :  marca
                        
                        },
             
             
                    success: function (response) {
                        console.log(response);
                        if(response['reporte'] != null)
                        {
                            len = response['reporte'].length;
                            var totalAlertas = 0;
                            var mesDesde = response['reporte'][0].Mes;
                            var mesHasta = response['reporte'][len-1].Mes;
                            $("#labelDesdeHasta").text("DESDE "+mesDesde+" HASTA "+mesHasta+" DEL "+anio);


                            for (let index = 0; index < len; index++) {
                                var mes = response['reporte'][index].Mes;
                                var alertas = response['reporte'][index].Alertas;
                                var promediodia = response['reporte'][index].Promediodia;
                                
                                var alertasNum = parseInt(alertas);
                                totalAlertas = totalAlertas + alertasNum;

                                $('#tablaReporte > tbody:last-child').append('<tr><td style="text-align: center;">'+mes+'</td><td style="text-align: center;">'+alertas+'</td> <td style="text-align: center;">'+promediodia+'</td></tr>');

                                
                            }
                            $('#tablaReporte > tbody:last-child').append('<tr><td colspan="3" style="text-align: center;">Total General: '+totalAlertas+'</td></tr>');
                            
                            
                        }
                        if(response['mayormotivo'] != null)
                        {
                            len = response['mayormotivo'].length;
                            for (let index = 0; index < len; index++) {
                                var motivo = response['mayormotivo'][index].motivo;
                                var nveces = response['mayormotivo'][index].nveces;
                                

                                $('#tablaReporteMayorMotivo > tbody:last-child').append('<tr><td style="text-align: center;">'+motivo+'</td><td style="text-align: center;">'+nveces+'</td></tr>');

                                
                            }
                            
                        }
                        if(response['horaspico'] != null)
                        {
                            len = response['horaspico'].length;
                            for (let index = 0; index < len; index++) {
                                var hora = response['horaspico'][index].hora;
                                var nveces = response['horaspico'][index].nveces;
                                

                                $('#tablaReporteHorasMayorAtencion > tbody:last-child').append('<tr><td style="text-align: center;">'+hora+'</td><td style="text-align: center;">'+nveces+'</td></tr>');

                                
                            }
                            
                        }
                    }
             
             
                });
            }
        });
    });
</script>






