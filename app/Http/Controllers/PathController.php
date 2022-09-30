<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use XAdmin\Path;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rutas = DB::select('exec spGetMonitoreoRutas');
        return view('paths.index',compact('rutas'));
    }

    public function indexPostVenta()
    {
        $rutas = DB::select('exec spGetMonitoreoRutas');
        return view('postventa.paths.index',compact('rutas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paths.create');
    }
    public function createPostVenta()
    {
        return view('postventa.paths.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nombre = $request->rutaNombre;
        $detalle = $request->rutaDetalle;
        $usuario = Auth::user()->Usuario; 
        //ctx.spMonitoreoRutaIngresar(0, txtNombre.Text, txtDetalle.Text, UsuarioG)
        try {
            DB::insert('exec spMonitoreoRutaIngresar ?,?,?,?',array(0,$nombre,$detalle,$usuario));
            $mensaje = 'Se ha creado la ruta correctamente';
            return redirect()->route('paths')->with('status',$mensaje);
        } catch (\Throwable $th) {
            return redirect()->route('paths')->withErrors('Se ha presentado un error al crear la Ruta.');
        }
        
    }

    public function storePostVenta(Request $request)
    {
        $nombre = $request->rutaNombre;
        $detalle = $request->rutaDetalle;
        $usuario = Auth::user()->Usuario; 
        //ctx.spMonitoreoRutaIngresar(0, txtNombre.Text, txtDetalle.Text, UsuarioG)
        try {
            DB::insert('exec spMonitoreoRutaIngresar ?,?,?,?',array(0,$nombre,$detalle,$usuario));
            $mensaje = 'Se ha creado la ruta correctamente';
            return redirect()->route('pathsPostVenta')->with('status',$mensaje);
        } catch (\Throwable $th) {
            return redirect()->route('pathsPostVenta')->withErrors('Se ha presentado un error al crear la Ruta.');
        }
        
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
        //No hace nada
        
        return redirect()->route('paths');
    }
    public function editPostVenta($id)
    {
        //No hace nada
        
        return redirect()->route('pathsPostVenta');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function delete($id)
    {
        //No hace nada
        //spMonitoreoRutaEliminar $id
        return redirect()->route('paths');
    }

    public function geocercasPorRuta($IdRuta)
    {
        $geocercas = DB::select('exec spGetMonitoreoRutasGeocercas ?',array($IdRuta));
        return view('paths.geocercasPorRuta',compact('geocercas','IdRuta'));

    }
    public function geocercasPorRutaPostVenta($IdRuta)
    {
        $geocercas = DB::select('exec spGetMonitoreoRutasGeocercas ?',array($IdRuta));
        return view('postventa.paths.geocercasPorRuta',compact('geocercas','IdRuta'));

    }

    public function verGeocercas($IdRuta)
    {
        $geocercas = DB::select('exec spGeocercaConsultar ?',array(0));
        //$geocercas = DB::table('Geocerca')->select('IdGeocerca','Nombre')->orderby('Nombre')->paginate(20);
        return view('paths.todasGeocercas',compact('geocercas','IdRuta'));
    }
    public function verGeocercasPostVenta($IdRuta)
    {
        $geocercas = DB::select('exec spGeocercaConsultar ?',array(0));
        //$geocercas = DB::table('Geocerca')->select('IdGeocerca','Nombre')->orderby('Nombre')->paginate(20);
        return view('postventa.paths.todasGeocercas',compact('geocercas','IdRuta'));
    }

    public function asignarGeocerca(Request $request)
    {
        $IdRuta = $request->IdRuta;
        $IdGeocerca = $request->IdGeocerca;
        $usuario = Auth::user()->Usuario; 

        $verificacion = DB::select('exec spGetMonitoreoGeocercasRutaLv ?,?',array($IdRuta,$IdGeocerca));
        
        try {
            $dato = $verificacion[0]->IdGeocerca;
            return redirect()->route('paths')->withErrors('Geocerca ya asignada a ruta.');
        } catch (\Throwable $th) {
            DB::insert('exec spMonitoreoRutasGeocercasIngresar ?,?,?,?,?',array($IdRuta,$IdGeocerca,1,1,$usuario));
            return redirect()->route('paths')->with('status','Geocerca asignada correctamente.');
        }
        
    }
    public function asignarGeocercaPostVenta(Request $request)
    {
        $IdRuta = $request->IdRuta;
        $IdGeocerca = $request->IdGeocerca;
        $usuario = Auth::user()->Usuario; 

        $verificacion = DB::select('exec spGetMonitoreoGeocercasRutaLv ?,?',array($IdRuta,$IdGeocerca));
        
        try {
            $dato = $verificacion[0]->IdGeocerca;
            return redirect()->route('pathsPostVenta')->withErrors('Geocerca ya asignada a ruta.');
        } catch (\Throwable $th) {
            DB::insert('exec spMonitoreoRutasGeocercasIngresar ?,?,?,?,?',array($IdRuta,$IdGeocerca,1,1,$usuario));
            return redirect()->route('pathsPostVenta')->with('status','Geocerca asignada correctamente.');
        }
        
    }

    public function quitarGeocerca($IdRuta, $IdGeocerca)
    {
        DB::delete('exec spMonitoreoRutasGeocercasEliminar ?,?',array($IdRuta,$IdGeocerca));
        DB::commit();
        $geocercas = DB::select('exec spGetMonitoreoRutasGeocercas ?',array($IdRuta));
        return view('paths.geocercasPorRuta',compact('geocercas','IdRuta'));
    }
    public function quitarGeocercaPostVenta($IdRuta, $IdGeocerca)
    {
        DB::delete('exec spMonitoreoRutasGeocercasEliminar ?,?',array($IdRuta,$IdGeocerca));
        DB::commit();
        $geocercas = DB::select('exec spGetMonitoreoRutasGeocercas ?',array($IdRuta));
        return view('postventa.paths.geocercasPorRuta',compact('geocercas','IdRuta'));
    }
}
