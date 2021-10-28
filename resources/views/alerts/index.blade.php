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
            font-size: 9px;
            }
    </style>

    <style type="text/css"> 
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
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
    </style>

<style>
        /* Modify the background color */
          
        .alert-custom {
            background-color: #fdfd96;
        }
        .alert-red-custom {
            background-color: red;
        }
        .bg-custom {
            background-color: gray;
        }
        /* Modify brand and text color */
          
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: green;
        }
    </style>



    


</head>
<body onload="cargarFecha()">
    <div id="app" >
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        

        <!--<main class="py-4">
            
        </main>-->
        <div class="container-fluid bg-custom" >
          

            <form class="form-group" method="POST" action="">
                        <table class="" id="tablaContadoresMonitoreos" border="0" name="tablaContadoresMonitoreos" width="100%">
							
								
							<tr>
								<td >Alertas por Producto</td>
								<td  align="center"><label class="form-check-label text-dark"><b>Alertas: </b></label></td>
								<td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
                                <td  align="center"><label class="form-check-label text-dark"><b>&nbsp;</b></label></td>
								
							</tr>
							<tr>
								
								<td >
                                    <div class="material-switch">
                                         
                                        <input class="form-check-input" type="checkbox" id="switchPorProducto">
                                        <label class="label-primary" for="switchPorProducto"></label>
                                    </div>    
                                    
                                </td>
                                <td align="center"><h3><label class="form-check-label text-dark" id="contadorAlertas"></label></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-success" id="contadorAtendiendose">0</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-dark alert-custom" id="contadorAmarillas">0</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-warning" id="contadorNaranjas">0</span></h3></td>
                                <td align="center"><h3><span class="badge rounded-pill text-white bg-danger" id="contadorRojas">0</span></h3></td>
								
								
							</tr>
							
										
							
							
						
						</table>

                        
           
                           
                            
                                <input type="text" class="form-control form-control-sm" id="aliasBuscar" placeholder="Filtrar Cliente...">
                                <!--<button type="button" class="btn btn-primary btn-sm " id="btBuscarAlertasTodosParametros" name="btBuscarAlertasTodosParametros">Buscar todos</button>-->
                                <input type="text" class="form-control form-control-sm" onkeyup="buscaAlertasInput()" id="buscadorAlertas" name="buscadorAlertas" placeholder="Filtrar...">
                            
                                <label class="form-check-label text-dark" for="ultimaActualizacion">Ultima actualizacion</label>
                                <input type="text"  id="ultimaActualizacion" readonly>
                                
                        
                           
                        </form>

            <?php
                $luzAlarma = "";
            ?>
          

           <div class="row" id="alertas">
                @foreach($alertas as $alerta)
                    <?php
                        $revisadoPor="";
                        $luzAlarma = "Imagenes/LuzAlarmaAmarilla.png";
                        
                        
                        if($alerta->EstadoAlarma==0)
                        {
                            $clase = "card text-center text-dark alert-custom  mb-3";
                            $claseTitulo="card-title text-dark";
                        }
                            
                           
                        if($alerta->EstadoAlarma==1)
                        {
                            $clase = "card text-center text-dark alert-custom mb-3";
                            $claseTitulo="card-title text-warning bg-dark";
                        }
                            
                        if($alerta->EstadoAlarma==2)
                        {
                            $clase = "card text-center text-dark  alert-custom mb-3";
                            $claseTitulo="card-title text-danger bg-dark";
                            $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                        }
                            
                        if($alerta->EstadoAlarma==5)
                        {
                            $clase = "card text-center text-dark bg-danger mb-3";
                            $claseTitulo="card-title text-dark";
                            $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                        }

                        if($alerta->SiendoAtendida==1)
                        {
                            $revisadoPor="Siendo atendida";
                            $clase = "card text-center text-white bg-success mb-3";
                        }    
                            
                    ?>
                    <div class="col-sm" id="tarjetasAlertas" name="tarjetasAlertas">
                        <div class="{{$clase}}" style="width: 15rem; margin-top: 20px;">
                            <!--<div class="card-header"><img src="{{asset($luzAlarma)}}"  style="height: 30px; width:30px" class="card-img-top" alt="Alerta"></div>
                            <div class="card-header">
                                {{$alerta->VID}}
                            </div>-->
                            <div class="card-body">
                                <?php
                                    $vid = substr($alerta->VID, 0, 15);
                                ?>
                                <p class="card-text"><b>{{$vid}}</b></p>
                                <?php
                                    $evento = substr($alerta->Evento, 0, 21);
                                ?>
                                <p class="{{$claseTitulo}}"><b>{{$evento}}</b></p>
                                <?php
                                    $fechaHoraRegistro = date('d/m/Y H:i:s',strtotime($alerta->FechaHoraRegistro));
                                ?>
                                <p class="card-text"><b>{{$fechaHoraRegistro}}</b></p>

                                <?php
                                    if($mod==0)
                                    {
                                        if($alerta->SiendoAtendida==1)
                                            $enlace = "";
                                        else
                                        {    $enlace = "/xadmin/alerts/show"."/".$alerta->Secuencia;

                                            ?>
                                            <a href="" class="btn btn-outline-primary text-dark btn-sm"  onclick="window.open('{{$enlace}}','{{$alerta->Secuencia}}','width=900,height=900'); return false;">Ver alerta</a>
                                            <?php
                                        }
                                    }
                                        
                                    else   
                                        $enlace = "/xadmin/alerts/edit/".$alerta->Secuencia;
                                ?>
                                
                                <p class="card-text"><small class="text-green"><b>{{$revisadoPor}}</b></small></p>
                            </div>
                            <!--<div class="card-footer">
                                <small class="text-success">{{$revisadoPor}}</small>
                            </div>-->
                        </div>
                    </div>
                @endforeach
               
            
            
            
        
        
            </div>
            </p>
            <div class="text-center">
        
            </div>
        </div>
    </div>

	<script type="text/javascript">

	   //setTimeout(function(){

        //buscarAlertas();

	   //},90000);

	</script>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        function split( val ) {
            return val.split( /,\s*/ );
        }

        function extractLast( term ) {
            return split( term ).pop();
        }

        $( "#aliasBuscar" ).autocomplete({
            minLength: 3,
            source: function( request, response ) 
            {
                //if() para que busque solo a partir del tercer caracter
                console.log("Revisa "+request.term);
                console.log(request.term.length);
                var ultimo = extractLast( request.term );
                // Fetch data
                if(ultimo.length>2)
                {
                    $.ajax({
                        url:"{{route('alerts.findAllParameters')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: extractLast( request.term )
                            
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                }
                
            },
            focus: function() {
                 return false;
             },
            select: function (event, ui) {
                // Set selection
                //$('#aliasBuscar').val(ui.item.label); // display the selected text
                var terms = split( this.value );
                terms.pop();
                terms.push( ui.item.label );
                terms.push( "" );
                this.value = terms.join( "," );
                return false;
        }
  });


        
        $( "#txtCliente" ).autocomplete({
            source: function( request, response ) 
            {
                console.log(request.term); 
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
                $('#idEntidad').val(ui.item.value);
                return false;
            }
        });
    });
