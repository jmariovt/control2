<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use XAdmin\Monitor;
use XAdmin\Asset;
use XAdmin\Http\Requests\StoreMonitorRequest;
use XAdmin\Rules\RangoPorcentaje;
use XAdmin\Http\Controllers\ProductController;
use XAdmin\Exports\MonitorsExport1;
use XAdmin\Exports\MonitorsExport2;
use XAdmin\Exports\MonitorsExportCiaMeses;
use XAdmin\Exports\MonitorsHojaRutaExport;
use XAdmin\Exports\MonitorsExportClienteMonitoreo;
use Maatwebsite\Excel\Facades\Excel;
use XAdmin\Mail\ClientesMonitoreoMailable;
use Illuminate\Support\Facades\Mail;





class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tipo = 1;
        
        $fechaDesde = '';//DB::select('select dbo.getPrimerMonitoreoActivo(0) AS fd')[0]->fd;
        if($fechaDesde == '')
        {
            //$fechaDesde = now()->format('d/m/Y');
            $fechaDesde = Carbon::now();
            $fechaDesde = $fechaDesde->add(-3, 'day');
            $fechaDesde = $fechaDesde->format('d/m/Y');
        }else{
            $fechaDesde_arreglo = explode ( " " , $fechaDesde );
            $fechaDesde = $fechaDesde_arreglo[0];
        }
            
        $fechaHasta = now()->format('d/m/Y'); // 15/09/2020

       

        
        $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'','A',$tipo));

        foreach ($monitors_temp as $monitor) {
            $entidad = DB::select('exec spEntidadesActivoConsultar ?',array($monitor->IdActivo));
            if($entidad)
                $monitor->entidad = $entidad;
            else
                $monitor->entidad = "N/D";
            
            if($monitor->VID)
            {
                    $registrosReportando = DB::table('ReportePosicion_Last')->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')->where('Id','=',$monitor->VID)->get();
                
                    
                    try {
                        if($registrosReportando)
                        {
                            if($registrosReportando[0]->DifMin>5 && $registrosReportando[0]->EstadoIgnicion=="1")
                            {   
                                $monitor->Reportando = "0";
                            }else
                            {    if($registrosReportando[0]->DifMin>65 && ($registrosReportando[0]->EstadoIgnicion=="0"||$registrosReportando[0]->EstadoIgnicion=='NULL'))
                                {   
                                    $monitor->Reportando = "0";
                                }else 
                                {
                                    
                                    $monitor->Reportando = "1";
                                }
                            }
                            
                        }
                    } catch (\Throwable $th) {
                        $monitor->Reportando = "0";
                    }
            }else //No tiene dispositivo
            {
                    $monitor->Reportando = "2"; 
            }

            $textoTipoMonitoreo = DB::table('TipoMonitoreo')->select('Monitoreo')->where('TipoMonitoreo','=',$monitor->TipoMonitoreo)->get();
            $monitor->DescripcionTipoMonitoreo = $textoTipoMonitoreo[0]->Monitoreo;
            //$monitoreoPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($monitor->IdActivo));
            //if($monitoreoPorActivar)
            //    $monitor->EstadoReal = $monitoreoPorActivar->EstadoReal;
            //else
            //$monitor->EstadoReal = "";

            $monitors[] = $monitor;
        }

        
        $tiposMonitoreos = DB::table('tipoMonitoreo')->select('TipoMonitoreo','Monitoreo')->where('TipoMonitoreo','<',5)->get();
       
        $ipAddr=\Request::ip();
        $perfiles = session('perfil');
      
        
        return view('monitors.index',compact('monitors','fechaDesde','fechaHasta','tiposMonitoreos','ipAddr','perfiles'));
        //return 'Holaaaa';
        


    }


    



    public function indexFechas($request)
    {

        //$fechaDesde = now()->format('d/m/Y'); // Entrega este formato 15/09/2020
        /*$fechaDesde = DB::select('select dbo.getPrimerMonitoreoActivo(0) AS fd')[0]->fd;
        if($fechaDesde == '')
        {
            $fechaDesde = now()->format('d/m/Y');
        }else{
            $fechaDesde_arreglo = explode ( " " , $fechaDesde );
            $fechaDesde = $fechaDesde_arreglo[0];
        }
            
        $fechaHasta = now()->format('d/m/Y'); // 15/09/2020
        */
       

        
        $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?',array($request->fechaDesde,$request->fechaHasta));

        foreach ($monitors_temp as $monitor) {
            $entidad = DB::select('exec spEntidadesActivoConsultar ?',array($monitor->IdActivo));
            if($entidad)
                $monitor->entidad = $entidad;
            else
                $monitor->entidad = "N/D";
            $monitors[] = $monitor;
        }

      
        
        return view('monitors.index',compact('monitors','fechaDesde','fechaHasta'));
        


    }

    public function findMonitors(Request $request)
    {
        $response = array();

        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $estado = $request->estado;
        $tipo = $request->tipo;

        

        $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'',$estado,$tipo));

        foreach ($monitors_temp as $monitor) {
            $entidad = DB::select('exec spEntidadesActivoConsultar ?',array($monitor->IdActivo));
            if($entidad)
                $monitor->entidad = $entidad;
            else
                $monitor->entidad = "N/D";
            

            if($monitor->VID)
            {
                $registrosReportando = DB::table('ReportePosicion_Last')->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')->where('Id','=',$monitor->VID)->get();
            

       
                
                try {
                    if($registrosReportando)
                    {
                        if($registrosReportando[0]->DifMin>5 && $registrosReportando[0]->EstadoIgnicion=="1")
                        {   
                            $monitor->Reportando = "0";
                        }else
                        {    if($registrosReportando[0]->DifMin>65 && ($registrosReportando[0]->EstadoIgnicion=="0"||$registrosReportando[0]->EstadoIgnicion=='NULL'))
                            {   
                                $monitor->Reportando = "0";
                            }else 
                            {
                                
                                $monitor->Reportando = "1";
                            }
                        }
                        
                    }
                } catch (\Throwable $th) {
                    $monitor->Reportando = "0";
                }
            }else
            {
                $monitor->Reportando = "0";
            }
                
            $textoTipoMonitoreo = DB::table('TipoMonitoreo')->select('Monitoreo')->where('TipoMonitoreo','=',$monitor->TipoMonitoreo)->get();
            $monitor->DescripcionTipoMonitoreo = $textoTipoMonitoreo[0]->Monitoreo;
                
            $response[] = $monitor;
        }
        $monitoreos['data'] = $response;


        return response()->json($monitoreos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tabla = 'TIPOALERTA';
         
        $typesAlerts = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'GEOCERCASMONITOREO';
         
        $geoCercasTemp = DB::select('exec spLlenarCombo ?',array($tabla));

        foreach ($geoCercasTemp as $gc) {
            if($gc->Codigo!=0)
            {
                $geoCercas[]=$gc;
            }
                
            
            
        }

        $fechaInicio = '';//DB::select('select dbo.getPrimerMonitoreoActivo(0) AS fd')[0]->fd;
        $fechaFin = '';
        //$fechaDesde = now()->format('d/m/Y');
        $fechaFin = Carbon::now();
        $fechaFin = $fechaFin->add(1, 'day');
        $fechaFin = $fechaFin->format('d-m-Y H:i');
        
            
        $fechaInicio = now()->format('d-m-Y H:i'); // 15/09/2020

        $tiposDeMonitoreo = DB::table('tipoMonitoreo')->select('TipoMonitoreo','Monitoreo')->where('tipoMonitoreo','<',5)->get();

        $tabla = 'MARCAS';
         
        $marcas = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'CONCESIONARIOS';
         
        $entidades = DB::select('exec spLlenarCombo ?',array($tabla));




        

        return view('monitors.create',compact('typesAlerts','geoCercas','fechaInicio','fechaFin','tiposDeMonitoreo','marcas','entidades'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonitorRequest $request)
    {

        

        $monitor = new Monitor();
        $monitor->idActivo = $request->input('idActivo');
        $monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        $monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');

        $tipoMonitoreo = $request->input('selectTipoDeMonitoreo');
        
        $usuarioIngreso = Auth::user()->Usuario; //13
        $ip=\Request::ip();
        
        $IdMonitoreo = -1;
       
        //$exito =  DB::insert('exec spMonitoreoingresarLv2 ?,?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,1,$IdMonitoreo));
        
        $resultado =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,$tipoMonitoreo));
        
        if(!$resultado)
        {
            return redirect()->route('monitors.create')->withErrors('Se ha producido un error al crear el montoreo.');
        }
        $IdMonitoreo = $resultado[0]->IdMonitoreo;
        
        $esMonitoreoAnterior = $request->input('monitoreos');  //Si es anterior, es distinto de cero
        

        $producto = $request->input('producto');
        $arreglo_producto = explode ( "_" , $producto );
        
        $idProducto = $arreglo_producto[0]; //15
        $IdTipoDispositivo = $arreglo_producto[1]; //16

        

        //{"IdUsuario":2,"Usuario":"lmoscoso","Nombre":"LUIS A. MOSCOSO C.","Administrador":"0","Estado":"E","UsuarioIngreso":"Admin","FechaIngreso":"2010-04-24 00:00:00.000","UsuarioModificacion":"Admin","FechaModificacion":"2012-04-24 12:06:37.447","AdministradorConcesionario":"0","ConfirmoEmail":"0","ConfirmoCelular":"0","PINConfirmacion":"","FechaUltimoLogin":"2017-07-14 19:46:28.223","uid":"4A767B54-FB14-44CE-A9CD-2B34A4B9D938"}

        //return $UsuarioIngreso;
        

        /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
        **/

        $listaEventos = $request->input('ListaEventos');  //Ya hace la combinación de geocercas con los eventos
       
        foreach ($listaEventos as $evento) {
            
            $arreglo_eventos = explode(";",$evento);
            
            $TipoMonitoreo = $arreglo_eventos[0]; //1
            $Evento = $arreglo_eventos[1]; //2
            $Nombre = $arreglo_eventos[2]; //3
            $Descripcion = ""; //4
            $IdGeocerca = $arreglo_eventos[3]; //5
            $NombreGeocerca = $arreglo_eventos[4];
            if(($TipoMonitoreo=="3" || $TipoMonitoreo=="4") && $Nombre=="0")
            {
                $textoAcomparar = substr($NombreGeocerca,0,10);
                if($textoAcomparar=="ALERTA POR")
                    $Nombre = $NombreGeocerca;
                else{
                    if($TipoMonitoreo=="3")
                        $Nombre = "ALERTA POR GEOCERCA IN: ".$NombreGeocerca;
                    else
                        $Nombre = "ALERTA POR GEOCERCA OUT: ".$NombreGeocerca;
                }
                    
                 
                
            }
            $Kilometraje = $arreglo_eventos[5]; //6
            $PorcentajeAnticipacion = $arreglo_eventos[6]; //7  //Porcentaje debe estar entre 5% y 25%
            $LimiteVelocidad = $arreglo_eventos[7]; //8
            $HoraDesde = $arreglo_eventos[8].":".$arreglo_eventos[9]; //9
            $HoraHasta = $arreglo_eventos[10].":".$arreglo_eventos[11]; //10
            $IdDespacho = 0; //11
            $IdUsuario = -1; //12
            //$UsuarioIngreso = ""; //13
            $idGrupoGeo = 0; //14
            $DentroGeo = ""; //15

            if(is_null($Evento))
                $Evento = 0;
            
            if($Evento=="null")
                $Evento = 0;
            
            if(is_null($IdGeocerca)||$IdGeocerca=="null")
                $IdGeocerca = 0;

            $IdAlerta = 0;

            $resultadoInsertAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($TipoMonitoreo, $Nombre, $Descripcion, $IdTipoDispositivo, $Evento, $IdGeocerca, $Kilometraje, $PorcentajeAnticipacion, $IdUsuario, $usuarioIngreso, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlerta, $idGrupoGeo));
                    
            //$IdAlerta=DB::table('D_Alerta')->max('IdAlerta')->where('IdUsuario','=', -1)->get();

            //$resultado = DB::select('select max(IdAlerta) as maxidalerta from D_Alerta where IdUsuario = -1');
            //$IdAlerta = $resultado[0]->maxidalerta;
            $IdAlerta = $resultadoInsertAlerta[0]->IdAlertaLv; 
            //return array($IdMonitoreo, $IdAlerta);
            DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));

        }


        $planes = $request->input('ListaPlanesDeAccion');
   
        if($planes)
        {
            foreach($planes as $plan)
            {
                
                $arreglo_planes = explode ( ";" , $plan );
                $tipo  = $arreglo_planes[0];
                $detalle = $arreglo_planes[1];
                $observaciones = $arreglo_planes[2];

                switch ($tipo) {
                    case 'Amarillo':
                        $tipo = 0;
                        break;
                    case 'Naranja':
                        $tipo = 1;
                        break;
                    default:
                        $tipo = 2;
                        break;
                }
                
                DB::insert('exec spPlanAcccionIngresar ?,?,?,?',array($IdMonitoreo,$tipo,$detalle,$observaciones));
            }
        }
       

        return redirect()->route('/alerts/message')->with('status','Monitoreo creado satisfactoriamente');
    
    }

    

    public function deleteMonitorAlert(Request $request)
    {
        $UsuarioLogin = Auth::user()->Usuario;
        $IdUsuario = Auth::user()->IdUsuario; 

        $alertas = $request->alertas;
      

        foreach ($alertas as $arreglo_alerta) {
            $alerta = explode("_", $arreglo_alerta);
            $IdMonitoreo = $alerta[0];
            $IdAlerta = $alerta[1];
            DB::delete('exec spMonitoreoD_AlertaEliminar ?,?',array($IdMonitoreo,$IdAlerta));
            DB::delete('exec spD_AlertaEliminar ?,?,?', array($IdUsuario, $IdAlerta, $UsuarioLogin));

        }
        $respuesta = "Se ha eliminado correctamente la alerta";
        

        
        $resultado['data'] =  array('resultado'=>$respuesta);
        $response = array();
         return response()->json($resultado);
        //return redirect()->route('monitors')->with('status','Monitoreo actualizado satisfactoriamente');
    }

    public function editalert($IdMonitoreo,$IdAlerta)
    {
        //$monitoreo = DB::table('Monitoreo')->where('IdMonitoreo','=', $IdMonitoreo)->get();

        $datos = DB::select('exec spMonitoreoDetalleConsultar ?', array($IdMonitoreo));

        $tabla = 'TIPOALERTA';
         
        $typesAlerts = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'GEOCERCASMONITOREO';
         
        $geoCercasTemp = DB::select('exec spLlenarCombo ?',array($tabla));

        foreach ($geoCercasTemp as $gc) {
            if($gc->Codigo!=0)
            {
                $geoCercas[]=$gc;
            }
                
            
            
        }

        $products = app('XAdmin\Http\Controllers\ProductController')->getProductByAssetInterno($datos[0]->IdActivo);

        $idProduct = $products[1]->Codigo;
        $eventos = app('XAdmin\Http\Controllers\ProductController')->getEventProductInterno($idProduct);

        //$eventosAsignados = DB::table('D_Alerta')->join('MonitoreoD_Alerta', function($join,$IdMonitoreo){$join->on('D_Alerta.Id_Alerta','=','MonitoreoD_Alerta.IdAlerta')->where('MonitoreoD_Alerta.IdMonitoreo','=',$IdMonitoreo);})->get();
        
        $IdAlertasAsignadas = DB::table('MonitoreoD_Alerta')->select('IdAlerta')->where('IdMonitoreo','=',$IdMonitoreo)->get();
        //return $IdAlertasAsignadas;

        foreach ($IdAlertasAsignadas as $IdAlertaAsignada) {
            $alertasAsignadasTemp = DB::table('D_Alerta')->where('IdAlerta','=',$IdAlertaAsignada->IdAlerta)->get();
            $alertasAsignadas[] = $alertasAsignadasTemp;
        }
       
        $alerta  = DB::table('D_Alerta')->where('IdAlerta','=', $IdAlerta)->get();
        $accion = "MOD";

        //return response()->json($eventos);
        return view('monitors.editalert',compact('datos','typesAlerts','geoCercas','IdMonitoreo','products','alerta','accion','eventos','alertasAsignadas'));
    }

    public function updatealert(Request $request)
    {
        $monitor = new Monitor();
        $monitor->idActivo = $request->input('idActivo');
        $monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        $monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');

        $esMonitoreoAnterior = $request->input('monitoreos');

        $IdAlerta = $request->input('IdAlerta');
        
        $TipoAlerta = $request->input('TipoMonitoreo'); //1

        $PorcentajeAnticipacion = $request->input('PorcentajeAnticipacion'); //2
        if($PorcentajeAnticipacion<>0) //Porcentaje debe estar entre 5% y 25%
        {
            $request->validate([
                'PorcentajeAnticipacion' => ['numeric', new RangoPorcentaje()]
                
               
            ]);
        }
 
        $usuarioCreacion = Auth::user()->Usuario;
        $ip="";
        //$IdMonitoreo =  DB::select('exec spMonitoreoingresar ?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioCreacion,$ip));
        
        $producto = $request->input('producto');
        $arreglo_producto = explode ( "_" , $producto );
        
        $idProducto = $arreglo_producto[0]; //3
        $IdTipoDispositivo = $arreglo_producto[1]; //4

        switch ($TipoAlerta) {
            case '1':
                # code...
                break;
            case '2':
                # code...
                break;
            case '3':
                //GeoCerca In
                
                break;
            case '4':
                //Geocerca Out

                break;
            case '5':
                # code...
                break;
            case '6':
                //Multicriterio

                break;
            default:
                # code...
                break;
        }


        /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
        **/

       



        

        $alertas = $request->input('ListaEventos');

        //$geoCercas = $request->input('ListaGeocercasSeleccionadas');
        
        
                if($alertas)
                {
                    foreach($alertas as $alerta)
                    {
                        $arreglo_eventos = explode(";",$alerta);
                        $TipoMonitoreo = $arreglo_eventos[0]; //1
                        $Evento = $arreglo_eventos[1]; //2
                        $Nombre = $arreglo_eventos[2]; //3
                        $Descripcion = ""; //4
                        $IdGeocerca = $arreglo_eventos[3]; //5
                        $NombreGeocerca = $arreglo_eventos[4];
                        if(($TipoMonitoreo=="3" || $TipoMonitoreo=="4")&& $Nombre=="0")
                        {
                            $textoAcomparar = substr($NombreGeocerca,0,10);
                            if($textoAcomparar=="ALERTA POR")
                                $Nombre = $NombreGeocerca;
                            else{
                                if($TipoMonitoreo=="3")
                                    $Nombre = "ALERTA POR GEOCERCA IN: ".$NombreGeocerca;
                                else
                                    $Nombre = "ALERTA POR GEOCERCA OUT: ".$NombreGeocerca;
                            }
                        }
                        $Kilometraje = $arreglo_eventos[5]; //6
                        $PorcentajeAnticipacion = $arreglo_eventos[6]; //7  //Porcentaje debe estar entre 5% y 25%
                        $LimiteVelocidad = $arreglo_eventos[7]; //8
                        $HoraDesde = $arreglo_eventos[8].":".$arreglo_eventos[9]; //9
                        $HoraHasta = $arreglo_eventos[10].":".$arreglo_eventos[11]; //10
                        $IdDespacho = 0; //11
                        $IdUsuario = -1; //12
                        //$UsuarioIngreso = ""; //13
                        $idGrupoGeo = 0; //14
                        $DentroGeo = null; //15
                    
                        /*AdicionarParametros("@TipoAlerta", Me._IdTipoAlerta)
                            AdicionarParametros("@Nombre", Me._Nombre)
                            AdicionarParametros("@Descripcion", Me._Descripcion)
                            AdicionarParametros("@IdTipoDispositivo", Me._IdTipoDispositivo)
                            AdicionarParametros("@Evento", Me._Evento)
                            AdicionarParametros("@IdGeocerca", Me._IdGeocerca)
                            AdicionarParametros("@Kilometraje", _Kilometraje)
                            AdicionarParametros("@PorcentajeAnticipacion", _Porcentaje)
                            AdicionarParametros("@IdUsuario", _IdUsuario)
                            AdicionarParametros("@IdProducto", _IdProducto)
                            AdicionarParametros("@HoraDesde", _HoraDesde)
                            AdicionarParametros("@HoraHasta", _HoraHasta)
                            AdicionarParametros("@LimiteVelocidad", _LimiteVelocidad)
                            AdicionarParametros("@DentroGeo", If(_DentroGeo, 1, 0))
                            AdicionarParametros("@IdDespacho", _IdDespacho)
                            AdicionarParametros("@idGrupoGeo", _IdGrupoGeo) */

                        DB::update('exec spD_AlertaActualizar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdAlerta, $TipoMonitoreo, $Nombre, $Descripcion, $IdTipoDispositivo, $Evento, $IdGeocerca, $Kilometraje, $PorcentajeAnticipacion, $IdUsuario, $UsuarioIngreso, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $idGrupoGeo));
                    
                     
                        return redirect()->route('monitors')->with('status','Alerta actualizada satisfactoriamente');
                    }
                }else{
                    return redirect()->route('monitors')->withErrors('Se ha producido un error. Seleccione una alerta')->withInput();
                }
           
                
        


        
        /**/

        
    
    }

   


    public function getLastMonitors($IdActivo)
    {
        $alerts['data'] = DB::select('exec spUltimosMonitoreosConsultar ?',array($IdActivo));

        $response = array();
        
        return response()->json($alerts);
    }

    public function getEventsMonitor($IdMonitor)
    {
        $temporal = DB::table('vieMonitoreoD_Alerta')->where('IdMonitoreo','=', $IdMonitor)->get();

        /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
        **/

        foreach ($temporal as $temp) {
            $IdAlerta = $temp->IdAlerta;
            $alerta = DB::table("D_Alerta")->select("Evento","TipoAlerta","Nombre","IdGeocerca","Kilometraje","PorcentajeAnticipacion","LimiteVelocidad")->where("IdAlerta","=",$IdAlerta)->get();
            //$tipoAlerta = DB::table("D_Alerta")->select("TipoAlerta")->where("IdAlerta","=",$IdAlerta)->get();
            $temp->evento = $alerta[0]->Evento;
            $temp->tipoAlerta = $alerta[0]->TipoAlerta;
            $temp->Nombre = $alerta[0]->Nombre;
            $temp->IdGeocerca = $alerta[0]->IdGeocerca;
            $temp->Kilometraje = $alerta[0]->Kilometraje;
            $temp->PorcentajeAnticipacion = $alerta[0]->PorcentajeAnticipacion;
            $temp->LimiteVelocidad = $alerta[0]->LimiteVelocidad;
            $eventos[] = $temp;

        }

        //$events['data']= DB::table('vieMonitoreoD_Alerta')->where('IdMonitoreo','=', $IdMonitor)->get();

        $events['data']=$eventos;

        $response = array();
        
        return response()->json($events);
        //return response()->json($temporal);
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
    public function edit($IdMonitoreo)
    {
        //$monitoreo = DB::table('Monitoreo')->where('IdMonitoreo','=', $IdMonitoreo)->get();

        $datos = DB::select('exec spMonitoreoDetalleConsultar ?', array($IdMonitoreo));

        $tabla = 'TIPOALERTA';
         
        $typesAlerts = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'GEOCERCASMONITOREO';
         
        $geoCercasTemp = DB::select('exec spLlenarCombo ?',array($tabla));

        foreach ($geoCercasTemp as $gc) {
            if($gc->Codigo!=0)
            {
                $geoCercas[]=$gc;
            }
                
            
            
        }

        $products = app('XAdmin\Http\Controllers\ProductController')->getProductByAssetInterno($datos[0]->IdActivo);

        
        $idProduct = $products[1]->Codigo;
        $eventos = app('XAdmin\Http\Controllers\ProductController')->getEventProductInterno($idProduct);

        $ultimosMonitoreos = DB::select('exec spUltimosMonitoreosConsultar ?',array($datos[0]->IdActivo));
        
        //return response()->json($products);
        return view('monitors.edit',compact('datos','typesAlerts','geoCercas','IdMonitoreo','products','ultimosMonitoreos','eventos'));
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
        $monitor = new Monitor();
        $monitor->idActivo = $request->input('idActivo');
        $monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        $monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');
        $IdMonitoreo = $request->input('IdMonitoreo');

        $esMonitoreoAnterior = $request->input('monitoreos');

        /*
          BD.spMonitoreoActualizar(CInt(Request.QueryString("MON")),
                                       CInt(txIDActivo.Text),
                                       String.Format("{0} {1}:{2}",
                                                     txFechaDesde.Text,
                                                     cbHoraDesde.Text,
                                                     cbMinutoDesde.Text),
                                                     String.Format("{0} {1}:{2}",
                                                                   txFechaHasta.Text,
                                                                   cbHoraHasta.Text,
                                                                   cbMinutoHasta.Text),
                                       cbEstado.SelectedItem.Value,
                                       "",
                                       Session("Usuario"),
                                       objMonitoreo.IP)
         */
        $usuarioIngreso = Auth::user()->Usuario;
        $ip=\Request::ip();
       
        DB::update('exec spMonitoreoActualizar ?,?,?,?,?,?,?,?',array($IdMonitoreo,$monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$monitor->Estado,"",$usuarioIngreso,$ip));
        
        $producto = $request->input('producto');
        $arreglo_producto = explode ( "_" , $producto );
        
        $idProducto = $arreglo_producto[0]; //15
        $IdTipoDispositivo = $arreglo_producto[1]; //16

       

        //{"IdUsuario":2,"Usuario":"lmoscoso","Nombre":"LUIS A. MOSCOSO C.","Administrador":"0","Estado":"E","UsuarioIngreso":"Admin","FechaIngreso":"2010-04-24 00:00:00.000","UsuarioModificacion":"Admin","FechaModificacion":"2012-04-24 12:06:37.447","AdministradorConcesionario":"0","ConfirmoEmail":"0","ConfirmoCelular":"0","PINConfirmacion":"","FechaUltimoLogin":"2017-07-14 19:46:28.223","uid":"4A767B54-FB14-44CE-A9CD-2B34A4B9D938"}

        
        

        /***
            * ESTRUCTURA:
            * tipoMonitoreo ; evento ; nombre ; IdGeocerca ; nombreGeocerca ; kilometraje ; porcentaje ; limitevelocidad ; horaInicio ; minutoInicio ; horaFin ; minutoFin
        **/

        $listaEventos = $request->input('ListaEventos');  //Ya hace la combinación de geocercas con los eventos
        if($listaEventos)
        {
            foreach ($listaEventos as $evento) {
                $arreglo_eventos = explode(";",$evento);
                $TipoMonitoreo = $arreglo_eventos[0]; //1
                $Evento = $arreglo_eventos[1]; //2
                $Nombre = $arreglo_eventos[2]; //3
                $Descripcion = ""; //4
                $IdGeocerca = $arreglo_eventos[3]; //5
                $NombreGeocerca = $arreglo_eventos[4];
                if(($TipoMonitoreo=="3" || $TipoMonitoreo=="4")&& $Nombre=="0")
                {
                    $textoAcomparar = substr($NombreGeocerca,0,10);
                    if($textoAcomparar=="ALERTA POR")
                        $Nombre = $NombreGeocerca;
                    else{
                        if($TipoMonitoreo=="3")
                            $Nombre = "ALERTA POR GEOCERCA IN: ".$NombreGeocerca;
                        else
                            $Nombre = "ALERTA POR GEOCERCA OUT: ".$NombreGeocerca;
                    }
                }
                $Kilometraje = $arreglo_eventos[5]; //6
                $PorcentajeAnticipacion = $arreglo_eventos[6]; //7  //Porcentaje debe estar entre 5% y 25%
                $LimiteVelocidad = $arreglo_eventos[7]; //8
                $HoraDesde = $arreglo_eventos[8].":".$arreglo_eventos[9]; //9
                $HoraHasta = $arreglo_eventos[10].":".$arreglo_eventos[11]; //10
                $IdDespacho = 0; //11
                $IdUsuario = -1; //12
                //$UsuarioIngreso = ""; //13
                $idGrupoGeo = 0; //14
                $DentroGeo = ""; //15

                if(is_null($Evento))
                    $Evento = 0;
                if($Evento=="null")
                    $Evento = 0;
                if(is_null($IdGeocerca)||$IdGeocerca=="null")
                {
                    if($TipoMonitoreo=="3" || $TipoMonitoreo=="4")
                    {
                        $mensaje = 'Error al guardar Monitoreo N° '.$IdMonitoreo.'. Comunique el inconveniente al Dpto. encargado.';
                        return back()->withErrors(['error' => $mensaje]);
                    }else
                    {
                        $IdGeocerca = 0;
                    }
                

                }   
                
                $IdAlertaOutput = 0;

                $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($TipoMonitoreo, $Nombre, $Descripcion, $IdTipoDispositivo, $Evento, $IdGeocerca, $Kilometraje, $PorcentajeAnticipacion, $IdUsuario, $usuarioIngreso, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                        
               
                $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;

                DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));

            }
        }

        $planes = $request->input('ListaPlanesDeAccion');
   
        if($planes)
        {
            foreach($planes as $plan)
            {
                
                $arreglo_planes = explode ( ";" , $plan );
                $tipo  = $arreglo_planes[0];
                $detalle = $arreglo_planes[1];
                $observaciones = $arreglo_planes[2];

                switch ($tipo) {
                    case 'Amarillo':
                        $tipo = 0;
                        break;
                    case 'Naranja':
                        $tipo = 1;
                        break;
                    default:
                        $tipo = 2;
                        break;
                }
                
                DB::insert('exec spPlanAcccionIngresar ?,?,?,?',array($IdMonitoreo,$tipo,$detalle,$observaciones));
            }
        }

        
       
        return redirect()->route('/alerts/message')->with('status','Monitoreo actualizado satisfactoriamente');
    }


    

    public function exportModelo1($idMonitor,$fechaDesde,$fechaHasta) // NO USADO, REEMPLAZADO POR exportInformes
    {
        //return Excel::download(new MonitorsExport1($idMonitor,$fechaDesde,$fechaHasta), 'InformeMonitoreo-'.$idMonitor.'-'.$fechaDesde.'.xlsx');
       
    }

    public function exportModelo2($idMonitor,$fechaDesde,$fechaHasta) // NO USADO, REEMPLAZADO POR exportInformes
    {
        //return Excel::download(new MonitorsExport2($idMonitor,$fechaDesde,$fechaHasta), 'InformeMonitoreo-'.$idMonitor.'-'.$fechaDesde.'.xlsx');
        
    }

    public function reportesClienteMonitoreo($UsuarioControl)
    {
        return view('monitors.reportesClienteMonitoreo',compact('UsuarioControl'));
    }

    public function exportReportesCliente(Request $request)
    {

        $validated = $request->validate([
              'informeFechaDesde' => 'required',
              'informeFechaHasta' => 'required',],
            [ 'informeFechaDesde.required' => 'Debe ingresar fecha inicial', 
              'informeFechaHasta.required' => 'Debe ingresar fecha final',]
        );

        $UsuarioControl = $request->UsuarioControl;
        $desde = $request->informeFechaDesde;
        $hasta = $request->informeFechaHasta;
        $tipoReporte = $request->tipoReporte;
        

        switch ($tipoReporte) {
            case '1':
                return Excel::download(new MonitorsExportClienteMonitoreo($UsuarioControl,$desde,$hasta), 'Novedades.xlsx');
                break;
            
            default:
                //return Excel::download(new MonitorsExport2($IdMonitoreo,$desde,$hasta), 'InformeMonitoreo-'.$alias.'_'.str_replace("/","",$desde).'.xlsx');
                break;
        }
    }


    public function informes($IdMonitoreo,$Dia1,$Mes1,$AnioHora1,$Dia2,$Mes2,$AnioHora2,$alias)
    {
        $FechaHoraInicio = $Dia1."/".$Mes1."/".$AnioHora1;
        $FechaHoraFin = $Dia2."/".$Mes2."/".$AnioHora2;
        return view('monitors.informes',compact('IdMonitoreo','FechaHoraInicio','FechaHoraFin','alias'));
        //return 'hola';
    }

    public function exportInformes(Request $request)
    {

        $validated = $request->validate([
              'informeFechaDesde' => 'required',
              'informeFechaHasta' => 'required',],
            [ 'informeFechaDesde.required' => 'Debe ingresar fecha inicial', 
              'informeFechaHasta.required' => 'Debe ingresar fecha final',]
        );

        $IdMonitoreo = $request->txtIdMonitoreo;
        $desde = $request->informeFechaDesde;
        $hasta = $request->informeFechaHasta;
        $tipoReporte = $request->tipoReporte;
        $alias = $request->alias;


        $fechaAux = Carbon::now();
        $fechaAux = $fechaAux->format('d-m-Y H:i');
        $fechaAuxArreglo = explode(" ",$fechaAux);
        $horaMinutoArreglo = $fechaAuxArreglo[1];
        $horaMinutoDiv = explode(":",$horaMinutoArreglo);
        $hora = $horaMinutoDiv[0];
        $minuto = $horaMinutoDiv[1];

        switch ($tipoReporte) {
            case '1':
                return Excel::download(new MonitorsExport1($IdMonitoreo,$desde,$hasta), 'InformeMonitoreo_'.str_replace("/","",$desde).$hora.$minuto.'_'.$alias.'.xlsx');
                break;
            
            default:
                return Excel::download(new MonitorsExport2($IdMonitoreo,$desde,$hasta), 'InformeMonitoreo_'.str_replace("/","",$desde).$hora.$minuto.'_'.$alias.'.xlsx');
                break;
        }
    }

    public function reportes()
    {
        return view('monitors.reportes');
        //return 'hola';
    }

    public function exportCiaMeses(Request $request)
    {
        $meses = array( $request->has("enero"),$request->has("febrero"),$request->has("marzo"),$request->has("abril"),$request->has("mayo"),$request->has("junio"),
                        $request->has("julio"),$request->has("agosto"),$request->has("septiembre"),$request->has("octubre"),$request->has("noviembre"),$request->has("diciembre"));
        return Excel::download(new MonitorsExportCiaMeses($meses,"1"),'reporteMonitoreosCiaMeses.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdMonitoreo,$IdActivo,$FechaHoraInicio,$FechaHoraFin)
    {
        $usuario = Auth::user()->Usuario; 
        
        $ip=\Request::ip();
        
        
        //DB::update('exec spMonitoreoActualizar ?,?,?,?,?,?,?,?',array($IdMonitoreo,$IdActivo,$FechaHoraInicio,$FechaHoraFin,"I","",$usuarioIngreso,$ip));
        
        return redirect()->route('monitors')->with('status','Monitoreo inactivado satisfactoriamente');
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

    public function controlMonitoreos()
    {
        $placa=" ";
        $monitoreosPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        return view('monitors.controlmonitoreos',compact('monitoreosPorActivar'));
    }

    public function buscarMonitoreosAlias(Request $request)
    {
        $placa=$request->idAlias;
        if($placa=='')
            $placa = ' ';
        $resultado['data'] = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        $response = array();
        return response()->json($resultado);

    }

    public function crearMonitoreoAutomaticoTIA(Request $request)
    {
        $IdAlerta = 0;
        $idActivo = $request->idactivo;
        $monitoreoOriginal = $request->monitoreoOriginal;

        //$fechaDesde = date('Y-m-d H:i:s');//now()->format('Y-m-d H:i:s');
        //$fechaHasta = date('Y-m-d H:i:s', strtotime($fechaDesde.' + 1 day'));

        $fechaHasta = Carbon::now();
        $fechaHasta = $fechaHasta->add(1, 'day');
        $fechaHasta = $fechaHasta->format('d-m-Y H:i');
        
            
        $fechaDesde = now()->format('d-m-Y H:i'); // 15/09/2020


  

        


        $usuarioIngreso = Auth::user()->Usuario; 
        $ip=\Request::ip();

        
        $respuesta = $monitoreoOriginal;
        $IdMonitoreo = 0;

        $IdAlertaOutput = 0;
        $resultado = array();
        
        $exito     =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$usuarioIngreso,$ip,1));

        
        /*$resultado['data'] = array('resultado'=>$respuesta);
        $response = array();
         return response()->json($resultado);*/

        
            /**
             * Public Enum EventoDefinido
                *PuertasAbierta 1
                *IgnicionOff 2
                *End Enum
             */
            
        $IdMonitoreo = $exito[0]->IdMonitoreo;
            

        $infoEventoDefinido = DB::select('exec spConsultarDefinicionEvento ?,?',array($idActivo,1)); //PuertasAbiertas

       /* $resultado['data'] = array('resultado'=>$infoEventoDefinido);
        $response = array();
         return response()->json($resultado);*/
             
        try {
            foreach ($infoEventoDefinido as $eventoDefinido) {
                $esMonitoreo = TRUE;
                $idTipoAlerta = 1;
                $idProducto = $eventoDefinido->IdProducto;
                $idTipoDispositivo = $eventoDefinido->TipoDispositivo;
                $evento = $eventoDefinido->NumeroEvento;
                $idGeocerca = 0;
                $kilometraje = 0;
                $porcentaje = 0;
                $idUsuario = -1;
                $usuario = "admin";
                $nombre = "ALERTA POR EVENTO PUERTAS ABIERTAS";
                $descripcion = "PUERTAS ABIERTAS CREADAS AUTOMATICAMENTE POR EL SISTEMA";
                $HoraDesde = '';
                $HoraHasta = '';
                $LimiteVelocidad = 0;
                $DentroGeo = 0;
                $IdDespacho = 0;
                $idGrupoGeo = 0;

                $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                
                $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;

                DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                $respuesta = $respuesta."Crea Puertas Abiertas. ".$IdAlerta." ";
            }
        } catch (\Throwable $th) {
            $respuesta = $respuesta."Error en Puertas Abiertas: ".$IdMonitoreo."-".$IdAlerta."-".$idTipoAlerta."-".$nombre."-".$descripcion."-".$idTipoDispositivo."-".$evento."-".$idGeocerca."-".$kilometraje."-".$porcentaje."-".$idUsuario."-".$usuario."-".$idProducto."-".$HoraDesde."-".$HoraHasta."-".$LimiteVelocidad."-".$DentroGeo."-".$IdDespacho."-".$IdAlertaOutput."-".$idGrupoGeo." ";
        }
             


        try {
            $result=0;
             
            $esActivoRefrigerado = DB::select('exec spMonitoreoEsActivoRefrigeradoLv ?,?,?',array($monitoreoOriginal,$idActivo,$result));
            if($esActivoRefrigerado[0]->Resultado==1)
            {
               $infoEventoDefinido2 = DB::select('exec spConsultarDefinicionEvento ?,?',array($idActivo,2)); //IgnicionOff
               foreach ($infoEventoDefinido2 as $eventoDefinido) {
                   $esMonitoreo = TRUE;
                   $idTipoAlerta = 1;
                   $idProducto = $eventoDefinido->IdProducto;
                   $idTipoDispositivo = $eventoDefinido->TipoDispositivo;
                   $evento = $eventoDefinido->NumeroEvento;
                   $idGeocerca = 0;
                   $kilometraje = 0;
                   $porcentaje = 0;
                   $idUsuario = -1;
                   $usuario = "admin";
                   $nombre = "ALERTA POR EVENTO IGNICION OFF";
                   $descripcion = "IGNICION OFF CREADO AUTOMATICAMENTE POR EL SISTEMA";
                   $HoraDesde = '';
                   $HoraHasta = '';
                   $LimiteVelocidad = 0;
                   $DentroGeo = 0;
                   $IdDespacho = 0;
                   $idGrupoGeo = 0;
                   $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                   $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;
                   DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                   $respuesta = $respuesta. "Crea Ignicion OFF. ".$IdAlerta." ";
               }
            }
        } catch (\Throwable $th) {
            $respuesta = $respuesta."Error en Ingnicion OFF. ";
        }
             
        try {
            //$geoCercaResultado = DB::select('exec spObtenerGoecercaPorPuntoFinalizaRetorno ?', array($monitoreoOriginal));
            $geoCercaResultado = DB::select('exec spObtenerGoecercaPorPuntoFinalizaRetornoLv ?', array($monitoreoOriginal));
             foreach($geoCercaResultado as $geo)
             {   $geoCerca = $geo->IdGeocerca;

                if($geoCerca > -59999)
                {
                    $esMonitoreo = TRUE;
                    $idTipoAlerta = 3;
                    $idProducto = "0";
                    $idTipoDispositivo = "0";
                    $evento = 0;
                    $idGeocerca = $geoCerca;
                    $kilometraje = 0;
                    $porcentaje = 0;
                    $idUsuario = -1;
                    $usuario = "admin";
                    $nombre = "ALERTA POR GEOCERCA IN: ".$geo->Nombre;
                    $descripcion = "GEOCERCA IN CREADO AUTOMATICAMENTE POR EL SISTEMA";
                    $HoraDesde = '';
                    $HoraHasta = '';
                    $LimiteVelocidad = 0;
                    $DentroGeo = 0;
                    $IdDespacho = 0;
                    $idGrupoGeo = 0;
                    $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                    $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;
                    DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                    DB::insert('exec spMonitoreoRetornoIngresar ?,?,?',array($monitoreoOriginal,$IdMonitoreo,$IdAlerta));
                    $respuesta = $respuesta. "Crea Geocerca In. ".$geoCerca." ".$IdAlerta." ";



                }else{
                    $respuesta = $respuesta."Debe asociar una geocerca al punto destino para este monitoreo. ";
                    
                }
             }
        } catch (\Throwable $th) {
            $respuesta = $respuesta."Error en Geocerca IN. ";
        }

        try {
            //$geoCercaResultado = DB::select('exec spObtenerGoecercaPorPuntoFinalizaRetorno ?', array($monitoreoOriginal));
            $geoCercaResultadoRutaProhibida = DB::select('exec spObtenerGoecercaPorPuntoFinalizaRetornoRutaProhibidaLv ?', array($monitoreoOriginal));
             foreach($geoCercaResultadoRutaProhibida as $geo)
             {   $geoCerca = $geo->IdGeocerca;

                if($geoCerca > -59999)
                {
                    $esMonitoreo = TRUE;
                    $idTipoAlerta = 3;
                    $idProducto = "0";
                    $idTipoDispositivo = "0";
                    $evento = 0;
                    $idGeocerca = $geoCerca;
                    $kilometraje = 0;
                    $porcentaje = 0;
                    $idUsuario = -1;
                    $usuario = "admin";
                    $nombre = "ALERTA POR GEOCERCA IN: ".$geo->Nombre;
                    $descripcion = "GEOCERCA IN CREADO AUTOMATICAMENTE POR EL SISTEMA";
                    $HoraDesde = '';
                    $HoraHasta = '';
                    $LimiteVelocidad = 0;
                    $DentroGeo = 0;
                    $IdDespacho = 0;
                    $idGrupoGeo = 0;
                    $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                    $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;
                    DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                    DB::insert('exec spMonitoreoRetornoIngresar ?,?,?',array($monitoreoOriginal,$IdMonitoreo,$IdAlerta));
                    $respuesta = $respuesta. "Crea Geocerca In. ".$geoCerca." ".$IdAlerta." ";

                    $esMonitoreo = TRUE;
                    $idTipoAlerta = 4;
                    $idProducto = "0";
                    $idTipoDispositivo = "0";
                    $evento = 0;
                    $idGeocerca = $geoCerca;
                    $kilometraje = 0;
                    $porcentaje = 0;
                    $idUsuario = -1;
                    $usuario = "admin";
                    $nombre = "ALERTA POR GEOCERCA OUT: ".$geo->Nombre;
                    $descripcion = "GEOCERCA OUT CREADO AUTOMATICAMENTE POR EL SISTEMA";
                    $HoraDesde = '';
                    $HoraHasta = '';
                    $LimiteVelocidad = 0;
                    $DentroGeo = 0;
                    $IdDespacho = 0;
                    $idGrupoGeo = 0;
                    $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                    $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;
                    DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                    DB::insert('exec spMonitoreoRetornoIngresar ?,?,?',array($monitoreoOriginal,$IdMonitoreo,$IdAlerta));
                    $respuesta = $respuesta. "Crea Geocerca In. ".$geoCerca." ".$IdAlerta." ";



                }else{
                    $respuesta = $respuesta."Debe asociar una geocerca al punto destino para este monitoreo. ";
                    
                }
             }
        } catch (\Throwable $th) {
            $respuesta = $respuesta."Error en Geocerca IN/OUT. ";
        }
             
        

        $resultado['data'] = array('resultado'=>$respuesta);
        $response = array();
         return response()->json($resultado);

        //return $respuesta;


    }

    public function controlarMonitoreo(Request $request)
    {
        $IdMonitoreo = $request->IdMonitoreo;
        $respuesta = "";
        $usuario = Auth::user()->Usuario;
        $nombre = Auth::user()->Nombre;
        /****
         * ToDo
         * Agregar Usuario a spActualizarEstadoRealMonitoreo
         * */
        try {
            DB::update('exec spActualizarEstadoRealMonitoreo ?',array($IdMonitoreo));
            //DB::update('exec spActualizarEstadoRealMonitoreoLv ?,?,?',array($IdMonitoreo,$usuario,$nombre));
            $respuesta = "Monitoreo actualizado correctamente";
            
        } catch (\Throwable $th) {
            $respuesta = "Error al actualizar el monitoreo ".$th->getMessage();
            DB::rollback();
        }
        
        $resultado['data'] = array('resultado'=>$respuesta);
        $response = array();
        return response()->json($resultado);
    }



    public function ConsultarDefinicionEvento($activo, $evento)
    {
        $definicionEvento = DB::select('exec spConsultarDefinicionEvento ?,?',array($activo,$evento));
        return $definicionEvento;
    }

    public function clienteMonitoreo()
    {
        $clientes = DB::select('exec spMonitoreoClientesConsultarLv');

        /*foreach ($clientes_temp as $cliente) {
            $activo = DB::table('MonitoreoControl_Usuarios_Activos')->select('vid','idactivo','alias')->where('clientemonitoreo','=', $cliente->UsuarioControl)->get();
            if($activo)
                $cliente->detalleActivos = $activo;
            else
                $cliente->detalleActivos = "";
            $clientes[] = $cliente;
        }*/

        return view('monitors.clienteMonitoreo',compact('clientes'));
    }

    public function deleteActivo($idActivo,$usuario)
    {
        try {
            DB::delete('exec spMonitoreoControlUsuariosActivos_eliminar ?,?',array($idActivo,$usuario));
            $respuesta = "Activo eliminado correctamente";
        } catch (\Throwable $th) {
            $respuesta = "Error al eliminar activo";
        }
        
        return redirect()->route('clienteMonitoreo')->with('status','Activo eliminado con éxito');
    }

    public function asignarActivo($usuario)
    {
        return view('monitors.activo',compact('usuario'));
    }


    public function guardarActivo(Request $request)
    {
        $activo = $request->activo;
        $usuario = $request->usuario;
        $respuesta = "";
        try {
            DB::insert('exec spMonitoreoControlUsuariosActivos_ingreso ?,?',array($activo,$usuario));
            DB::commit();
            $respuesta = "Activo asignado correctamente";
        } catch (\Throwable $th) {
            $respuesta = "Error al asignar activo: ".$usuario." - ".$activo;
            DB::rollback();
        }
        
        
        
        $resultado['data'] = array('resultado'=>$respuesta);
        $response = array();
        return response()->json($resultado);
    }

    public function actualizarCliente(Request $request)
    {
        $usuario = $request->usuario;
        $estado = $request->estado;
        $validoHasta = $request->validoHasta;
        $enviarCorreo = $request->enviarCorreo;

        if($enviarCorreo=="SI")
            $enviarCorreo = 1;
        else   
            $enviarCorreo = 0;

        $respuesta = "";
        try {
            DB::update('exec spMonitoreoControlUsuariosActualizar ?,?,?,?',array($usuario,$estado,$validoHasta,$enviarCorreo));
            $respuesta = "Cliente actualizado correctamente";
        } catch (\Throwable $th) {
            $respuesta = "Error al actualizar cliente";
        }
        
            

        
        $resultado['data'] = array('resultado'=>$respuesta);
        $response = array();
        return response()->json($resultado);
    }

    public function borrarCliente($usuario) // En el procedimiento se lee SEQUITAESTAOPCION
    {
        //DB::delete('exec spMonitoreoControlUsuariosEliminar ?',array($usuario)); 
        return redirect()->route('clienteMonitoreo');//->with('status','Usuario eliminado con éxito');

    }

    public function enviarMailUsuario($usuario)
    {
        $mk = DB::select("select dbo.getEmaildeUsuarioHojaRutaMon('".$usuario."') AS mail")[0]->mail; //getEmaildeUsuarioHojaRutaMon(usuario)
        $mailArreglo = explode('&',$mk);
        $mailTo = $mailArreglo[0];
        $mailPass = $mailArreglo[1];
        
        $correo = new ClientesMonitoreoMailable($usuario,$mailPass,$mailTo);
        Mail::to($mailTo)->send($correo);
        return redirect()->route('clienteMonitoreo')->with('status','Mail enviado con éxito');
    }





    public function ingresarClienteMonitoreo()
    {
        return view('monitors.ingresarClienteMonitoreo');
    }

    public function getClienteMonitoreo(Request $request)
    {
        $buscar = $request->search;
        
        
        $resultado = array();
        $response = array();
        $clientes = DB::table('Cliente')->select('IdEntidad','Nombres', 'Apellidos')->where('IdEntidad','like',$buscar.'%')->orderby('Apellidos','asc')->limit(100)->get();
         

        foreach($clientes as $cliente)
        {
            $response[] = array("value"=>$cliente->IdEntidad, "label"=>$cliente->Nombres.' '.$cliente->Apellidos);
        }
        
        return response()->json($response);
    }

    public function storeIngresarClienteMonitoreo(Request $request)
    {
        $validated = $request->validate([
            'txtNombre' => 'required|max:255',
            'txtUsuario' => 'required|min:4|max:10',
            'txtEmail' => 'required|email:rfc,dns',
            'txtClave' => 'required|min:10',
            'selTipo' => 'string',
            
        ]);

       
        
        $tipoCliente = $request->input('selTipo');
        if($tipoCliente!=0)
            {$cedula = $request->input('txtCedulaRUC');
            
            if(strlen($cedula)<1)
                $cedula = "0000000000000";

            $nombre = $request->input('txtNombre');
            $usuario = $request->input('txtUsuario');
            $clave = $request->input('txtClave');
            $email = $request->input('txtEmail');
            $fechaIngreso = now()->format('d/m/Y H:i');
            $validoHasta = $request->input('txtValidoHasta');

            if(strlen($validoHasta)<1)
            {
                $validoHasta = "";
            }

            $estado = "A";
            if($tipoCliente=="T")
                $estado = "I";
            
            DB::insert('exec spMonitoreoClientesIngresar ?,?,?,?,?,?,?,?,?',array($cedula,$nombre,$usuario,$clave,$email,$tipoCliente,$estado,$fechaIngreso,$validoHasta)); 
            
            return redirect()->route('ingresarClienteMonitoreo')->with('status','Usuario ingresado con éxito '.$cedula);
        }
        else
            return redirect()->route('ingresarClienteMonitoreo')->withErrors('Escoja Tipo de Cliente')->withInput();
    }


    public function asociarClienteMonitoreo()
    {
        $tabla = 'CLIENTES_MONITOREO_CONTROL';
         
        $terceros = DB::select('exec spLlenarCombo ?,?',array($tabla,"T"));

        $tabla = 'CLIENTES_MONITOREO_CONTROL';
         
        $clientes = DB::select('exec spLlenarCombo ?,?',array($tabla,"I"));


        return view('monitors.asociarClienteMonitoreo',compact('terceros','clientes'));
    }

    public function getMonitoreosActivosXCliente($cliente)
    {
        $tabla = 'MONITOREOSACTIVOSXCLIENTE';
        
        $monitoreos['data'] = DB::select('exec spLlenarCombo ?,?',array($tabla,$cliente));

        $response = array();
        
        return response()->json($monitoreos);
    }

    public function storeAsociarClienteMonitoreo(Request $request)
    {

        $validated = $request->validate([
            'IdMonitoreo' => 'required',
            'tercero' => 'required',
            'cliente' => 'required',
            
            
            
        ],[ 'IdMonitoreo.required' => 'Debe escoger un Monitoreo', 
            'tercero.required' => 'El campo Tercero es obligatorio',
            'cliente.required' => 'Debe escoger un Cliente',]
        );

        $IdMonitoreo = $request->input('IdMonitoreo');
        $textoMonitoreo = $request->input('textoMonitoreo');
        $tercero = $request->input('chkTercero');
        $terceroNombre = $request->input('terceroNombre');
        $clienteNombre = $request->input('clienteNombre');
        $cliente = $request->input('cliente');
        $tipoCliente = $request->input('tipoCliente');

        
        DB::update('exec spMonitoreoInfoAdicionalAsociarTercero ?,?,?,?',array($IdMonitoreo,$tercero,$cliente,$tipoCliente)); 

        $correoyClave = DB::select('exec getEmaildeUsuarioHojaRutaMon ?',array($tercero));
        $correoClaveArreglo = explode("&",$correoyClave[0]);
        $correo = $correoClaveArreglo[0];
        $clave = $correoClaveArreglo[1];

        $ok = enviarMailAsociacion($terceroNombre,$correo,$tercero,$clave,$IdMonitoreo,$textoMonitoreo,$clienteNombre,$tipoCliente);

        return redirect()->route('asociarClienteMonitoreo')->with('status','Usuario asociado con éxito '.$cliente);

        /*EnviarEmailAsociacion(cbClienteTercero.SelectedItem.Text, 
                                correo, 
                                cbClienteTercero.SelectedValue, 
                                clave, 
                                cbMonitoreosCliente.SelectedValue, 
                                cbMonitoreosCliente.SelectedItem.Text, 
                                cbClientes.SelectedItem.Text, 
                                cbClientes.SelectedValue.Split("&")(1))
        */
            
    }

    public function enviarMailAsociacion($terceroNombre,$correo,$tercero,$clave,$IdMonitoreo,$textoMonitoreo,$clienteNombre,$tipoCliente)
    {
        
        
        $mail = new AsociarClienteMonitoreoMailable($terceroNombre,$correo,$tercero,$clave,$IdMonitoreo,$textoMonitoreo,$clienteNombre,$tipoCliente);
        Mail::to($correo)->send($mail);
        return 1;//redirect()->route('clienteMonitoreo')->with('status','Mail enviado con éxito');
    }

    public function mostrarHojaRuta($IdMonitoreo, $Usuario, $Cliente, $Tipo, Request $request)
    {

        $datosCliente = DB::select('exec spMonitoreoInfoAdicionalProvisionalConsultar ?,?',array($IdMonitoreo,$Usuario));

        $planesAccion = array();
        if($datosCliente[0]->IdMonitoreo!="")
        {
            $planesAccion = DB::select('exec spPlanAccionConsultarxMonitoreo ?',array($datosCliente[0]->IdMonitoreo));
        }

        //Request $request;

        //return $planAccion;
        return view('monitors.hojaRuta',compact('datosCliente','Usuario','Cliente','Tipo','planesAccion','IdMonitoreo'));
    }
    public function eliminarHojaRuta($IdMonitoreo, $Usuario)
    {
        DB::delete('exec spMonitoreoInfoAdicionalProvisionalEliminar ?,?',array($Usuario,$IdMonitoreo));
        return redirect()->route('clienteMonitoreo')->with('status','Hoja de Ruta eliminada con éxito');
    }

    public function storeHojaRuta(Request $request)
    {
        $usuario = Auth::user()->Usuario; 

        $txtUsuario = $request->input('txtUsuario');
        $IdMonitoreo = $request->input('txtIdMonitoreo');
        $tieneMonitoreo = 0;

        if($IdMonitoreo!="")
            $tieneMonitoreo = 1;


        $validated = $request->validate([
            //'txtContenedorNombre' => 'required',
            //'txtContenedorPies' => 'required',
            //'txtContenedorTipoCarga' => 'required',
            'txtVehiculoPlaca'=> 'required',
            'txtVehiculoMarca' => 'required',
            //'txtVehiculoColor' => 'required',
            'txtChoferNombre' => 'required',
            'txtChoferCelular'=> 'required',
            
            'txtRutaSeguir' => 'required',
            'txtFechaHoraOrigen'=> 'required',
            'txtOrigenCiudadLugar' => 'required',
            'txtOrigenDireccion' => 'required',
            'txtFechaHoraDestino' => 'required',
            'txtDestinoCiudadLugar'=> 'required',
            'txtDestinoDireccion' => 'required',
            /*'txtContenedorPies' => 'required',
            'txtContenedorTipoCarga' => 'required',
            'txtVehiculoPlaca'=> 'required',
            'txtContenedorNombre' => 'required',
            'txtContenedorPies' => 'required',
            'txtContenedorTipoCarga' => 'required',
            'txtVehiculoPlaca'=> 'required',*/
            
            
        ],[ //'txtContenedorNombre.required' => 'El campo Número de contenedor es obligatorio', 
            //'txtContenedorPies.required' => 'El campo Pies es obligatorio',
            //'txtContenedorTipoCarga.required' => 'Tipo de carga obligatoria',
            'txtVehiculoPlaca.required' => 'Placa obligatoria',
            'txtVehiculoMarca.required' => 'Marca es obligatorio', 
            //'txtVehiculoColor.required' => 'El campo Color es obligatorio',
            'txtChoferNombre.required' => 'Nombre de chofer obligatorio',
            'txtChoferCelular.required' => 'Placa obligatoria',
            
            'txtRutaSeguir.required' => 'Ruta a seguir es obligatoria',
            'txtFechaHoraOrigen.required' => 'Fecha inicio obligatoria',
            'txtOrigenCiudadLugar.required' => 'El campo Ciudad de origen es obligatorio', 
            'txtOrigenDireccion.required' => 'El campo Direccion de origen es obligatorio',
            'txtFechaHoraDestino.required' => 'Fecha final obligatoria',
            'txtDestinoCiudadLugar.required' => 'El campo Ciudad de destino es obligatorio',
            'txtDestinoDireccion.required' => 'El campo Direccion de destino es obligatorio',
            'txtChoferNombre.required' => 'Nombre de chofer obligatorio',
            'txtChoferCelular.required' => 'Placa obligatoria',
            
            'txtRutaSeguir.required' => 'Ruta a seguir es obligatoria',
            'txtFechaHoraOrigen.required' => 'Fecha inicio obligatoria',
            'txtOrigenCiudadLugar.required' => 'El campo Ciudad de origen es obligatorio', 
            'txtOrigenDireccion.required' => 'El campo Direccion de origen es obligatorio',
            'txtFechaHoraDestino.required' => 'Fecha final obligatoria',
            'txtDestinoCiudadLugar.required' => 'El campo Ciudad de destino es obligatorio',]
        );

        $Numero_Contenedor = $request->input('txtContenedorNombre');
        $Pies_Contenedor = $request->input('txtContenedorPies');
        $TipoCarga_Contenedor = $request->input('txtContenedorTipoCarga');
        $placa = $request->input('txtVehiculoPlaca');
        $marca = $request->input('txtVehiculoMarca');
        $color = $request->input('txtVehiculoColor');
        $chofer_nombre = $request->input('txtChoferNombre');
        $chofer_celular = $request->input('txtChoferCelular');
        $acompanante_nombre = $request->input('txtAcompananteNombre');
        $acompanante_celular = $request->input('txtAcompananteCelular');
        $ruta_a_seguir = $request->input('txtRutaSeguir');
        $fecha_inicio = $request->input('txtFechaHoraOrigen');
        $ciudad_origen = $request->input('txtOrigenCiudadLugar');
        $direccion_origen = $request->input('txtOrigenDireccion');
        $fecha_fin = $request->input('txtFechaHoraDestino');
        $ciudad_destino = $request->input('txtDestinoCiudadLugar');
        $direccion_destino = $request->input('txtDestinoDireccion');

        $contacto1 = "";
        $contacto2 = "";
        $contacto3 = "";

        if($request->input('txtContactosNombre1') <> "" && $request->input('txtContactosEmail1') <> "") 
            $contacto1 = $request->input('txtContactosNombre1') . " - " . $request->input('txtContactosEmail1');

        if($request->input('txtContactosNombre2') <> "" && $request->input('txtContactosEmail2') <> "") 
        {   $contacto2 = $request->input('txtContactosNombre2') . " - " . $request->input('txtContactosEmail2');
            $contacto1 = $contacto1."%".$contacto2;
        }

        if($request->input('txtContactosNombre3') <> "" && $request->input('txtContactosEmail3') <> "") 
        {   $contacto3 = $request->input('txtContactosNombre3') . " - " . $request->input('txtContactosEmail3');
            $contacto1 = $contacto1."%".$contacto3;
        }

        $parada1 = "";
        $parada2 = "";
        $parada3 = "";
        $parada4 = "";
        $parada5 = "";

        if($request->input('txtInfoAdicionalLugar1') <> "" && $request->input('txtInfoAdicionalTiempo1') <> "") 
            $parada1 = $request->input('txtInfoAdicionalLugar1') . " - " . $request->input('txtInfoAdicionalTiempo1');

        if($request->input('txtInfoAdicionalLugar2') <> "" && $request->input('txtInfoAdicionalTiempo2') <> "") 
        {   $parada2 = $request->input('txtInfoAdicionalLugar2') . " - " . $request->input('txtInfoAdicionalTiempo2');
            $parada1 = $parada1."%".$parada2;
        }

        if($request->input('txtInfoAdicionalLugar3') <> "" && $request->input('txtInfoAdicionalTiempo3') <> "") 
        {   $parada3 = $request->input('txtInfoAdicionalLugar3') . " - " . $request->input('txtInfoAdicionalTiempo3');
            $parada1 = $parada1."%".$parada3;
        }

        if($request->input('txtInfoAdicionalLugar4') <> "" && $request->input('txtInfoAdicionalTiempo4') <> "") 
        {   $parada4 = $request->input('txtInfoAdicionalLugar4') . " - " . $request->input('txtInfoAdicionalTiempo4');
            $parada1 = $parada1."%".$parada4;
        }

        if($request->input('txtInfoAdicionalLugar5') <> "" && $request->input('txtInfoAdicionalTiempo5') <> "") 
        {   $parada5 = $request->input('txtInfoAdicionalLugar5') . " - " . $request->input('txtInfoAdicionalTiempo5');
            $parada1 = $parada1."%".$parada5;
        }

        $nombreSeveridad0 = "";
        $nombreSeveridad1 = "";
        $nombreSeveridad2 = "";

        $celularSeveridad0 = "";
        $celularSeveridad1 = "";
        $celularSeveridad2 ="";

        $correoSeveridad0 = "";
        $correoSeveridad1 = "";
        $correoSeveridad2 = "";

        if((($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")) ||
           (($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "")) ||
           (($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")))
        {
            return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Debe de ingresar al menos dos contactos para informar en caso de eventualidades');
        }

        $puedeEnviarHojaRuta = true;//DB::select('select dbo.SePuedeEnviarHojaRuta('.$IdMonitoreo.','.$txtUsuario.') AS val')[0]->val;

        if($puedeEnviarHojaRuta)
        {
            

            if($tieneMonitoreo==0)
            {
                //DB::update('exec spMonitoreoInfoAdicionalProvisionalActualizar4 ?,?,?', array());
            }
        }
        

        
/* $exito = DB::insert('exec spMonitoreoInfoAdicionalProvisionalingresar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array(  $usuario,
                                                                                    $Numero_Contenedor,
                                                                                    $Pies_Contenedor,
                                                                                    $TipoCarga_Contenedor,
                                                                                    $placa,
                                                                                    $marca,
                                                                                    $color,
                                                                                    $chofer_nombre,
                                                                                    $chofer_celular,
                                                                                    $acompanante_nombre,
                                                                                    $acompanante_celular,
                                                                                    $ruta_a_seguir,
                                                                                    $fecha_inicio,
                                                                                    $ciudad_origen,
                                                                                    $direccion_origen,
                                                                                    $fecha_fin,
                                                                                    $ciudad_destino,
                                                                                    $direccion_destino,
                                                                                    $contacto1,
                                                                                    $parada1,
                                                                                    $nombreSeveridad0,
                                                                                    $celularSeveridad0,
                                                                                    $correoSeveridad0,
                                                                                    $nombreSeveridad1,
                                                                                    $celularSeveridad1,
                                                                                    $correoSeveridad1,
                                                                                    $nombreSeveridad2,
                                                                                    $celularSeveridad2,
                                                                                    $correoSeveridad2
                                                                                ));*/

                                                                                
        
        
        
        
        
                                                                                /*
        BD.spMonitoreoInfoAdicionalProvisionalingresar(Session("Usuario"), _
                                                               txNumero.Value, _
                                                               txPies.Value, _
                                                               txTipoCarga.Value, _
                                                               txPlaca.Value, _
                                                               txMarca.Value, _
                                                               txColor.Value, _
                                                               txNombreChofer.Value, _
                                                               txCelularChofer.Value, _
                                                               txAcompNombre.Value, _
                                                               txAcompCelular.Value, _
                                                               txRuta.Value, _
                                                               String.Format("{0} {1}:{2}", datepickerorigen.Value, _
                                                               cbHoraInicio.Value, _
                                                               cbMinutoInicio.Value), _
                                                               txCiudadOrigen.Value, _
                                                               txDireccionOrigen.Value, _
                                                               String.Format("{0} {1}:{2}", _
                                                               datepickerdestino.Value, _
                                                               cbHoraFin.Value, _
                                                               cbMinutoFin.Value), _
                                                               txCiudadDestino.Value, _
                                                               txDireccionDestino.Value, _
                                                               contacto1 + txContactosOtros.Value, _
                                                               parada1 + txParadasOtras.Value, _
                                                               txNombre_Severidad_0.Value, _
                                                               txCelular_Severidad_0.Value, _
                                                               txCorreo_Severidad_0.Value, _
                                                               txNombre_Severidad_1.Value, _
                                                               txCelular_Severidad_1.Value, _
                                                               txCorreo_Severidad_1.Value, _
                                                               txNombre_Severidad_2.Value, _
                                                               txCelular_Severidad_2.Value, _
                                                               txCorreo_Severidad_2.Value)
         */

         $exito=true;
         try {
                DB::update('exec spMonitoreoInfoAdicionalProvisionalActualizar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array(  $txtUsuario,
                $IdMonitoreo,
                $Numero_Contenedor,
                $Pies_Contenedor,
                $TipoCarga_Contenedor,
                $placa,
                $marca,
                $color,
                $chofer_nombre,
                $chofer_celular,
                $acompanante_nombre,
                $acompanante_celular,
                $ruta_a_seguir,
                $fecha_inicio,
                $ciudad_origen,
                $direccion_origen,
                $fecha_fin,
                $ciudad_destino,
                $direccion_destino,
                $contacto1,
                $parada1,
                $nombreSeveridad0,
                $celularSeveridad0,
                $correoSeveridad0,
                $nombreSeveridad1,
                $celularSeveridad1,
                $correoSeveridad1,
                $nombreSeveridad2,
                $celularSeveridad2,
                $correoSeveridad2
            ));
            $exito = true;
         } catch (\Throwable $th) {
             $exito = false;
         }

        
        if($exito)
            return redirect()->route('clienteMonitoreo')->with('status','Hoja de ruta enviada con éxito.');
        else
            return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Error al grabar Hoja de Ruta');
        
        
    }

    public function exportHojaRuta($IdMonitoreo,$Usuario,$Cliente) 
    {
        return Excel::download(new MonitorsHojaRutaExport($IdMonitoreo,$Usuario,$Cliente), 'monitoreo_'.$IdMonitoreo.'_HojaRuta.xlsx');
        //return 'hola';
    }

    public function mostrarTodasAlertas(Request $request)
    {
        $IdMonitoreo = $request->idMonitoreo;
        $IdActivo = $request->idActivo;
        //Select idAlerta,Nombre from viemonitoreoD_Alerta vam with (nolock) where vam.idMonitoreo = @tmpidMonitoreo

        $alertasCrudas = DB::table('viemonitoreoD_Alerta')->select('idAlerta','Nombre')->where('idMonitoreo','=',$IdMonitoreo)->get();
        
        foreach($alertasCrudas as $alerta){
            $alertas[] = array("alerta"=>$IdMonitoreo.";".$alerta->idAlerta.";".$IdActivo.";".str_replace('ALERTA GEOCERCA:','',str_replace('ALERTA PARA EVENTO','',strtoupper($alerta->Nombre))));
        }
        return response()->json($alertas);
        //Set @Alertas = @Alertas + convert(varchar,@tmpidMonitoreo) + ';' + convert(varchar,@tmpIdAlerta) + ';' + convert(varchar,@tmpidActivo) + ';' + REPLACE(REPLACE(UPPER(@Nombre),'ALERTA PARA EVENTO',''),'ALERTA GEOCERCA:','') + '%'
		
    }

    public function recorrido()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y H:i');
        return view('monitors.recorrido',compact('fecha'));
    }

    public function consultaSMS()
    {
        //$fecha = Carbon::now();
        //$fecha = $fecha->format('d/m/Y H:i');
        return view('monitors.consultaSMS');
    }

    public function buscarSMS(Request $request)
    {
        $buscar = $request->buscar;
        $opcionBusqueda = $request->opcionBusqueda;
        $buscarTiposDeMensajes = $request->buscarTiposDeMensajes; // R  Recibidos (SMPP) --- E Enviados (SMPP) ---   EX Enviados (XMPP)

        $resultado = array();
        switch ($opcionBusqueda) {
            case 'celular':

                
                //$resultado = BuscarSMSPorCelular($buscar, $buscarTiposDeMensajes);
                switch ($buscarTiposDeMensajes) {
                    case 'R':
                        $resultado = DB::connection('sqlsrvsms')->table('ttbsmsin')->select('FechaHora','MIN','MSJ')->where('MIN','like','%'.$buscar.'%')->orderby('FechaHora','desc')->limit(25)->get();
                        break;
                    case 'E':
                        $resultado = DB::connection('sqlsrvsms')->table('ttbsmsout')->select('FechaHora','MIN','MSJ')->where('MIN','like','%'.$buscar.'%')->orderby('FechaHora','desc')->limit(25)->get();
                        break;
                    default: //EX
                        $resultado = DB::select('exec spConsultaXMPP ?,?',array($buscar,''));
                        break;
                }
                break;
            
            default: //placa
                switch ($buscarTiposDeMensajes) {
                    case 'R':
                        $resultado = DB::connection('sqlsrvsms')->table('ttbsmsin')->select('FechaHora','MIN','MSJ')->where('MSJ','like','%'.$buscar.'%')->orderby('FechaHora','desc')->limit(25)->get();
                        break;
                    case 'E':
                        $resultado = DB::connection('sqlsrvsms')->table('ttbsmsout')->select('FechaHora','MIN','MSJ')->where('MSJ','like','%'.$buscar.'%')->orderby('FechaHora','desc')->limit(25)->get();
                        break;
                    default: //EX
                        $resultado = DB::select('exec spConsultaXMPP ?,?',array('',$buscar));
                        break;
                }
                
                break;
        }
        $response = array();
        return response()->json($resultado);


    }

   

    public function BuscarSMSPorPlaca($buscar, $buscarTiposDeMensajes)
    {
        switch ($buscarTiposDeMensajes) {
            case 'R':
                # code...
                break;
            case 'E':
                # code...
                break;
            default: //EX
                # code...
                break;
        }
    }

    public function pruebapv()
    {
        $celular = '593979362610';
        $opc = DB::connection('sqlsrvsms')->select('exec spSMSGateWay ?',array($celular));
        foreach ($opc as $value) {
            return $value;
        }
        return $opc[0];
        $op = $opc[0][0];
        return view('monitors.pruebapostventa', compact('op'));
    }

    public function consultaGeneral()
    {
        return view('monitors.consultaGeneral');
    }


    public function datosUsuarioConsultar(Request $request)
    {
        $buscar = $request->search;
        $criterio = $request->criterio;

        $entidades  = DB::select('exec spDatosUsuarioConsultar ?,?',array($buscar,$criterio));
        $response = array();



        /*foreach ($entidades as $entidad) {
            
            
            try {
                if($entidad->IdEntidad!=null)
                    $IdEntidad = $entidad->IdEntidad;
                else {
                    $IdEntidad = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Entidad!=null)
                    $Entidad = $entidad->Entidad;
                else {
                    $Entidad = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Direccion!=null)
                    $Direccion = $entidad->Direccion;
                else {
                    $Direccion = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Celular!=null)
                    $Celular = $entidad->Celular;
                else {
                    $Celular = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Convencional!=null)
                    $Convencional = $entidad->Convencional;
                else {
                    $Convencional = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Email!=null)
                    $Email = $entidad->Email;
                else {
                    $Email = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->Usuario!=null)
                    $Usuario = $entidad->Usuario;
                else {
                    $Usuario = "";
                }
                } catch (\Throwable $th) {
               
                }
            try {
                if($entidad->IdUsuario!=null)
                    $IdUsuario = $entidad->IdUsuario;
                else {
                    $IdUsuario = "";
                }
                } catch (\Throwable $th) {
               
                }
            
                
            
                switch ($criterio) {
                case '0':
                    if((preg_match($buscar,$IdEntidad)!=false) )
                    {
                        $response[] = array("label"=>$IdEntidad,"value"=>$IdEntidad.';'.$Entidad.';'.$Direccion.';'.$Celular.';'.$Convencional.';'.$Email.';'.$Usuario.';'.$IdUsuario);   
                    }
                    break;
                case '1':
                    if((preg_match($buscar,$Entidad)!=false) )
                    {
                        $response[] = array("label"=>$Entidad,"value"=>$IdEntidad.';'.$Entidad.';'.$Direccion.';'.$Celular.';'.$Convencional.';'.$Email.';'.$Usuario.';'.$IdUsuario);   
                    }
                    break;
                case '4':
                    if((preg_match($buscar,$Usuario)!=false) )
                    {
                        $response[] = array("label"=>$Usuario,"value"=>$IdEntidad.';'.$Entidad.';'.$Direccion.';'.$Celular.';'.$Convencional.';'.$Email.';'.$Usuario.';'.$IdUsuario);   
                    }
                    break;
                
            }
        }*/

        
        /*switch ($criterio) {
            case '0':
                foreach($entidades as $entidad){
                    /*$Entidad = "";
                    if($entidad->Entidad!=null)
                        $Entidad = $entidad->Entidad;
                    $Direccion = "";
                    if($entidad->Direccion!=null)
                            $Direccion = $entidad->Direccion;
                    $Celular = "";
                    if($entidad->Celular!=null)
                        $Celular = $entidad->Celular;
                    $Convencional = "";
                    if($entidad->Convencional!=null)
                        $Convencional = $entidad->Convencional;
                    $Email = "";
                    if($entidad->Email!=null)
                        $Email = $entidad->Email;
                    $Usuario = "";
                    if($entidad->Usuario!=null)
                        $Usuario = $entidad->Usuario;
                    $IdUsuario = "";
                    if($entidad->IdUsuario!=null)
                        $IdUsuario = $entidad->IdUsuario;*/

                   /* $response[] = array("label"=>$entidad->IdEntidad,"value"=>$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$Usuario.';'.$IdUsuario);
                 }
                break;
            case '1':
                foreach($entidades as $entidad){
                    $response[] = array("label"=>$entidad->Entidad,"value"=>$entidad->IdEntidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario);
                 }
                break;
            case '4':
                foreach($entidades as $entidad){
                    $Entidad = "";
                    if($entidad->Entidad!=null)
                        $Entidad = $entidad->Entidad;
                    $IdEntidad = "";
                    if($entidad->IdEntidad!=null)
                        $IdEntidad = $entidad->IdEntidad;
                    $response[] = array("label"=>$entidad->Usuario,"value"=>$entidad->IdEntidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->IdUsuario);
                 }
                break;
            default:
                $response[] = array("label"=>"","value"=>"");
                break;
        }*/


        switch ($criterio) {
            case '0':
                foreach($entidades as $entidad){
                    $celular = '593'.substr($entidad->Celular,1);
                    $op = '0'; //DB::connection('sqlsrvsms')->select('exec spSMSGateWay ? AS op',array($celular))[0]->op;
                    switch ($op) {
                        case '0':
                            $operadora = 'Claro';
                            break;
                        case '1':
                            $operadora = 'Movistar';
                            break;
                        default:
                            $operadora = 'Indeterminado';
                            break;
                    }
                    $response[] = array("label"=>$entidad->IdEntidad,"value"=>$entidad->IdEntidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';;'.$operadora);
                 }
                break;
            case '1':
                foreach($entidades as $entidad){
                    $celular = '593'.substr($entidad->Celular,1);
                    $op = '0'; //DB::connection('sqlsrvsms')->select('exec spSMSGateWay ? AS op',array($celular))[0]->op;
                    switch ($op) {
                        case '0':
                            $operadora = 'Claro';
                            break;
                        case '1':
                            $operadora = 'Movistar';
                            break;
                        default:
                            $operadora = 'Indeterminado';
                            break;
                    }
                    $response[] = array("label"=>$entidad->Entidad,"value"=>$entidad->IdEntidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario.';'.$operadora);
                 }
                break;
            case '4':
                foreach($entidades as $entidad){
                    $celular = '593'.substr($entidad->Celular,1);
                    $op = '0'; //DB::connection('sqlsrvsms')->select('exec spSMSGateWay ? AS op',array($celular))[0]->op;
                    switch ($op) {
                        case '0':
                            $operadora = 'Claro';
                            break;
                        case '1':
                            $operadora = 'Movistar';
                            break;
                        default:
                            $operadora = 'Indeterminado';
                            break;
                    }
                    $response[] = array("label"=>$entidad->Usuario,"value"=>$entidad->identidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';;'.$operadora);
                 }
                break;
            default:
                # code...
                break;
        }
        
        
        
        
        

         
         return response()->json($response);
    }
}
