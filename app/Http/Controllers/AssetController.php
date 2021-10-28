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
               $assets = Asset::orderby('CodSysHunter','asc')->select('IdActivo','CodSysHunter')->where('CodSysHunter', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->CodSysHunter,"value"=>$asset->IdActivo);
               }
               break;
            case 2:    // VID
               $assets = Asset::orderby('uid','asc')->select('IdActivo','uid')->where('uid', 'like', '%' .$search . '%')->limit(100)->get();
               foreach($assets as $asset){
                  $response[] = array("label"=>$asset->uid,"value"=>$asset->IdActivo);
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
        
        
        $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo, IdActivo as Id'))->where('Alias','LIKE','%'.$buscar.'%');
        
        $activosChasis = DB::table('Activo')->select(DB::raw('Chasis as Activo, IdActivo as Id'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);

        $activosMotor = DB::table('Activo')->select(DB::raw('Motor as Activo, IdActivo as Id'))->where('Motor','LIKE','%'.$buscar.'%')->union($activosChasis);
        
        $activosCodSysHunter = DB::table('Activo')->select(DB::raw('CodSysHunter as Activo, IdActivo as Id'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosMotor)->limit(100)->get();
        

        foreach($activosCodSysHunter as $activoCodSysHunter){
            $response[] = array("label"=>$activoCodSysHunter->Activo,"value"=>$activoCodSysHunter->Id);
         }
        //$usuario = $usuario.' Usuario';
        //$entidad = DB::table('Entidad')->where('IdEntidad','LIKE','%'.$buscar.'%')->union($usuario)->get();
        
        return response()->json($response);
        //return $entidad;
    
    }

    public function buscarActivoConVId(Request $request)
    {
       
        $buscar = $request->search;
        
        
        $activosAlias = DB::table('Activo')->select(DB::raw('Alias as Activo, IdActivo as Id'))->where('Alias','LIKE','%'.$buscar.'%');
        
        $activosChasis = DB::table('Activo')->select(DB::raw('Chasis as Activo, IdActivo as Id'))->where('Chasis','LIKE','%'.$buscar.'%')->union($activosAlias);

        $activosMotor = DB::table('Activo')->select(DB::raw('Motor as Activo, IdActivo as Id'))->where('Motor','LIKE','%'.$buscar.'%')->union($activosChasis);
        
        $activosCodSysHunter = DB::table('Activo')->select(DB::raw('CodSysHunter as Activo, IdActivo as Id'))->where('CodSysHunter','LIKE','%'.$buscar.'%')->union($activosMotor)->limit(100)->get();
        

        foreach($activosCodSysHunter as $activoCodSysHunter){
           
            $response[] = array("label"=>$activoCodSysHunter->Activo,"value"=>$activoCodSysHunter->Id);
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

   public function ActivoTIA(Request $request)
   {
      $idmonitoreo = $request->idmonitoreo;
      
      
         $resultado['data'] = DB::select('exec spMonitoreoEsActivoTIALv ?,?', array($idmonitoreo,-1));
         $response = array();
         return response()->json($resultado);
         //return $resultado;//$resultado[0]->Activo;
      
   
   }
}