</script>


<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#btBuscarAlertasCliente" ).click(function(){

                // SIN USAR
           
                
                /*$.ajax({
                    url:"{{route('alerts.buscarAlertasCliente')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        idEntidad: $("#idEntidad").val()
                        
                    
                    },
                    success: function( response ) {
                        $("#alertas").empty();
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                            console.log("Trajo "+len+" datos");
                            
                        }
                        if(len==0)
                        {
                            $('#alertas').append('<div class="col-sm"><br><p>No hay resultados</p></div>');
                        }
                        
                        for(var i=0; i<len; i++)
                        {

                            var revisadoPor="";
                            if(response['data'][i].SiendoAtendida==1)
                                revisadoPor='Siendo atendida';



                            if(response['data'][i].EstadoAlarma==0)
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

                            var vid = response['data'][i].VID;
                            var evento = response['data'][i].Evento;
                            var vid_2 = vid.substring(0,15);
                            var evento_2 = evento.substring(0,21);
                            var fechaHoraRegistro = response['data'][i].FechaHoraRegistro;
                            var secuencia = response['data'][i].Secuencia;

                            
                            $('#alertas').append('<div class="col-sm"><div class="'+clase+'" style="width: 15rem; margin-top: 20px;"><div class="card-header">'+vid_2+'</div><div class="card-body"><p class="'+claseTitulo+'">'+evento_2+'</p><p class="card-text">'+fechaHoraRegistro+'</p><a href="/xadmin/alerts/show/'+secuencia+'" class="btn btn-outline-primary" target="_blank" onclick="window.open(\'/xadmin/alerts/show/'+secuencia+'\',\'newwindow\',\'width=900,height=900\'); return false;">Ver alerta</a></div><div class="card-footer"><small class="text-success">'+revisadoPor+'</small></div></div></div>');
                        
                        }
                        
                        //response( data );
                    }
                });*/
                
           
        });
    });
