<?php

namespace XAdmin\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Closure;

class EsClienteExterno
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


        try {
            //$usuario = Auth::user()->Usuario;
            //$clave = Auth::user()->Clave;
            $usuario = Auth::guard('web')->user()->Usuario;
            $clave = Auth::guard('web')->user()->Clave;
        } catch (\Throwable $th) {
            Log::info('Mariolog error '.$th->getMessage());
            return redirect('/login');
        }
        $aplicacion = 7; //IdAplicación en tabla Aplicacion =   7 PX Admin


        $ejecucion = 0;
        $mensaje = "";

        $perfiles = session('perfil');
        $arregloPerfiles = explode(";",$perfiles);
        $tienePerfil = false;

        foreach ($arregloPerfiles as $perfil) {
            //if($perfil=="1000"||$perfil=="6")
            if($perfil=="1007")
                $tienePerfil = true;
        }

        //if(session('idApp')==7)
        if($tienePerfil)
        {
            Log::info('Mariolog tiene perfil ClienteExterno');
            return $next($request);
        }
        else
        {   
            Log::info('Mariolog No tiene perfil ClienteExterno'); 
            return redirect('/')->withErrors('Acceso no autorizado.');
        }


        /*
        
        $perfiles = session('perfil');
        $arregloPerfiles = explode(";",$perfiles);
        $tienePerfil = false;
        
        foreach ($arregloPerfiles as $perfil) {
            if($perfil=="1003")  // ERWIN DEBE DEFINIR
                $tienePerfil = true;
        }
        if($tienePerfil)
            return $next($request);
        else
            return redirect('/postventa/consultaGeneral/')->withErrors('Acceso no autorizado.'); */

       

       
    }
}
