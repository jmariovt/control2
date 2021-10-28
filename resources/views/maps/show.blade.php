<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xadmin') }}</title>
    <link rel="stylesheet" href="{{asset('leaflet/js/leaflet.css') }}">
    <link rel="stylesheet" href="{{asset('leaflet/css/distance.css') }}">
    <link rel="stylesheet" href="{{asset('leaflet/css/L.Control.Geonames.css') }}">
    <link rel="stylesheet" href="{{asset('leaflet/js/leaflet-measure.css') }}">

   
    <style type="text/css">
        #map {
            height: 880px;
            width: 1240px;
            background-color: #f8e468;
            font-family: Roboto;
            font-size: x-small;
        }

        .leaflet-map-pane {
            z-index: 2 !important;
            font-family: Roboto;
            font-size: x-small;
        }

        .leaflet-google-layer {
            z-index: 1 !important;
            font-family: Roboto;
            font-size: x-small;
        }

        .body {
            font-family: Roboto;
            font-size: x-small;
            background-color: #e5e5e5;
        }
    </style>
    <script src="{{asset('leaflet/js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/leaflet.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/layer/Marker.Text.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/layer/vector/GPX.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/control/Distance.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/L.Control.Geonames.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/leaflet-measure.js')}}" type="text/javascript"></script>
    <script src="{{asset('leaflet/js/Leaflet.GoogleMutant.js')}}" type="text/javascript"></script>

    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuMimu7-55am4RMe-W3y8nhSXGqfJMGvQ"></script>
   

    <script type="text/javascript">
        var URLParser = function (url) {
            this.url = url || window.location.href;
            this.urlObject = this.parse();
        };

        URLParser.prototype = {
            constructor: URLParser,

            parse: function (url) {
                var tempArr,
                    item,
                    i,
                    returnObj = {};
                this.url = url || this.url;
                tempArr = this.url.split("?");
                returnObj.baseURL = tempArr[0];
                returnObj.params = {};
                if (tempArr.length > 1) {
                    returnObj.queryString = tempArr[1];
                    tempArr = tempArr[1].split("&");
                    for (i = 0; i < tempArr.length; i++) {
                        item = tempArr[i].split("=");
                        returnObj.params[item[0]] = item[1];
                    }
                } else {
                    returnObj.queryString = "";
                }

                return returnObj;
            },

            toString: function () {
                var strURL = this.urlObject.baseURL + "?",
                    paramObj = this.urlObject.params,
                    prop;
                for (prop in paramObj) {
                    if (paramObj.hasOwnProperty(prop)) {
                        strURL += prop + "=" + paramObj[prop] + "&";
                    }
                }
                return strURL.substr(0, strURL.length - 1);
            },

            removeParams: function (removeArray) {
                var paramObj = this.urlObject.params,
                    key,
                    i;
                if (removeArray instanceof Array) {
                    for (i = 0; i < removeArray.length; i++) {
                        key = removeArray[i];
                        if (paramObj.hasOwnProperty(key)) {
                            delete paramObj[key];
                        }
                    }
                }
            },

            addParams: function (paramObj) {
                var params = this.urlObject.params,
                    key;
                if (typeof paramObj === "object") {
                    for (key in paramObj) {
                        if (paramObj.hasOwnProperty(key)) {
                            params[key] = paramObj[key];
                        }
                    }
                }
            }
        };

        var lat;
        var lon;
        var vid;
        
        $(function () {
            var up = new URLParser();
            var urlObj = up.parse(window.location.href);

            lat = $("#txlatitud").val();// urlObj.params['lat'];
            lon = $("#txlongitud").val();//urlObj.params['lon'];
            vid = 'Alerta';        
            
            if (lat == '' || lon == '' || vid == '') {
                alert('No se Puede mostrar la Unidad en el Mapa'), window.close();
            }

            var map = new L.Map('map', { center: new L.LatLng(lat, lon), zoom: 16 });
            var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
                    maxZoom: 18
                }).addTo(map);

            var roadMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type: 'roadmap'
            });


            var sat = L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/{type}/{mapID}/hybrid.day/{z}/{x}/{y}/{size}/{format}?app_id={app_id}&app_code={app_code}&lg={language}', {
                attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
                subdomains: '1234',
                mapID: 'newest',
                app_id: 'CgGocaGhjM3R0L5EjEXW',
                app_code: 'VOCUmAyT3dMaPqx75qzR2g',
                base: 'aerial',
                maxZoom: 17,
                type: 'maptile',
                language: 'eng',
                format: 'png8',
                size: '256'
            });

            L.control.layers({
                openstreet: osm,
                maps: roadMutant,
                hibrido: sat
            }, {}, {
                    collapsed: true
                }).addTo(map);

            map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.

            var cIcono = L.Icon.extend({
                options: {
                    iconSize: [24, 24],
                    iconAnchor: [12, 20],
                    popupAnchor: [-2, -20]
                }
            });

            var Icono = new cIcono({ iconUrl: '{{asset("Imagenes/Red_Point.gif")}}' })
            try {
                //var d = new L.Control.Distance(); map.addControl(d);
                //map.addControl(new L.Control.Scale());
                var measureControl = new L.Control.Measure(
                    {
                        position: 'bottomright',
                        primaryLengthUnit: 'kilometers',
                        secondaryLengthUnit: 'miles',
                        localization: 'es'
                    });
                measureControl.addTo(map);

                var Texto = '';
            }
            catch (Error) { }

            Texto += '<table>';
            //Texto += '<tr><td>vid</td><td>' + vid + '</td></tr>';
            Texto += '<tr><td>Lat y Lon</td><td>' + new String(lat) + ' ; ' + new String(lon) + '</td></tr>';
            Texto += '</table>';

            var tMarker = new L.Marker.Text(new L.latLng(lat, lon), vid).bindPopup(Texto).setIcon(Icono);
            map.addLayer(tMarker);

            try {
                var control = L.control.geonames({ username: 'cbi.test' });
                map.addControl(control);
            }
            catch (Error) { }

            //map.on('contextmenu', function (e) {
            //    alert(e.latlng.lat.toString() + '  ' + e.latlng.lng.toString());
            //});
            //var pointA = new L.LatLng(lat, lon);
            //var pointB = new L.LatLng(lat - 0.1, lon - 0.1);
            //var pointList = [pointA, pointB];
            //var firstpolyline = new L.Polyline(pointList, {
            //    color: 'red',
            //    weight: 6,
            //    opacity: 0.5,
            //    smoothFactor: 1
            //});
            //firstpolyline.addTo(map);
            Texto = null;
            window.focus();
        });
    </script>
</head>
<body style="margin-top:0px; margin:0; padding: 0">
    <form id="frmMapa">
        <div id="map" style="background-color:gray"></div>
        <input type="hidden" class="form-control form-control-sm" id="txlatitud" name="txlatitud"  value="{{$latitud}}" >
        <input type="hidden" class="form-control form-control-sm" id="txlongitud" name="txlongitud"  value="{{$longitud}}" >
        <input type="hidden" class="form-control form-control-sm" id="txfecha" name="txfecha"  value="" >
        <input type="hidden" class="form-control form-control-sm" id="txvid" name="txvid"  value="" >
        <input type="hidden" class="form-control form-control-sm" id="txplaca" name="txplaca"  value="" >
        
    </form>
</body>
</html>