</script>



<script type="text/javascript">
    
    
    
    
    
    var myVar;
    function cargarFecha()
    {
        console.log("La de afuera");
        var currentdate = new Date(); 
        var datetime = currentdate.getDate() + "/"
        + (currentdate.getMonth()+1)  + "/" 
        + currentdate.getFullYear() + " "  
        + currentdate.getHours() + ":"  
        + currentdate.getMinutes() + ":" 
        + currentdate.getSeconds();
        $('#ultimaActualizacion').val(datetime);
    }

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    function buscaAlertasInput()
    {
        console.log('Hola');
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("buscadorAlertas");
        filter = input.value.toUpperCase();
        table = document.getElementById("alertas");
        cards = table.getElementsByTagName("div");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < cards.length; i++) 
        {
            var continua = 1;

            if(cards[i].id==="tarjetasAlertas")
            {
                divRaiz = cards[i].getElementsByTagName("p");
                for(j=0;j<divRaiz.length && continua==1;j++)
                {
                    texto = divRaiz[j].textContent || divRaiz[3].innerText;
                    if(texto.toUpperCase().indexOf(filter) > -1)
                    {
                        cards[i].style.display = "";
                        continua=0;
                    }else
                    {
                        cards[i].style.display = "none";
                    }
                }
                
            }



            
            
        }
    }

    

        function buscarAlertas()
        {
            console.log("Entraa");
            
                console.log("Hola "+$("#aliasBuscar").val());
                var parametros = $("#aliasBuscar").val();
                var porProducto = $("#switchPorProducto").is(':checked');

                console.log('Por producto: '+porProducto);
                if(parametros.length>0)
                {
                    console.log("tiene escrito");
                    parametros = parametros.slice(0, -1);
                }else
                {
                    parametros = "000";
                }
                console.log(parametros);
                // Fetch data
                $.ajax({
                    url:"{{route('alerts.findAlertsByParameters')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        parametros: parametros,
                        porProducto: porProducto
                        
                    
                    },
                    success: function( response ) {
                        $("#alertas").empty();
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                            console.log("Trajo "+len+" datos");
                            //var dt = new Date();
                            //var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                            var currentdate = new Date(); 
                            var datetime = currentdate.getDate() + "/"
                            + (currentdate.getMonth()+1)  + "/" 
                            + currentdate.getFullYear() + " "  
                            + currentdate.getHours() + ":"  
                            + currentdate.getMinutes() + ":" 
                            + currentdate.getSeconds();
                            $('#ultimaActualizacion').val(datetime);
                        }
                        if(len==0)
                        {
                            $('#alertas').append('<div class="col-sm"><br><p>No hay resultados</p></div>');
                        }

                        var contadorAmarillo = 0;
                        var contadorNaranja = 0;
                        var contadorRojo = 0;
                        var contadorAtendiendose = 0;
                        
                        for(var i=0; i<len; i++)
                        {

                            var revisadoPor="";
                            $luzAlarma = "Imagenes/LuzAlarmaAmarilla.png";
                            



                            if(response['data'][i].EstadoAlarma==0 && response['data'][i].SiendoAtendida!=1)
                            {
                                var clase = 'card text-center text-dark alert-custom  mb-3';
                                var claseTitulo='card-title text-dark';
                                contadorAmarillo++;
                            }
                            
                           
                            if(response['data'][i].EstadoAlarma==1 && response['data'][i].SiendoAtendida!=1)
                            {
                                var clase = 'card text-center text-dark alert-custom mb-3';
                                var claseTitulo='card-title text-warning bg-dark';
                                contadorNaranja++;
                            }
                                
                            if(response['data'][i].EstadoAlarma==2 && response['data'][i].SiendoAtendida!=1)
                            {
                                var clase = 'card text-center text-dark  alert-custom mb-3';
                                var claseTitulo='card-title text-danger bg-dark';
                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                contadorRojo++;
                            }
                                
                            if(response['data'][i].EstadoAlarma==5 && response['data'][i].SiendoAtendida!=1)
                            {
                                var clase = 'card text-center text-dark bg-danger mb-3';
                                var claseTitulo='card-title text-dark';
                                $luzAlarma = "Imagenes/LuzAlarmaRoja.png";
                                contadorRojo++;
                            }

                            

                            if(response['data'][i].SiendoAtendida==1)
                            {
                                revisadoPor='Siendo atendida';
                                var clase = "card text-center text-white bg-success mb-3";
                                contadorAtendiendose++;
                            }
                                
                            var vid = response['data'][i].VID;
                            var evento = response['data'][i].Evento;
                            var vid_2 = vid.substring(0,15);
                            var evento_2 = evento.substring(0,21);
                            var fecha = response['data'][i].FechaHoraRegistro;
                            var fechaHoraRegistro = fecha.slice(0,19);
                            var secuencia = response['data'][i].Secuencia;

                            var textoVentana = "";
                            var textoBoton = "";
                            if(response['data'][i].SiendoAtendida==1)
                                textoVentana = "";
                            else
                             {   
                                 textoVentana = "window.open('/xadmin/alerts/show/"+secuencia+"','"+secuencia+"','width=900,height=900'); return false;";
                                 textoBoton ='<a href="" class="btn btn-outline-primary text-dark btn-sm" onclick="'+textoVentana+'">Ver alerta</a>';
                             }

                            
                            $('#alertas').append('<div class="col-sm" id="tarjetasAlertas"><div class="'+clase+'" style="width: 15rem; margin-top: 20px;"><div class="card-body"><p class="card-text"><b>'+vid_2+'</b></p><p class="'+claseTitulo+'"><b>'+evento_2+'</b></p><p class="card-text"><b>'+fechaHoraRegistro+'</b></p>'+textoBoton+'<p class="card-text"><small class="text-dark"><b>'+revisadoPor+'<b></small></p></div></div></div>');
                            $('#contadorAmarillas').text(contadorAmarillo);
                            $('#contadorNaranjas').text(contadorNaranja);
                            $('#contadorRojas').text(contadorRojo);
                            $("#contadorAtendiendose").text(contadorAtendiendose);
                        }
                        buscaAlertasInput();
                        //response( data );
                    }
                });
        }
    

    $(document).ready(function(){
        setInterval(function()
            {
                cargarFecha();
                buscarAlertas();
                
            }, 20000);

            
        
        
    });

    $(document).ready(function(){
        $( "#btBuscarAlertasTodosParametros" ).click(function(){
                buscarAlertas();
           
        });
    
        function recargarDatos()
        {
            cargarFecha();
            buscarAlertas();
            
        }

        function cargarFecha()
        {
            console.log("La de adentro");
            var currentdate = new Date(); 
            var datetime = currentdate.getDate() + "/"
            + (currentdate.getMonth()+1)  + "/" 
            + currentdate.getFullYear() + " "  
            + currentdate.getHours() + ":"  
            + currentdate.getMinutes() + ":" 
            + currentdate.getSeconds();
            $('#ultimaActualizacion').val(datetime);
        }

        function buscaAlertasInput()
        {
            console.log('Hola alertas input');
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("buscadorAlertas");
            filter = input.value.toUpperCase();
            table = document.getElementById("alertas");
            cards = table.getElementsByTagName("div");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < cards.length; i++) 
            {
                var continua = 1;

                if(cards[i].id==="tarjetasAlertas")
                {
                    divRaiz = cards[i].getElementsByTagName("p");
                    for(j=0;j<divRaiz.length && continua==1;j++)
                    {
                        texto = divRaiz[j].textContent || divRaiz[3].innerText;
                        if(texto.toUpperCase().indexOf(filter) > -1)
                        {
                            cards[i].style.display = "";
                            continua=0;
                        }else
                        {
                            cards[i].style.display = "none";
                        }
                    }
                    
                }



                
                
            }
        }
    });

