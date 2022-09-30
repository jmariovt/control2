<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use XAdmin\Asset;


class AssetController extends Controller
{

   
    public function getAssets(Request $request){

      $search = $request->search;
      $buscarPor = $request->buscar;

      if($search == ''){
         //$employees = Employees::orderby('name','asc')->select('id','name')->limit(5)->get();
      }else{
         /*if($buscarPor==0)
         {
            $assets = Asset::orderby('Alias','asc')->select('IdActivo','Alias')->where('Alias', 'like', '%' .$search . '%')->limit(100)->get();
         }*/
         $response = array();
         switch ($buscarPor) {
            case 0:   //PLACA
               $assets = Asset::orderby('Alias','asc')->select('IdActivo','Alias')->where('Alias', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->Alias,"value"=>$asset->IdActivo);
               }
               break;
            case 1:   //CodSysHunter
               $assets = Asset::orderby('CodSysHunter','asc')->select('IdActivo','CodSysHunter','Alias')->where('CodSysHunter', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->CodSysHunter,"value"=>$asset->IdActivo,"alias"=>$asset->Alias);
               }
               break;
            case 2:    // VID
               $assets = Asset::orderby('uid','asc')->select('IdActivo','uid')->where('uid', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->uid,"value"=>$asset->IdActivo,"alias"=>$asset->Alias);
               }
               break;
            case 3:   // Chasis
               $assets = Asset::orderby('Chasis','asc')->select('IdActivo','Chasis')->where('Chasis', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->Chasis,"value"=>$asset->IdActivo);
               }
               break;
            case 4:    // Motor
               $assets = Asset::orderby('Motor','asc')->select('IdActivo','Motor')->where('Motor', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->Motor,"value"=>$asset->IdActivo);
               }
               break;
            default:
               # code...
               break;
         }
         
      }

      

      return response()->json($response);
   }


   public function buscarActivo(Request $request)
    {
       
        $buscar = $request->search;
        
        
        $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo'))->where('Alias','LIKE','%'.$buscar.'%');
        
        $activosChasis = DB::table('Activo')->select(DB::raw('Chasis as Activo'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);

        $activosMotor = DB::table('Activo')->select(DB::raw('Motor as Activo'))->where('Motor','LIKE','%'.$buscar.'%')->union($activosChasis);
        
        $activosCodSysHunter = DB::table('Activo')->select(DB::raw('CodSysHunter as Activo'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosMotor)->limit(100)->get();
        

        foreach($activosCodSysHunter as $activoCodSysHunter){
            $response[] = array("label"=>$activoCodSysHunter->Activo);
         }
        //$usuario = $usuario.' Usuario';
        //$entidad = DB::table('Entidad')->where('IdEntidad','LIKE','%'.$buscar.'%')->union($usuario)->get();
        
        return response()->json($response);
        //return $entidad;
    
    }


    public function buscarActivoConId(Request $request)
    {
       
        $buscar = $request->search;

        //$idUsuario = $request->idUsuario;
        //$idSubUsuario = $request->idSubUsuario;

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');
        
        if($idSubUsuario=="0")
        {
        
            $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo, IdActivo as Id'))->where('Alias','LIKE','%'.$buscar.'%');
            
            $activosChasis = DB::table('Activo')->select(DB::raw('Chasis as Activo, IdActivo as Id'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);

            $activosMotor = DB::table('Activo')->select(DB::raw('Motor as Activo, IdActivo as Id'))->where('Motor','LIKE','%'.$buscar.'%')->union($activosChasis);
            
            $activosCodSysHunter = DB::table('Activo')->select(DB::raw('CodSysHunter as Activo, IdActivo as Id'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosMotor)->limit(100)->get();
            

            foreach($activosCodSysHunter as $activoCodSysHunter){
                  $response[] = array("label"=>$activoCodSysHunter->Activo,"value"=>$activoCodSysHunter->Id);
               }
         }else
         {
            $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo, IdActivo as Id'))->where('Alias','LIKE','%'.$buscar.'%')->get();
            foreach ($activosAlias as $activo) {
               if($idCategoria=="10")
               {
                  $activoSubUsuario = DB::table('ActivoSubUsuario')->select('idActivo')
                                                                ->where('idActivo','=',$activo->Id)
                                                                ->where('IdUsuario','=',$idUsuario)
                                                                ->where('IdSubUsuario','=',$idSubUsuario)->get();
               }else
               {
                  $activoSubUsuario = DB::table('ActivoSubUsuario')->select('idActivo')
                                                                ->where('idActivo','=',$activo->Id)
                                                                ->where('IdUsuario','=',$idUsuario)
                                                                ->get();
               }
               try {
                  if($activoSubUsuario[0])
                  {
                     $response[] = array("label"=>$activo->Activo,"value"=>$activo->Id);
                  }else
                  {
                     $response[] = array();
                  }
               } catch (\Throwable $th) {
                  //$response[] = array();
               }
               
            }
             
             
             
         }

        
        return response()->json($response);
        //return $entidad;
    
    }

   public function buscarActivoConVId(Request $request)
   {
       
      $buscar = $request->search;
      
      
      $response = array();
      $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo, IdActivo as Id, Alias as Placa'))->where('Alias','LIKE','%'.$buscar.'%')->limit(20)->get();
   
      //$activosChasis = DB::table('Activo')->select(DB::raw('Chasis as Activo, IdActivo as Id, Alias as Placa'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);

      //$activosMotor = DB::table('Activo')->select(DB::raw('Motor as Activo, IdActivo as Id, Alias as Placa'))->where('Motor','LIKE','%'.$buscar.'%')->union($activosChasis);
      
      //$activosCodSysHunter = DB::table('Activo')->select(DB::raw('CodSysHunter as Activo, IdActivo as Id, Alias as Placa'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosMotor)->limit(20)->get();
      
      
      //foreach($activosCodSysHunter as $activoCodSysHunter){
      foreach($activosAlias as $activoCodSysHunter){
         
         $response[] = array("label"=>$activoCodSysHunter->Activo,"value"=>$activoCodSysHunter->Id,"placa"=>$activoCodSysHunter->Placa);
      }
        
        
        
        
        
      return response()->json($response);
      //return $entidad;
    
   }

    public function buscarVid(Request $request)
    {
      $placa = $request->placa;
      $vid = DB::select('select dbo.BuscarPlacaCriterio (?,?) AS vid',array($placa,'v'))[0]->vid;
      $uid = DB::select('select dbo.getuidIdDispositivo (?) AS uid',array($vid))[0]->uid;
      $response['vid'] = $vid;
      $response['uid'] = $uid;
      return response()->json($response);
    }

    public function buscarUidConVid(Request $request)
    {
      $vid = $request->vid;
      
      $uid = DB::select('select dbo.getuidIdDispositivo (?) AS uid',array($vid))[0]->uid;
      
      $response['uid'] = $uid;
      return response()->json($response);
    }

    public function buscarDatosReenvioDatosConVid(Request $request)
    {
      $vid = $request->vid;
      $placa = $request->placa;

       
      $repors = DB::select('exec spActivoUbicacionConsultar ?,?,?',array($vid,0,"12800"));
      foreach ($repors as $key => $value) {
         $reporteArreglo = explode("_",$value->Ubicacion);
         $reporte = $reporteArreglo[7];
      }

      $IPS = DB::select('exec spDispositivoIPConsultar ?',array($vid));
      foreach ($IPS as $key => $value) {
         $protocolo = $value->Protoolo;
         
      }

      $servidoresDisponibles = DB::table('ServidorFoward')->orderby('NombreServidor')->get();

      $servidoresRegistrados = DB::table('GPSUnitServidorFoward')->where('id','=',$vid)->get();

      $response['reporte'] = $reporte;
      $response['protocolo'] = $protocolo;
      $response['servidoresDisponibles'] = $servidoresDisponibles;
      $response['servidoresRegistrados'] = $servidoresRegistrados;

      return response()->json($response);

    }

    public function buscarPlacaConVid(Request $request)
    {
      $vid = $request->search;
      //$placa = DB::select('select dbo.BuscarPlacaCriterio (?,?) AS placa',array($vid,'2'))[0]->placa;

      try {
         $respuestas = DB::table('vieActivosEntidad')->select('Alias','VID')->where('VID','LIKE','%'.$vid.'%')->groupBy('VID','Alias')->limit(50)->get();

         foreach($respuestas as $respuesta){
            $response[] = array("label"=>$respuesta->VID,"value"=>$respuesta->Alias);
         }    
      } catch (\Throwable $th) {
         $response[] = $th->getMessage(); 
      }
     

      //$response[] = array("label"=>$vid,"value"=>$placa);
      return response()->json($response);
    }

   public function ActivoTIA(Request $request)
   {
      $idmonitoreo = $request->idmonitoreo;
      
      
         $resultado['data'] = DB::select('exec spMonitoreoEsActivoTIALv ?,?', array($idmonitoreo,-1));

         // SE ENVIAN DATOS DEL MONTOREO
         $resultado['estado'] = DB::table('Monitoreo')->select(DB::raw('Estado as estado, FechaHoraInicioReal as FechaHoraInicioReal, EstadoReal as EstadoReal'))->where('IdMonitoreo','=',$idmonitoreo)->get();

         // SE VERIFICA SI EL MONITOREO TIENE ALERTAS PENDIENTES POR ATENDER
         $caidas = DB::select('exec spAlertasConsultaCaidasXMonitoreo ?',array($idmonitoreo));
         $contador = 0;
         try {
            foreach ($caidas as $caida) {
               $contador++;
            }
         } catch (\Throwable $th) {
            
         }
         

         $resultado['caidas'] = $contador;
         $response = array();
         return response()->json($resultado);
         //return $resultado;//$resultado[0]->Activo;
      
   
   }
}
