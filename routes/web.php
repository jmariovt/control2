<?php

use Illuminate\Support\Facades\Route;

use XAdmin\Mail\ClientesMonitoreoMailable;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('points', 'PointController');

//Auth::routes();

/** NUEVO */

// Show Register Page & Login Page
Route::get('/login', 'LoginController@show')->name('login')->middleware('guest');
Route::get('/register', 'RegistrationController@show')
    ->name('register')
    ->middleware('guest');

// Para post venta
Route::get('/loginpostventa', 'LoginController@showpv')->name('loginpostventa')->middleware('guest');

// Register & Login User
Route::post('/login', 'LoginController@authenticate');
Route::post('/register', 'RegistrationController@register');

Route::post('/logout', 'LoginController@logout')->name('logout');

// Protected Routes - allows only logged in users
//Route::middleware('auth')->group(function () {
Route::middleware('esMonitoreo')->group(function () {
    
    Route::get('/', function(){
        return view('home');
    });

    Route::middleware('esSupervisorControl')->group(function(){
        Route::get('/alerts/reportegerencial','AlertController@reportegerencial');
        Route::post('/alerts/consultaReportesGerenciales','AlertController@consultaReportesGerenciales')->name('alerts.consultaReportesGerenciales');
    });

    



    Route::get('/puntos', 'PointController@index');
    Route::get('/puntos/create', 'PointController@create');
    Route::get('/puntos/edit/{IdPunto}','PointController@edit');
    Route::post('/puntos/store','PointController@store');
    Route::post('/puntos/update','PointController@update');
    Route::get('/puntos/destroy/{id}','PointController@destroy');
    
    Route::get('/puntos/edit/{id}', function () {
        return view('points.edit');
    });
    
    Route::get('/geocercas', function () {
        return view('geofences.index');
    });
    Route::get('/alerts/message', function(){
        return view('alerts.message');
    })->name('/alerts/message');

    Route::get('/monitors','MonitorController@index')->name('monitors');
    Route::post('/monitors/indexFechas','MonitorController@indexFechas');
    Route::post('/monitors/store','MonitorController@store');
    Route::get('/monitors/create','MonitorController@create');
    Route::post('/products/buscarNombreProducto','ProductController@buscarNombreProducto')->name('products.buscarNombreProducto');
    
    Route::get('/monitors/edit/{IdMonitoreo}','MonitorController@edit');
    Route::get('/monitors/editalert/{IdMonitoreo}/{IdAlerta}','MonitorController@editalert');
    Route::post('/monitors/updatealert','MonitorController@updatealert');
    Route::get('/monitors/destroy/{IdMonitoreo}/{IdActivo}/{FechaHoraInicio}/{FechaHoraFin}','MonitorController@destroy');
    Route::post('/monitors/update','MonitorController@update');
    //Route::get('/monitors/deleteMonitorAlert/{IdMonitoreo}/{IdAlerta}','MonitorController@deleteMonitorAlert');
    Route::post('/monitors/deleteMonitorAlert','MonitorController@deleteMonitorAlert')->name('monitors.deleteMonitorAlert');
    Route::post('/monitors/mostrarTodasAlertas','MonitorController@mostrarTodasAlertas')->name('monitors.mostrarTodasAlertas');

    Route::get('/monitors/clienteMonitoreo','MonitorController@clienteMonitoreo')->name('clienteMonitoreo');
    Route::get('/monitors/deleteActivo/{idActivo}/{usuario}','MonitorController@deleteActivo');
    Route::get('/monitors/ingresarClienteMonitoreo','MonitorController@ingresarClienteMonitoreo')->name('ingresarClienteMonitoreo');
    Route::get('/monitors/asociarClienteMonitoreo','MonitorController@asociarClienteMonitoreo');
    Route::get('/monitors/asignarActivo/{usuario}','MonitorController@asignarActivo');
    Route::post('/assets/buscarActivo','AssetController@buscarActivo')->name('assets.buscarActivo');
    Route::post('/monitors/guardarActivo','MonitorController@guardarActivo')->name('monitors.guardarActivo');
    Route::post('/monitors/actualizarCliente','MonitorController@actualizarCliente')->name('monitors.actualizarCliente');
    Route::get('/monitors/borrarCliente/{Usuario}','MonitorController@borrarCliente');
    Route::get('/monitors/enviarMailUsuario/{Usuario}','MonitorController@enviarMailUsuario');
    Route::post('/monitors/getClienteMonitoreo','MonitorController@getClienteMonitoreo')->name('monitors.getClienteMonitoreo');
    Route::post('/monitors/storeIngresarClienteMonitoreo','MonitorController@storeIngresarClienteMonitoreo');
    Route::post('/monitors/storeAsociarClienteMonitoreo','MonitorController@storeAsociarClienteMonitoreo');
    Route::get('/monitors/getMonitoreosActivosXCliente/{cliente}','MonitorController@getMonitoreosActivosXCliente');
    Route::get('/monitors/mostrarHojaRuta/{IdMonitoreo}/{Usuario}/{Cliente}/{Tipo}','MonitorController@mostrarHojaRuta')->name('mostrarHojaRuta');
    Route::post('/monitors/storeHojaRuta','MonitorController@storeHojaRuta');
    Route::get('/monitors/exportHojaRuta/{IdMonitoreo}/{Usuario}/{Cliente}','MonitorController@exportHojaRuta');
    Route::get('/monitors/eliminarHojaRuta/{IdMonitoreo}/{Usuario}','MonitorController@eliminarHojaRuta');
    Route::get('/monitors/reportesClienteMonitoreo/{UsuarioControl}','MonitorController@reportesClienteMonitoreo');
    Route::post('/monitors/exportReportesCliente','MonitorController@exportReportesCliente');

    Route::get('/monitors/recorrido/','MonitorController@recorrido');
    Route::get('/monitors/consultaSMS/','MonitorController@consultaSMS');
    Route::post('/monitors/buscarSMS/','MonitorController@buscarSMS')->name('monitors.buscarSMS');

    Route::get('/monitors/pruebapv/','MonitorController@pruebapv');
 
   

    Route::get('/monitors/controlMonitoreos','MonitorController@controlMonitoreos');
    Route::post('/monitors/crearMonitoreoAutomaticoTIA','MonitorController@crearMonitoreoAutomaticoTIA')->name('monitors.crearMonitoreoAutomaticoTIA');
    Route::post('/monitors/controlarMonitoreo','MonitorController@controlarMonitoreo')->name('monitors.controlarMonitoreo');
    Route::post('/monitors/buscarMonitoreosAlias','MonitorController@buscarMonitoreosAlias')->name('monitors.buscarMonitoreosAlias');
    
    Route::get('/monitors/informes/{IdMonitoreo}/{Dia1}/{Mes1}/{AnioHora1}/{Dia2}/{Mes2}/{AnioHora2}/{Alias}','MonitorController@informes');
    Route::get('/monitors/reportes/','MonitorController@reportes');
    Route::get('/monitors/exportModelo1/{IdMonitoreo}/{fechaDesde}/{fechaHasta}', 'MonitorController@exportModelo1');
    Route::get('/monitors/exportModelo2/{IdMonitoreo}/{fechaDesde}/{fechaHasta}', 'MonitorController@exportModelo2');
    Route::post('/monitors/exportInformes','MonitorController@exportInformes');
    Route::post('/monitors/exportCiaMeses','MonitorController@exportCiaMeses');





    Route::post('/assets/getAssets/','AssetController@getAssets')->name('assets.getAssets');
    Route::post('/assets/ActivoTIA/','AssetController@ActivoTIA')->name('assets.ActivoTIA');
    //Route::get('/assets/ActivoTIA/{idmonitoreo}','AssetController@ActivoTIA')->name('assets.ActivoTIA');
    Route::get('/alerts/typeAlerts','AlertController@getTypesAlerts')->name('alerts.getTypesAlerts');
    Route::post('/assets/buscarActivoConId/','AssetController@buscarActivoConId')->name('assets.buscarActivoConId');
    Route::post('/assets/buscarActivoConVId/','AssetController@buscarActivoConVId')->name('assets.buscarActivoConVId');
    Route::post('/assets/buscarVid/','AssetController@buscarVid')->name('assets.buscarVid');

    Route::get('/monitors/getLastMonitors/{IdActivo}','MonitorController@getLastMonitors')->name('alerts.getLastMonitors');
    Route::get('/monitors/getEventsMonitor/{IdMonitoreo}','MonitorController@getEventsMonitor')->name('monitors.getEventsMonitor');
    Route::get('/monitors/getProductByAsset/{IdActivo}','ProductController@getProductByAsset');
    Route::get('/monitors/getEventProduct/{IdProductoDispositivo}','ProductController@getEventProduct');
    Route::post('/monitors/findMonitors','MonitorController@findMonitors')->name('monitors.findMonitors');

    Route::get('/plans/getPlansMonitor/{IdMonitoreo}','PlanController@getPlansMonitor')->name('plans.getPlansMonitor');


    Route::get('alerts','AlertController@index');
    Route::get('/pendingAlerts','AlertController@indexPendientes');
    Route::get('companyAlerts/{cia}','AlertController@indexCompany');
    Route::get('/alerts/show/{Secuencia}','AlertController@show');
    Route::get('/alerts/edit/{Secuencia}','AlertController@edit');
    Route::post('/alerts/store','AlertController@store');
    Route::post('/alerts/update/','AlertController@update');
    Route::post('/alerts/getCustomers','AlertController@getCustomers')->name('alerts.getCustomers');
    Route::post('/alerts/buscarAlertasCliente','AlertController@buscarAlertasCliente')->name('alerts.buscarAlertasCliente');
    Route::post('/alerts/updateAtendidoPor','AlertController@updateAtendidoPor')->name('alerts.updateAtendidoPor');
    Route::post('/alerts/findAllParameters','AlertController@findAllParameters')->name('alerts.findAllParameters');
    Route::post('/alerts/findAlertsByParameters','AlertController@findAlertsByParameters')->name('alerts.findAlertsByParameters');
    Route::get('/maps/show/{latitud}/{longitud}','MapController@show')->name('maps.show');
    Route::get('/alerts/seguimientoalertas','AlertController@seguimientoalertas');
    Route::post('/alerts/seguimientoAlertasBuscar','AlertController@seguimientoAlertasBuscar')->name('alerts.seguimientoAlertasBuscar');
    Route::get('/alerts/pruebaSeguimientoAlertas','AlertController@pruebaSeguimientoAlertas');
    Route::post('/alerts/exportSeguimientoAlertas','AlertController@exportSeguimientoAlertas');
   


    Route::get('/monitors/consultaGeneral/','MonitorController@consultaGeneral')->name('postVenta');

    Route::get('/geofences','GeofenceController@index')->name('geofences');
    Route::get('/geofences/create','GeofenceController@create')->name('geofences.create');
    Route::get('/geofences/edit/{IdGeocerca}','GeofenceController@edit')->name('geofences.edit');
    Route::get('/geofences/delete/{IdGeocerca}','GeofenceController@destroy');
    Route::post('/geofences/store','GeofenceController@store');
    Route::post('/geofences/update','GeofenceController@update');

    Route::get('/paths','PathController@index')->name('paths');
    
    Route::get('/paths/geocercasPorRuta/{IdRuta}','PathController@geocercasPorRuta');
    Route::get('/paths/create','PathController@create');
    Route::get('/paths/edit/{IdRuta}','PathController@edit');
    Route::get('/paths/delete/{IdRuta}','PathController@delete'); // No hace nada
    Route::get('/paths/geocercasPorRuta/{IdRuta}/geocercas','PathController@verGeocercas');
    Route::post('/paths/asignarGeocerca','PathController@asignarGeocerca');
    Route::get('/paths/quitarGeocerca/{IdRuta}/{IdGeocerca}','PathController@quitarGeocerca');
    Route::post('/paths/store','PathController@store');
    

    Route::get('/pruebamapas', function(){
        $response = \GoogleMaps::load('geocoding')
		->setParam (['address' =>'santa cruz'])
 		->get();
        echo $response;
    });

    Route::get('/mailclientemonitoreo', function(){
        $correo = new ClientesMonitoreoMailable;
        Mail::to('jmariovt@gmail.com')->send($correo);
        return "Mail enviado";
    });


    Route::get('/pruebamapas2', function(){
        $config = array();
        $config['center'] = 'auto';
        $config['onboundschanged'] = 'if (!centreGot) {
                var mapCentre = map.getCenter();
                marker_0.setOptions({
                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                });
            }
            centreGot = true;';
    
        app('map')->initialize($config);
    
        // set up the marker ready for positioning
        // once we know the users location
        $marker = array();
        app('map')->add_marker($marker);
    
        $map = app('map')->create_map();
        echo "<html><head><script type='text/javascript'>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";
    });
    

});

Route::middleware('esPostventa')->group(function () {
    // POST-VENTA
    Route::get('/', function(){
        return view('home');
    });

    Route::get('/monitors/pruebapv','MonitorController@pruebapv');

    //Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/monitors/consultaGeneral/','MonitorController@consultaGeneral')->name('postVenta');
    Route::post('/monitors/datosUsuarioConsultar/','MonitorController@datosUsuarioConsultar')->name('monitors.datosUsuarioConsultar');
});

//Route::post('/logout', 'LoginController@logout');


/** FIN NUEVO */



Route::get('/home', 'HomeController@index')->name('home');



/*Route::get('/asignacion', function () {
    return view('assignment');
});*/
//Route::get('/asignacion','MonitorController@index');
//Route::get('/monitors','MonitorController@index');




Route::get('/pruebaip',function () {
    return Request::ip();
});

