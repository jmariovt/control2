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
use XAdmin\Exports\MonitorsHojaRutaExportExterno;
use XAdmin\Exports\MonitorsExportClienteMonitoreo;
use Maatwebsite\Excel\Facades\Excel;
use XAdmin\Mail\ClientesMonitoreoMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use XAdmin\Mail\MensajeRegistrosRecorridoMailable;
use XAdmin\Mail\ConfirmarHojaRutaClienteMailable;
use XAdmin\Mail\PostVentaResetClaveMailable;

use DateTime;
use Storage;





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

        $monitors = array();

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');


        $fechaDesde = '';//DB::select('select dbo.getPrimerMonitoreoActivo(0) AS fd')[0]->fd;
        if($fechaDesde == '')
        {
            //$fechaDesde = now()->format('d/m/Y');
            $fechaDesde = Carbon::now();
            
            if($idSubUsuario=="0")
            {
                $fechaDesde = $fechaDesde->add(-3, 'day');
            }
            
            $fechaDesde = $fechaDesde->format('d/m/Y');
        }else{
            $fechaDesde_arreglo = explode ( " " , $fechaDesde );
            $fechaDesde = $fechaDesde_arreglo[0];
        }
            
        $fechaHasta = now()->format('d/m/Y'); // 15/09/2020

        try {
            //Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            //Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
       
        Log::info('Lentitud. Va a ejecutar consulta de Monitoreos '.$fechaAhora);
        if($idSubUsuario=="0")
        {
            // ES UN USUARIO INTERNO
            $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'','A',$tipo));
        }else
        {
            // ES UN USUARIO EXTERNO (SUBUSUARIO)
            if($idCategoria=="9")
            {
                // ES UN SUPERVISOR EXTERNO - PERFILES 4
                $monitors_temp = DB::select('exec spMonitoreoConsultarLvExternoSupervisor ?,?,?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'','A',$tipo,$idUsuario,$idSubUsuario));

            }else if($idCategoria=="10")
            {
                // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
                //$monitors_temp = DB::select('exec spMonitoreoConsultarLvExterno ?,?,?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'','A',$tipo,$idUsuario,$idSubUsuario));
                //spMonitoreoConsultarLvExternoPorGrupos
                $monitors_temp = DB::select('exec spMonitoreoConsultarLvExternoPorGrupos ?,?,?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'','A',$tipo,$idUsuario,$idSubUsuario));
            }
        }
        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Ha ejecutado consulta de Monitoreos '.$fechaAhora);
        

        foreach ($monitors_temp as $monitor) {
            $entidad = DB::select('exec spEntidadesActivoConsultar ?',array($monitor->IdActivo));
            if($entidad)
                $monitor->entidad = $entidad;
            else
                $monitor->entidad = "N/D";
            
            if($monitor->VID)
            {
                    $registrosReportando = DB::table('ReportePosicion_Last')
                                    //->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                    ->select(DB::raw('DATEDIFF(MINUTE, FechaHoraRecibido,  dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                    ->where('Id','=',$monitor->VID)->get();
                
                    
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

            if($idSubUsuario!="0"&&$idCategoria=="9")
            {
                $nombreCompleto = DB::table('SubUsuario')->select('NombreCompleto')->where('IdSubUsuario','=',$monitor->idSubUsuario)->where('IdUsuario','=',$idUsuario)->get();
                try {
                    $monitor->NombreCompleto = $nombreCompleto[0]->NombreCompleto;
                } catch (\Throwable $th) {
                    $monitor->NombreCompleto = "XAdminDespacho";
                }
                
            }


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

        try {
            //Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            //Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        



       // $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'',$estado,$tipo));

       if($idSubUsuario=="0")
       {
           // ES UN USUARIO INTERNO
           $monitors_temp = DB::select('exec spMonitoreoConsultarLv ?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'',$estado,$tipo));
       }else
       {
           // ES UN USUARIO EXTERNO (SUBUSUARIO)
           if($idCategoria=="9")
           {
               // ES UN SUPERVISOR EXTERNO - PERFILES 4
               $monitors_temp = DB::select('exec spMonitoreoConsultarLvExternoSupervisor ?,?,?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'',$estado,$tipo,$idUsuario,$idSubUsuario));



           }else if($idCategoria=="10")
           {
               // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
               $monitors_temp = DB::select('exec spMonitoreoConsultarLvExterno ?,?,?,?,?,?,?,?',array($fechaDesde,$fechaHasta,0,'',$estado,$tipo,$idUsuario,$idSubUsuario));
           }
       }

        
        
        
        
        
        
        foreach ($monitors_temp as $monitor) {
            $entidad = DB::select('exec spEntidadesActivoConsultar ?',array($monitor->IdActivo));
            if($entidad)
                $monitor->entidad = $entidad;
            else
                $monitor->entidad = "N/D";
            

            if($monitor->VID)
            {
                $registrosReportando = DB::table('ReportePosicion_Last')
                                    //->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                    ->select(DB::raw('DATEDIFF(MINUTE, FechaHoraRecibido,  dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                    ->where('Id','=',$monitor->VID)
                                    ->get();
            

       
                
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

            if($idSubUsuario!="0"&&$idCategoria=="9")
            {
                $nombreCompleto = DB::table('SubUsuario')->select('NombreCompleto')->where('IdSubUsuario','=',$monitor->idSubUsuario)->where('IdUsuario','=',$idUsuario)->get();
                try {
                    $monitor->NombreCompleto = $nombreCompleto[0]->NombreCompleto;
                } catch (\Throwable $th) {
                    $monitor->NombreCompleto = "XAdminDespacho";
                }
                
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

        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Inicia creacion de Monitoreo'.$fechaAhora);

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


        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');

        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Inicia creacion de Monitoreo'.$fechaAhora);

        

        return view('monitors.create',compact('typesAlerts','geoCercas','fechaInicio','fechaFin','tiposDeMonitoreo','marcas','entidades','idUsuario','idSubUsuario'));
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
        //$monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        //$monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');

        $fechaInicioFin = $request->input('FechaHoraInicioFinCreate');
        $fechaArreglo = explode(' / ',$fechaInicioFin);
        $monitor->FechaHoraInicio = $fechaArreglo[0];
        $monitor->FechaHoraFin = $fechaArreglo[1];

        $dateTimeInicio = new \DateTime($fechaArreglo[0]);
        $dateTimeFin = new \DateTime($fechaArreglo[1]);

        if($dateTimeInicio>$dateTimeFin)
            return back()->withErrors(['error' => 'Verifique que las fechas estén correctas.']);

        $tipoMonitoreo = $request->input('selectTipoDeMonitoreo');
        
        try {
            $usuarioIngreso = Auth::guard('web')->user()->Usuario; 
        } catch (\Throwable $th) {
            $usuarioIngreso = Auth::guard('websubusers')->user()->Usuario; 
        }
        

        // Se agregan por el tema de los subUsuarios
        $IdUsuario = session('idUsuario');
        $IdSubUsuario = session('idSubUsuario');
        
        
        $ip=\Request::ip();
        
        $IdMonitoreo = -1;
       
        //$resultado =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,$tipoMonitoreo));
        if($IdSubUsuario=="0")
        {
            // ES UN USUARIO INTERNO
            $resultado =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,$tipoMonitoreo));  
        }else
        {
            $resultado =  DB::select('exec spMonitoreoingresarLv2_pruebasSU ?,?,?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,$tipoMonitoreo,$IdUsuario,$IdSubUsuario));
        }
        

        
        
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
            $IdUsuarioAlerta = -1; //12
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

            $resultadoInsertAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($TipoMonitoreo, $Nombre, $Descripcion, $IdTipoDispositivo, $Evento, $IdGeocerca, $Kilometraje, $PorcentajeAnticipacion, $IdUsuarioAlerta, $usuarioIngreso, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlerta, $idGrupoGeo));
                    
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
 
        //$usuarioCreacion = Auth::user()->Usuario;
        try {
            $usuarioCreacion = Auth::guard('web')->user()->Usuario; 
        } catch (\Throwable $th) {
            $usuarioCreacion = Auth::guard('websubusers')->user()->Usuario; 
        }
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

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');

        return view('monitors.edit',compact('datos','typesAlerts','geoCercas','IdMonitoreo','products','ultimosMonitoreos','eventos','idUsuario','idSubUsuario'));
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
        //$monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        //$monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');
        $IdMonitoreo = $request->input('IdMonitoreo');

        $fechaInicioFin = $request->input('FechaHoraInicioFinEdit');
        $fechaArreglo = explode(' / ',$fechaInicioFin);
        $monitor->FechaHoraInicio = $fechaArreglo[0];
        $monitor->FechaHoraFin = $fechaArreglo[1];

        $dateTimeInicio = new \DateTime($fechaArreglo[0]);
        $dateTimeFin = new \DateTime($fechaArreglo[1]);

        if($dateTimeInicio>$dateTimeFin)
            return back()->withErrors(['error' => 'Verifique que las fechas estén correctas.']);

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
        //$usuarioIngreso = Auth::user()->Usuario;
        try {
            $usuarioIngreso = Auth::guard('web')->user()->Usuario;
        } catch (\Throwable $th) {
            $usuarioIngreso = Auth::guard('websubusers')->user()->Usuario;
        }

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
                return Excel::download(new MonitorsExport1($IdMonitoreo,$desde,$hasta), 'InformeMonitoreo_'.str_replace("/","",$desde).$hora.$minuto.'_'.$alias.'.xls');
                break;
            
            default:
                return Excel::download(new MonitorsExport2($IdMonitoreo,$desde,$hasta), 'InformeMonitoreo_'.str_replace("/","",$desde).$hora.$minuto.'_'.$alias.'.xls');
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
        //$usuario = Auth::user()->Usuario; 
        
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
        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        //$monitoreosPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        if($idCategoria=="0")
        {
            $monitoreosPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        }else
        {
            // ES UN USUARIO EXTERNO (SUBUSUARIO)
            if($idCategoria=="9")
            {
                // ES UN SUPERVISOR EXTERNO - PERFILES 4
                $monitoreosPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLvExterno ?,?,?",array($placa,$idUsuario,$idSubUsuario));

            }else if($idCategoria=="10")
            {
                // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
                $monitoreosPorActivar = DB::select("exec spMonitoreosPorActivarConsultarLvExterno ?,?,?",array($placa,$idUsuario,$idSubUsuario));
                
            }
        }
        return view('monitors.controlmonitoreos',compact('monitoreosPorActivar'));
    }

    public function buscarMonitoreosAlias(Request $request)
    {
        $placa=$request->idAlias;
        if($placa=='')
            $placa = ' ';
        //$resultado['data'] = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        
        if($idCategoria=="0")
        {
            $resultado['data'] = DB::select("exec spMonitoreosPorActivarConsultarLv ?",array($placa));
        }else
        {
            // ES UN USUARIO EXTERNO (SUBUSUARIO)
            if($idCategoria=="9")
            {
                // ES UN SUPERVISOR EXTERNO - PERFILES 4
                $resultado['data'] = DB::select("exec spMonitoreosPorActivarConsultarLvExterno ?,?,?",array($placa,$idUsuario,$idSubUsuario));

            }else if($idCategoria=="10")
            {
                // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
                $resultado['data'] = DB::select("exec spMonitoreosPorActivarConsultarLvExterno ?,?,?",array($placa,$idUsuario,$idSubUsuario));
                
            }
        }
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


  

        


        //$usuarioIngreso = Auth::user()->Usuario; 
        try {
            $usuarioIngreso = Auth::guard('web')->user()->Usuario;
        } catch (\Throwable $th) {
            $usuarioIngreso = Auth::guard('websubusers')->user()->Usuario;
        }

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

        
        
        $infoEventoDefinidoBP = DB::select('exec spConsultarDefinicionEventoLv ?,?',array($idActivo,3)); //Boton de panico

       /* $resultado['data'] = array('resultado'=>$infoEventoDefinido);
        $response = array();
         return response()->json($resultado);*/
             
        try {
            foreach ($infoEventoDefinidoBP as $eventoDefinido) {
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
                $nombre = "BOTON DE PANICO";
                $descripcion = "BOTON DE PANICO CREADO AUTOMATICAMENTE POR EL SISTEMA";
                $HoraDesde = '';
                $HoraHasta = '';
                $LimiteVelocidad = 0;
                $DentroGeo = 0;
                $IdDespacho = 0;
                $idGrupoGeo = 0;

                $resultadoIngresarAlerta = DB::select('exec spD_AlertaIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($idTipoAlerta, $nombre, $descripcion, $idTipoDispositivo, $evento, $idGeocerca, $kilometraje, $porcentaje, $idUsuario, $usuario, $idProducto, $HoraDesde, $HoraHasta, $LimiteVelocidad, $DentroGeo, $IdDespacho, $IdAlertaOutput, $idGrupoGeo));
                
                $IdAlerta = $resultadoIngresarAlerta[0]->IdAlertaLv;

                DB::insert('exec spMonitoreoD_AlertaIngresar ?,?', array($IdAlerta, $IdMonitoreo));
                $respuesta = $respuesta."Crea Boton de Pánico. ".$IdAlerta." ";
            }
        } catch (\Throwable $th) {
            $respuesta = $respuesta."Error en Botón de Pánico: ".$IdMonitoreo."-".$IdAlerta."-".$idTipoAlerta."-".$nombre."-".$descripcion."-".$idTipoDispositivo."-".$evento."-".$idGeocerca."-".$kilometraje."-".$porcentaje."-".$idUsuario."-".$usuario."-".$idProducto."-".$HoraDesde."-".$HoraHasta."-".$LimiteVelocidad."-".$DentroGeo."-".$IdDespacho."-".$IdAlertaOutput."-".$idGrupoGeo." ";
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
        $alertasPendientes = $request->alertasPendientes;

        $respuesta = "";
        //$usuario = Auth::user()->Usuario;
        //$nombre = Auth::user()->Nombre;
        //$idUsuario = Auth::user()->IdUsuario;

        try {
            $usuario = Auth::guard('web')->user()->Usuario;
            $nombre = Auth::guard('web')->user()->Nombre;
            $idUsuario = Auth::guard('web')->user()->IdUsuario;
        } catch (\Throwable $th) {
            $usuario = Auth::guard('websubusers')->user()->Usuario;
            $nombre = Auth::guard('websubusers')->user()->Nombre;
            $idUsuario = Auth::guard('websubusers')->user()->IdUsuario;
        }

        $ip = \Request::ip();

        /****
         * ToDo
         * Agregar Usuario a spActualizarEstadoRealMonitoreoLv
         * */
        try {
            //DB::update('exec spActualizarEstadoRealMonitoreo ?',array($IdMonitoreo));
            DB::update('exec spActualizarEstadoRealMonitoreoLv ?,?,?,?',array($IdMonitoreo,$idUsuario,$ip,$alertasPendientes));
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
        /*
        if($enviarCorreo=="SI")
            $enviarCorreo = 1;
        else   
            $enviarCorreo = 0;
        
        */
  
        $respuesta = "";
        try {
            DB::update('exec spMonitoreoControlUsuariosActualizar ?,?,?,?',array($usuario,$estado,$validoHasta,$enviarCorreo));
            $respuesta = "Cliente actualizado correctamente.";
        } catch (\Throwable $th) {
            $respuesta = $th->getMessage();
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
        $mailTo = $mailArreglo[0];//jmariovt@gmail.com
        $mailPass = $mailArreglo[1];
        
        $correo = new ClientesMonitoreoMailable($usuario,$mailPass,$mailTo);
        Log::info('Mariolog  envio correo: '.$mailTo);
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
        if($tipoCliente!="0")
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

        $correoyClave = DB::select('select dbo.getEmaildeUsuarioHojaRutaMon (?) AS mu',array($tercero))[0]->mu;
        //DB::select('select dbo.getTotalAlertas (?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->ta;
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
            //'txtVehiculoMarca' => 'required',
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
            //'txtVehiculoMarca.required' => 'Marca es obligatorio', 
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

        if($request->input('txtInfoAdicionalLugar1') <> "" || $request->input('txtInfoAdicionalTiempo1') <> "") 
            $parada1 = $request->input('txtInfoAdicionalLugar1') . " - " . $request->input('txtInfoAdicionalTiempo1');

        if($request->input('txtInfoAdicionalLugar2') <> "" || $request->input('txtInfoAdicionalTiempo2') <> "") 
        {   $parada2 = $request->input('txtInfoAdicionalLugar2') . " - " . $request->input('txtInfoAdicionalTiempo2');
            $parada1 = $parada1."%".$parada2;
        }

        if($request->input('txtInfoAdicionalLugar3') <> "" || $request->input('txtInfoAdicionalTiempo3') <> "") 
        {   $parada3 = $request->input('txtInfoAdicionalLugar3') . " - " . $request->input('txtInfoAdicionalTiempo3');
            $parada1 = $parada1."%".$parada3;
        }

        if($request->input('txtInfoAdicionalLugar4') <> "" || $request->input('txtInfoAdicionalTiempo4') <> "") 
        {   $parada4 = $request->input('txtInfoAdicionalLugar4') . " - " . $request->input('txtInfoAdicionalTiempo4');
            $parada1 = $parada1."%".$parada4;
        }

        if($request->input('txtInfoAdicionalLugar5') <> "" || $request->input('txtInfoAdicionalTiempo5') <> "") 
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

        $nombreSeveridad0 = $request->input('txtPlanNombre1');
        $nombreSeveridad1 = $request->input('txtPlanNombre2');
        $nombreSeveridad2 = $request->input('txtPlanNombre3');

        $celularSeveridad0 = $request->input('txtPlanCelular1');
        $celularSeveridad1 = $request->input('txtPlanCelular2');
        $celularSeveridad2 = $request->input('txtPlanCelular3');

        $correoSeveridad0 = $request->input('txtPlanCorreo1');
        $correoSeveridad1 = $request->input('txtPlanCorreo2');
        $correoSeveridad2 = $request->input('txtPlanCorreo3');

        if((($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")) ||
           (($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "")) ||
           (($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")))
        {
            //return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Debe de ingresar al menos dos contactos para informar en caso de eventualidades');
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

    /****
     * HOJAS DE RUTA
     * CLIENTES
     * 
     * 
     */

    public function adminCliente($cliente)
    {
        //Debo mostrar las platillas del cliente

        $tipoCliente = session('hojaRuta_TipoCliente');
        //return  'Tipo de cliente: '.$tipoCliente;

        $hojasRuta = array();

        try {
            $hojasRuta = DB::select('exec spMonitoreoClienteHojaRutaCargarPlantillaLv ?',array($cliente));    
            //Id	NombrePlantilla
            //1	    QUITO POSORJA
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
        return view('monitors.hojasDeRutaClientes.admin',compact('hojasRuta','cliente'));
    }

    public function adminClienteModificarPlantilla($cliente,$id)
    {
        $nombre = session('nombre');
        $usuario = session('usuario');
        $tipoCliente = session('hojaRuta_TipoCliente');
        $activos = array();
        try {
            $activos = DB::select('exec spLlenarCombo ?,?,?,?', array('ACTIVOSCLIENTEMONITOREO',$cliente,'',''));
        } catch (\Throwable $th) {
            
        }

        $nombrePlantillaDatos = DB::table('MonitoreoHojaRutaPlantilla')
                                ->select('NombrePlantilla')
                                ->where('UsuarioMonitoreoControl','=',$cliente)
                                ->where('Id','=',$id)->get();
        $nombrePlantilla = $nombrePlantillaDatos[0]->NombrePlantilla;
        //Debo mostrar las platillas del cliente spMonitoreoHojaRutaPlantillaConsultar
        $datosCliente = DB::select('exec spMonitoreoHojaRutaPlantillaConsultar ?,?',array($id,$cliente));
        $tipoCliente = "I";
        return view('monitors.hojasDeRutaClientes.update', compact('datosCliente','nombre','activos','cliente','id','nombrePlantilla','tipoCliente'));
    }

    public function adminClienteCrearPlantilla($cliente)
    {
        //Debo mostrar las platillas del cliente 
        $nombre = session('nombre');
        $usuario = session('usuario');
        $activos = array();
        try {
            $activos = DB::select('exec spLlenarCombo ?,?,?,?', array('ACTIVOSCLIENTEMONITOREO',$usuario,'',''));
        } catch (\Throwable $th) {
            
        }
        return view('monitors.hojasDeRutaClientes.create',compact('cliente','nombre','activos'));
    }

    public function storeHojaRutaCliente(Request $request)
    {
        $usuario = Auth::user()->Usuario; 

        $txtUsuario = $request->input('txtUsuario');
        $IdMonitoreo = $request->input('txtIdMonitoreo');
        $tieneMonitoreo = 0;

        if($IdMonitoreo!="")
            $tieneMonitoreo = 1;


        /*
        $validated = $request->validate([
            //'txtContenedorNombre' => 'required',
            //'txtContenedorPies' => 'required',
            //'txtContenedorTipoCarga' => 'required',
            'txtVehiculoPlaca'=> 'required',
            //'txtVehiculoMarca' => 'required',
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
            'txtVehiculoPlaca'=> 'required',
            
            
        ],[ //'txtContenedorNombre.required' => 'El campo Número de contenedor es obligatorio', 
            //'txtContenedorPies.required' => 'El campo Pies es obligatorio',
            //'txtContenedorTipoCarga.required' => 'Tipo de carga obligatoria',
            'txtVehiculoPlaca.required' => 'Placa obligatoria',
            //'txtVehiculoMarca.required' => 'Marca es obligatorio', 
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
        );*/

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

        $nombrePlantilla = $request->input('txtNombrePlantilla');
        $cliente = $request->input('txtCliente');

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

        if($request->input('txtInfoAdicionalLugar1') <> "" || $request->input('txtInfoAdicionalTiempo1') <> "") 
            $parada1 = $request->input('txtInfoAdicionalLugar1') . " - " . $request->input('txtInfoAdicionalTiempo1');

        if($request->input('txtInfoAdicionalLugar2') <> "" || $request->input('txtInfoAdicionalTiempo2') <> "") 
        {   $parada2 = $request->input('txtInfoAdicionalLugar2') . " - " . $request->input('txtInfoAdicionalTiempo2');
            $parada1 = $parada1."%".$parada2;
        }

        if($request->input('txtInfoAdicionalLugar3') <> "" || $request->input('txtInfoAdicionalTiempo3') <> "") 
        {   $parada3 = $request->input('txtInfoAdicionalLugar3') . " - " . $request->input('txtInfoAdicionalTiempo3');
            $parada1 = $parada1."%".$parada3;
        }

        if($request->input('txtInfoAdicionalLugar4') <> "" || $request->input('txtInfoAdicionalTiempo4') <> "") 
        {   $parada4 = $request->input('txtInfoAdicionalLugar4') . " - " . $request->input('txtInfoAdicionalTiempo4');
            $parada1 = $parada1."%".$parada4;
        }

        if($request->input('txtInfoAdicionalLugar5') <> "" || $request->input('txtInfoAdicionalTiempo5') <> "") 
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

        $nombreSeveridad0 = $request->input('txtPlanNombre1');
        $nombreSeveridad1 = $request->input('txtPlanNombre2');
        $nombreSeveridad2 = $request->input('txtPlanNombre3');

        $celularSeveridad0 = $request->input('txtPlanCelular1');
        $celularSeveridad1 = $request->input('txtPlanCelular2');
        $celularSeveridad2 = $request->input('txtPlanCelular3');

        $correoSeveridad0 = $request->input('txtPlanCorreo1');
        $correoSeveridad1 = $request->input('txtPlanCorreo2');
        $correoSeveridad2 = $request->input('txtPlanCorreo3');

        if((($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")) ||
           (($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "")) ||
           (($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")))
        {
            //return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Debe de ingresar al menos dos contactos para informar en caso de eventualidades');
        }

        $puedeEnviarHojaRuta = true;//DB::select('select dbo.SePuedeEnviarHojaRuta('.$IdMonitoreo.','.$txtUsuario.') AS val')[0]->val;

        if($puedeEnviarHojaRuta)
        {
            

            if($tieneMonitoreo==0)
            {
                //DB::update('exec spMonitoreoInfoAdicionalProvisionalActualizar4 ?,?,?', array());
            }
        }


        
                                                

         $exito=true;
         try {

            $exito = DB::insert('exec spMonitoreoHojaRutaPlantillaingresar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array(  $usuario,
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
                $correoSeveridad2,
                $nombrePlantilla
            ));

 
                
            $exito = true;
         } catch (\Throwable $th) {
             $exito = false;
         }

        
        if($exito)
            return redirect()->route('adminCliente', ['cliente' => $request->input('txtCliente')])->with('status','Plantilla Hoja de ruta creada con éxito.');
        else
            return redirect()->route('crearPlantilla', ['cliente' => $request->input('txtCliente')])->withErrors('Error al crear Plantilla Hoja de Ruta');
        
        
    }

    public function updateHojaRutaCliente(Request $request)
    {
        $usuario = Auth::user()->Usuario; 

        //$txtUsuario = $request->input('txtUsuario');
        //$IdMonitoreo = $request->input('txtIdMonitoreo');
        $tieneMonitoreo = 0;


        //if($IdMonitoreo!="")
          //  $tieneMonitoreo = 1;


          /*
        $validated = $request->validate([
            //'txtContenedorNombre' => 'required',
            //'txtContenedorPies' => 'required',
            //'txtContenedorTipoCarga' => 'required',
            'txtVehiculoPlaca'=> 'required',
            //'txtVehiculoMarca' => 'required',
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
            'txtVehiculoPlaca'=> 'required',
            
            
        ],[ //'txtContenedorNombre.required' => 'El campo Número de contenedor es obligatorio', 
            //'txtContenedorPies.required' => 'El campo Pies es obligatorio',
            //'txtContenedorTipoCarga.required' => 'Tipo de carga obligatoria',
            'txtVehiculoPlaca.required' => 'Placa obligatoria',
            //'txtVehiculoMarca.required' => 'Marca es obligatorio', 
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
        );*/

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

        $nombrePlantilla = $request->input('txtNombrePlantilla');
        $cliente = $request->input('txtCliente');
        $id = $request->input('txtId');

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

        if($request->input('txtInfoAdicionalLugar1') <> "" || $request->input('txtInfoAdicionalTiempo1') <> "") 
            $parada1 = $request->input('txtInfoAdicionalLugar1') . " - " . $request->input('txtInfoAdicionalTiempo1');

        if($request->input('txtInfoAdicionalLugar2') <> "" || $request->input('txtInfoAdicionalTiempo2') <> "") 
        {   $parada2 = $request->input('txtInfoAdicionalLugar2') . " - " . $request->input('txtInfoAdicionalTiempo2');
            $parada1 = $parada1."%".$parada2;
        }

        if($request->input('txtInfoAdicionalLugar3') <> "" || $request->input('txtInfoAdicionalTiempo3') <> "") 
        {   $parada3 = $request->input('txtInfoAdicionalLugar3') . " - " . $request->input('txtInfoAdicionalTiempo3');
            $parada1 = $parada1."%".$parada3;
        }

        if($request->input('txtInfoAdicionalLugar4') <> "" || $request->input('txtInfoAdicionalTiempo4') <> "") 
        {   $parada4 = $request->input('txtInfoAdicionalLugar4') . " - " . $request->input('txtInfoAdicionalTiempo4');
            $parada1 = $parada1."%".$parada4;
        }

        if($request->input('txtInfoAdicionalLugar5') <> "" || $request->input('txtInfoAdicionalTiempo5') <> "") 
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

        $nombreSeveridad0 = $request->input('txtPlanNombre1');
        $nombreSeveridad1 = $request->input('txtPlanNombre2');
        $nombreSeveridad2 = $request->input('txtPlanNombre3');

        $celularSeveridad0 = $request->input('txtPlanCelular1');
        $celularSeveridad1 = $request->input('txtPlanCelular2');
        $celularSeveridad2 = $request->input('txtPlanCelular3');

        $correoSeveridad0 = $request->input('txtPlanCorreo1');
        $correoSeveridad1 = $request->input('txtPlanCorreo2');
        $correoSeveridad2 = $request->input('txtPlanCorreo3');

        if((($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")) ||
           (($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
           ($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "")) ||
           (($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "") && 
           ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")))
        {
            //return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Debe de ingresar al menos dos contactos para informar en caso de eventualidades');
        }

        $puedeEnviarHojaRuta = true;//DB::select('select dbo.SePuedeEnviarHojaRuta('.$IdMonitoreo.','.$txtUsuario.') AS val')[0]->val;

        if($puedeEnviarHojaRuta)
        {
            

            if($tieneMonitoreo==0)
            {
                //DB::update('exec spMonitoreoInfoAdicionalProvisionalActualizar4 ?,?,?', array());
            }
        }
        

   
        
        if($Numero_Contenedor==null)
            $Numero_Contenedor="";
        if($Pies_Contenedor==null)
            $Pies_Contenedor="";
        if($TipoCarga_Contenedor==null)
            $TipoCarga_Contenedor="";
        if($placa==null)
            $placa="";
        if($marca==null)
            $marca="";
        if($color==null)
        $color="";
        if($chofer_nombre==null)
            $chofer_nombre="";
        if($chofer_celular==null)
            $chofer_celular="";
        if($acompanante_nombre==null)
            $acompanante_nombre="";
        if($acompanante_celular==null)
            $acompanante_celular="";
        if($ruta_a_seguir==null)
            $ruta_a_seguir="";
        if($fecha_inicio==null)
            $fecha_inicio="";
        if($ciudad_origen==null)
            $ciudad_origen="";
        if($direccion_origen==null)
            $direccion_origen="";
        if($fecha_fin==null)
            $fecha_fin="";
        if($ciudad_destino==null)
            $ciudad_destino="";
        if($direccion_destino==null)
            $direccion_destino="";
        if($contacto1==null)
            $contacto1="";
        if($parada1==null)
            $parada1="";
        if($nombreSeveridad0==null)
            $nombreSeveridad0="";
        if($celularSeveridad0==null)
            $celularSeveridad0="";
        if($correoSeveridad0==null)
            $correoSeveridad0="";
        if($nombreSeveridad1==null)
            $nombreSeveridad1="";
        if($celularSeveridad1==null)
            $celularSeveridad1="";
        if($correoSeveridad1==null)
            $correoSeveridad1="";
        if($nombreSeveridad2==null)
            $nombreSeveridad2="";
        if($celularSeveridad2==null)
            $celularSeveridad2="";
        if($correoSeveridad2==null)
            $correoSeveridad2="";
        if($nombrePlantilla==null)
            $nombrePlantilla="";

        
            /*return $cliente.' - '.
            $id.' - '.
            $Numero_Contenedor.' - '.
            $Pies_Contenedor.' - '.
            $TipoCarga_Contenedor.' - '.
            $placa.' - '.
            $marca.' - '.
            $color.' - '.
            $chofer_nombre.' - '.
            $chofer_celular.' - '.
            $acompanante_nombre.' - '.
            $acompanante_celular.' - '.
            $ruta_a_seguir.' - '.
            $fecha_inicio.' - '.
            $ciudad_origen.' - '.
            $direccion_origen.' - '.
            $fecha_fin.' - '.
            $ciudad_destino.' - '.
            $direccion_destino.' - '.
            $contacto1.' - '.
            $parada1.' - '.
            $nombreSeveridad0.' - '.
            $celularSeveridad0.' - '.
            $correoSeveridad0.' - '.
            $nombreSeveridad1.' - '.
            $celularSeveridad1.' - '.
            $correoSeveridad1.' - '.
            $nombreSeveridad2.' - '.
            $celularSeveridad2.' - '.
            $correoSeveridad2.' - '.
            $nombrePlantilla;*/
        
                                                

         $exito=true;
         try {

            $exito = DB::insert('exec spMonitoreoHojaRutaPlantillaActualizar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array( 
                $cliente,
                $id,
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
                $correoSeveridad2,
                $nombrePlantilla
            ));

 
                
            $exito = true;
         } catch (\Throwable $th) {
             $exito = false;
             $error = $th->getMessage();
             $mensajeError = "Error al grabar Plantilla Hoja de Ruta. ".$error;

         }

        
        if($exito)
            return redirect()->route('adminCliente',['cliente' => $request->input('txtCliente')])->with('status','Plantilla actualizada con éxito.');
        else
            return redirect()->route('modificarPlantilla', ['cliente' => $request->input('txtCliente'), 'Id' => $id])->withErrors($mensajeError);
        
        
    }

    public function deleteHojaRutaCliente($cliente,$id)
    {
        try {
            DB::delete('exec spMonitoreoHojaRutaPlantillaeliminar ?,?', array($cliente,$id));
            $mensaje = "Plantilla eliminada correctamente.";
            return redirect()->route('adminCliente', ['cliente' => $cliente])->with('status',$mensaje);
        } catch (\Throwable $th) {
            //throw $th;
            $mensaje = "Error al eliminar Plantilla: ".$th->getMessage();
            return redirect()->route('modificarPlantilla', ['cliente' => $cliente, 'Id'=>$id])->withErrors($mensaje);
        }
    }

    public function enviarHojaRutaCliente(Request $request)
    {
        //return $request;
        try
        {

            $tipoCliente = session('hojaRuta_TipoCliente'); // "I"
            
            $usuario = session('usuario');
            $nombreArchivo = "";

            

           /* $validated = $request->validate([
                //'txtContenedorNombre' => 'required',
                //'txtContenedorPies' => 'required',
                //'txtContenedorTipoCarga' => 'required',
                'txtVehiculoPlaca'=> 'required',
                //'txtVehiculoMarca' => 'required',
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
                'txtVehiculoPlaca'=> 'required',
                
                
            ],[ //'txtContenedorNombre.required' => 'El campo Número de contenedor es obligatorio', 
                //'txtContenedorPies.required' => 'El campo Pies es obligatorio',
                //'txtContenedorTipoCarga.required' => 'Tipo de carga obligatoria',
                'txtVehiculoPlaca.required' => 'Placa obligatoria',
                //'txtVehiculoMarca.required' => 'Marca es obligatorio', 
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
            );*/

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

            $nombrePlantilla = $request->input('txtNombrePlantilla');
            $cliente = $request->input('txtCliente');
            $id = $request->input('txtId');

            $IdActivo = $request->input('chkActivos');

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

            if($request->input('txtInfoAdicionalLugar1') <> "" || $request->input('txtInfoAdicionalTiempo1') <> "") 
                $parada1 = $request->input('txtInfoAdicionalLugar1') . " - " . $request->input('txtInfoAdicionalTiempo1');

            if($request->input('txtInfoAdicionalLugar2') <> "" || $request->input('txtInfoAdicionalTiempo2') <> "") 
            {   $parada2 = $request->input('txtInfoAdicionalLugar2') . " - " . $request->input('txtInfoAdicionalTiempo2');
                $parada1 = $parada1."%".$parada2;
            }

            if($request->input('txtInfoAdicionalLugar3') <> "" || $request->input('txtInfoAdicionalTiempo3') <> "") 
            {   $parada3 = $request->input('txtInfoAdicionalLugar3') . " - " . $request->input('txtInfoAdicionalTiempo3');
                $parada1 = $parada1."%".$parada3;
            }

            if($request->input('txtInfoAdicionalLugar4') <> "" || $request->input('txtInfoAdicionalTiempo4') <> "") 
            {   $parada4 = $request->input('txtInfoAdicionalLugar4') . " - " . $request->input('txtInfoAdicionalTiempo4');
                $parada1 = $parada1."%".$parada4;
            }

            if($request->input('txtInfoAdicionalLugar5') <> "" || $request->input('txtInfoAdicionalTiempo5') <> "") 
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

            $nombreSeveridad0 = $request->input('txtPlanNombre1');
            $nombreSeveridad1 = $request->input('txtPlanNombre2');
            $nombreSeveridad2 = $request->input('txtPlanNombre3');

            $celularSeveridad0 = $request->input('txtPlanCelular1');
            $celularSeveridad1 = $request->input('txtPlanCelular2');
            $celularSeveridad2 = $request->input('txtPlanCelular3');

            $correoSeveridad0 = $request->input('txtPlanCorreo1');
            $correoSeveridad1 = $request->input('txtPlanCorreo2');
            $correoSeveridad2 = $request->input('txtPlanCorreo3');

            if((($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
            ($request->input('txtPlanNombre2') == "" || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")) ||
            (($request->input('txtPlanNombre1') == "" || $request->input('txtPlanCelular1') == "" || $request->input('txtPlanCorreo1') == "") && 
            ($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "")) ||
            (($request->input('txtPlanNombre3') == "" || $request->input('txtPlanCelular3') == "" || $request->input('txtPlanCorreo3') == "") && 
            ($request->input('txtPlanNombre2') == ""  || $request->input('txtPlanCelular2') == "" || $request->input('txtPlanCorreo2') == "")))
            {
                //return redirect()->route('mostrarHojaRuta', ['IdMonitoreo' => $request->input('txtIdMonitoreo'), 'Usuario'=>$request->input('txtUsuario'), 'Cliente' => $request->input('txtCliente'), 'Tipo'=>$request->input('txtTipo')])->withErrors('Debe de ingresar al menos dos contactos para informar en caso de eventualidades');
            }

            //return response()->json($IdActivo);
            

            if(($tipoCliente=="I" && $IdActivo!="0")||$tipoCliente=="T")
            {
                
                
                $monitor = new Monitor();
                $monitor->idActivo = $IdActivo;
                //$monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
                //$monitor->FechaHoraFin = $request->input('FechaHoraFin');
                //$monitor->Estado = $request->input('Estado');

                
                $monitor->FechaHoraInicio = $fecha_inicio;
                $monitor->FechaHoraFin = $fecha_fin;

                
                //if($dateTimeInicio>$dateTimeFin)
                //    return back()->withErrors(['error' => 'Verifique que las fechas estén correctas.']);

                
                try {
                    $usuarioIngreso = Auth::guard('web')->user()->Usuario; 
                } catch (\Throwable $th) {
                    $usuarioIngreso = Auth::guard('websubusers')->user()->Usuario; 
                }
                

                // Se agregan por el tema de los subUsuarios
                $IdUsuario = session('idUsuario');
                $IdSubUsuario = session('idSubUsuario');
                
                
                $ip=\Request::ip();
                
                $IdMonitoreo = -1;
            
                //$resultado =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip,$tipoMonitoreo));
                
                // ES UN USUARIO INTERNO

                

                    $resultado =  DB::select('exec spMonitoreoingresarLv2 ?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioIngreso,$ip));  
                    $IdMonitoreo = $resultado[0]->IdMonitoreo;
                
        
                    if($nombreSeveridad0!="" && ($celularSeveridad0!=""||$correoSeveridad0!=""))
                    {
                        DB::insert('exec spPlanAcccionIngresar ?,?,?,?',array($IdMonitoreo,0,$nombreSeveridad0,$celularSeveridad0.' '.$correoSeveridad0));
                    }
                    if($nombreSeveridad1!="" && ($celularSeveridad1!=""||$correoSeveridad1!=""))
                    {
                        DB::insert('exec spPlanAcccionIngresar ?,?,?,?',array($IdMonitoreo,1,$nombreSeveridad1,$celularSeveridad1.' '.$correoSeveridad1));
                    }
                    if($nombreSeveridad2!="" && ($celularSeveridad2!=""||$correoSeveridad2!=""))
                    {
                        DB::insert('exec spPlanAcccionIngresar ?,?,?,?',array($IdMonitoreo,2,$nombreSeveridad2,$celularSeveridad2.' '.$correoSeveridad2));
                    }
                    
                
                    DB::insert('exec spMonitoreoInfoAdicionalingresar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdMonitoreo,
                                                                                                                $usuario,
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
                                                                                                                $ciudad_origen.' - '.$direccion_origen,
                                                                                                                $ciudad_destino.' - '.$direccion_destino,
                                                                                                                $contacto1,
                                                                                                                '',
                                                                                                                $parada1
                                                                                                                ));

                    $nombreArchivo = 'monitoreo_'.$IdMonitoreo.'_HojaRuta.xlsx';
                    Excel::store(new MonitorsHojaRutaExport($IdMonitoreo,$usuario,$usuario), 'monitoreo_'.$IdMonitoreo.'_HojaRuta.xlsx');
                    
                    // Se guarda en ./storage/app
                    $mensaje = "Monitoreo ".$IdMonitoreo." creado";

                    if($tipoCliente=="I")
                    {
                        $notificacion = "El cliente " . $cliente . " ha ingresado el monitoreo " . $IdMonitoreo . " sobre la unidad " . $placa;
                        DB::insert('exec spMonitoreoNotificacionesInsertar ?,?,?',array($IdMonitoreo,"Hunter Monitoreo - Ingreso Monitoreo",$notificacion));
                    }

                    
                    $correosBcc = array('lmoscoso@carsegsa.com','jvera@carsegsa.com');  //AlertarSesionRemota
                    $correosCc = array('centralmonitoreo@carsegsa.com','centrocontrolhunter@gmail.com');

                    
                    $mk = DB::select("select dbo.getEmaildeUsuarioHojaRutaMon('".$usuario."') AS mail")[0]->mail; //getEmaildeUsuarioHojaRutaMon(usuario)
                    $mailArreglo = explode('&',$mk);
                    $email = $mailArreglo[0];
                    $asunto = "Hunter Monitoreo - Ingreso Monitoreo";
                    $cuerpo = "El cliente ".$cliente." ha ingresado el monitoreo ".$IdMonitoreo." sobre la unidad ".$placa.".";
                    Log::info("MarioLogMail. Email: ".$email.'. IdMonitoreo: '.$IdMonitoreo.'. Placa: '.$placa);
                    $correo = new ConfirmarHojaRutaClienteMailable($cliente,$placa,$IdMonitoreo,$nombreArchivo,$asunto,$cuerpo);

                    Mail::to($email)->cc($correosCc)->bcc($correosBcc)->send($correo); 

                    if(Storage::exists($nombreArchivo)){
                        Storage::delete($nombreArchivo);
                    }
                

                


            }elseif ($tipoCliente=="E"||($tipoCliente=="I"&&$IdActivo==0)) {
                
                 DB::insert('exec spMonitoreoInfoAdicionalProvisionalingresar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array(  $usuario,
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
                $fechaHora = Carbon::now();
                $fechaHora = $fechaHora->format('dmY_His');
                $nombreArchivo = "HojaRutaMonitoreo-".$fechaHora.".xlsx";
                //Excel::store(new MonitorsHojaRutaExport(0,$usuario,$usuario),$nombreArchivo);
                Excel::store(new MonitorsHojaRutaExportExterno(
                $usuario,
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
                $correoSeveridad2),$nombreArchivo);

                $mk = DB::select("select dbo.getEmaildeUsuarioHojaRutaMon('".$usuario."') AS mail")[0]->mail; //getEmaildeUsuarioHojaRutaMon(usuario)
                $mailArreglo = explode('&',$mk);
                $email = $mailArreglo[0];
                $asunto = "Hunter Monitoreo - Ingreso Hoja Ruta";
                $cuerpo = "El cliente " . $cliente . " ha ingresado una hoja de ruta para su respectiva revisión y asignación de unidad ";
                $correo = new ConfirmarHojaRutaClienteMailable($cliente,$placa,0,$nombreArchivo,$asunto,$cuerpo);
                Mail::to($email)->cc('centralmonitoreo@carsegsa.com')->bcc($correosBcc)->send($correo); 

                if(Storage::exists($nombreArchivo)){
                    Storage::delete($nombreArchivo);
                }
            }

        } catch (\Throwable $th) {
            $mensaje = $th->getMessage();
            Log::info("MarioLogMail: ".$mensaje);
        }

        return response()->json($mensaje);
    }


    /***
     *  FIN
     */

    public function mostrarTodasAlertas(Request $request)
    {
        $IdMonitoreo = $request->idMonitoreo;
        $IdActivo = $request->idActivo;

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        

        
        //$alertasCrudas = DB::table('viemonitoreoD_Alerta')->select('idAlerta','Nombre')->where('idMonitoreo','=',$IdMonitoreo)->get();

        if($idSubUsuario=="0")
        {
            $alertasCrudas = DB::table('viemonitoreoD_Alerta')->select('idAlerta','Nombre')->where('idMonitoreo','=',$IdMonitoreo)->get();
        }else
        {
            $alertasCrudas = DB::table('viemonitoreoD_AlertaExterno')->select('idAlerta','Nombre')->where('idMonitoreo','=',$IdMonitoreo)->get();
        }
        
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
        
        //if(session('idApp')==7)
          //  return view('postventa.recorrido',compact('fecha'));
        //else
            return view('monitors.recorrido',compact('fecha'));
    }

    public function recorridoPostVenta()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y 23:59');

        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00');

        //if(session('idApp')==7)
            return view('postventa.recorrido',compact('fecha','fechaDesde'));
        //else
        //    return view('monitors.recorrido',compact('fecha'));
    }

    public function consultaSMS()
    {
        //$fechaHasta = Carbon::now();
        //$fecha = $fecha->format('d/m/Y H:i');
        //if(session('idApp')==7)
        //    return view('postventa.consultaSMS');
        //else
            return view('monitors.consultaSMS');
    }

    public function consultaSMSPostVenta()
    {
        $fechaHasta = Carbon::now();
        $fechaHasta = $fechaHasta->format('d/m/Y 23:59:59');
        $fechaDesde = Carbon::now()->subDays(7);
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00:00');
        $consultaSmsFechas = $fechaDesde ." - ".$fechaHasta;
        //if(session('idApp')==7)
        return view('postventa.consultaSMS',compact('consultaSmsFechas'));
        //else
        //    return view('monitors.consultaSMS');
    }

    public function buscarSMSpv(Request $request)
    {
        try {
            $buscar = $request->buscar;
            $opcionBusqueda = $request->opcionBusqueda;
            $buscarTiposDeMensajes = $request->buscarTiposDeMensajes; // R  Recibidos (SMPP) --- E Enviados (SMPP) ---   EX Enviados (XMPP)
            $consultaSmsFechas = $request->consultaSmsFechas;
            $consultaSmsFechasArreglo = explode(" - ",$consultaSmsFechas);
            $fechaDesde = $consultaSmsFechasArreglo[0];
            $fechaHasta = $consultaSmsFechasArreglo[1];

            $resultado = array();

       
            switch ($opcionBusqueda) {
                case 'celular':
    
                    
                    //$resultado = BuscarSMSPorCelular($buscar, $buscarTiposDeMensajes);
                    switch ($buscarTiposDeMensajes) {
                        case 'R':
                            $resultado = DB::select('exec spBuscarSmsRecibidosConFechaLv ?,?,?',array($buscar,$fechaDesde,$fechaHasta));
                            break;
                        case 'E':
                            $resultado = DB::select('exec spBuscarSmsEnviadosConFechaLv ?,?,?',array($buscar,$fechaDesde,$fechaHasta));
                            break;
                        default: //EX
                            $resultado = DB::select('exec spConsultaXMPPConFecha ?,?,?,?',array($buscar,'',$fechaDesde,$fechaHasta));
                            break;
                    }
                    break;
                
                default: //placa
                    switch ($buscarTiposDeMensajes) {
                        case 'R':
                            $resultado = DB::select('exec spBuscarSmsRecibidosPorMensajesConFechaLv ?,?,?',array($buscar,$fechaDesde,$fechaHasta));
                            break;
                        case 'E':
                            $resultado = DB::select('exec spBuscarSmsEnviadosPorMensajesConFechaLv ?,?,?',array($buscar,$fechaDesde,$fechaHasta));
                            break;
                        default: //EX
                            $resultado = DB::select('exec spConsultaXMPPConFecha ?,?,?,?',array('',$buscar,$fechaDesde,$fechaHasta));
                            break;
                    }
                    
                    break;
            }    
        } catch (\Throwable $th) {
            $resultado = $th->getMessage();
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



    /*************************
     * POST-VENTA
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *************************/

    public function pruebapv()
    {
        $celular = '593979362610';
        $opc = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular));
        //$opc = DB:select('select [10.100.97.200,4700].[RASTRACSERVER].[dbo].getTotalAlertasContestadasExterno (?,?,?) AS tar')

        foreach ($opc as $value) {
            return $value->Op;
        }
        return $opc[0];
        $op = $opc[0][0];
        return view('monitors.pruebapostventa', compact('op'));
    }

    public function consultaGeneral()
    {
        return view('postventa.consultaGeneral');
    }


    public function datosUsuarioConsultar(Request $request)
    {
        $buscar = $request->search;
        $criterio = $request->criterio;

        $unidades = array();
        $emailsms = array();

        $ip = \Request::ip();

        try {
            $entidades  = DB::select('exec spDatosUsuarioConsultar ?,?',array($buscar,$criterio));
           

            foreach($entidades as $entidad)
            {
                switch ($criterio) {
                    case '0':
                        $response[] = array("value"=>$entidad->IdEntidad, "label"=>$entidad->IdEntidad);
                        break;
                    
                    case '1':
                        $response[] = array("value"=>$entidad->Entidad, "label"=>$entidad->Entidad);
                        
                        break;
                    case '4':
                        $response[] = array("value"=>$entidad->Usuario, "label"=>$entidad->Usuario);
                        break;
                }
                
            }
        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
            
        
         return response()->json($response);
    }

    public function restablecerClave(Request $request)
    {
        $uid = $request->uid;
        $usuarioSesion = $request->usuarioSesion;
        $ip = \Request::ip();
        
        
        try
        {
            $keys = DB::select('exec spUsuarioConsultarKey ?',array($uid));
            $IdUsuario = $keys[0]->IdUsuario;
            $Usuario = $keys[0]->Usuario;
            $Nombre = $keys[0]->Nombre;
            $Clave = $keys[0]->Clave;
            $Estado = $keys[0]->Estado;
        }catch(\Throwable $th){
            $IdUsuario = -1;
            $response[] = $th->getMessage();
        }

        if($Estado!="A")
        {
            $response[] = "El Usuario no se encuentra en estado A, no se puede realizar la operación.";
        }else
        {
            try{
                $informacion = DB::select('exec spDatosUsuarioConsultarDetalle ?,?',array($Usuario,"4"));
                $email = $informacion[0]->Email;
                $sms = $informacion[0]->Celular;
                if($email=="")
                {
                    $response[] = "El Usuario no tiene un correo registrado, no se puede realizar la operación.";
                }else
                {
                    $claveRegistro = DB::select('exec getClaveRandom ?',array("6"));
                    $claveNueva = $claveRegistro[0]->Clave;
                    if($claveNueva!="")
                    {
                        DB::update('exec spUsuarioClaveActualizarCH ?,?',array($IdUsuario,$claveNueva));
                        
                        // Enviar Correo
                        $correosBcc = array('lmoscoso@carsegsa.com','jneira@carsegsa.com');  //AlertarSesionRemota


                        
                        $correo = new PostVentaResetClaveMailable($Usuario,$claveNueva);
                        Mail::to($email)->bcc($correosBcc)->send($correo);  //COMENTADO EN DESARROLLO
                        $response[] = "Contraseña nueva enviada con exito al usuario solicitado";

                        if($sms!="")
                        {
                            DB::insert('exec spSMSLIngresar ?,?,?',array($sms,"Estimado cliente una nueva clave de usuario para huntermonitoreo.com fue enviada a su email","admin@xadmin"));
                        }

                        DB::insert('exec spLogUsuarioGeoIngresar ?,?,?,?,?', array($Usuario,"SEND PASS","USUARIO: ".$usuarioSesion,"",$ip));
                    }
                      
                }
            }catch(\Throwable $th){
                
                $response[] = $th->getMessage();
            }
            
        }
        




        //$response['keys'] = $keys;
        
        return response()->json($response);

    }

    public function traeEntidadesPorVid(Request $request)
    {
        $vid = $request->search;
        //$response = array();
        //try {
            $response = DB::table('vieActivosEntidad')
                        ->select('IdEntidad')
                        ->where('VID','=',$vid)
                        ->get();
        //} catch (\Throwable $th) {
        //    $response[] = $th->getMessage();
        //}
        
        return response()->json($response);
    }

    public function unidadesUsuarioCriterio(Request $request)
    {
        $IdUsuario = $request->IdUsuario;
        $criterio = $request->Criterio;

        $ip = \Request::ip();
        
        $unidades_temp = DB::select('exec spActivosUsuarioConsultar ?,?',array($IdUsuario,$ip));
        $unidades = array();

        switch ($criterio) {
            case 'T':
                
                foreach ($unidades_temp as $unidad) {
                    try {
                        $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                    } catch (\Throwable $th) {
                        $unidad->Dispositivo = "N/D";
                    }
                    
                    if($unidad->Estado=="A"){
                        $unidad->Estado = "Activo";
                       
                    }
                    else{
                        $unidad->Estado = "Suspendido";
                        
                    }
                    $unidades[] = $unidad;
                }

                break;
            case 'A':
                foreach ($unidades_temp as $unidad) {
                    try {
                        $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                    } catch (\Throwable $th) {
                        $unidad->Dispositivo = "N/D";
                    }
                    
                    if($unidad->Estado=="A"){
                        $unidad->Estado = "Activo";
                        $unidades[] = $unidad;
                    }
                    
                    
                }
                break;
            case 'S':
                foreach ($unidades_temp as $unidad) {
                    try {
                        $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                    } catch (\Throwable $th) {
                        $unidad->Dispositivo = "N/D";
                    }
                    
                    if($unidad->Estado=="A"){
                        
                       
                    }
                    else{
                        $unidad->Estado = "Suspendido";
                        $unidades[] = $unidad;
                    }
                    
                    
                }
                break;
            case 'SC': //SimCards Cortadas
                foreach ($unidades_temp as $unidad) {
                    try {
                        $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                    } catch (\Throwable $th) {
                        $unidad->Dispositivo = "N/D";
                    }
                    
                    if($unidad->EstadoSIM=="COR"){
                        if($unidad->Estado=="A"){
                            $unidad->Estado = "Activo";
                           
                        }
                        else{
                            $unidad->Estado = "Suspendido";
                            
                        }
                        $unidades[] = $unidad;
                    }
                    
                    
                    
                }
                break;
                case 'NR': //No Reportando
                    foreach ($unidades_temp as $unidad) {
                        try {
                            $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                        } catch (\Throwable $th) {
                            $unidad->Dispositivo = "N/D";
                        }


                        if($unidad->VID)
                        { 
                            $registrosReportando = DB::table('ReportePosicion_Last')
                                                    //->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                                    ->select(DB::raw('DATEDIFF(MINUTE, FechaHoraRecibido,  dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                                    ->where('Id','=',$unidad->VID)
                                                    ->get();
                        

                
                            
                            try { 
                                if($registrosReportando)
                                {
                                    if($registrosReportando[0]->DifMin>5 && $registrosReportando[0]->EstadoIgnicion=="1")
                                    {   
                                        if($unidad->Estado=="A"){
                                            $unidad->Estado = "Activo";
                                           
                                        }
                                        else{
                                            $unidad->Estado = "Suspendido";
                                            
                                        }
                                        $unidades[] = $unidad;
                                    }else
                                    {    if($registrosReportando[0]->DifMin>65 && ($registrosReportando[0]->EstadoIgnicion=="0"||$registrosReportando[0]->EstadoIgnicion=='NULL'))
                                        {   
                                            if($unidad->Estado=="A"){
                                                $unidad->Estado = "Activo";
                                               
                                            }
                                            else{
                                                $unidad->Estado = "Suspendido";
                                                
                                            }
                                            $unidades[] = $unidad;
                                        }else 
                                        {
                                            
                                            //$DispositivosTransmitiendo++;
                                        }
                                    }
                                    
                                }
                            } catch (\Throwable $th) {
                                if($unidad->Estado=="A"){
                                    $unidad->Estado = "Activo";
                                   
                                }
                                else{
                                    $unidad->Estado = "Suspendido";
                                    
                                }
                                $unidades[] = $unidad;
                            }
                        }else
                        {
                            if($unidad->Estado=="A"){
                                $unidad->Estado = "Activo";
                               
                            }
                            else{
                                $unidad->Estado = "Suspendido";
                                
                            }
                            $unidades[] = $unidad;
                        }
                        
                        
                        
                        
                        
                    }
                    break;
            default:
                # code...
                break;
        }

        $response['unidades'] = $unidades;
        return $unidades;
        //return response()->json($response);

        
    }


    public function datosUsuarioConsultarDetalle(Request $request)
    {
        $buscar = $request->search;
        $criterio = $request->criterio;

        $unidades = array();
        $emailsms = array();
        $aplicaciones = array();

        $celulares = array();
        $emails = array();

        // CONTADORES
        $NumeroRegistros = 0;
        $VehiculosActivados = 0;
        $VehiculosDesactivados = 0;
        $DispositivosTransmitiendo = 0;
        $DispositivosDesactivados = 0;
        $SimActivas = 0;
        $SimDesactivadas = 0;

        $usuarioSesion = session('usuario');

        
        $ip = \Request::ip();

        try {
            $entidades  = DB::select('exec spDatosUsuarioConsultarDetalle ?,?',array($buscar,$criterio));
            $response = array();
    
            $cantidadEntidades = 0;
            foreach ($entidades as $entidad) {
                $cantidadEntidades++;
            }
    
            if($cantidadEntidades>0)
            {
                $IdUsuario = $entidades[0]->IdUsuario;
                $unidades_temp = DB::select('exec spActivosUsuarioConsultar ?,?',array($IdUsuario,$ip));

                //txUID.Text = BD.getUIDIdUsuario(Info.IdUsuario)
                $UID = DB::select('select dbo.getUIDIdUsuario (?) AS uid',array($IdUsuario))[0]->uid;
    
                
    
                foreach ($unidades_temp as $unidad) {
                    try {
                        $unidad->Dispositivo = DB::select('select dbo.getTipoDispositivo (?) AS disp',array($unidad->VID))[0]->disp;
                    } catch (\Throwable $th) {
                        $unidad->Dispositivo = "N/D";
                    }
                    
                    if($unidad->Estado=="A"){
                        $unidad->Estado = "Activo";
                        $VehiculosActivados++;
                    }
                    else{
                        $unidad->Estado = "Suspendido";
                        $VehiculosDesactivados++;
                    }


                    if($unidad->VID)
                    {
                        $registrosReportando = DB::table('ReportePosicion_Last')
                                                //->select(DB::raw('DATEDIFF(MINUTE, DATEADD(DAY, DATEDIFF(DAY, 0, FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)), 0),FechaHoraRecibido - dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                                ->select(DB::raw('DATEDIFF(MINUTE, FechaHoraRecibido,  dateadd(HOUR, -5, FechaHora)) as DifMin'),'EstadoIgnicion')
                                                ->where('Id','=',$unidad->VID)
                                                ->get();
                    

            
                        
                        try {
                            if($registrosReportando)
                            {
                                if($registrosReportando[0]->DifMin>5 && $registrosReportando[0]->EstadoIgnicion=="1")
                                {   
                                    $DispositivosDesactivados++;
                                }else
                                {    if($registrosReportando[0]->DifMin>65 && ($registrosReportando[0]->EstadoIgnicion=="0"||$registrosReportando[0]->EstadoIgnicion=='NULL'))
                                    {   
                                        $DispositivosDesactivados++;
                                    }else 
                                    {
                                        
                                        $DispositivosTransmitiendo++;
                                    }
                                }
                                
                            }
                        } catch (\Throwable $th) {
                            $DispositivosDesactivados++;
                        }
                    }else
                    {
                        $DispositivosDesactivados++;
                    }

                    if($unidad->EstadoSIM)
                    {
                        if(substr($unidad->EstadoSIM,0,1)=="A")
                            $SimActivas++;
                        else
                            $SimDesactivadas++;
                    }


    
                    $unidades[] = $unidad;
                    $NumeroRegistros++;
                }
    
                $emailsms_temp = DB::select('exec dbo.spUsuarioEmailSMSConsultar ?',array($IdUsuario));
                $emailsms = array();
                $aplicaciones = array();
                // Tipo Dato                  Propietario                           Operadora
                //  SMS	593989182824	DANIEL SIGIFREDO MARTINEZ REYES 
                foreach ($emailsms_temp as $emailsms_row) {
                    if($emailsms_row->Tipo=="SMS")
                    {
                        $celular = $emailsms_row->Dato;
                        try {
                            $resultados = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular)); //'1';
                            $op = $resultados[0]->Op;
                            $operadora = "";
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
                        } catch (\Throwable $th) {
                            $operadora = 'Indeterminado';
                        }
                        
                        $emailsms_row->Operadora = $operadora;
                    } 
                    $emailsms[] = $emailsms_row;
                }
    
                $aplicaciones = DB::table('vieUsuariosAplicacion')->where('IdUsuario','=',$IdUsuario)->get();
                $aplicacionesArray = array();
                foreach ($aplicaciones as $key => $value) {
                    array_push($aplicacionesArray,$value->IdAplicacion);
                }

                $aplicacionesTemp = DB::table('Aplicacion')->get();
                $aplicacionesTotales = array();

                foreach ($aplicacionesTemp as $key => $value) {
                    if(!in_array($value->IdAplicacion,$aplicacionesArray))
                    {
                        $aplicacionesTotales[] = $aplicacionesTemp;
                    }
                }




                /* CELULARES Y EMAIL */
                $IdUsuario = $entidades[0]->IdUsuario;
                $unidades_temp = DB::select('exec spActivosUsuarioConsultar ?,?',array($IdUsuario,$ip));

                //txUID.Text = BD.getUIDIdUsuario(Info.IdUsuario)
                $UID = DB::select('select dbo.getUIDIdUsuario (?) AS uid',array($IdUsuario))[0]->uid;
    
                $emails = DB::select('exec dbo.spUsuarioEmailConsultar ?',array($IdUsuario));
                $celulares = DB::select('exec dbo.spUsuarioSMSConsultar ?',array($IdUsuario));
        
    
    
    
            }

            /*foreach ($unidades as $key => $value) {
                $NumeroRegistros++;

            }*/
    
    
    
            
    
            switch ($criterio) {
                case '0':
                    foreach($entidades as $entidad){
                        $celular = '593'.substr($entidad->Celular,1);
                        try {
                            $resultados = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular)); //'0';
                            $op = $resultados[0]->Op;
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
                        } catch (\Throwable $th) {
                            $operadora = 'Indeterminado';
                        }
                        
                        $response['detalle'] = array($entidad->IdEntidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario.';'.$operadora);
                     }
                    break;
                case '1':
                    foreach($entidades as $entidad){
                        $celular = '593'.substr($entidad->Celular,1);
                        try {
                            $resultados = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular));
                            $op = $resultados[0]->Op;
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
                        } catch (\Throwable $th) {
                            $operadora = 'Indeterminado';
                        }
                        
                        $response['detalle'] = array($entidad->IdEntidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario.';'.$operadora);
                     }
                    break;
                case '4':
                    foreach($entidades as $entidad){
                        $celular = '593'.substr($entidad->Celular,1);
                        try {
                            $resultados = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular));
                            $op = $resultados[0]->Op;
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
                        } catch (\Throwable $th) {
                            $operadora = 'Indeterminado';
                        }
                        
                        $response['detalle'] = array($entidad->identidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario.';'.$operadora);
                     }
                    break;
                default:
                    # code...
                    break;
            }
            
            //$response['uid'] = $UID;
            //$response['usariosesion'] = $usuarioSesion;
            $response['datosAdicionales'] = array("uid"=>$UID,"usuarioSesion"=>$usuarioSesion);
            $response['unidades'] = $unidades;
            $response['emailsms'] = $emailsms;
            $response['aplicaciones'] = $aplicaciones;
            $response['aplicacionesTotales'] = $aplicacionesTotales;
            $response['contadores'] = array("NumeroRegistros"=>$NumeroRegistros,"VehiculosActivados"=>$VehiculosActivados,"VehiculosDesactivados"=>$VehiculosDesactivados,"DispositivosTransmitiendo"=>$DispositivosTransmitiendo,"DispositivosDesactivados"=>$DispositivosDesactivados,"SimActivas"=>$SimActivas,"SimDesactivadas"=>$SimDesactivadas);
    
            $response['celulares'] = $celulares;
            $response['emails'] = $emails;
            

        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        
        

        
         return response()->json($response);
    }

    public function eliminaAplicacionesUsuario(Request $request)
    {
        $IdUsuario = $request->IdUsuario;
        $IdAplicacion = 0;

        
        try {
            DB::delete('exec spUsuarioAplicacionEliminar ?,?',array($IdUsuario,$IdAplicacion));
            $response[] = "OK";    
        } catch (\Throwable $th) {
            $response[] = "ERROR AL ELIMINAR APLICACIONES".$th->getMessage();
        }
        return response()->json($response);
    }

    public function grabarAplicacionUsuario(Request $request)
    {
        $IdAplicacion = $request->IdAplicacion;
        $Usuario = $request->Usuario;
        $IdUsuario = $request->IdUsuario;

        
        try {
            DB::insert('exec spUsuarioAplicacionIngresar ?,?,?',array($IdUsuario,$IdAplicacion,$Usuario));
            $response[] = "OK"; 
        } catch (\Throwable $th) {
            $response[] = "ERROR AL INSERTAR".$th->getMessage();
        }
        return response()->json($response);
    }

    public function modificarAlias($IdActivo,$IdUsuario,$Alias,$Etiqueta = null)
    {
        return view('postventa.modificarAlias',compact('IdActivo','IdUsuario','Alias','Etiqueta'));
    }

    public function grabarModificarAlias(Request $request)
    {
        //bd.spDatosActivoModificar(IdActivo, nAlias, UsuarioModificacion, idUsuario, IP)
        $IdActivo = $request->IdActivo;
        $NuevoAlias = $request->NuevoAlias;
        $UsuarioModificacion = session('usuario');//$request->UsuarioModificacion;
        $IdUsuario = $request->IdUsuario;
        $nuevaEtiqueta = $request->NuevaEtiqueta;
        $IP=\Request::ip();
        $mensaje = '';

        //$mensaje = 'Alias actualizado satisfactoriamente_'.$IdActivo.'_'.$nuevoAlias.'_'.$IdUsuario.'_'.$UsuarioModificacion;

        //return redirect()->route('/alerts/message')->with('status',$mensaje);    
        
        if($NuevoAlias=='' && $nuevaEtiqueta=='')
            return redirect()->route('/alerts/messagepv')->with('status','No hay datos a actualizar, por favor verifique.');
        else
        {
            try {
                //DB::update('exec spDatosActivoModificar ?,?,?,?,?',array($IdActivo,$NuevoAlias, $UsuarioModificacion, $IdUsuario, $IP));
                // Nuevo SP
                $datos = $IdActivo.' - '.$NuevoAlias.' - '.$nuevaEtiqueta.' - '.$UsuarioModificacion.' - '.$IdUsuario.' - '.$IP;
                Log::info("MarioLogModificaAlias: ".$datos);

                if($NuevoAlias=='')
                {
                    DB::update('exec spDatosActivoModificarEtiquetaLv ?,?,?,?,?',array($IdActivo,$nuevaEtiqueta, $UsuarioModificacion, $IdUsuario, $IP));
                    $mensaje = 'Etiqueta actualizada correctamente.';
                }elseif ($nuevaEtiqueta=='') {
                    DB::update('exec spDatosActivoModificar ?,?,?,?,?',array($IdActivo,$NuevoAlias, $UsuarioModificacion, $IdUsuario, $IP));
                    $mensaje = 'Alias actualizado correctamente.';
                }else {
                    DB::update('exec spDatosActivoModificarLv ?,?,?,?,?,?',array($IdActivo,$NuevoAlias, $nuevaEtiqueta, $UsuarioModificacion, $IdUsuario, $IP));    
                    $mensaje = 'Alias y Etiqueta actualizadas correctamente.';
                }
                

                return redirect()->route('/alerts/messagepv')->with('status',$mensaje);    
            } catch (\Throwable $th) {
                $mensaje = 'ERROR: '.$th->getMessage();
                Log::info("MarioLogModificaAlias: ".$mensaje);
                return redirect()->route('/alerts/messagepv')->with('status',$mensaje);    
            }
        }
        
    }

    public function buscaOperadora(Request $request)
    {
        $search = $request->search;
        $celular = '593'.substr($search,1);
        try {
            $resultados = DB::select('exec [10.100.97.124,47000].[RASTRACSERVER].[dbo].spSMSGateWay ?',array($celular)); //'0';
            $op = $resultados[0]->Op;
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
        } catch (\Throwable $th) {
            $operadora = 'Indeterminado';
        }
        
        $response['Op'] = $operadora;
        return response()->json($response);

    }

    public function actualizarDatos(Request $request)
    {
        $IdEntidad = $request->IdEntidad;
        $IdUsuario = $request->IdUsuario;
        $Email = $request->Email;
        $Celular = $request->Celular;

        $UsuarioModificacion = session('nombre');
        $IP=\Request::ip();

        
        try {
            DB::update('exec spDatosEntidadModificar ?,?,?,?,?,?',array($IdEntidad,$Celular,$Email, $UsuarioModificacion, $IdUsuario, $IP));
            $response[] = "OK";
        } catch (\Throwable $th) {
            $mensaje = 'ERROR: '.$th->getMesssage();
            $response[] = $mensaje;
        }
        return response()->json($response);
    }

    public function editarConfiguracionActivo($IdActivo, $vid, $IdUsuario)
    {
        $idChoferActual=0;
        $configuracion = array();
        $choferes = array();

        $placa = DB::select('select dbo.BuscarPlacaCriterio (?,?) AS p',array($vid,2))[0]->p;
        $configuraciones = DB::select('exec spActivoConfiguracionConsultar ?,?',array($IdActivo,$IdUsuario));

        try {
            $configuracion = $configuraciones[0];
            $idChoferActual = $configuracion->idChoferActual;
            $tabla = 'CONDUCTOR';
            $choferes = DB::select('exec spLlenarCombo ?,?',array($tabla,$IdUsuario));
            
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }
        

        return view("postventa.configuracionActivo",compact('placa','configuracion','choferes','idChoferActual','IdUsuario','IdActivo'));
    }

    public function actualizarConfiguracionActivo(Request $request)
    {
        $IdActivo = $request->input('IdActivo');
        $Icono = "";
        $Actividad = $request->input('Actividad');
        $IdUsuario = $request->input('IdUsuario');
        $ConsumoPromedio = $request->input('ConsumoPromedio');
        $UnidadConsumo = $request->input('UnidadConsumo');
        $Chofer = $request->input('Chofer');
        $Etiqueta1 = $request->input('Etiqueta1');
        $Unidad1 = $request->input('Unidad1');
        $RangoMin1 = $request->input('RangoMin1');
        $RangoMax1 = $request->input('RangoMax1');
        $EscalaMin1 = $request->input('EscalaMin1');
        $EscalaMax1 = $request->input('EscalaMax1');
        $Etiqueta2 = $request->input('Etiqueta2');
        $Unidad2 = $request->input('Unidad2');
        $Alias = $request->input('RangoMin2');
        $RangoMin2 = $request->input('RangoMax2');
        $EscalaMin2 = $request->input('EscalaMin2');
        $EscalaMax2 = $request->input('EscalaMax2');
        $Etiqueta3 = $request->input('Etiqueta3');
        $Unidad3 = $request->input('Unidad3');
        $RangoMin3 = $request->input('RangoMin3');
        $RangoMax3 = $request->input('RangoMax3');
        $EscalaMin3 = $request->input('EscalaMin3');
        $EscalaMax3 = $request->input('EscalaMax3');

        

        try {
            DB::update('exec spActivoConfiguracionActualizar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdActivo,$Icono,$Actividad, $IdUsuario, $ConsumoPromedio, $UnidadConsumo,$Chofer,$Etiqueta1,$EscalaMin1,$EscalaMax1,$Unidad1,$RangoMin1,$RangoMax1,$Etiqueta2,$EscalaMin2,$EscalaMax2,$Unidad2,$RangoMin2,$RangoMax2,$Etiqueta3,$EscalaMin3,$EscalaMax3,$Unidad3,$RangoMin3,$RangoMax3));
            return redirect()->route('/alerts/messagepv')->with('status','Configuración actualizada satisfactoriamente');    
        } catch (\Throwable $th) {
            $mensaje = 'ERROR: '.$th->getMesssage();
            return redirect()->route('/alerts/messagepv')->with('status',$mensaje);    
        }

        //return $request;
    }

    public function reportesDisponibles()
    {
        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00:00');

        $fechaHasta = Carbon::now();
        $fechaHasta = $fechaHasta->format('d/m/Y 23:59:59');

        $fechaDesdeUnidadesSinReportar = Carbon::now();
        $fechaDesdeUnidadesSinReportar = $fechaDesdeUnidadesSinReportar->add(-7, 'day');
        $fechaDesdeUnidadesSinReportar = $fechaDesdeUnidadesSinReportar->format('d/m/Y');
        

        $fechaHastaUnidadesSinReportar = Carbon::now();
        $fechaHastaUnidadesSinReportar = $fechaHastaUnidadesSinReportar->format('d/m/Y');

        $fechaDesdeConsumoSMS = new Carbon('last day of last month');
        $fechaDesdeConsumoSMS = $fechaDesdeConsumoSMS->format('d/m/Y');
        $fechaHastaConsumoSMS = Carbon::now();
        $fechaHastaConsumoSMS = $fechaHastaConsumoSMS->format('d/m/Y');

        $fechaDesdeComandosEnviados = Carbon::now();
        $fechaDesdeComandosEnviados = $fechaDesdeComandosEnviados->add(-3,'day');
        $fechaDesdeComandosEnviados = $fechaDesdeComandosEnviados->format('Ymd 00:00:00');

        $fechaHastaComandosEnviados = Carbon::now();
        $fechaHastaComandosEnviados = $fechaHastaComandosEnviados->format('Ymd 23:59:59');



        return view('postventa.reportes',compact('fechaDesde','fechaHasta','fechaDesdeUnidadesSinReportar','fechaHastaUnidadesSinReportar','fechaDesdeConsumoSMS','fechaHastaConsumoSMS','fechaDesdeComandosEnviados','fechaHastaComandosEnviados'));
    }


    public function ActivoRecorridoConsultar(Request $request)
    {
        $uid = $request->uid;
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $placa = $request->placa;
        $usuario = session('nombre');

        try {
            $resultadoListaCorreos = DB::select('exec spEnviarEmailEntidadVID ?',array($uid));
            //IdEntidad	           TelefonoCelular	Email	              Estado
            //0992526742001**EG*01	0959487266	MARIA.GAVICA@AB-INBEV.COM	A

            $listaCorreos = array();
            foreach ($resultadoListaCorreos as $key => $value) {
                //array_push($listaCorreos,$value->Email);
                if($value->Email!='')
                    $listaCorreos[] = $value->Email;
            }

            $correosBcc = array('lmoscoso@carsegsa.com','jneira@carsegsa.com');  //AlertarSesionRemota


            //construct($placa,$usuario,$fechaDesde,$fechaHasta)
            $correo = new MensajeRegistrosRecorridoMailable($placa,$usuario,$fechaDesde,$fechaHasta);
            //Log::info('Mariolog  envio correo: '.$mailTo);
            
            
            

            $resultado = DB::select('exec spActivoRecorridoRConsultarXadminLv ?,?,?,?,?,?,?',array($uid, 'CUS', 'CUS', 0, '128.0.2.2', $fechaDesde, $fechaHasta));
            $response[] = $resultado;
            Mail::to($listaCorreos)->bcc($correosBcc)->send($correo);  //COMENTADO EN DESARROLLO
            
        } catch (\Throwable $th) {
            //$response[] = "Error: ".$th->getMessage();
        }
            
        
        return response()->json($response);
    }


    function UnidadesSinReportarConsultar(Request $request)
    {
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $resultado = DB::select('exec spVehiculosNoReportanEntre7y2 ?,?',array($fechaDesde, $fechaHasta));
        $response[] = $resultado;
        return response()->json($response);

    }

    function UnidadesSinEntidadConsultar(Request $request)
    {
        $resultado = array();
        $resultado = DB::select('exec spVehiculosHuerfanosLv');
        $response[] = $resultado;
        return response()->json($response);

    }

    function EntidadesSinUsuarioConsultar(Request $request)
    {
        $resultado = array();
        $resultado = DB::select('exec spEntidadSinUsuarios');
        $response[] = $resultado;
        return response()->json($response);

    }

    function ConsumoSMSConsultar(Request $request)
    {
        $celular = $request->celular;
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $resultado = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($celular, $fechaDesde, $fechaHasta, "1", "",""));
        $response[] = $resultado;
        return response()->json($response);

    }

    function DetalleSMS($datos)
    {
        $datosArreglo = explode("_",$datos);
        $numero = $datosArreglo[0];
        $fechaDesde = $datosArreglo[1];
        $fechaHasta = $datosArreglo[2];
        $nivel = "2";//$datosArreglo[3];
        $tipo = $datosArreglo[4];
        //return $datosArreglo;
        $registros = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($numero, $fechaDesde,$fechaHasta,"2",$tipo,""));
        //return $registros;
        $total = 0;
        foreach($registros as $registro)
        {
            $total = $total + $registro->CANTIDAD;
        }

        return view('postventa.detalleSMS',compact('numero','fechaDesde','fechaHasta','total','registros','tipo'));// $datosArreglo;
    }

    function DetalleSMSvid($datos)
    {
        $registros = array();
        $datosArreglo = explode("_",$datos);
        $numero = $datosArreglo[0];
        $fechaDesde = $datosArreglo[1];
        $fechaHasta = $datosArreglo[2];
        $tipo = $datosArreglo[3];
        $vid = $datosArreglo[4];
        //return $datosArreglo;
        $registros = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($numero, $fechaDesde,$fechaHasta,"3",$tipo,$vid));
        //return $registros;
        $total = 0;
        //foreach($registros as $registro)
        //{
        //    $total = $total + $registro->CANTIDAD;
        //}

        return view('postventa.detalleSMSvid',compact('numero','fechaDesde','fechaHasta','vid','registros'));// $datosArreglo;
    }

    function celularesEmails()
    {
        return view('postventa.celularesEmails');
    }

    public function datosUsuarioConsultarDetalle2(Request $request)
    {
        $buscar = $request->search;
        $criterio = $request->criterio;

        $celulares = array();
        $emails = array();
        
        $usuarioSesion = session('usuario');

        
        $ip = \Request::ip();

        try {
            $entidades  = DB::select('exec spDatosUsuarioConsultarDetalle ?,?',array($buscar,$criterio));
            $response = array();
    
            $cantidadEntidades = 0;
            foreach ($entidades as $entidad) {
                $cantidadEntidades++;
                $response['detalle'] = array($entidad->identidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario);

            }
     
            if($cantidadEntidades>0)
            {
                $IdUsuario = $entidades[0]->IdUsuario;
                $unidades_temp = DB::select('exec spActivosUsuarioConsultar ?,?',array($IdUsuario,$ip));

                //txUID.Text = BD.getUIDIdUsuario(Info.IdUsuario)
                $UID = DB::select('select dbo.getUIDIdUsuario (?) AS uid',array($IdUsuario))[0]->uid;
    
                
    
                
    
                $emails = DB::select('exec dbo.spUsuarioEmailConsultar ?',array($IdUsuario));
                $celulares = DB::select('exec dbo.spUsuarioSMSConsultar ?',array($IdUsuario));
        
    
    
    
            }

         
            $response['datosAdicionales'] = array("uid"=>$UID,"usuarioSesion"=>$usuarioSesion);
            $response['celulares'] = $celulares;
            $response['emails'] = $emails;
            
    
            
 

        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        
        
         return response()->json($response);
    }


    public function datosUsuarioConsultarDetalleConServidores(Request $request)
    {
        $buscar = $request->search;
        $criterio = $request->criterio;

        $celulares = array();
        $emails = array();
        
        $usuarioSesion = session('usuario');

        
        $ip = \Request::ip();

        $servidoresRegistrados = array();
        $servidoresDisponibles = array();

        try {
            $entidades  = DB::select('exec spDatosUsuarioConsultarDetalle ?,?',array($buscar,$criterio));
            $response = array();
            
    
            $cantidadEntidades = 0;
            foreach ($entidades as $entidad) {
                $cantidadEntidades++;
                $response['detalle'] = array($entidad->identidad.';'.$entidad->Entidad.';'.$entidad->Direccion.';'.$entidad->Celular.';'.$entidad->Convencional.';'.$entidad->Email.';'.$entidad->Usuario.';'.$entidad->IdUsuario);

            }
     
            if($cantidadEntidades>0)
            {
                $IdUsuario = $entidades[0]->IdUsuario;
                $servidoresRegistrados = DB::table('UsuarioServidorFoward')->where('id','=',$IdUsuario)->get();
                $servidoresDisponibles = DB::table('ServidorFoward')->orderby('NombreServidor')->get();
            }

            $response['servidoresRegistrados'] = $servidoresRegistrados;
            $response['servidoresDisponibles'] = $servidoresDisponibles;  
         
            
            
            
            
    
            


        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        
        
         return response()->json($response);
    }




    public function guardarNuevoCorreo(Request $request)
    {
        $IdUsuario = $request->IdUsuario;
        $correo = $request->correo;
        $propietario = $request->propietario;
        $usuario = session('usuario');
        

        try {
            DB::update('exec dbo.spUsuarioEmailIngresar ?,?,?,?',array($IdUsuario,$correo,$propietario,$usuario));
            $response['Resultado'] = "OK";
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        
        return response()->json($response);
    }

    public function guardarCorreoEdicion(Request $request)
    {
        try {
            $IdUsuario = $request->IdUsuario;
            $correo = $request->correo;
            $antiguoCorreo = $request->antiguoCorreo;
            $propietario = $request->propietario;
        
       //maria.gavica@ab-inbev.com - MARIA JOSE GAVIC - 112433 - maria.gavica@ab-inbev.com
        
            DB::update('exec dbo.spUsuarioEmailActualizar ?,?,?,?',array($IdUsuario,$propietario,$antiguoCorreo,$correo));
            $response['Resultado'] = "OK";//.$IdUsuario.' - '.$propietario.' - '.$antiguoCorreo.' - '.$correo;
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        return response()->json($response);
    }

    public function guardarNuevoCelular(Request $request)
    {
        $IdUsuario = $request->IdUsuario;
        $numero = $request->numero;
        $propietario = $request->propietario;
        $usuario = session('usuario');
        
        try {
            DB::update('exec dbo.spUsuarioSMSIngresar ?,?,?,?',array($IdUsuario,$numero,$propietario,$usuario));
            $response['Resultado'] = "OK";
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        return response()->json($response);
    }

    public function guardarCelularEdicion(Request $request)
    {
        $IdUsuario = $request->IdUsuario;
        $propietario = $request->propietario;
        $numero = $request->numero;
        $antiguoNumero = $request->antiguoNumero;


        try {
            DB::update('exec dbo.spUsuarioSMSActualizar ?,?,?,?',array($IdUsuario,$propietario,$antiguoNumero,$numero));
            $response['Resultado'] = "OK";
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        return response()->json($response);
    }

    public function eliminarCelular(Request $request)
    {
        $IdUsuario = $request->idUsuario;
        $numero = $request->numero;
        
        try {
            DB::delete('exec dbo.spUsuarioSMSEliminar ?,?',array($IdUsuario,$numero));
            $response['Resultado'] = "OK";
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        return response()->json($response);
    }

    public function eliminarCorreo(Request $request)
    {
        $IdUsuario = $request->idUsuario;
        $correo = $request->correo;
        
        
        try {
            DB::delete('exec dbo.spUsuarioEmailEliminar ?,?',array($IdUsuario,$correo));
            $response['Resultado'] = "OK";
        } catch (\Throwable $th) {
            $response['Resultado'] = "Error: ".$th->getMessage(); 
        }
        return response()->json($response);
    }

    public function reenvioDatos()
    {
        //$servidores = DB::table('ServidorFoward')->orderby('NombreServidor')->get();
        return view('postventa.reenvioDatos');
    }

    public function eliminaServidoresUnidad(Request $request)
    {
        $vid = $request->vid;
        $conteoVid = 0;
        $response[] = "OK";

        $conteoVid = DB::select('select dbo.getCountVID('.$vid.') AS c')[0]->c;
        
        try {
            if($conteoVid>0)
            {   
                DB::delete('exec spGPSUnitServidorfwdEliminar ?',array($vid));
                $response[] = "OK";    
            }
        } catch (\Throwable $th) {
            $response[] = "ERROR AL ELIMINAR SERVIDORES. ".$th->getMessage();
        }
        return response()->json($response);

    }

    public function grabarServidoresUnidad(Request $request)
    {
        $vid = $request->vid;
        $idServidor = $request->idServidor;

        $usuario = session('usuario');

        try {
            DB::insert('exec spGPSUnitServidorfwdIngresar ?,?,?',array($vid,$idServidor,$usuario));
            $response[] = "OK"; 
        } catch (\Throwable $th) {
            $response[] = "ERROR AL INSERTAR".$th->getMessage();
        }
        return response()->json($response);
    }

    public function eliminaServidoresPorUsuario(Request $request)
    {
        $idUsuario = $request->idUsuario;
        $conteoVid = 0;

        $response[] = "OK";
        
        try {
            $conteoVid = DB::select('select dbo.getCountVIDUsuario('.$idUsuario.') AS c')[0]->c;
            if($conteoVid>0)
            {   
                DB::delete('exec spGPSUnitServidorfwdUsuarioEliminar ?',array($idUsuario));
                $response[] = "OK";    
            }
        } catch (\Throwable $th) {
            $response[] = "ERROR AL ELIMINAR SERVIDORES POR USUARIO. ".$th->getMessage();
        }
        return response()->json($response);

    }

    public function grabarServidoresPorUsuario(Request $request)
    {
        $idUsuario = $request->idUsuario;
        $idServidor = $request->idServidor;

        $usuario = session('usuario');

        try {
            DB::insert('exec spGPSUnitServidorfwdUsuarioIngresar ?,?,?',array($idUsuario,$idServidor,$usuario));
            $response[] = "OK"; 
        } catch (\Throwable $th) {
            $response[] = "ERROR AL INSERTAR".$th->getMessage();
        }
        return response()->json($response);
    }


    

    public function buscarSMS(Request $request)
    {
        $buscar = $request->buscar;
        $opcionBusqueda = $request->opcionBusqueda;
        $buscarTiposDeMensajes = $request->buscarTiposDeMensajes; // R  Recibidos (SMPP) --- E Enviados (SMPP) ---   EX Enviados (XMPP)
    
        $consultaSmsFechas = $request->consultaSmsFechas;
        $fechaArreglo = explode(" - ",$consultaSmsFechas);
        $fechaDesde = $fechaArreglo[0];
        $fechaHasta = $fechaArreglo[1];

        $resultado = array();

        try {
            switch ($opcionBusqueda) {
                case 'celular':
    
                    
                    //$resultado = BuscarSMSPorCelular($buscar, $buscarTiposDeMensajes);
                    switch ($buscarTiposDeMensajes) {
                        case 'R':
                            $resultado = DB::select('exec spBuscarSmsRecibidosLv ?',array($buscar));
                            break;
                        case 'E':
                            $resultado = DB::select('exec spBuscarSmsEnviadosLv ?',array($buscar));
                            break;
                        default: //EX
                            $resultado = DB::select('exec spConsultaXMPP ?,?',array($buscar,''));
                            break;
                    }
                    break;
                
                default: //placa
                    switch ($buscarTiposDeMensajes) {
                        case 'R':
                            $resultado = DB::select('exec spBuscarSmsRecibidosPorMensajesLv ?',array($buscar));
                            break;
                        case 'E':
                            $resultado = DB::select('exec spBuscarSmsEnviadosPorMensajesLv ?',array($buscar));
                            break;
                        default: //EX
                            $resultado = DB::select('exec spConsultaXMPP ?,?',array('',$buscar));
                            break;
                    }
                    
                    break;
            }    
        } catch (\Throwable $th) {
            $resultado = $th->getMessage();
        }
        
        $response = array();
        return response()->json($resultado);


    }

    public function consultaCorreosEnviados()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y 23:59');

        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00');
        
        return view('postventa.consultaCorreosEnviados',compact('fecha','fechaDesde'));
    }
    
    function consultaCorreosEnviadosPost(Request $request)
    {
        
        try {
            $buscar = $request->buscar;
            $fechaDesde = $request->fechaDesde;
            $fechaHasta = $request->fechaHasta;
            $resultado = array();
            /*$resultado = DB::table('EmailLOG')
                     ->select('FechaHoraEnviado','TO','CC','BCC','Subject','Body')
                     ->where('TO','like','%'.$buscar.'%')
                     ->orWhere('Subject','like','%'.$buscar.'%')
                     ->whereDate('FechaHoraEnviado','>=',$fechaDesde)
                     ->whereDate('FechaHoraEnviado','<=',$fechaHasta)  
                     ->limit(15000)
                     ->get();*/
            $resultado = DB::select('exec spBuscarCorreosEnviadosLv ?,?,?',array($buscar,$fechaDesde,$fechaHasta));
            $response[] = $resultado;
        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        //$resultado = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($celular, $fechaDesde, $fechaHasta, "1", "",""));
        

        return response()->json($response);

    }
    

    public function consultaReenvioDatos()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('d/m/Y 23:59');

        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00');
        
        return view('postventa.consultaReenvioDatos',compact('fecha','fechaDesde'));
    }
    
    function consultaReenvioDatosPost(Request $request)
    {
        $buscar = $request->buscar;
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $resultado = array();
        try {
            $resultado = DB::table('SwitchParserLOG')//DATEADD(hour,-5,FechaHoraOcurrencia)
                     ->select(DB::raw('DATEADD(HOUR,-5,FechaHora) as FechaHora'),'FechaHoraTransaccion','Evento','Destino','Respuesta')
                     ->where('vid','like','%'.$buscar.'%')
                     ->whereDate('FechaHoraTransaccion','>=',$fechaDesde)
                     ->whereDate('FechaHoraTransaccion','<=',$fechaHasta)  
                     //->limit(100)
                     ->get();
            $response[] = $resultado;
        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        //$resultado = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($celular, $fechaDesde, $fechaHasta, "1", "",""));
        

        return response()->json($response);

    }

    function ConsultarComandos(Request $request)
    {
        $vid = $request->vid;
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $resultado = array();
        try {
            $resultado = DB::select('exec spBuscarComandoEnviado ?,?,?',array($vid,$fechaDesde,$fechaHasta));
                    
            $response[] = $resultado;
        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        //$resultado = DB::select('exec spConsumoSMS ?,?,?,?,?,?',array($celular, $fechaDesde, $fechaHasta, "1", "",""));
        

        return response()->json($response);

    }

    function consultaUsuariosCorreoCelular()
    {
        return view('postventa.consultaCorreoSMS');   
    }

    function consultaUsuariosCorreoCelularPost(Request $request)
    {
        $buscar = $request->buscar;
        $resultado = array();
        try {
            $resultado = DB::table('Entidad')
                        ->join('vieUsuarioEntidad','Entidad.IdEntidad','=','vieUsuarioEntidad.IdEntidad')
                        ->select('vieUsuarioEntidad.IdEntidad','vieUsuarioEntidad.Usuario','vieUsuarioEntidad.Nombre','Entidad.Email','Entidad.TelefonoCelular','Entidad.TelefonoConvencional')
                        ->where('Entidad.Email','like','%'.$buscar.'%')
                        ->orWhere('Entidad.TelefonoCelular','like','%'.$buscar.'%')
                        ->get();
            $response[] = $resultado;
        } catch (\Throwable $th) {
            $response[] = $th->getMessage();
        }
        return response()->json($response);
    }

}
