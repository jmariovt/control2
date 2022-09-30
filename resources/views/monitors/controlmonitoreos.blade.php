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
            font-size: 9px;
            }
    </style>



    


</head>
<body>
    <div id="app" >
        

        <!--<main class="py-4">
            
        </main>-->
        <div class="container-fluid" >
            <!--<select id="cmbCompania" name="cmbCompania" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="*" selected="selected">TODAS</option>
                <option value="0990017514001">TIENDAS INDUSTRIALES ASOCIADAS</option>
            </select>-->
            <!--<a href="/xadmin/alerts" class="btn btn-primary btn-sm" >Ver alertas de todos los clientes</a>-->
            
            <div class="form-group">
                <input type="text" class="form-control-sm" id="txtUnidad" name="txtUnidad" placeholder="Unidad a buscar" >
                <div id=aliasList></div>
		    
			    <input type="hidden" class="form-control form-control-sm" id="idAlias" name="idAlias"  >
			
		    
               
            
                <select class="form-control-sm" id="buscarPor">
                    <option value="1">CodSysHunter</option>
                    <option value="0" selected>Placa</option>
                    <option value="2">VID</option>
                </select>
                <button type="button" class="btn btn-primary btn-sm " id="btUnidadBuscar" name="btUnidadBuscar">Buscar</button>
            </div>

            <!--<a href="/xadmin/companyAlerts/0990017514001/" class="btn btn-primary btn-sm" >Ver TIA</a>-->
            
           
            
           <div class="row" id="monitoreos">
                @foreach($monitoreosPorActivar as $monitoreoporactivar)
                    <?php
                        
                        
                        if($monitoreoporactivar->EstadoReal==1)
                        {
                            $clase = "card text-white text-center bg-danger";
                            $textoBoton = "Detener";
                        }else
                        {
                            $clase = "card text-white text-center bg-info";
                            $textoBoton = "Iniciar";
                        }
                            
                           
                        
                            
                    ?>
                    <div class="col-sm">
                        <div class="{{$clase}}" style="width: 15rem; margin-top: 20px;">
                            
                            <div class="card-body">
                                <h5 class="card-title"> {{$monitoreoporactivar->Alias}}</h5>
                                <?php
                                    $fechaHoraInicio = date('d/m/Y H:i:s',strtotime($monitoreoporactivar->FechaHoraInicio));
                                ?>
                                <p class="card-text">{{$fechaHoraInicio}}</p>
                                <?php
                                    $fechaHoraFin = date('d/m/Y H:i:s',strtotime($monitoreoporactivar->FechaHoraFin));
                                ?>
                                <p class="card-text">{{$fechaHoraFin}}</p>

                                <?php
                                    
                                        $enlace = "/xadmin/assets/ActivoTIA/".$monitoreoporactivar->IdMonitoreo;
                                    
                                ?>

                                <button type="Button" class="btn btn-outline-primary" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('{{$monitoreoporactivar->IdMonitoreo}}');">{{$textoBoton}}</button>
                                
                               
                               
                            
                            </div>
                            <!--<div class="card-footer">
                                <small class="text-success">Hola</small>
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

	   setTimeout(function(){

	       location.reload();

	   },60000);

	</script>





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
                        if (confirm(" ¿ Desea crear el monitoreo automático para TIA con las alertas de Apertua/Cierre de puertas e Ignición Off:  ?")) {
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


    function crearMonitoreoAutomatico(idactivo, monitoreoOriginal) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         var result = 0, msg = '';
         console.log("entra a crear monitoreo automatico");
         $.ajax({
             type: "post",
             url: "{{route('monitors.crearMonitoreoAutomaticoTIA')}}",
             dataType: "json",
             data: {
                 idactivo : idactivo , 
                 monitoreoOriginal :  monitoreoOriginal, 
                 _token : CSRF_TOKEN 
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
                    alert(response['data'].resultado);
                }
             }
             
             
         });
         //return result;
     }




</script>


<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#btUnidadBuscar" ).click(function(){
            
           
                // Fetch data
                $.ajax({
                    url:"{{route('monitors.buscarMonitoreosAlias')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        idAlias: $("#idAlias").val()
                        
                    
                    },
                    success: function( response ) {
                        $("#monitoreos").empty();
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                            console.log("Trajo "+len+" datos");
                            
                        }
                        if(len==0)
                        {
                            $('#monitoreos').append('<div class="col-sm"><br><p>No hay resultados</p></div>');
                        }
                        
                        for(var i=0; i<len; i++)
                        {

                            if(response['data'][i].EstadoReal==1)
                            {
                                var clase = 'card text-white text-center bg-danger';
                                var textoBoton = 'Detener';
                            }else
                            {
                                var clase = 'card text-white text-center bg-info';
                                var textoBoton = 'Iniciar';
                            }
                            
                           
                           
                            var alias = response['data'][i].Alias;
                            var fechaHoraInicio = response['data'][i].FechaHoraInicio;
                            var fechaHoraFin = response['data'][i].FechaHoraFin;
                            var idMonitoreo = response['data'][i].IdMonitoreo;

                            
                            $('#monitoreos').append('<div class="col-sm"><div class="'+clase+'" style="width: 15rem; margin-top: 20px;"><div class="card-body"><h5 class="card-title">'+alias+'</h5><p class="card-text">'+fechaHoraInicio+'</p><p class="card-text">'+fechaHoraFin+'</p><button class="btn btn-outline-primary" id="btnConfirmarAccion" name="btnConfirmarAccion" onclick="javascript:confirmaraccion('+idMonitoreo+');">'+textoBoton+'</button></div></div></div>');
                        



                            




                        }
                        
                        //response( data );
                    }
                });
           
        });
    });
</script>


<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#txtUnidad" ).autocomplete({
                source: function( request, response ) 
                {
                    
                    // Fetch data
                    $.ajax({
                        url:"{{route('assets.getAssets')}}",
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
                        $('#txtUnidad').val(ui.item.label); // display the selected text
                        $('#idAlias').val(ui.item.value); // save selected id to input
                        //traeUltimosMonitoreos();
                        //traeProductos();
                        return false;
                    
                     }
        });


       



    });
</script>
   


</body>
</html>






