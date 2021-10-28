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

    <style type="text/css"> 
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
    </style>



    


</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Asignación de activo</div>

                            <div class="card-body">
                                <div class="container">
	    				            <div class="row justify-content-center">
                                        <form class="form-group" method="POST" action="">
                                            <input  type="text" id="txtBuscarActivo" name="txtBuscarActivo" placeholder="Alias, Chasis, Motor o CodSysHunter">
                                            <input  type="hidden" id="txtUsuario" name="txtUsuario" value="{{$usuario}}">
                                            <input  type="hidden" id="idActivo" name="idActivo" >
                                            <button type="button"  class="btn btn-outline-primary btn-sm" id="btnGuardarActivo">Guardar</button>
                                            
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


<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $( "#txtBuscarActivo" ).autocomplete({
            minLength: 3,
            source: function( request, response ) 
            {
                console.log(request.term); 
                // Fetch data
                $.ajax({
                    url:"{{route('assets.buscarActivoConId')}}",
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
                $('#txtBuscarActivo').val(ui.item.label); // display the selected text
                $('#idActivo').val(ui.item.value);
                return false;
            }
        });


        $( "#btnGuardarActivo" ).click(function(){
            
           var activo = $("#idActivo").val();
           var longitudActivo = activo.length;
           if(longitudActivo>0)
           {
                // Fetch data
                $.ajax({
                    url:"{{route('monitors.guardarActivo')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        activo: $("#idActivo").val(),
                        usuario: $("#txtUsuario").val()
                        
                    
                    },
                    success: function( response ) {
                        console.log("Asignó activo");
                        alert(response['data'].resultado);
                        window.close();
                        if(response['data'] != null)
                        {
                            len = response['data'].length;
                            console.log("Trajo "+len+" datos");
                           
                        }
                    }
                });
           } else{
               alert("Debe ingresar un activo");
           }
           
        });



    });


</script>