</script>

<script type="text/javascript">

    $(document).ready(function(){
        setInterval(function()
            {
                actualizaContadores();
                
            }, 1000);
        
        
    });

    function actualizaContadores()
    {
        //console.log('Entra a actualizar contadores');
        //actualizaReportando();
        if(document.getElementById("alertas")){
        //actualizaIniciados();
        actualizaEnPantalla();
        //actualizaAtendiendose();
        //actualizaReportando();
        }
    }

    function actualizaEnPantalla()
    {
        //console.log('Hola');
        var table, tr, td, i, txtValue, contador=0, noReportando=0;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("alertas");
        cards = table.getElementsByTagName("div");
        
        // Loop through all table rows, and hide those who don't match the search query
        
        for (i = 0; i < cards.length; i++) 
        {
            //console.log(cards[i]);
            if(cards[i].id==="tarjetasAlertas")
                contador++;
                
                    
                
            
            
        }
        $("#contadorAlertas").text(contador);
        //$("#contadorNoReportando").text(noReportando);
    }

    function actualizaAtendiendose()
    {
        //console.log('Verifica Iniciados');
        var table, tr, td, i, txtValue, contador=0, contadorNoIniciados=0, filter, cards,divCuerpo,parrafos,p,texto, divRaiz;
        //input = document.getElementById("inputBuscarMonitoreo");
        //filter = input.value.toUpperCase();
        table = document.getElementById("alertas");
        cards = table.getElementsByTagName("div");

        for (i = 0; i < cards.length; i++) 
        {
            if(cards[i].id==="tarjetasAlertas")
            {
                divRaiz = cards[i].getElementsByTagName("p");
            
                texto = divRaiz[3].innerText;
                if(texto==="Siendo atendida")
                    contador++;
            }
            
        }
        
        
        $("#contadorAtendiendose").text(contador);
        
    }
</script>

<script type="text/javascript">
    function buscaAlertasInput()
    {
        console.log('Hola');
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("buscadorAlertas");
        filterAll = input.value.toUpperCase();
        filter = filterAll.split(";");
        table = document.getElementById("alertas");
        cards = table.getElementsByTagName("div");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < cards.length; i++) 
        {
            var continua = 1;

            if(cards[i].id==="tarjetasAlertas")
            {
                divRaiz = cards[i].getElementsByTagName("p");
                for(j=0;j<divRaiz.length && continua==1;j++)
                {
                    texto = divRaiz[j].textContent || divRaiz[3].innerText;
                    mostrar = 0;
                    for(k=0;k<filter.length;k++)
                    {
                        if(texto.toUpperCase().indexOf(filter[k]) > -1)
                        {
                            mostrar = 1;
                            
                        }else
                        {
                            
                        }
                    }
                    if(mostrar == 1)
                    {
                        cards[i].style.display = "";
                        continua=0;
                    }else{
                        cards[i].style.display = "none";
                    }
                    
                }
                
            }



            
            
        }
    }
</script>


   


</body>
</html>






