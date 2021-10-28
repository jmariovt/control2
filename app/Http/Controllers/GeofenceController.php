<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use XAdmin\Geofence;

class GeofenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $IdUsuario = 0;
        $geofences = DB::select('exec spGeocercaConsultar ?',array($IdUsuario));
        //return $geocercas;
        return view('geofences.index',compact('geofences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('geofences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombre = $request->geofenceNombre;
        $tipo = $request->geofenceTipo;
        $anchoLinea = $request->geofenceAnchoLinea;
        $numeroDePuntos = $request->geofenceNumeroDePuntos;
        $arregloPuntos = array();
        $arregloPuntosTemp = $request->arregloPuntos;

        $IdUsuario = 0;
        $Usuario =  Auth::user()->Usuario; 


        $existe = DB::select('select dbo.ExisteGeocerca (?,?) AS existe',array($nombre,$IdUsuario))[0]->existe;
        if($existe==1)
        {
            return redirect()->route('geofences.create')->withInput()->withErrors('Ya existe nombre de Geocerca.');
        }

        $resultado = DB::select('exec spGeocercaIngresarLv ?,?,?,?,?',array($nombre,$IdUsuario,$tipo,$anchoLinea,$Usuario));
        $IdGeocerca = $resultado[0]->IdGeocerca;
        $arregloPuntos = explode(";",$arregloPuntosTemp);
        $secuencia = 1;
        foreach ($arregloPuntos as $puntoArreglo) {
            $punto = explode(",",$puntoArreglo);
            try {
                $latitud = $punto[0];
                $longitud = $punto[1];
                DB::insert('exec spPuntos_GeocercaIngresar ?,?,?,?',array($IdGeocerca,$secuencia,$latitud,$longitud));
                $secuencia++;
            } catch (\Throwable $th) {
                
            }
        }

        return redirect()->route('/alerts/message')->with('status','Geocerca creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idUsuario = 0;
        $geocercas = DB::select('exec spGeocercaConsultarPorIndice ?,?', array($idUsuario,$id));
        $geocerca = $geocercas[0];

        return view('geofences.show',compact('geocerca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idUsuario = 0;
        $geocercas = DB::select('exec spGeocercaConsultarPorIndice ?,?', array($idUsuario,$id));
        $geocerca = $geocercas[0];

        $puntosGeocerca = DB::select('exec spPuntos_GeocercaConsultar ?',array($id));

        $txtPuntosGeocerca = "";
        $cantidadPuntos = 0;
        foreach ($puntosGeocerca as $punto) {
            $txtPuntosGeocerca = $txtPuntosGeocerca.$punto->Lat.",".$punto->Lon.";";
            $cantidadPuntos++;
        }

        return view('geofences.edit',compact('geocerca','txtPuntosGeocerca','cantidadPuntos'));
        
    }

    /**return view('geofences.create');
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $nombre = $request->geofenceNombre;
        $tipo = $request->geofenceTipo;
        $anchoLinea = $request->geofenceAnchoLinea;
        $numeroDePuntos = $request->geofenceNumeroDePuntos;
        $arregloPuntos = array();
        $arregloPuntosTemp = $request->arregloPuntos;
        $IdGeocerca = $request->idGeocerca;
        $IdUsuario = 0;
        $Usuario =  Auth::user()->Usuario; 
        $haCambiadoPuntos = $request->haCambiadoPuntos;

        //return $request;

        

        //DB::update('exec spGeocercaActualizar ?,?,?,?,?,?',array($IdGeocerca,$nombre,$IdUsuario,$tipo,$anchoLinea,$Usuario));
  
        if($haCambiadoPuntos == "S")
        {
            //DB::table('Puntos_Geocerca')->where('IdGeocerca', '=', $IdGeocerca)->delete();

            $arregloPuntos = explode(";",$arregloPuntosTemp);
            $secuencia = 1;
            foreach ($arregloPuntos as $puntoArreglo) {
                $punto = explode(",",$puntoArreglo);
                try {
                    $latitud = $punto[0];
                    $longitud = $punto[1];
                    //DB::insert('exec spPuntos_GeocercaIngresar ?,?,?,?',array($IdGeocerca,$secuencia,$latitud,$longitud));
                    $secuencia++;
                } catch (\Throwable $th) {
                    
                }
            }
        }
        

        return redirect()->route('/alerts/message')->with('status','Geocerca creada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
