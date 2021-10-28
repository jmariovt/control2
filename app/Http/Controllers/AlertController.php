<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use XAdmin\Alert;
use XAdmin\Exports\AlertsExportSeguimientoAlertas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

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

        $pendientes = DB::select('exec spAlertasConsultaPendientes');
        $cantidadPendientes = sizeof($pendientes);

        $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$cia));
        DB::update('exec spActualizarFalsasSiendoAtendida');



        return view('alerts.index', compact('alertas','mod','cantidadPendientes'));
    }

    public function indexCompany($cia)
    {
        $tipo = "1";
        //$cia = "*";
        $mod = "0";

        $pendientes = DB::select('exec spAlertasConsultaPendientes');
        $cantidadPendientes = sizeof($pendientes);

        $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$cia));
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

        $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$idEntidad));
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

        $usuario = Auth::user()->Usuario;
        $nombreUsuario = Auth::user()->Nombre;

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
                    DB::insert('exec spAlertaSeguimientoIngresarLv ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',array($IdActivo, $IdMonitoreo, $IdAlerta, $nombreCliente, $placa, $marca, $modelo, $producto, $tipoDispositivo, $alerta, $tipoAlerta, $estadoAlarma, $cambiaEstadoAlarma, $fechaOcurrencia, $fechaGestion, $usuario,$nombreUsuario, $gestion, 'False', $secuenciaxatender->Secuencia, $vid, $codSysHunter, $chasis, $motor, $id_estado, $descripcion_estado, $fechaRegistro, $motivoAlerta, $alertaRepetida, $datosIncorrectos));
            
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
    public function show($secuencia)
    {

        $usuario = Auth::user()->Usuario;

        if($secuencia!="0")
        {

            //return view('alerts.show',compact('alerta','infoAdicional','secuencia','fechaAccion','comboMotivoAlerta','mostrarChecksGestion','consultaPlanDeAccion','consultaUltimasGestiones','mod'));
            
           
        
            $alertaTemp = DB::select('exec spAlertaSecuenciaConsultarLv ?',array($secuencia));
            

            DB::update('exec spActualizarAlertaAtendida ?,?',array($secuencia,1));
            DB::update('exec spActualizarUsuarioRevisandoAlerta ?,?',array($secuencia,$usuario));

            $alerta = DB::select('exec spAlertaSecuenciaConsultarLv ?',array($secuencia));
            //IdMonitoreo	IdAlerta	IdActivo	VID	         NivelBateria	TipoMonitoreo	FechaHoraInicio	           FechaHoraFin	Tipo	Nombre	NombreAlerta	FechaHoraOcurrencia	FechaHoraRegistro	DireccionAlerta	Producto	TipoDispositivo	NombreCompleto	Placa	CodSysHunter	Marca	Modelo	Direccion	Convencional	Celular	Email	chasis	motor	id_estado	descripcion_estado	Latitud	Longitud
            //19531	        437294	     35694	   1002075591   NO DISPONIBLE	2	             2016-01-01 08:00:00.000	2020-12-31 23:50:00.000	ROJO	ALERTA DE IMPACTO	Evento	1969-12-31 19:01:19.000	2016-02-04 10:00:08.080	De los Cedros,Quito,Quito	HUNTER GPS HMT	CALAMP LMU2720	PATRICIO JOHNSON LOPEZ 	PCL7336	1002075591	TOYOTA	BB 4RUNNER LTD TA 4.0 5P 4X4				hmonitoreouio@gmail.com	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	NO DISPONIBLE	-0,1230728	-78,48123

            
            $alertaSiendoAtendida = $alertaTemp[0]->SiendoAtendida;//DB::table('AlertaActivoMonitoreo')->select('SiendoAtendida')->where('IdAlerta','=',$alerta[0]->IdAlerta)->where('Secuencia','=',$secuencia)->get();
            //return $alertaSiendoAtendida;
            /*if($alertaSiendoAtendida[0]->SiendoAtendida=="1")
            {
                return redirect()->route('alerts')->withErrors('Alerta está siendo atendida.');
        
            }*/

            $tabla = 'MOTIVORECLAMOCONTROL';
            $mostrarChecksGestion = true;
            if(($alerta[0]->Producto)=='')
            {
                $comboMotivoAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'3'));
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
             $SecuenciasXAtender = DB::select('exec spAlertasXAtender ?,?,?,?',array($alerta[0]->IdActivo, $alerta[0]->IdMonitoreo, $alerta[0]->IdAlerta,$secuencia));
            
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
        DB::update('exec spActualizarAlertaAtendida ?,?',array($secuencia,0));
        DB::update('exec spActualizarUsuarioRevisandoAlerta',array($secuencia,""));

        $alerta = DB::select('exec spAlertaSecuenciaConsultar ?',array($secuencia));

        $SecuenciasXAtender = DB::select('exec spAlertasXAtender ?,?,?,?',array($alerta[0]->$IdActivo, $alerta[0]->$IdMonitoreo, $alerta[0]->$IdAlerta,$secuencia));
        foreach($SecuenciasXAtender as $secuenciaxatender)
        {
            DB::update('exec spActualizarAlertaAtendida ?,?',array($secuenciaxatender->Secuencia,0));
            DB::update('exec spActualizarUsuarioRevisandoAlerta',array($secuenciaxatender->Secuencia,""));
        }
        $response['data'] = $alerta;

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

        if($porProducto=='true')
            $tipo = "2";

        
        

        $arreglo_listado_parametros = array_filter(explode ( "," , $parametros ));
        $total_alertas = array(array());
        $alertas = array();

        if($parametros=="000")
        {
            $buscar = '*';
            $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$buscar));
            //array_merge($total_alertas,$alertas);
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
                            $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$buscar));
                            break;
                        case "C":
                            # CLIENTE, buscamos el IdEntidad
                            $cliente = DB::table('Cliente')->select('IdEntidad as IdEntidad')->where('Nombres','LIKE',$buscar.'%')->get();
                            $alertas = DB::select('exec spAlertasConsulta ?,?',array($tipo,$cliente[0]->IdEntidad));
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
        $tabla = 'MOTIVORECLAMOCONTROL';
         
        $motivosAlerta = DB::select('exec spLlenarCombo ?,?',array($tabla,'2'));

        $tabla = 'AGENTES_AM';
         
        $agentes = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'PRODUCTOS';
         
        $productos = DB::select('exec spLlenarCombo ?',array($tabla));

        $tabla = 'TIPODISPOSITIVOS';
         
        $dispositivos = DB::select('exec spLlenarCombo ?',array($tabla));

        return view('alerts.seguimientoalertas',compact('motivosAlerta','agentes','productos','dispositivos'));

        
    }

    public function pruebaSeguimientoAlertas()
    {
        $alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array('36156','01/01/2017 00:00:00','15/10/2017 23:50:00','','','','','','','','',''));
        $alerta = $alertas[1];
        return $alertas;
        
    }

    public function seguimientoAlertasBuscar(Request $request)
    {
        /*
                    Dim TotalAlertas As Integer = BD.getTotalAlertas(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)
                    Dim TotalAlertasResueltas As Integer = BD.getTotalAlertasContestadas(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)
                    Dim Robos As Integer = BD.getAlertasRobos(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)
                    Dim Repetidas As Integer = BD.getAlertasRepetidas(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)
                    Dim CasosEnviadas As Integer = BD.getAlertasCasosEnviados(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)
                    Dim DatosIncorrectos As Integer = BD.getAlertasDatosIncorrectos(FechaDesde, FechaHasta, cbTipoAlerta.SelectedItem.Value)

                    txTotalAlertas.Text = TotalAlertas.ToString
                    txTotalAlertasResueltas.Text = TotalAlertasResueltas.ToString

                    If TotalAlertasResueltas > 0 Then
                        txAlertasRobos.Text = ((Robos / TotalAlertasResueltas) * 100).ToString("##,##0.00") + "%"
                        txAlertasRepetidas.Text = ((Repetidas / TotalAlertasResueltas) * 100).ToString("##,##0.00") + "%"
                        txAlertasCasosEnviados.Text = ((CasosEnviadas / TotalAlertasResueltas) * 100).ToString("##,##0.00") + "%"
                        txAlertasDatosIncorrectos.Text = ((DatosIncorrectos / TotalAlertasResueltas) * 100).ToString("##,##0.00") + "%"
                    Else
                        txAlertasRobos.Text = "0.00%"
                        txAlertasRepetidas.Text = "0.00%"
                        txAlertasCasosEnviados.Text = "0.00%"
                        txAlertasDatosIncorrectos.Text = "0.00%"

                    End If
                */
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

        

        $totalAlertas = DB::select('select dbo.getTotalAlertas (?,?,?) AS ta',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->ta;
        $totalAlertasResueltas = DB::select('select dbo.getTotalAlertasContestadas (?,?,?) AS tar',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->tar;
        $robos = DB::select('select dbo.getAlertasRobos (?,?,?) AS robos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->robos;
        $repetidas = DB::select('select dbo.getAlertasRepetidas (?,?,?) AS repetidas',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->repetidas;
        $casosEnviados = DB::select('select dbo.getAlertasCasosEnviados (?,?,?) AS casos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->casos;
        $datosIncorrectos = DB::select('select dbo.getAlertasDatosIncorrectos (?,?,?) AS incorrectos',array($fechaDesde,$fechaHasta,$tipoAlerta))[0]->incorrectos;

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

        if($fechaDesde == null)
            $fechaDesde = '';
        if($fechaHasta == null)
            $fechaHasta = '';
        if($tipoAlerta == null)
            $tipoAlerta = '';
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
            $motivoAlerta = '';
        if($cmbRepetidas == null)
            $cmbRepetidas = '';
        if($cmbPendientes == null)
            $cmbPendientes = '';
        if($cmbRobo == null)
            $cmbRobo = '';
        if($cmbDatosIncorrectos == null)
            $cmbDatosIncorrectos = '';



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


        return response()->json($response);*/

        //$alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array('36156','01/01/2017 00:00:00','15/10/2017 23:50:00','','','','3','','','','',''));

        $alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$cmbRepetidas,$cmbPendientes,$cmbRobo,$cmbDatosIncorrectos));
        
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
            $totalAlertasXAgente = sizeof($alertas);
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

        

        $promedioAlertasContestadas = number_format(($totalAlertasResueltas/$totalAlertas)*100,2).' %';
        $promedioAlertasTotalesXAgente = number_format(($totalAlertasXAgente/$totalAlertas)*100,2).' %';

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

        
        //$response = "";// $totalAlertas;

        return response()->json($response);
    }

    function exportSeguimientoAlertas(Request $request)
    {
        
        $fecha = Carbon::now();
           
        $fecha = $fecha->format('dmY');
        return Excel::download(new AlertsExportSeguimientoAlertas($request),'Seguimiento_De_Alertas_'.$fecha.'.xlsx');
    }

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

    
}
