<?php

namespace XAdmin\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Closure;

class EsMonitoreo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return $next($request);
        
        try {
            Log::info('Mariolog EsMonitoreo user: '.Auth::user());
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            try {
                Log::info('Mariolog  EsMonitoreo subuser: '.Auth::guard('websubusers')->user());//Auth::user());
                $usuario = Auth::guard('websubusers')->user()->Usuario; //Auth::user()->Usuario;
                $clave = Auth::guard('websubusers')->user()->Clave; //Auth::user()->Clave;
            } catch (\Throwable $th) {
                return redirect('/login');
            }
            
        }
        

        $aplicacion = 37; //IdAplicación en tabla Aplicacion =   37	XADMIN


        $ejecucion = 0;
        $mensaje = "";
        
        /*if(session('idApp')==$aplicacion)
            return $next($request);
        else
            return redirect('/monitors/consultaGeneral/');*/


        $perfiles = session('perfil');
        $arregloPerfiles = explode(";",$perfiles);
        $tienePerfil = false;
    
        foreach ($arregloPerfiles as $perfil) {
            if($perfil=="1003"||$perfil=="4"||$perfil=="1002")
                $tienePerfil = true;
        }
        
        

        if($tienePerfil)
        {
            Log::info('Mariolog tiene perfil EsMonitoreo');
            return $next($request);
        }
        else
        {   
            Log::info('Mariolog No tiene perfil EsMonitoreo'); 
            return redirect('/postventa/consultaGeneral/')->withErrors('Acceso no autorizado.');
        }

        
    }
}
