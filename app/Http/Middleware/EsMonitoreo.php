<?php

namespace XAdmin\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        
        try {
            $usuario = Auth::user()->Usuario;
            $clave = Auth::user()->Clave;
        } catch (\Throwable $th) {
            return redirect('/login');
        }
        

        

        


         


        $aplicacion = 37; //IdAplicación en tabla Aplicacion =   37	XADMIN


        $ejecucion = 0;
        $mensaje = "";
        
        if(session('idApp')==$aplicacion)
            return $next($request);
        else
            return redirect('/monitors/consultaGeneral/');

        
    }
}
