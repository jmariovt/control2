<?php

namespace XAdmin\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Closure;

class EsPostVenta
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
        $aplicacion = 7; //IdAplicación en tabla Aplicacion =   7 PX Admin


        $ejecucion = 0;
        $mensaje = "";

        if(session('idApp')==7)
            return $next($request);
        else
            return redirect('monitors');

       

       
    }
}