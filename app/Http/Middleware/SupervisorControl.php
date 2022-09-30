<?php

namespace XAdmin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SupervisorControl
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
            if($perfil=="1002")
                $tienePerfil = true;
        }
        if($tienePerfil)
            return $next($request);
        else
            return redirect('monitors')->withErrors('Acceso no autorizado.');
    }
}
