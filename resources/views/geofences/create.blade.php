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

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBuMimu7-55am4RMe-W3y8nhSXGqfJMGvQ&libraries=places"></script>

    

       
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
                <div class="card-header">Creación de geocerca</div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row">
							<form class="form-group" method="POST" action="/xadmin/geofences/store" id="storeGeofence">
                                @csrf
								<div class="modal-body">
								    
                                            <div class="form-group">
										        <label for="geofenceNombre">Nombre</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceNombre" name="geofenceNombre" value="{{old('geofenceNombre')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceTipo">Tipo de geocerca</label>
                                                <select class="form-control form-control-sm" id="geofenceTipo" name="geofenceTipo">
                                                    <option value="1">Poligonal</option>
                                                    <option value="2">Lineal</option>
                                                    <option value="3">Circular</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceAnchoLinea">Ancho de línea</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceAnchoLinea" name="geofenceAnchoLinea" value="{{old('geofenceAnchoLinea')}}">
                                            </div>
                                            <div class="form-group">
										        <label for="geofenceNumeroDePuntos">Número de Puntos</label>
                                                <input class="form-control form-control-sm" type="text" id="geofenceNumeroDePuntos" name="geofenceNumeroDePuntos" value="{{old('geofenceNumeroDePuntos')}}">
                                            </div>
                                            <input class="form-control form-control-sm" type="hidden" id="arregloPuntos" name="arregloPuntos" value="">
                                        
                                </div>
                                <div id="map"></div>
                                <input id="pac-input"></input>
                                <div id="floating-panel">
                                    <input id="removePoligono" class="btn btn-secondary btn-sm" type="button" value="Borrar" />
                                    
                                </div>
                                <div class="modal-footer">
									<a href="" onclick="window.close();"  class="btn btn-secondary btn-sm">Cancelar</a>
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
    var markersPol = [];
    var markers = [];
    let geocerca;
    var puntosTexto = "";
    var geocercasCirculares = 0;
    window.onload = function() 
    {
        
        var latlng = new google.maps.LatLng(-2.1532, -79.8936);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 15,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            
        });

        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */ (
            document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */
        (input));

        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();
            for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
            }

            // For each place, get the icon, place name, and location.
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            var place = null;
            var viewport = null;
            for (var i = 0; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location
                });
                viewport = place.geometry.viewport;
                markers.push(marker);

                bounds.extend(place.geometry.location);
            }
            map.setCenter(bounds.getCenter());
        });

        // Bias the SearchBox results towards places that are within the bounds of the
        // current map's viewport.
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);
        });
        




        //var marker = new google.maps.Marker({
        //    position: latlng,
        //    map: map,
        //    title: 'Set lat/lon values for this property',
        //    draggable: true
        //});
        //markers.push(marker);
        //google.maps.event.addListener(marker, 'dragend', function(a) {
        //    console.log(a);
        //    document.getElementById("puntoLatitud").value = a.latLng.lat();
        //    document.getElementById("puntoLongitud").value = a.latLng.lng();
        //});

        google.maps.event.addListener(map, "click", function(ov, latlng, overlaylatlng) {               //dblclick 
                var numeroPuntos = $("#geofenceNumeroDePuntos").val();
                var tipoGeocerca = $("#geofenceTipo").val();
                
                console.log(numeroPuntos);
                if (ov.latLng) {
                    //DeleteMarkers();
                    switch (tipoGeocerca) {
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
                                console.log(puntosTexto);
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
        $("#arregloPuntos").val(puntosTexto);
    }

    $('#storeGeofence').submit(function() {
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
