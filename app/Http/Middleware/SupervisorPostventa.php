<?php

namespace XAdmin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SupervisorPostventa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $usuario = Auth::user()->Usuario;
            $clave = Auth::user()->Clave;
        } catch (\Throwable $th) {
            return redirect('/login');
        }

        $perfiles = session('perfil');
        $arregloPerfiles = explode(";",$perfiles);
        $tienePerfil = false;

        foreach ($arregloPerfiles as $perfil) {
            if($perfil=="1004")
                $tienePerfil = true;
        }
        if($tienePerfil)
            return $next($request);
        else
            return redirect('/postventa/consultaGeneral/')->withErrors('Acceso no autorizado.');
    }
}
