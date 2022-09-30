<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use XAdmin\Alert;
use XAdmin\Exports\AlertsExportSeguimientoAlertas;
use XAdmin\Exports\AlertsExportAlertasPorMonitorista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use DateTime;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo = "1";
        $cia = "*";
        $mod = "0";

        $gruposUsuario = array();

        $pendientes = DB::select('exec spAlertasConsultaPendientes');
        $cantidadPendientes = sizeof($pendientes);

        try {
            Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

       // $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$cia)); Se agregan subusuarios


        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Antes de consultar alertas'.$fechaAhora);
        if($idSubUsuario=="0")
       {
           // ES UN USUARIO INTERNO - TODO IGUAL
           $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$cia));

       }else
       {
           // ES UN USUARIO EXTERNO (SUBUSUARIO)
           Log::info('ES USUARIO EXTERNO');
           if($idCategoria=="9")
           {
               // ES UN SUPERVISOR EXTERNO - PERFILES 4
               
               $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));

               //select * from Grupo where IdUsuario=112433 AND
               //IdGrupo IN (select idGrupo from SubUsuarioGrupo sug where  idUsuario=112433)
               $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->get();//->whereIn('IdGrupo',function($query){
                //$query->select('idGrupo')->from('SubUsuarioGrupo')->where('idUsuario','=','112433');
               //})->get();
               
               Log::info('ha cargado supervisor');

           }else if($idCategoria=="10")
           {
               // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
               $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
               $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->whereIn('IdGrupo',function($query) use($idSubUsuario){
                $query->select('idGrupo')->from('SubUsuarioGrupo')->where('idUsuario','=','112433')->where('IdSubUsuario','=',$idSubUsuario);
               })->get();
               //return $gruposUsuario;
               Log::info('ha cargado operador');
           }
       }

       $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Despues de consultar alertas'.$fechaAhora);



        DB::update('exec spActualizarFalsasSiendoAtendida');
        Log::info('ha actualziado');


        return view('alerts.index', compact('alertas','mod','cantidadPendientes','gruposUsuario'));
    }

    public function alertasAgrupadasPorVehiculoAnterior()
    {
        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        if($idCategoria=="9")
        {
            // ES UN SUPERVISOR EXTERNO - PERFILES 4
            $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));
            $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->get();
        }else if($idCategoria=="10")
        {
            // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
           $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
           $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->whereIn('IdGrupo',function($query) use($idSubUsuario){
            $query->select('idGrupo')->from('SubUsuarioGrupo')->where('idUsuario','=','112433')->where('IdSubUsuario','=',$idSubUsuario);
           })->get();
         
        }
        
        
        $alertasVehiculo = array();
        $alertasVehiculoTotales = array();
        foreach($alertas as $val) {
            $alertasVehiculo[$val->VID][] = $val;
            
        }
        $totalContador = 0;
        $totalVerdes = 0;
        $totalAmarillas = 0;
        $totalNaranjas = 0;
        $totalRojas = 0;

        foreach ($alertasVehiculo as $key => $alertaVehiculo) {
            $contador = 0;
            $cantidadVerdes = 0;
            $cantidadAmarillas = 0;
            $cantidadNaranjas = 0;
            $cantidadRojas = 0;
            foreach ($alertaVehiculo as $key1 => $value) {
                $contador++;
                $totalContador++;
                if($value->EstadoAlarma=='')
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                
                if($value->EstadoAlarma==0)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                
                if($value->EstadoAlarma==1)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                if($value->EstadoAlarma==2)
                {
                    $cantidadNaranjas++;
                    $totalNaranjas++;
                }
                    
                if($value->EstadoAlarma==5)
                {
                    $cantidadRojas++;
                    $totalRojas++;
                }

                if($value->SiendoAtendida==1)
                {
                    $cantidadVerdes++;
                    $totalVerdes++;
                }
            }
            $alertasVehiculoTotales[$key]['totales'] = $contador;
            $alertasVehiculoTotales[$key]['verdes'] = $cantidadVerdes;
            $alertasVehiculoTotales[$key]['amarillas'] = $cantidadAmarillas;
            $alertasVehiculoTotales[$key]['naranjas'] = $cantidadNaranjas;
            $alertasVehiculoTotales[$key]['rojas'] = $cantidadRojas;
        }


        

        
        $tabla = 'MOTIVORECLAMOCONTROL';
        $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'3'));
            
        $fechaAccion = now()->format('d/m/Y H:i:s');


        //return $alertasVehiculo;
        return view('alerts.alertasAgrupadasPorVehiculo',compact('alertasVehiculo','fechaAccion','comboMotivoAlerta','alertasVehiculoTotales','totalContador','totalAmarillas','totalVerdes','totalNaranjas','totalRojas'));
    }

    public function alertasAgrupadasPorVehiculo()
    {
        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        if($idCategoria=="9")
        {
            // ES UN SUPERVISOR EXTERNO - PERFILES 4
            $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));
            $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->get();
        }else if($idCategoria=="10")
        {
            // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
           $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
           $gruposUsuario = DB::table('Grupo')->select('Grupo','IdGrupo')->where('IdUsuario','=','112433')->whereIn('IdGrupo',function($query) use($idSubUsuario){
            $query->select('idGrupo')->from('SubUsuarioGrupo')->where('idUsuario','=','112433')->where('IdSubUsuario','=',$idSubUsuario);
           })->get();
         
        }
        
        
        $alertasVehiculo = array();
        $alertasVehiculoTotales = array();
        foreach($alertas as $val) {
            $alertasVehiculo[$val->VID][] = $val;
            
        }
        $totalContador = 0;
        $totalVerdes = 0;
        $totalAmarillas = 0;
        $totalNaranjas = 0;
        $totalRojas = 0;
        $totalVehiculos = 0;

        foreach ($alertasVehiculo as $key => $alertaVehiculo) {
            $totalVehiculos++;
            $contador = 0;
            $cantidadVerdes = 0;
            $cantidadAmarillas = 0;
            $cantidadNaranjas = 0;
            $cantidadRojas = 0;
            foreach ($alertaVehiculo as $key1 => $value) {
                $contador++;
                $totalContador++;
                if($value->EstadoAlarma=='')
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                
                if($value->EstadoAlarma==0)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                
                if($value->EstadoAlarma==1)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                if($value->EstadoAlarma==2)
                {
                    $cantidadNaranjas++;
                    $totalNaranjas++;
                }
                    
                if($value->EstadoAlarma==5)
                {
                    $cantidadRojas++;
                    $totalRojas++;
                }

                if($value->SiendoAtendida==1)
                {
                    $cantidadVerdes++;
                    $totalVerdes++;
                }
            }
            $alertasVehiculoTotales[$key]['totales'] = $contador;
            $alertasVehiculoTotales[$key]['verdes'] = $cantidadVerdes;
            $alertasVehiculoTotales[$key]['amarillas'] = $cantidadAmarillas;
            $alertasVehiculoTotales[$key]['naranjas'] = $cantidadNaranjas;
            $alertasVehiculoTotales[$key]['rojas'] = $cantidadRojas;
        }


        

        
        $tabla = 'MOTIVORECLAMOCONTROL';
        $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'3'));
            
        $fechaAccion = now()->format('d/m/Y H:i:s');


        //return $alertasVehiculo;
        return view('alerts.alertasAgrupadasPorVehiculo',compact('alertasVehiculo','fechaAccion','comboMotivoAlerta','alertasVehiculoTotales','totalContador','totalAmarillas','totalVerdes','totalNaranjas','totalRojas','gruposUsuario','totalVehiculos'));
    }

    public function alertasAgrupadasPorVehiculoPost(Request $request)
    {
        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        $grupo = $request->grupo;

        /*if($idCategoria=="9")
        {
            // ES UN SUPERVISOR EXTERNO - PERFILES 4
            $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));
        }else if($idCategoria=="10")
        {
            // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
           $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
         
        }*/

        if($grupo=="0")
        {
            // ES UN USUARIO EXTERNO (SUBUSUARIO)
            if($idCategoria=="9")
            {
                // ES UN SUPERVISOR EXTERNO - PERFILES 4
                $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));

            }else if($idCategoria=="10")
            {
                // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
                $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
            }
        }else
        {
            if($idCategoria=="9")
            {
                $alertas = DB::select('exec spAlertasConsultaPorGrupoSupervisor ?',array($grupo));
            }else
            {
                $alertas = DB::select('exec spAlertasConsultaPorGrupoOperador ?,?',array($grupo,$idSubUsuario));
            }
            
        }




        
        
        $alertasVehiculo = array();
        foreach($alertas as $val) {
            $alertasVehiculo[$val->VID][] = $val;
            
        }

        $totalContador = 0;
        $totalVerdes = 0;
        $totalAmarillas = 0;
        $totalNaranjas = 0;
        $totalRojas = 0;

        foreach ($alertasVehiculo as $key => $alertaVehiculo) {
            $contador = 0;
            $cantidadVerdes = 0;
            $cantidadAmarillas = 0;
            $cantidadNaranjas = 0;
            $cantidadRojas = 0;
            foreach ($alertaVehiculo as $key1 => $value) {
                $contador++;
                $totalContador++;
                if($value->EstadoAlarma=='')
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                
                if($value->EstadoAlarma==0)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                
                if($value->EstadoAlarma==1)
                {
                    $cantidadAmarillas++;
                    $totalAmarillas++;
                }
                    
                if($value->EstadoAlarma==2)
                {
                    $cantidadNaranjas++;
                    $totalNaranjas++;
                }
                    
                if($value->EstadoAlarma==5)
                {
                    $cantidadRojas++;
                    $totalRojas++;
                }

                if($value->SiendoAtendida==1)
                {
                    $cantidadVerdes++;
                    $totalVerdes++;
                }
            }
            $alertasVehiculoTotales[$key]['totales'] = $contador;
            $alertasVehiculoTotales[$key]['verdes'] = $cantidadVerdes;
            $alertasVehiculoTotales[$key]['amarillas'] = $cantidadAmarillas;
            $alertasVehiculoTotales[$key]['naranjas'] = $cantidadNaranjas;
            $alertasVehiculoTotales[$key]['rojas'] = $cantidadRojas;
        }

        
        

        $response['alertasVehiculo'] = $alertasVehiculo;
        $response['alertasVehiculoTotales'] = $alertasVehiculoTotales;
        $response['alertasTotales'] = [$totalContador,$totalVerdes, $totalAmarillas, $totalNaranjas, $totalRojas];
        
        return response()->json($response);

        //return view('alerts.alertasAgrupadasPorVehiculo',compact('alertasVehiculo','fechaAccion','comboMotivoAlerta'));
    }


    public function storeGroup(Request $request)
    {
        //return $request;


        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        //$usuario = Auth::user()->Usuario;
        $nombreUsuario = session('nombre');//Auth::user()->Nombre;

        try {
            //Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            //Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = session('usuario');//Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $gestion = "";

        if($request->input("gestionRealizada"))
            $gestion = $request->input("gestionRealizada");
        else
            $gestion = "";
        
        if($gestion=="null")
            $gestion = "";

        $fechaAccion = $request->fechaAccion;
        $cambiaEstadoAlarma = $request->input("comboCambiarEstado");
        $motivoAlerta = $request->input("comboMotivoAlerta");
        $vehiculoSecuencia = $request->vehiculoSecuencias;

        $alertaRepetida = $request->has("chkAlertaRepetida");
        $datosIncorrectos = $request->has("chkDatosIncorrectos");

        if($motivoAlerta == null)
            $motivoAlerta='';
        
        //if($tipoDispositivo == null)
        //    $tipoDispositivo = '';

        
            if($request->has("chkDetenido"))
            {
                $gestion = $gestion . "\DETENCION";
            }
            if($request->has("chkLlamada"))
            {
                $gestion = $gestion . "\LLAMADA";
            }
            if($request->has("ckhNovedad"))
            {
                $gestion = $gestion . "\NOVEDAD";
            }
        

        $enviarCaso = $request->has("chkEnviarCaso");

        if($enviarCaso)
            $enviarCaso = "True";
        else
            $enviarCaso = "False";
        
        if($alertaRepetida)
            $alertaRepetida = "True";
        else
            $alertaRepetida = "False";

        if($datosIncorrectos)
            $datosIncorrectos = "True";
        else
            $datosIncorrectos = "False";



        $arregloVehiculoSecuencia = explode(";",$vehiculoSecuencia);

        $numeroSecuencias = count($arregloVehiculoSecuencia)-1;
        
        Log::info('Mariolog secuencias: '.$vehiculoSecuencia);
        
        for ($i=1; $i<=$numeroSecuencias; $i++)
        {
            $secuencia = $arregloVehiculoSecuencia[$i];
            Log::info('Mariolog secuencia: '.$secuencia);

        


            $alerta = DB::select('exec spAlertaSecuenciaConsultarLv ?',array($secuencia));
            //IdMonitoreo	IdAlerta	IdActivo	VID	         NivelBateria	TipoMonitoreo	FechaHoraInicio	           FechaHoraFin         	Tipo	Nombre	         NombreAlerta	FechaHoraOcurrencia	FechaHoraRegistro	DireccionAlerta	Producto	TipoDispositivo	NombreCompleto	Placa	CodSysHunter	Marca	Modelo	Direccion	Convencional	Celular	Email	chasis	motor	id_estado	descripcion_estado	Latitud	Longitud
            //19531	        437294	     35694	   1002075591   NO DISPONIBLE	2	             2016-01-01 08:00:00.000	2020-12-31 23:50:00.000	ROJO	ALERTA DE IMPACTO	Evento	1969-12-31 19:01:19.000	2016-02-04 10:00:08.080	De los Cedros,Quito,Quito	HUNTER GPS HMT	CALAMP LMU2720	PATRICIO JOHNSON LOPEZ 	PCL7336	1002075591	TOYOTA	BB 4RUNNER LTD TA 4.0 5P 4X4				hmonitoreouio@gmail.com	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	-0,1230728	-78,48123
            
            $fechaOcurrencia = $alerta[0]->FechaHoraOcurrencia;
            list($fecha,$tiempo) = explode(" ",$fechaOcurrencia);
            list($anio,$mes,$dia) = explode("-",$fecha);
            list($hora,$minuto,$segundo) = explode(":",$tiempo);
            $timestampFechaOcurrencia = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
            $fechaOcurrencia = date("d/m/Y H:i:s",$timestampFechaOcurrencia);

            $fechaRegistro = $alerta[0]->FechaHoraRegistro;
            list($fecha,$tiempo) = explode(" ",$fechaRegistro);
            list($anio,$mes,$dia) = explode("-",$fecha);
            list($hora,$minuto,$segundo) = explode(":",$tiempo);
            $timestampFechaRegistro = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
            $fechaRegistro = date("d/m/Y H:i:s",$timestampFechaRegistro);

            $fechaGestion = $request->input('fechaAccion');
            //return $fechaGestion; 03/03/2022 14:31:30
            list($fecha,$tiempo) = explode(" ",$fechaGestion);
            list($dia,$mes,$anio) = explode("/",$fecha);
            list($hora,$minuto,$segundo) = explode(":",$tiempo);
            $timestampFechaGestion = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
            $fechaGestion = date("Ymd H:i:s",$timestampFechaGestion);


            DB::insert('exec spAlertaSeguimientoIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($alerta[0]->IdActivo, $alerta[0]->IdMonitoreo, $alerta[0]->IdAlerta, $alerta[0]->NombreCompleto, $alerta[0]->Placa, $alerta[0]->Marca, $alerta[0]->Modelo, $alerta[0]->Producto, $alerta[0]->TipoDispositivo, $alerta[0]->Nombre, $alerta[0]->NombreAlerta, $alerta[0]->Tipo, $cambiaEstadoAlarma, $fechaOcurrencia, $fechaGestion, $usuario, $nombreUsuario, $gestion, $enviarCaso, $secuencia, $alerta[0]->VID, $alerta[0]->CodSysHunter, $alerta[0]->chasis, $alerta[0]->motor, $alerta[0]->id_estado, $alerta[0]->descripcion_estado, $fechaRegistro, $motivoAlerta, $alertaRepetida, $datosIncorrectos));
                
        }

        return redirect()->route('alertasAgrupadasPorVehiculo')->with('status','Alertas gestionadas con éxito');



    }

    public function indexCompany($cia)
    {
        $tipo = "1";
        //$cia = "*";
        $mod = "0";

        $pendientes = DB::select('exec spAlertasConsultaPendientes');
        $cantidadPendientes = sizeof($pendientes);

        $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$cia));
        DB::update('SET NOCOUNT ON ; exec spActualizarFalsasSiendoAtendida');



        return view('alerts.index', compact('alertas','mod','cantidadPendientes'));
    }

    public function buscarAlertasCliente(Request $request)
    {
        $tipo = "1";
        $idEntidad = $request->idEntidad;
        $mod = "0";

        //$pendientes = DB::select('exec spAlertasConsultaPendientes');
        //$cantidadPendientes = sizeof($pendientes);

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



        //$alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$idEntidad));

        if($idSubUsuario=="0")
       {
           // ES UN USUARIO INTERNO - TODO IGUAL
           $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$cia));

       }else
       {
           // ES UN USUARIO EXTERNO (SUBUSUARIO)
           if($idCategoria=="9")
           {
               // ES UN SUPERVISOR EXTERNO - PERFILES 4
               $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idSubUsuario));

           }else if($idCategoria=="10")
           {
               // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
               $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
           }
       }
        
        
        DB::update('SET NOCOUNT ON ; exec spActualizarFalsasSiendoAtendida');
        $response['data'] = $alertas;

        return response()->json($response);
        //return view('alerts.index', compact('alertas','mod','cantidadPendientes'));
    }

    public function getCustomers(Request $request)
    {
            $search = $request->search;

            if($search == ''){
            }
            else{
                $response = array();
                $clientes = DB::table('Cliente')->orderby('Nombres','asc')->select('IdEntidad','Nombres')->where('Nombres', 'like', '%' . $search . '%')->limit(100)->get();
                     foreach($clientes as $cliente){
                        $response[] = array("label"=>$cliente->Nombres,"value"=>$cliente->IdEntidad);
                     }
            }
            
      
            return response()->json($response);
         
    }


    public function indexPendientes()
    {
        $tipo = "1";
        $cia = "*";
        $mod = "1";
        $alertas = DB::select('exec spAlertasConsultaPendientes');
        $cantidadPendientes = sizeof($alertas);
        DB::update('SET NOCOUNT ON ; exec spActualizarFalsasSiendoAtendida');
        return view('alerts.index', compact('alertas','mod','cantidadPendientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //$request->validate([
        //    'gestionRealizada' => 'required|alpha_num'
        //]);
       


        if (false)
            return redirect()->back()->withInput();
        
        $IdActivo = $request->input('IdActivo');
        $IdMonitoreo = $request->input('IdMonitoreo');
        $IdAlerta = $request->input('IdAlerta');
        $nombreCliente = $request->input('nombreCliente');
        $placa = $request->input('placaCliente');
        $marca = $request->input('marcaCliente');
        $modelo = $request->input('modeloCliente');
        $producto = $request->input('Producto');
        $tipoDispositivo = $request->input('TipoDispositivo');
        $alerta = $request->input('alerta');
        $tipoAlerta = $request->input('tipoAlerta');
        $estadoAlarma = $request->input('estadoAlarma');
        $cambiaEstadoAlarma = $request->input('comboCambiarEstado');

        $fechaIngreso = $request->input("fechaOcurrencia");
        $fechaAccion = $request->input('fechaAccion');

        //$usuario = Auth::user()->Usuario;
        $nombreUsuario = session('nombre');//Auth::user()->Nombre;

        try {
            //Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            //Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = session('usuario');//Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $gestion = "";

        if($request->input("gestionRealizada"))
            $gestion = $request->input("gestionRealizada");
        else
            $gestion = "";
        
        if($gestion=="null")
            $gestion = "";

        $secuencia = $request->input("secuencia");
        $vid = $request->input("vid");
        $codSysHunter = $request->input("csh");
        $chasis = $request->input("chasis");
        $motor = $request->input("motor");
        $id_estado = $request->input("id_estado");
        $descripcion_estado = $request->input("descripcion_estado");
        $motivoAlerta = $request->input("comboMotivoAlerta");
        $alertaRepetida = $request->has("chkAlertaRepetida");
        $datosIncorrectos = $request->has("chkDatosIncorrectos");

        

        if($motivoAlerta == null)
            $motivoAlerta='';
        if($producto == null)
            $producto = '';
        if($tipoDispositivo == null)
            $tipoDispositivo = '';

        if($producto == '')
        {
            if($request->has("chkDetenido"))
            {
                $gestion = $gestion . "\DETENCION";
            }
            if($request->has("chkLlamada"))
            {
                $gestion = $gestion . "\LLAMADA";
            }
            if($request->has("ckhNovedad"))
            {
                $gestion = $gestion . "\NOVEDAD";
            }
        }

        $enviarCaso = $request->has("chkEnviarCaso");

        if($enviarCaso)
            $enviarCaso = "True";
        else
            $enviarCaso = "False";
        
        if($alertaRepetida)
            $alertaRepetida = "True";
        else
            $alertaRepetida = "False";

        if($datosIncorrectos)
            $datosIncorrectos = "True";
        else
            $datosIncorrectos = "False";

        
        $fechaOcurrencia = $request->input("fechaOcurrencia");
        $fechaGestion = $request->input('fechaAccion');
        
            
        $arregloParaVer = array();
        $arregloParaVer['IdActivo'] = $IdActivo ;
        $arregloParaVer['IdMonitoreo'] = $IdMonitoreo ;
        $arregloParaVer['IdAlerta'] = $IdAlerta;
        $arregloParaVer['nombreCliente'] = $nombreCliente ;
        $arregloParaVer['placaCliente'] = $placa ;
        $arregloParaVer['marcaCliente'] = $marca ;
        $arregloParaVer['modeloCliente'] = $modelo ;
        $arregloParaVer['Producto'] = $producto ;
        $arregloParaVer['TipoDispositivo'] = $tipoDispositivo ;
        $arregloParaVer['alerta'] = $alerta;
        $arregloParaVer['tipoAlerta'] = $tipoAlerta ;
        $arregloParaVer['estadoAlarma'] = $estadoAlarma ;
        $arregloParaVer['comboCambiarEstado'] = $cambiaEstadoAlarma ;

        $fechaOcurrencia = $request->input("fechaOcurrencia");
        list($fecha,$tiempo) = explode(" ",$fechaOcurrencia);
        list($dia,$mes,$anio) = explode("/",$fecha);
        list($hora,$minuto,$segundo) = explode(":",$tiempo);
        $timestampFechaOcurrencia = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
        $fechaOcurrencia = date("d/m/Y H:i:s",$timestampFechaOcurrencia);

        $fechaRegistro = $request->input('fechaRegistro');
        list($fecha,$tiempo) = explode(" ",$fechaRegistro);
        list($dia,$mes,$anio) = explode("/",$fecha);
        list($hora,$minuto,$segundo) = explode(":",$tiempo);
        $timestampFechaRegistro = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
        $fechaRegistro = date("d/m/Y H:i:s",$timestampFechaRegistro);



        //$fechaOcurrencia  = date('d/m/Y H:i:s', strtotime($fechaOcurrencia));
        //$fechaOcurrencia = $fechaOcurrencia->format('d/m/Y H:i:s');

        $arregloParaVer['fechaOcurrencia'] = $fechaOcurrencia;

        $fechaGestion = $request->input('fechaAccion');
        list($fecha,$tiempo) = explode(" ",$fechaGestion);
        list($anio,$mes,$dia) = explode("-",$fecha);
        list($hora,$minuto,$segundo) = explode(":",$tiempo);
        $timestampFechaGestion = mktime($hora,$minuto,$segundo,$mes,$dia,$anio);
        $fechaGestion = date("Ymd H:i:s",$timestampFechaGestion);
        $arregloParaVer['fechaGestion'] = $fechaGestion;

        $arregloParaVer['fechaRegistro'] = $fechaRegistro = $request->input('fechaRegistro');

        if($timestampFechaRegistro < $timestampFechaOcurrencia)
        {
            $fechaRegistro = $fechaOcurrencia;
            $arregloParaVer['fechaRegistro'] = $fechaRegistro;
        }    

        

        $arregloParaVer['usuario'] = $usuario ;

        $arregloParaVer['gestionRealizada'] = $gestion ;
        $arregloParaVer['pendiente']= $enviarCaso;
        $arregloParaVer['secuencia'] = $secuencia ;
        $arregloParaVer['vid'] = $vid;
        $arregloParaVer['csh'] = $codSysHunter ;
        $arregloParaVer['chasis'] = $chasis ;
        $arregloParaVer['motor'] = $motor ;
        $arregloParaVer['id_estado'] = $id_estado;
        $arregloParaVer['descripcion_estado'] = $descripcion_estado ;
        $arregloParaVer['comboMotivoAlerta'] = $motivoAlerta ;
        $arregloParaVer['chkAlertaRepetida'] = $alertaRepetida ;
        $arregloParaVer['chkDatosIncorrectos'] = $datosIncorrectos ;

        //return $fechaOcurrencia;
        //return $arregloParaVer;
        
        

        try {
            DB::insert('exec spAlertaSeguimientoIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdActivo, $IdMonitoreo, $IdAlerta, $nombreCliente, $placa, $marca, $modelo, $producto, $tipoDispositivo, $alerta, $tipoAlerta, $estadoAlarma, $cambiaEstadoAlarma, $fechaOcurrencia, $fechaGestion, $usuario, $nombreUsuario, $gestion, $enviarCaso, $secuencia, $vid, $codSysHunter, $chasis, $motor, $id_estado, $descripcion_estado, $fechaRegistro, $motivoAlerta, $alertaRepetida, $datosIncorrectos));
                    
            $SecuenciasXAtender = DB::select('exec spAlertasXAtender ?,?,?,?',array($IdActivo, $IdMonitoreo, $IdAlerta,$secuencia));
            
            foreach($SecuenciasXAtender as $secuenciaxatender)
            {
                if($request->has('CheckSecuencia_'.$secuenciaxatender->Secuencia))
                {
                    DB::insert('exec spAlertaSeguimientoIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdActivo, $IdMonitoreo, $IdAlerta, $nombreCliente, $placa, $marca, $modelo, $producto, $tipoDispositivo, $alerta, $tipoAlerta, $estadoAlarma, $cambiaEstadoAlarma, $secuenciaxatender->FechaOcurrencia, $fechaGestion, $usuario,$nombreUsuario, $gestion, 'False', $secuenciaxatender->Secuencia, $vid, $codSysHunter, $chasis, $motor, $id_estado, $descripcion_estado, $fechaRegistro, $motivoAlerta, $alertaRepetida, $datosIncorrectos));
            
                }     
               

                

                DB::update('exec spActualizarAlertaAtendida ?,?',array($secuenciaxatender->Secuencia,0));
                DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuenciaxatender->Secuencia,""));
            }
            
        } catch (Throwable $th) {

            DB::update('exec spActualizarAlertaAtendida ?,?',array($secuencia,0));
            DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuencia,""));
            
            $SecuenciasXAtender2 = DB::select('exec spAlertasXAtender ?,?,?,?',array($IdActivo, $IdMonitoreo, $IdAlerta,$secuencia));
            
            foreach($SecuenciasXAtender2 as $secuenciaxatender2)
            {
                DB::update('exec spActualizarAlertaAtendida ?,?',array($secuenciaxatender2->Secuencia,0));
                DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuenciaxatender2->Secuencia,""));
            }
            $error = 'COMUNICAR AL AREA ENCARGADA: '.$th->getMessage();
            return redirect()->back()->withErrors($error);
            
        }

        


        //return $request;
        //return view('alerts.message')->with('status','Alerta actualizado satisfactoriamente');
        return redirect()->route('/alerts/message')->with('status','Alerta actualizada satisfactoriamente');
        
        /*

                Dim SecuenciasXAtender = BD.spAlertasXAtender(txIdActivo.Text, txIdMonitoreo.Text, txIdAlerta.Text, CInt(Request.QueryString("REC")))
                    For Each Dato In SecuenciasXAtender
                        Try
                            BD.spActualizarAlertaAtendida(Dato.Secuencia, 0)
                            BD.spActualizarUsuarioRevisandoAlerta(Dato.Secuencia.ToString, "")
                        Catch exe As Exception
                            Console.Write(exe.Message)
                        End Try
                    Next
        
        
        */
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($secuencia,$client_id = '')
    {

        //$usuario = Auth::user()->Usuario;
        try {
            //Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            //Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
            $usuario = session('usuario');//$usuario = Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
            $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
        }

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        //return $client_id;

        if($secuencia!="0")
        {

            //return view('alerts.show',compact('alerta','infoAdicional','secuencia','fechaAccion','comboMotivoAlerta','mostrarChecksGestion','consultaPlanDeAccion','consultaUltimasGestiones','mod'));
            
           
        
            $alertaTemp = DB::select('exec spAlertaSecuenciaConsultarLv ?',array($secuencia));
            
            //Log::info('entra a show');
            DB::update('exec spActualizarAlertaAtendida ?,?',array($secuencia,1));
            DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuencia,$usuario));
            //Log::info('en show luego de actualizar');

            $idUsuario = session('idUsuario');
            $idSubUsuario = session('idSubUsuario');
            $idCategoria = session('idCategoria');
            $alerta = DB::select('exec spAlertaSecuenciaConsultarLv ?',array($secuencia));
            //IdMonitoreo	IdAlerta	IdActivo	VID	         NivelBateria	TipoMonitoreo	FechaHoraInicio	           FechaHoraFin         	Tipo	Nombre	         NombreAlerta	FechaHoraOcurrencia	FechaHoraRegistro	DireccionAlerta	Producto	TipoDispositivo	NombreCompleto	Placa	CodSysHunter	Marca	Modelo	Direccion	Convencional	Celular	Email	chasis	motor	id_estado	descripcion_estado	Latitud	Longitud
            //19531	        437294	     35694	   1002075591   NO DISPONIBLE	2	             2016-01-01 08:00:00.000	2020-12-31 23:50:00.000	ROJO	ALERTA DE IMPACTO	Evento	1969-12-31 19:01:19.000	2016-02-04 10:00:08.080	De los Cedros,Quito,Quito	HUNTER GPS HMT	CALAMP LMU2720	PATRICIO JOHNSON LOPEZ 	PCL7336	1002075591	TOYOTA	BB 4RUNNER LTD TA 4.0 5P 4X4				hmonitoreouio@gmail.com	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	-0,1230728	-78,48123

            
            $alertaSiendoAtendida = $alertaTemp[0]->SiendoAtendida;//DB::table('AlertaActivoMonitoreo')->select('SiendoAtendida')->where('IdAlerta','=',$alerta[0]->IdAlerta)->where('Secuencia','=',$secuencia)->get();
            //return $alertaSiendoAtendida;
            /*if($alertaSiendoAtendida[0]->SiendoAtendida=="1")
            {
                return redirect()->route('alerts')->withErrors('Alerta está siendo atendida.');
        
            }*/

            $tabla = 'MOTIVORECLAMOCONTROL';
            $mostrarChecksGestion = true;
            $paramtroMotivoAlertas = '3';

            

            if($idSubUsuario!="0")
            {
                //$paramtroMotivoAlertas = '4';
                $nombreDeAlerta = $alerta[0]->Nombre;
                //switch por nombre de alerta
                switch (true) {
                    case strpos($nombreDeAlerta,'VISITA MAS TARDE')!==false:
                        $paramtroMotivoAlertas = '5';
                        break;
                    case strpos($nombreDeAlerta,'ENTREGA FUERA DE RANGO')!==false:
                        $paramtroMotivoAlertas = '6';
                        break;
                    case strpos($nombreDeAlerta,'PARADA NO PLAN')!==false:
                        $paramtroMotivoAlertas = '7';
                        break;
                    case strpos($nombreDeAlerta,'ENCUESTA NEGATIVA')!==false:
                        $paramtroMotivoAlertas = '8';
                        break;
                    case strpos($nombreDeAlerta,'TIEMPO EXCEDIDO EN DEPOT')!==false:
                        $paramtroMotivoAlertas = '9';
                        break;
                    case strpos($nombreDeAlerta,'DEMORA EN PRIMERA VISITA')!==false:
                        $paramtroMotivoAlertas = '10';
                        break;
                    case strpos($nombreDeAlerta,'EXCESO TIEMPO DE VIAJE')!==false:
                        $paramtroMotivoAlertas = '11';
                        break;
                    default:
                        $paramtroMotivoAlertas = '4';
                        break;
                }
            }

            if(($alerta[0]->Producto)=='')
            {
                $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,$paramtroMotivoAlertas));
            }else
            {
                $esAlertaBotonPanico = DB::select('select dbo.EsAlertaBotonPanico (?,?) AS abp',array($alerta[0]->IdAlerta,$alerta[0]->IdMonitoreo))[0]->abp;
       
                //$esAlertaBotonPanico = DB::select('exec EsAlertaBotonPanico ?,?',array($alerta[0]->IdAlerta,$alerta[0]->IdMonitoreo));
                $comboMotivoAlerta = DB::select('exec spLlenarCombo ?',array($tabla,$esAlertaBotonPanico));
                $mostrarChecksGestion = false;
            }

            $consultaPlanDeAccion = DB::select('exec spAlertaConsultarPlanDeAccion ?',array($alerta[0]->IdMonitoreo));

            $consultaUltimasGestiones = DB::select('exec spAlertasUltGestionesConsultarLv ?,?,?,?', array($alerta[0]->IdActivo,$alerta[0]->IdMonitoreo,$alerta[0]->IdAlerta,$alerta[0]->VID));

            $infoAdicional = DB::select('exec spConsultarMonInfoAdicional ?',array($alerta[0]->IdMonitoreo));//  IdMonitoreo
            //Chofer_Nombre	Chofer_Celular	Acompanante_Nombre	Acompanante_Celular	Ruta_A_Seguir	Direccion_Origen	Direccion_Destino	A_Informar_Recorrido	Frecuencia_Recorrido	Paradas_Permitidas
            //$alerta = $alerta[0];
            if(sizeof($infoAdicional)>0)
                $infoAdicional = $infoAdicional[0];
            else
            {
                $infoAdicional = (object) array("Chofer_Nombre"=>"","Chofer_Celular"=>"","Acompanante_Nombre"=>"","Acompanante_Celular"=>"","Ruta_A_Seguir"=>"","Direccion_Origen"=>"","Direccion_Destino"=>"","A_Informar_Recorrido"=>"","Frecuencia_Recorrido"=>"","Paradas_Permitidas"=>"",);
            
            }
            //return response()->json($alerta);
         
            $SecuenciasXAtender = array();
            if($idSubUsuario=="0")
            {
                $SecuenciasXAtender = DB::select('exec spAlertasXAtender ?,?,?,?',array($alerta[0]->IdActivo, $alerta[0]->IdMonitoreo, $alerta[0]->IdAlerta,$secuencia));
            }else{
                $SecuenciasXAtender = DB::select('exec spAlertasXAtenderExterno ?,?,?,?,?',array($alerta[0]->IdActivo, $alerta[0]->IdMonitoreo, $alerta[0]->IdAlerta,$secuencia,$client_id));
            }
            $secuenciaxatenderSecuencia = "";
            foreach($SecuenciasXAtender as $secuenciaxatender)
            {
                
                    
                $secuenciaxatenderSecuencia = $secuenciaxatender->Secuencia;
                if($secuenciaxatenderSecuencia)
                {
                    
                        
                        DB::update('exec spActualizarAlertaAtendida ?,?',array($secuenciaxatenderSecuencia,1));
                        DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuenciaxatenderSecuencia,$usuario));
                    
                }
                    
                
                
            }

            $mod = "0";
            $fechaAccion = now()->format('d/m/Y H:i:s');
            //$newDate = date('Y-m-d',$time);
            $alerta = $alerta[0];
            /*$infoAgregadaJson = $alerta->informacion_agregada;
            $infoAgregada1 = json_decode($infoAgregadaJson, true);
            $productos = $infoAgregada1['WATCHFOXPDU']['products'];
            return sizeof($productos);
            foreach($productos as $producto)
            {
                return $producto;
            }*/
            return view('alerts.show',compact('alerta','infoAdicional','secuencia','fechaAccion','comboMotivoAlerta','mostrarChecksGestion','consultaPlanDeAccion','consultaUltimasGestiones','mod','SecuenciasXAtender','alertaSiendoAtendida'));
            //return response()->json($alerta);
            //return response()->json($infoAdicional);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($secuencia)
    {
        $alerta = DB::select('exec spAlertaSecuenciaConsultar ?',array($secuencia));
        //IdMonitoreo	IdAlerta	IdActivo	VID	         NivelBateria	TipoMonitoreo	FechaHoraInicio	           FechaHoraFin	Tipo	Nombre	NombreAlerta	FechaHoraOcurrencia	FechaHoraRegistro	DireccionAlerta	Producto	TipoDispositivo	NombreCompleto	Placa	CodSysHunter	Marca	Modelo	Direccion	Convencional	Celular	Email	chasis	motor	id_estado	descripcion_estado	Latitud	Longitud
        //19531	        437294	     35694	   1002075591   NO DISPONIBLE	2	             2016-01-01 08:00:00.000	2020-12-31 23:50:00.000	ROJO	ALERTA DE IMPACTO	Evento	1969-12-31 19:01:19.000	2016-02-04 10:00:08.080	De los Cedros,Quito,Quito	HUNTER GPS HMT	CALAMP LMU2720	PATRICIO JOHNSON LOPEZ 	PCL7336	1002075591	TOYOTA	BB 4RUNNER LTD TA 4.0 5P 4X4				hmonitoreouio@gmail.com	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	-0,1230728	-78,48123

        $tabla = 'MOTIVORECLAMOCONTROL';
        $mostrarChecksGestion = true;
        if(($alerta[0]->Producto)=='')
        {
            $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'3'));
        }else
        {
            //$esAlertaBotonPanico = DB::select('exec EsAlertaBotonPanico ?,?',array($alerta[0]->IdAlerta,$alerta[0]->IdMonitoreo));
            $esAlertaBotonPanico = DB::select('select dbo.EsAlertaBotonPanico (?,?) AS abp',array($alerta[0]->IdAlerta,$alerta[0]->IdMonitoreo))[0]->abp;
            $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,$esAlertaBotonPanico));
            $mostrarChecksGestion = false;
        }

        $consultaPlanDeAccion = DB::select('exec spAlertaConsultarPlanDeAccion ?',array($alerta[0]->IdMonitoreo));

        $consultaUltimasGestiones = DB::select('exec spAlertasUltGestionesConsultar ?,?,?,?', array($alerta[0]->IdActivo,$alerta[0]->IdMonitoreo,$alerta[0]->IdAlerta,$alerta[0]->VID));

        $infoAdicional = DB::select('exec spConsultarMonInfoAdicional ?',array($alerta[0]->IdMonitoreo));//  IdMonitoreo
        //Chofer_Nombre	Chofer_Celular	Acompanante_Nombre	Acompanante_Celular	Ruta_A_Seguir	Direccion_Origen	Direccion_Destino	A_Informar_Recorrido	Frecuencia_Recorrido	Paradas_Permitidas
        $alerta = $alerta[0];
        if(sizeof($infoAdicional)>0)
            $infoAdicional = $infoAdicional[0];
        else
        {
            $infoAdicional = (object) array("Chofer_Nombre"=>"","Chofer_Celular"=>"","Acompanante_Nombre"=>"","Acompanante_Celular"=>"","Ruta_A_Seguir"=>"","Direccion_Origen"=>"","Direccion_Destino"=>"","A_Informar_Recorrido"=>"","Frecuencia_Recorrido"=>"","Paradas_Permitidas"=>"",);
           
        }

        
        $fechaAccion = now()->format('d/m/Y H:i:s');
        //$newDate = date('Y-m-d',$time);

        $DatoMod = DB::select('exec spAlertaSeguimientoConsultarXSecuencia ?',array($secuencia));
        $mod = "1";
        return view('alerts.show',compact('alerta','infoAdicional','secuencia','fechaAccion','comboMotivoAlerta','mostrarChecksGestion','consultaPlanDeAccion','consultaUltimasGestiones','mod','DatoMod'));
        //return response()->json($alerta);
        //return response()->json($infoAdicional);
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
        //DB.spAlertaSeguimientoActualizar(CInt(Request.QueryString("REC")), txGestión.Text, chbEsRobo.Checked.ToString, cbMotivoAlerta.SelectedItem.Value, txFechaAccion.Text, Session("Usuario"))

        $gestion = $request->input("gestionRealizada");
        $chkEsRobo = $request->has("ckhEsRobo");
        $motivoAlerta = $request->input("comboMotivoAlerta");
        $fechaAccion = $request->input('fechaAccion');
        $usuario =  Auth::user()->Usuario;

        return $request;

        //DB::select('exec spAlertaSeguimientoActualizar ?,?,?,?,?,?',array($secuencia,$gestion,$chkEsRobo,$motivoAlerta,$fechaAccion,$usuario));
    }

    public function updateAtendidoPor(Request $request)
    {
        $secuencia = $request->Secuencia;
        $atendidoPor = "";
        $valor = $request->Valor;
        if($valor==1)
            $atendidoPor = session('usuario');
        
        try {
            DB::update('exec spActualizarAlertaAtendida ?,?',array($secuencia,$valor));
             DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuencia,$atendidoPor));

            $alerta = DB::select('exec spAlertaSecuenciaConsultar ?',array($secuencia));

            $SecuenciasXAtender = DB::select('exec spAlertasXAtender ?,?,?,?',array($alerta[0]->IdActivo, $alerta[0]->IdMonitoreo, $alerta[0]->IdAlerta,$secuencia));
            foreach($SecuenciasXAtender as $secuenciaxatender)
            {
                DB::update('exec spActualizarAlertaAtendida ?,?',array($secuenciaxatender->Secuencia,$valor));
                DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuenciaxatender->Secuencia,$atendidoPor));
            }
            $response['data'] = $alerta;
        } catch (\Throwable $th) {
            $response['data'] = $th->getMessage();
        }
        

        return response()->json($response);
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
    public function getTypesAlerts()
    {
        $tabla = 'TIPOALERTA';
         
        $typesAlerts = DB::select('exec spLlenarCombo ?',array($tabla));

        $response = array();
        foreach($typesAlerts as $typeAlert){
            $response[] = array("label"=>$typeAlert->Descripcion,"value"=>$typeAlert->Codigo);
        }
        return response()->json($response);
    }

    public function findAllParameters(Request $request)
    {
        $buscar = $request->search;
        $usuarios = DB::table('Usuario')->select(DB::raw('concat(Usuario,\'*U*\') as Nombre, Usuario as Valor'))->where('Usuario','LIKE','%'.$buscar.'%');
        
        $entidades = DB::table('Entidad')->select(DB::raw('concat(IdEntidad,\'*E*\') as Nombre, IdEntidad as Valor'))->where('IdEntidad','LIKE','%'.$buscar.'%')->union($usuarios);

        $clientes = DB::table('Cliente')->select(DB::raw('concat(Nombres,\'*C*\') as Nombre, IdEntidad as Valor'))->where('Nombres','LIKE','%'.$buscar.'%')->union($entidades);
        
        $activosAlias = DB::table('Activo')->select(DB::raw('concat(Alias,\'*A*\') as Nombre, Alias as Valor'))->where('Alias','LIKE','%'.$buscar.'%')->union($clientes);
        
        $activosChasis = DB::table('Activo')->select(DB::raw('concat(Chasis,\'*CH*\') as Nombre, Chasis as Valor'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);
        
        $activosCodSysHunter = DB::table('Activo')->select(DB::raw('concat(CodSysHunter,\'*CSH*\') as Nombre, CodSysHunter as Valor'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosChasis)->get();
        

        foreach($activosCodSysHunter as $activoCodSysHunter){
            $response[] = array("label"=>$activoCodSysHunter->Nombre,"value"=>$activoCodSysHunter->Valor);
         }
        //$usuario = $usuario.' Usuario';
        //$entidad = DB::table('Entidad')->where('IdEntidad','LIKE','%'.$buscar.'%')->union($usuario)->get();
        
        return response()->json($response);
        //return $entidad;
    }

    

    public function findAlertsByParameters(Request $request)
    {
        $tipo = "1";
        $parametros = $request->parametros;
        $porProducto = $request->porProducto;
        $grupo = $request->grupo;

        if($porProducto=='true')
            $tipo = "2";

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

        
        

        $arreglo_listado_parametros = array_filter(explode ( "," , $parametros ));
        $total_alertas = array(array());
        $alertas = array();

        if($parametros=="000")
        {
            $buscar = '*';
            //$alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$buscar));
            if($idSubUsuario=="0")
            {
                // ES UN USUARIO INTERNO - TODO IGUAL
                $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$buscar));

            }else
            {
                if($grupo=="0")
                {
                    // ES UN USUARIO EXTERNO (SUBUSUARIO)
                    if($idCategoria=="9")
                    {
                        // ES UN SUPERVISOR EXTERNO - PERFILES 4
                        $alertas = DB::select('exec spAlertasConsultaExternoSupervisor ?,?',array($idSubUsuario,$idUsuario));

                    }else if($idCategoria=="10")
                    {
                        // ES UN OPERADOR EXTERNO (SUBUSUARIO) - PERFILES 4
                        $alertas = DB::select('exec spAlertasConsultaExterno ?,?',array($idSubUsuario,$idUsuario));
                    }
                }else
                {
                    if($idCategoria=="9")
                    {
                        $alertas = DB::select('exec spAlertasConsultaPorGrupoSupervisor ?',array($grupo));
                    }else
                    {
                        $alertas = DB::select('exec spAlertasConsultaPorGrupoOperador ?,?',array($grupo,$idSubUsuario));
                    }
                    
                }
                
            }
            
        }else {
            foreach ($arreglo_listado_parametros as $parametro) {
            
                if($parametro)
                {
                    $arreglo_parametros = explode("*",$parametro);
                    $buscar = $arreglo_parametros[0];
                    $tipoParametro = $arreglo_parametros[1];
                    $alertas = array();
                    switch ($tipoParametro) {
                        case "U":
                            # USUARIO
                            $alertas = DB::select('exec spAlertasConsultaUsuario ?,?',array($tipo,$buscar));
                            break;
                        case "E":
                            # ENTIDAD, se usa el SP original
                            $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$buscar));
                            break;
                        case "C":
                            # CLIENTE, buscamos el IdEntidad
                            $cliente = DB::table('Cliente')->select('IdEntidad as IdEntidad')->where('Nombres','LIKE',$buscar.'%')->get();
                            $alertas = DB::select('exec spAlertasConsultaLv2 ?,?',array($tipo,$cliente[0]->IdEntidad));
                            break;
                        case "A":
                            # ALIAS
                            $alertas = DB::select('exec spAlertasConsultaAlias ?,?',array($tipo,$buscar));
                            break;
                        case "CH":
                            # CHASIS
                            $alertas = DB::select('exec spAlertasConsultaChasis ?,?',array($tipo,$buscar));
                            break;
                            
                        default:
                            # CODSYSHUNTER
                            $alertas = DB::select('exec spAlertasConsultaCSH ?,?',array($tipo,$buscar));
                            break;
                    }
                    //array_merge($total_alertas,$alertas);
                    
                }
                
                
            }
        }

        
        

        //$total_alertas = array_unique ($total_alertas);

        $response['data'] = $alertas;

        return response()->json($response);
    }


    public function seguimientoalertas()
    {

        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00:00');

        $fechaHasta = Carbon::now();
        $fechaHasta = $fechaHasta->format('d/m/Y 23:59:59');


        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        
        if($idSubUsuario=="0")
        {
            $tabla = 'AGENTES_AM';
         
            $agentes = DB::select('exec spLlenarCombo ?',array($tabla));

            $tabla = 'MOTIVORECLAMOCONTROL';
         
            $motivosAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'2'));

        }else
        {
            $tabla = 'AGENTES_EXT';
         
            $agentes = DB::select('exec spLlenarCombo ?',array($tabla));

            $tabla = 'MOTIVORECLAMOCONTROL';
         
            $motivosAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'2'));

        }

        
        

        $tabla = 'PRODUCTOS';
         
        $productos = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'TIPODISPOSITIVOS';
         
        $dispositivos = DB::select('exec spLlenarCombo ?',array($tabla));

        return view('alerts.seguimientoalertas',compact('motivosAlerta','agentes','productos','dispositivos','fechaDesde','fechaHasta'));

        
    }

    public function pruebaSeguimientoAlertas()
    {
        $alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array('36156','01/01/2017 00:00:00','15/10/2017 23:50:00','','','','','','','','',''));
        $alerta = $alertas[1];
        return $alertas;
        
    }

    public function seguimientoAlertasBuscar(Request $request)
    {
        
        
  
            
        try {
  
            $fechaDesde = $request->input('fechaDesde');
            $fechaHasta = $request->input('fechaHasta');
            $tipoAlerta = $request->input('tipoAlerta');
    
            $alias = $request->input('unidadBuscar');
            $idActivo = $request->input('idActivo');
            $agente = $request->input('agente');
            $producto = $request->input('producto');
            $dispositivo = $request->input('dispositivo');
            $motivoAlerta = $request->input('motivoAlerta');
            $cmbRepetidas = $request->input('alertasRepetidas');
            $cmbPendientes = $request->input('casosEnviados');
            $cmbRobo = $request->input('robos');
            $cmbDatosIncorrectos = $request->input('datosIncorrectos');
    
            $idUsuario = session('idUsuario');
            $idSubUsuario = session('idSubUsuario');
            $idCategoria = session('idCategoria');
    
    
            if($fechaDesde == null)
                $fechaDesde = '';
            if($fechaHasta == null)
                $fechaHasta = '';
            if($tipoAlerta == null)
                $tipoAlerta = '0';
            if($alias == null )
                $alias = '';
            if($idActivo == null || $idActivo == '')
                $idActivo = '0';
            if($agente == null)
                $agente = '';
            if($producto == null)
                $producto = '';
            if($dispositivo == null)
                $dispositivo = '';
            if($motivoAlerta == null)
                $motivoAlerta = '0';
            if($cmbRepetidas == null)
                $cmbRepetidas = '';
            if($cmbPendientes == null)
                $cmbPendientes = '';
            if($cmbRobo == null)
                $cmbRobo = '';
            if($cmbDatosIncorrectos == null)
                $cmbDatosIncorrectos = '';
    
        
            if($idSubUsuario=="0")
            {
                $totalAlertas = DB::select('select dbo.getTotalAlertasLv (?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->ta;
                $totalAlertasResueltas = DB::select('select dbo.getTotalAlertasContestadas (?,?,?) AS tar',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->tar;
                $robos = DB::select('select dbo.getAlertasRobos (?,?,?) AS robos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->robos;
                $repetidas = DB::select('select dbo.getAlertasRepetidas (?,?,?) AS repetidas',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->repetidas;
                $casosEnviados = DB::select('select dbo.getAlertasCasosEnviados (?,?,?) AS casos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->casos;
                $datosIncorrectos = DB::select('select dbo.getAlertasDatosIncorrectos (?,?,?) AS incorrectos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->incorrectos;
            }else
            {
                //$totalAlertas = DB::select('select dbo.getTotalAlertasExterno (?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->ta;
                //$totalAlertasResueltas = DB::select('select dbo.getTotalAlertasContestadasExterno (?,?,?) AS tar',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->tar;
                //$robos = DB::select('select dbo.getAlertasRobosExterno (?,?,?) AS robos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->robos;
                //$repetidas = DB::select('select dbo.getAlertasRepetidasExterno (?,?,?) AS repetidas',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->repetidas;
                //$casosEnviados = DB::select('select dbo.getAlertasCasosEnviadosExterno (?,?,?) AS casos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->casos;
                //$datosIncorrectos = DB::select('select dbo.getAlertasDatosIncorrectosExterno (?,?,?) AS incorrectos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->incorrectos;
                if($agente=='')
                {
                    
                    $totalAlertas = DB::select('select dbo.getTotalAlertasExterno (?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->ta;
                    $totalAlertasResueltas = DB::select('select dbo.getTotalAlertasContestadasExterno (?,?,?) AS tar',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->tar;
                    $robos = DB::select('select dbo.getAlertasRobosExterno (?,?,?) AS robos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->robos;
                    $repetidas = DB::select('select dbo.getAlertasRepetidasExterno (?,?,?) AS repetidas',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->repetidas;
                    $casosEnviados = DB::select('select dbo.getAlertasCasosEnviadosExterno (?,?,?) AS casos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->casos;
                    $datosIncorrectos = DB::select('select dbo.getAlertasDatosIncorrectosExterno (?,?,?) AS incorrectos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->incorrectos;
                
                }else
                {
                    $totalAlertas = DB::select('select dbo.getTotalAlertasExternoNombre (?,?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->ta;
                    $totalAlertasResueltas = DB::select('select dbo.getTotalAlertasContestadasExternoNombre (?,?,?,?) AS tar',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->tar;
                    $robos = DB::select('select dbo.getAlertasRobosExternoNombre (?,?,?,?) AS robos',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->robos;
                    $repetidas = DB::select('select dbo.getAlertasRepetidasExternoNombre (?,?,?,?) AS repetidas',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->repetidas;
                    $casosEnviados = DB::select('select dbo.getAlertasCasosEnviadosExternoNombre (?,?,?,?) AS casos',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->casos;
                    $datosIncorrectos = DB::select('select dbo.getAlertasDatosIncorrectosExternoNombre (?,?,?,?) AS incorrectos',array($fechaDesde,$fechaHasta,$tipoAlerta,$agente))[0]->incorrectos;
                
                    
                }
                
                
                
                
            }

            
            //$response['totalAlertas'] = $totalAlertas; 
            //$response['totalAlertasResueltas'] = $totalAlertasResueltas; 
            //return response()->json($response);
            


            if($totalAlertasResueltas>0)
            {
                $alertasRobos = number_format(($robos/$totalAlertasResueltas)*100,2).' %';
                $alertasRepetidas = number_format(($repetidas/$totalAlertasResueltas)*100,2).' %';
                $alertasCasosEnviados = number_format(($casosEnviados/$totalAlertasResueltas)*100,2).' %';
                $alertasDatosIncorrectos = number_format(($datosIncorrectos/$totalAlertasResueltas)*100,2).' %';
            }else
            {
                $alertasRobos = '0.00%';
                $alertasRepetidas = '0.00%';
                $alertasCasosEnviados = '0.00%';
                $alertasDatosIncorrectos = '0.00%';
            }

            

        


            /*$response['fechaDesde'] = $fechaDesde; 
            $response['fechaHasta'] = $fechaHasta;
            $response['tipoAlerta'] = $tipoAlerta;

            $response['alias'] = $alias;
            $response['idActivo'] = $idActivo; 
            $response['agente'] = $agente ;
            $response['producto'] = $producto; 
            $response['dispositivo'] = $dispositivo;  
            $response['motivoAlerta'] = $motivoAlerta;  
            $response['cmbRepetidas'] = $cmbRepetidas; 
            $response['cmbPendientes'] = $cmbPendientes; 
            $response['cmbRobo'] = $cmbRobo; 
            $response['cmbDatosIncorrectos'] = $cmbDatosIncorrectos; 
            */
                


            

            //return response()->json($response);

            //$alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array('36156','01/01/2017 00:00:00','15/10/2017 23:50:00','','','','3','','','','',''));

            $sp = "0";
            $sp = $idActivo.' - '.$fechaDesde.' - '.$fechaHasta.' - '.$agente.' - '.$producto.' - '.$dispositivo.' - '.$tipoAlerta.' - '.$motivoAlerta.' - '.$cmbRepetidas.' - '.$cmbPendientes.' - '.$cmbRobo.' - '.$cmbDatosIncorrectos;
            if($idSubUsuario=="0")
            {
                // ES UN USUARIO INTERNO
                $alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$cmbRepetidas,$cmbPendientes,$cmbRobo,$cmbDatosIncorrectos));    
                $sp = $idActivo.' - '.$fechaDesde.' - '.$fechaHasta.' - '.$agente.' - '.$producto.' - '.$dispositivo.' - '.$tipoAlerta.' - '.$motivoAlerta.' - '.$cmbRepetidas.' - '.$cmbPendientes.' - '.$cmbRobo.' - '.$cmbDatosIncorrectos;
            }else
            {
                if($agente=='')
                {
                    
                    $alertas_temp = DB::select('exec spAlertaSeguimientoConsultarLvExternoSinNombre ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$cmbRepetidas,$cmbPendientes,$cmbRobo,$cmbDatosIncorrectos));
                    foreach ($alertas_temp as $alerta_temp) {
                        if($alerta_temp->NombreAgente=='')
                        {
                            try {
                                $monitoristas = DB::table('ActivoSubUsuario')->select('IdSubUsuario')->where('IdUsuario','=',112433)->where('IdActivo','=',$alerta_temp->IdActivo)->get();
                                $operadores = '';
                                foreach ($monitoristas as $monitorista) {
                                    $agentes = DB::table('SubUsuario')->select('NombreCompleto')->where('IdUsuario','=',112433)->where('IdSubUsuario','=',$monitorista->IdSubUsuario)->get();
                                    
                                    foreach ($agentes as $agenteuno) {
                                        $operadores = $operadores.$agenteuno->NombreCompleto.', ';
                                    }
                                }
                                $alerta_temp->NombreAgente = $operadores;    
                            } catch (\Throwable $th) {
                                
                            }
                            
                        }
                        $alertas[] = $alerta_temp;
                    }

                    
                
                
                }else
                {
                    $alertas = DB::select('exec spAlertaSeguimientoConsultarLvExterno ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$cmbRepetidas,$cmbPendientes,$cmbRobo,$cmbDatosIncorrectos));
                }
                
            }

            

            //$alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$cmbRepetidas,$cmbPendientes,$cmbRobo,$cmbDatosIncorrectos));
            
            $tiempoRespuesta = 0;
            $indice = 0;



            foreach($alertas as $alerta)
            {
                //$gestionArreglo = explode("\\",$alerta->Gestion);
                //$gestion = $gestionArreglo[0];
                //$alertas[$indice]->Gestion = $gestion;
                $indice++;
                $fechaInicio = strtotime($alerta->FechaRegistro);
                $fechaFin =  strtotime($alerta->FechaGestion);

                $diferenciaFechas = $alerta->DiferenciaFechas;
                list($fecha,$tiempo) = explode(" ",$diferenciaFechas);
                //list($anio,$mes,$dia) = explode("-",$fecha);
                list($hora,$minuto,$segundos) = explode(":",$tiempo);

                
                list($segundo,$microsegundo) = explode(".",$segundos);
                $timestampDiferencia = mktime($hora,$minuto,$segundo,0,0,0);
                $diferenciaFechas = date("H:i:s",$timestampDiferencia);

                $minutos = ($hora*60) + ($minuto) + ($segundos/60);
                

                //if($alerta->FechaGestion<>'')
                $tiempoRespuesta = $tiempoRespuesta + round($minutos,2);
            
            }

            

            
            
            if(sizeof($alertas)>0)
            {
                $totalAlertasResultantes = sizeof($alertas);
                $tiempoRespuestaPromedio = number_format($tiempoRespuesta/sizeof($alertas),2).' min';
                $totalAlertasXAgente = $totalAlertasResueltas;
                /*if($agente=='')
                {
                    $totalAlertasXAgente = $totalAlertasResueltas; // sizeof($alertas);
                }else
                {
                    $totalAlertasXAgente = 0;
                    foreach ($alertas as $alerta) {
                        if($alerta->FechaGestion=='')
                        {

                        }else
                        {
                            $totalAlertasXAgente = $totalAlertasXAgente + 1;
                        }
                    }
                }*/
            }else{
                $totalAlertasResultantes = 0;
                $tiempoRespuestaPromedio = "--------";
                $totalAlertasXAgente = 0;
            }

        

            if($totalAlertasResueltas>0)
            {
                $promedioAlertasContestadasXAgente = number_format(($totalAlertasXAgente/$totalAlertasResueltas)*100,2).' %';
            }else{
                $promedioAlertasContestadasXAgente = '0.00%';
            }

            

            
            if($totalAlertas>0)
            {
                $promedioAlertasContestadas = number_format(($totalAlertasResueltas/$totalAlertas)*100,2).' %';
                $promedioAlertasTotalesXAgente = number_format(($totalAlertasXAgente/$totalAlertas)*100,2).' %';
            }else
            {
                $promedioAlertasContestadas = '0.00%';
                $promedioAlertasTotalesXAgente = '0.00%';
            }
            

            //$response = $totalAlertasResueltas;
            //return response()->json($response);

            $response['promedioAlertasContestadas'] = $promedioAlertasContestadas;
            $response['promedioAlertasTotalesXAgente'] = $promedioAlertasTotalesXAgente;

            $response['promedioAlertasContestadasXAgente'] = $promedioAlertasContestadasXAgente;

            $response['totalAlertasResultantes'] = $totalAlertasResultantes;
            $response['tiempoRespuestaPromedio'] = $tiempoRespuestaPromedio;
            $response['totalAlertasXAgente'] = $totalAlertasXAgente;

        
            $response['alertas'] = $alertas;
            $response['totalAlertas'] = $totalAlertas;
            $response['totalAlertasResueltas'] = $totalAlertasResueltas;
            $response['robos'] = $robos;
            $response['repetidas'] = $repetidas;
            $response['casosEnviador'] = $casosEnviados;
            $response['datosIncorrectos'] = $datosIncorrectos;
            $response['alertasRobos'] = $alertasRobos;
            $response['alertasRepetidas'] = $alertasRepetidas;
            $response['alertasCasosEnviados'] = $alertasCasosEnviados;
            $response['alertasDatosIncorrectos'] = $alertasDatosIncorrectos;

            $response['idSubUsuario'] = $idSubUsuario;
            $response['sp'] = $sp;
        } catch (\Throwable $th) {
            $response['error'] = $th->getMessage();
        }

        
        //$response = "";// $totalAlertas;

        return response()->json($response);
    }

    function exportSeguimientoAlertas(Request $request)
    {
        
        $fecha = Carbon::now();
           
        $fecha = $fecha->format('dmY');
        return Excel::download(new AlertsExportSeguimientoAlertas($request),'Seguimiento_De_Alertas_'.$fecha.'.xlsx');
    }



    public function seguimientoAlertasAgrupadasPorMonitorista()
    {

        $fechaDesde = Carbon::now();
        $fechaDesde = $fechaDesde->format('d/m/Y 00:00:00');

        $fechaHasta = Carbon::now();
        $fechaHasta = $fechaHasta->format('d/m/Y 23:59:59');


        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        
        if($idSubUsuario=="0")
        {
            $tabla = 'AGENTES_AM';
         
            $agentes = DB::select('exec spLlenarCombo ?',array($tabla));

            $tabla = 'MOTIVORECLAMOCONTROL';
         
            $motivosAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'2'));

        }else
        {
            $tabla = 'AGENTES_EXT';
         
            $agentes = DB::select('exec spLlenarCombo ?',array($tabla));

            $tabla = 'MOTIVORECLAMOCONTROL';
         
            $motivosAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'2'));

        }

        
        
        
        $tabla = 'GRUPOSCN';
         
        $grupos = DB::select('exec spLlenarCombo ?',array($tabla));
        /*
        $tabla = 'TIPODISPOSITIVOS';
         
        $dispositivos = DB::select('exec spLlenarCombo ?',array($tabla));
        */

        return view('alerts.alertasAgrupadasPorMonitorista',compact('fechaDesde','fechaHasta','agentes','grupos'));

        
    }

    public function average_time($total, $count, $rounding = 0) {
        $total = explode(":", strval($total));
        if (count($total) !== 3) return false;
        $sum = $total[0]*60*60 + $total[1]*60 + $total[2];
        $average = $sum/(float)$count;
        $hours = floor($average/3600);
        $minutes = floor(fmod($average,3600)/60);
        $seconds = number_format(fmod(fmod($average,3600),60),(int)$rounding);
        return $hours.":".$minutes.":".$seconds;
    }

    public function sum_the_time($time1, $time2) {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time)
        {
          list($hour,$minute,$second) = explode(':', $time);
          $seconds += $hour*3600;
          $seconds += $minute*60;
          $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        return "{$hours}:{$minutes}:{$seconds}";
      }


    public function seguimientoAlertasBuscarAgrupados(Request $request)
    {
        
        
        $fechaDesde = $request->input('fechaDesde');
        $fechaHasta = $request->input('fechaHasta');
        $agente = $request->input('agente');
        $grupo = $request->input('grupo');

        if($agente == null)
            $agente = '';
        if($grupo == null)
            $grupo = '';

        

        //return response()->json($alertas);

        try {

            Log::info("ANTES DE TRAER LISTADOS");
            if($agente=='')
            {
                Log::info("ANTES DE ATENDIDAS");
                $alertasAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                Log::info("LUEGO DE ATENDIDAS");
                $alertasNoAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosNoAtendidosSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                $alertasGeneradas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosGeneradasSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                $alertasAtendidasPorOtros = array();
            }else
            {
                $alertasAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasNoAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosNoAtendidosConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasGeneradas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosGeneradasConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasAtendidasPorOtros = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosPorOtroConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
            }
            Log::info("LUEGO DE TRAER LISTADOS");

            //$response = $alertasAtendidasPorOtros;
            //return response()->json($response);
            

            $alertasAgrupadas = array();
            $sumaTiempos = array();

            $evento = '';

            /*********** ALERTAS GENERADAS *********/ 
            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['G'] = 0;
                
            }

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                } 
                $alertasAgrupadas[$evento]['G']++;
                
            }


            /************ ALERTAS ATENDIDAS ********/ 
            
            foreach($alertasAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['A'] = 0; 
                $alertasAgrupadas[$evento]['TP'] = 0;
                $sumaTiempos[$evento] = date('H:i:s',strtotime('00:00:00'));
            }
            //$response = $sumaTiempos;
            //return response()->json($response);


            foreach($alertasAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $diferenciaTiempos = date("H:i:s",strtotime($val->Diferencia));
                //return response()->json($diferenciaTiempos);
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['A']++;
                $sumaTiempos[$evento] = AlertController::sum_the_time($sumaTiempos[$evento],$diferenciaTiempos);
            }
            
            //$response = $sumaTiempos;     
            //return response()->json($response);
            

            foreach ($alertasAtendidas as $key => $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $tiempoPromedioArreglo = explode(":",AlertController::average_time($sumaTiempos[$evento],$alertasAgrupadas[$evento]['A']));
                
                $alertasAgrupadas[$evento]['TP'] = $tiempoPromedioArreglo[1];//AlertController::average_time($sumaTiempos[$evento],$alertasAgrupadas[$evento]['A']);
            }

            //$response = $alertasAgrupadas;     
            //return response()->json($response);

            

            /********** ALERTAS NO ATENDIDAS **********/
            foreach($alertasNoAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['NA'] = 0;
                
            }

            foreach($alertasNoAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['NA']++;
                
            }

            /****** ALERTAS ATENDIDAS POR OTROS ******/

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['APO'] = 0;
                
            }

            foreach($alertasAtendidasPorOtros as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                $alertasAgrupadas[$evento]['APO']++;
                
            }

            /************/

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                try {
                    $alertasAgrupadas[$evento]['EFICIENCIA'] = number_format(($alertasAgrupadas[$evento]['A'] / $alertasAgrupadas[$evento]['G']) * 100)."%" ;
                } catch (\Throwable $th) {
                    $alertasAgrupadas[$evento]['EFICIENCIA'] = "0.00%";
                }
                
                
            }

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                try {
                    if(number_format(100-(($alertasAgrupadas[$evento]['TP'] * 100 / 10) - 100),2)>=0)
                        $alertasAgrupadas[$evento]['EFICACIA'] = number_format(100-(($alertasAgrupadas[$evento]['TP'] * 100 / 10) - 100),2)."%" ;
                    else
                        $alertasAgrupadas[$evento]['EFICACIA'] = "0.00%";
                } catch (\Throwable $th) {
                    $alertasAgrupadas[$evento]['EFICACIA'] = "0.00%";
                }
                
                
            }
    
            
            
            
            $response['data'] = $alertasAgrupadas;
        } catch (\Throwable $th) {
            $response = $th->getMessage() ;
        }
        

        
        
        return response()->json($response);
    }


    function exportAlertasPorMonitorista(Request $request)
    {
        
        $fecha = Carbon::now();
           
        $fecha = $fecha->format('dmY');
        return Excel::download(new AlertsExportAlertasPorMonitorista($request),'AlertasPorMonitorista_'.$fecha.'.xlsx');
    }

    

   
    /****
     * POST VENTA
     * 
     * 
     * 
     * 
     */

    function reportegerencial()
    {
        $anio = Carbon::now()->format('Y');
        $anios = array();
        for ($i=0; $i < 3 ; $i++) { 
            array_push($anios,$anio + $i -1);
        }
        $tabla = "MARCA";
        $comboMarcas = DB::select('exec spLlenarCombo ?,?',array($tabla,''));


        //return $anios;
        return view('alerts.reportegerencial',compact('anios','comboMarcas'));
    }

    function consultaReportesGerenciales(Request $request)
    {
        $anio = $request->anio;
        $marca = $request->marca;

        //return $request;

        $reporteGerencial = DB::select('exec spAlertaReporteGerencial ?,?',array($anio,$marca));

        $response['reporte'] = $reporteGerencial;

        $mayorMotivoAlertas = DB::select('exec spMayorMotivoAlertas ?,?',array($anio,$marca));

        $response['mayormotivo'] = $mayorMotivoAlertas;

        $horasPicoAtencion = DB::select('exec spAlertaConsultarHorasPicoAtencion ?,?',array($anio,$marca));

        $response['horaspico'] = $horasPicoAtencion;

        return response()->json($response);
    }

    /*function reparaFechas()
    {
        $registros = DB::table('CorregirFechas')->select('secuencia','idAlerta','fecha')->get();
        foreach ($registros as $registro) {
            $secuencia = $registro->secuencia;
            $idAlerta = $registro->idAlerta;
            DB::update('exec spRepararFechasLv ?,?',array($secuencia,$idAlerta));    
        }
        return $registros;
        
    }*/

    /*function consultacaidasxmonitoreo(Request $request)
    {
        $idMonitoreo = $request->idMonitoreo;
        $caidas = DB::select('exec spAlertasConsultaCaidasXMonitoreo ?',array($idMonitoreo));
        $contador = 0;
        foreach ($caidas as $caida) {
            $contador++;
        }

        $resultado['data'] = $contador;
        $response = array();
        return response()->json($resultado);
    }*/

    
}
