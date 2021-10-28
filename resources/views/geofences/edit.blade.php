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

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBuMimu7-55am4RMe-W3y8nhSXGqfJMGvQ"></script>

    

       
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
    <div class="row">
        
            <div class="card">
                <div class="card-header">Modificación de geocerca</div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row">
							<form class="form-group" method="POST" action="/xadmin/geofences/update" id="updateGeofence">
                                @csrf
								<div class="modal-body">
								    
                                            <div class="form-group">
										        <label for="geofenceNombre">Nombre</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceNombre" value="{{$geocerca->Nombre}}" name="geofenceNombre">
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    switch ($geocerca->Tipo) {
                                                        case '1':
                                                            $selectPoligonal = "selected";
                                                            $selectLineal = "";
                                                            $selectCircular = "";
                                                            break;
                                                        case '2':
                                                            $selectPoligonal = "";
                                                            $selectLineal = "selected";
                                                            $selectCircular = "";
                                                            break;
                                                        default:
                                                            $selectPoligonal = "";
                                                            $selectLineal = "";
                                                            $selectCircular = "selected";
                                                            break;
                                                    }
                                                ?>
										        <label for="geofenceTipo">Tipo de geocerca</label>
                                                <select class="form-control form-control-sm" id="geofenceTipo">
                                                    <option value="1" $selectPoligonal>Poligonal</option>
                                                    <option value="2" $selectLineal>Lineal</option>
                                                    <option value="3" $selectCircular>Circular</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceAnchoLinea">Ancho de línea</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceAnchoLinea" value="{{$geocerca->Parametro1}}" name="geofenceAnchoLinea" >
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceNumeroDePuntos">Número de Puntos</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceNumeroDePuntos" value="{{$cantidadPuntos}}" name="geofenceNumeroDePuntos" >
                                            </div>
                                            <input class="form-control form-control-sm" type="hidden" id="arregloPuntos" name="arregloPuntos" value="{{$txtPuntosGeocerca}}">
                                            <input class="form-control form-control-sm" type="hidden" id="idGeocerca" name="idGeocerca" value="{{$geocerca->IdGeocerca}}">
                                            <input class="form-control form-control-sm" type="hidden" id="haCambiadoPuntos" name="haCambiadoPuntos" value="N">
                                     
                                </div>
                                <div id="map"></div>
                                <div id="floating-panel">
                                    <input id="removePoligono" class="btn btn-secondary btn-sm" type="button" value="Borrar" />
                                    
                                </div>
                                <div class="modal-footer">
									<a href="" onclick="window.close();" class="btn btn-secondary">Cancelar</a>
									<button type="submit" class="btn btn-primary">Guardar</button>
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
    var markersPol = [];
    var markers = [];
    let geocerca;
    var puntosTexto = "";
    var geocercasCirculares = 0;
    window.onload = function() 
    {
        
        //var latlng = new google.maps.LatLng(-2.1532, -79.8936);
        var txtPuntosGeocerca = $("#arregloPuntos").val();
        console.log(txtPuntosGeocerca);
        var numeroPuntos = $("#geofenceNumeroDePuntos").val();
        var arregloPuntos = txtPuntosGeocerca.split(";");
        for(i=0;i<numeroPuntos;i++)
        {
            arregloPunto = arregloPuntos[i].split(",");
            latitud = parseFloat(arregloPunto[0]);
            longitud = parseFloat(arregloPunto[1]);
            console.log(latitud+" "+longitud);
            var latlng = new google.maps.LatLng(latitud,longitud);

            if(i==0)
            {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: latlng,
                    zoom: 15,
                    streetViewControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            }

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Set lat/lon values for this property',
                draggable: false
            });

            markers.push(marker);
            markersPol.push({lat: latitud, lng: longitud});

            if(markersPol.length==numeroPuntos)
            {
                console.log('Construct the polygon.');
                geocerca = new google.maps.Polygon({
                    paths: markersPol,
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                });
                console.log(markersPol);
                geocerca.setMap(map);
                //$("#arregloPuntos").val(puntosTexto);
            }
        }

        google.maps.event.addListener(map, "click", function(ov, latlng, overlaylatlng) {               //dblclick 
                var numeroPuntos = $("#geofenceNumeroDePuntos").val();
                var tipoGeocerca = $("#geofenceTipo").val();
                console.log(numeroPuntos);
                if (ov.latLng) 
                {
                    //DeleteMarkers();
                    switch (tipoGeocerca) 
                    {
                        case "1":
                    
                            if(markersPol.length<numeroPuntos && numeroPuntos >= 3 )
                            {
                                console.log(ov.latLng.lat());
                                


                                var marker = new google.maps.Marker({
                                    position: ov.latLng,
                                    map: map,
                                    title: 'Set lat/lon values for this property',
                                    draggable: false
                                });

                                markers.push(marker);
                                markersPol.push({lat: ov.latLng.lat(), lng: ov.latLng.lng()});
                                puntosTexto = puntosTexto + ov.latLng.lat() + "," + ov.latLng.lng() + ";";
                                if(markersPol.length==numeroPuntos)
                                {
                                    console.log('Construct the polygon.');
                                     geocerca = new google.maps.Polygon({
                                        paths: markersPol,
                                        strokeColor: "#FF0000",
                                        strokeOpacity: 0.8,
                                        strokeWeight: 2,
                                        fillColor: "#FF0000",
                                        fillOpacity: 0.35,
                                    });
                                    console.log(markersPol);
                                    geocerca.setMap(map);
                                    $("#arregloPuntos").val(puntosTexto);
                                }
                            }
                            break;
                        case "2":
                            console.log(ov.latLng.lat());
                                


                                var marker = new google.maps.Marker({
                                    position: ov.latLng,
                                    map: map,
                                    title: 'Set lat/lon values for this property',
                                    draggable: false
                                });

                                markers.push(marker);
                                markersPol.push({lat: ov.latLng.lat(), lng: ov.latLng.lng()});
                                $("#geofenceNumeroDePuntos").val(markers.length);
                                puntosTexto = puntosTexto + ov.latLng.lat() + "," + ov.latLng.lng() + ";";
                                if(markersPol.length>1)
                                {
                                    console.log('Construct the polyline.');
                                    
                                     geocerca = new google.maps.Polyline({
                                        paths: [markersPol[markersPol.length-1],markersPol[markersPol.length]],
                                        strokeColor: "#FF0000",
                                        strokeOpacity: 0.8,
                                        strokeWeight: 2,
                                        
                                    });
                                    console.log(markersPol);
                                    geocerca.setMap(map);
                                    
                                    
                                    $("#arregloPuntos").val(puntosTexto);
                                }
                            break;
                        default:
                            if(geocercasCirculares<1)
                            {
                                var marker = new google.maps.Marker({
                                    position: ov.latLng,
                                    map: map,
                                    title: 'Set lat/lon values for this property',
                                    draggable: false
                                });
                                markers.push(marker);
                                puntosTexto = puntosTexto + ov.latLng.lat() + "," + ov.latLng.lng() + ";";
                                geocerca = new google.maps.Circle({
                                    strokeColor: "#FF0000",
                                    strokeOpacity: 0.8,
                                    strokeWeight: 2,
                                    fillColor: "#FF0000",
                                    fillOpacity: 0.35,
                                    map,
                                    center: ov.latLng,
                                    radius: 500,
                                });
                                
                                geocercasCirculares++;
                                $("#arregloPuntos").val(puntosTexto);
                            }
                            break;
                    }       
                    
                        
                }
            });
            document.getElementById("removePoligono").addEventListener("click", removePolygon);
    };

    function DeleteMarkers() {
        //Loop through all the markers and remove
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
        markersPol = [];
        geocercasCirculares = 0;
    };

    function removePolygon() {
        geocerca.setMap(null);
        DeleteMarkers();
        puntosTexto="";
        $("#arregloPuntos").val("");
        $("#haCambiadoPuntos").val("S");
    }

    $('#updateGeofence').submit(function() {
        var numeroPuntos = $("#geofenceNumeroDePuntos").val();
        var cantidadPuntosDibujados = markers.length;
        

        
        if (numeroPuntos!=cantidadPuntosDibujados)
        {
            alert('Verifique la cantidad de puntos ingresados para continuar');
            return false;
        }else
        {
            
                    return true;
             
        }
        //$(window).off('beforeunload');
        

    });
</script>

