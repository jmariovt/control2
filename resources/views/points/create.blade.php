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
    <script src="{{asset('js/jquery.highlight-5.js')}}" type="text/javascript"></script>
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Fonts -->
<!--    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <!-- Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{asset('js/daterangepicker.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBuMimu7-55am4RMe-W3y8nhSXGqfJMGvQ"></script>

    

       
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
    
    <style type="text/css">
        .highlight { 
            background-color: green;
         }
        #map {
            height: 300px;
            width: 700px;
            border: 1px solid #000;
            }
    </style>

    <!-- JS, Popper.js, and jQuery -->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">

   
    


</head>
<body>
    <div id="app">
        

       
        <div class="container">
@include('common.success')
@include('common.errors')
<div class="container">
    <div class="row ">
        
            <div class="card">
                <div class="card-header">Creación de Punto Referencial</div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row ">
							<form class="form-group" method="POST" action="/xadmin/puntos/store" id="storePoint">
                                @csrf
								<div class="modal-body">
								    
                                            <div class="form-group">
										        <label for="puntoNombre">Nombre</label>
                                                <input class="form-control form-control-sm" type="text" id="puntoNombre" name="puntoNombre" value="{{ old('puntoNombre')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="puntoLatitud">Latitud</label>
                                                <input class="form-control form-control-sm" type="text" id="puntoLatitud" name="puntoLatitud" value="{{ old('puntoLatitud')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="puntoLongitud">Longitud</label>
                                                <input class="form-control form-control-sm" type="text" id="puntoLongitud" name="puntoLongitud" value="{{ old('puntoLongitud')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="idCliente">Id Cliente</label>
                                                <input class="form-control form-control-sm" type="text" id="idCliente" name="idCliente" value="{{ old('idCliente')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="descripcion">Descripción</label>
                                                <input class="form-control form-control-sm" type="text" id="descripcion" name="descripcion" value="{{ old('descripcion')}}" >
                                            </div>
                                            <div class="form-group" >
											<label for="selectAsociarGeocerca">Asociar Geocerca</label>
											<select class="form-control form-control-sm" id="selectAsociarGeocerca" name="selectAsociarGeocerca">
												<!--<option value="0">Placa</option>-->
                                                <option value='-99999' >NINGUNO</option>
												@foreach($geocercas as $geocerca)
													
													<option value='{{ $geocerca->IdGeocerca }}' >{{ $geocerca->Nombre }}</option>
												@endforeach
											</select>
										</div>
                                    
                                </div>
                                <div id="map"></div>
                                <div class="modal-footer">
									<a href="" onclick="window.close();" class="btn btn-secondary btn-sm">Cancelar</a>
									<button type="submit" class="btn btn-primary btn-sm">Guardar</button>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       
    </div>
</div>
</div>
    </div>

    


</body>
</html>
<script type="text/javascript">
    var markers = [];
    window.onload = function() 
    {
        
        var latlng = new google.maps.LatLng(-2.1532, -79.8936);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 11,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'Set lat/lon values for this property',
            draggable: true
        });
        markers.push(marker);
        google.maps.event.addListener(marker, 'dragend', function(a) {
            console.log(a);
            document.getElementById("puntoLatitud").value = a.latLng.lat();
            document.getElementById("puntoLongitud").value = a.latLng.lng();
            
            
        });

        google.maps.event.addListener(map, "dblclick", function(ov, latlng, overlaylatlng) {               
                if (ov.latLng) {
                    DeleteMarkers();
                    console.log(ov.latLng.lat());
                    document.getElementById("puntoLatitud").value = ov.latLng.lat();
                    //txLatitudC.SetText(ov.latLng.lat());

                    document.getElementById("puntoLongitud").value = ov.latLng.lng();


                    var marker = new google.maps.Marker({
                        position: ov.latLng,
                        map: map,
                        title: 'Set lat/lon values for this property',
                        draggable: true
                    });

                    google.maps.event.addListener(marker, 'dragend', function(a) {
                        console.log(a);
                        document.getElementById("puntoLatitud").value = a.latLng.lat();
                        document.getElementById("puntoLongitud").value = a.latLng.lng();
                   
            
                    });
                    markers.push(marker);
                }
            });
    };
    function DeleteMarkers() {
        //Loop through all the markers and remove
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    };
</script>
