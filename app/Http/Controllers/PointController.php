<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use XAdmin\Point;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$points = Point::all();

        $points = DB::select('exec spPuntoConsultar');
        
        return view('points.index',compact('points'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $geocercas = DB::select('exec spGeocercaConsultar ?',array(0));
        return view('points.create',compact('geocercas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'puntoNombre' => 'required',
            'puntoLatitud' => 'required',
            'puntoLongitud' => 'required',            
        ]);

        $puntoNombre = $request->puntoNombre;
        $puntoLatitud = $request->puntoLatitud;
        $puntoLongitud = $request->puntoLongitud;
        $idCliente = $request->idCliente;
        $descripcion = $request->descripcion;
        $selectAsociarGeocerca = $request->selectAsociarGeocerca;

        $IdUsuario = 0;//Auth::user()->IdUsuario;

        if($idCliente=="null")
        {
            $idCliente = ' ';
        }
        if($descripcion=="null")
        {
            $descripcion = ' ';
        }


        $resultado = DB::select('exec spPuntoIngresarLv ?,?,?,?,?,?,?',array($puntoNombre,$descripcion,$puntoLatitud,$puntoLongitud,0,$IdUsuario,$idCliente));
        $idPunto = $resultado[0]->idPunto;
        $mensaje = '';
        if($selectAsociarGeocerca<>'-99999')
        {
            DB::insert('exec spPuntosReferenciaGeocercaIngresar ?,?,?',array($idPunto,$selectAsociarGeocerca,1));
            $mensaje = 'Se ha creado correctamente el Punto '.$idPunto.' y se ha asociado a Geocerca '.$selectAsociarGeocerca.'.';
        }else{
            $mensaje = 'Se ha creado correctamente el Punto '.$idPunto.'.';
        }
        
        
        return redirect()->route('/alerts/message')->with('status',$mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $punto = DB::select('exec spPuntoConsultar ?', array($id));
        $geocercas = DB::select('exec spGeocercaConsultar ?',array(0));
        $IdGeocercaAsociada = DB::select('exec spPuntosReferenciaGeocercaConsultar ?',array($id));

        return view('points.edit',compact('punto','geocercas','IdGeocercaAsociada')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'puntoNombre' => 'required',
            'puntoLatitud' => 'required',
            'puntoLongitud' => 'required',            
        ]);

        $puntoNombre = $request->puntoNombre;
        $puntoLatitud = $request->puntoLatitud;
        $puntoLongitud = $request->puntoLongitud;
        $idCliente = $request->idCliente;
        $descripcion = $request->descripcion;
        $selectAsociarGeocerca = $request->selectAsociarGeocerca;
        $idPunto = $request->IdPunto;
        $IdGeocercaAsociada = $request->txtIdGeocerca;

        $haCambiadoSelect = $request->haCambiadoSelect;

        $IdUsuario = Auth::user()->IdUsuario;

        if($idCliente=='null')
        {
            $idCliente = '';
        }
        if($descripcion=='null')
        {
            $descripcion = '';
        }


        DB::select('exec spPuntoActualizar ?,?,?,?,?,?,?,?',array($idPunto,$puntoNombre,$descripcion,$puntoLatitud,$puntoLongitud,0,$IdUsuario,$idCliente));
        
        $mensaje = '';
        if($haCambiadoSelect=="S")
        {
            if($selectAsociarGeocerca<>'-99999')
            {
                DB::insert('exec spPuntosReferenciaGeocercaIngresar ?,?,?',array($idPunto,$selectAsociarGeocerca,1));
                $mensaje = 'Se ha actualizado correctamente el Punto '.$idPunto.' y se ha asociado a Geocerca '.$selectAsociarGeocerca.'.';
            }else{
                //$IdGeocercasAsociada = DB::select('exec spPuntosReferenciaGeocercaConsultar ?',array($idPunto));
                //foreach ($IdGeocercasAsociada as $IdGeocercaAsociada) {
                    DB::insert('exec spPuntosReferenciaGeocercaIngresar ?,?,?',array($idPunto,$IdGeocercaAsociada,0));
                //}
                
                $mensaje = 'Se ha actualizado correctamente el Punto '.$idPunto.' y se ha desasociado de la Geocerca '.$IdGeocercaAsociada.'.';
            }
        }
        
        
        return redirect()->route('/alerts/message')->with('status',$mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('exec spPuntoEliminar ?',array($id));
        return redirect()->route('/alerts/message')->with('status','Punto eliminado.');
    }
}
