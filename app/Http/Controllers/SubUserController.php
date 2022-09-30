<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegisterUsers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;


class SubUserController extends Controller
{
    //use AuthenticatesUsers;
    protected $loginView = 'auth.subusuario.login'; 
    protected $guard = 'websubusers';

    public function show()
    {
        return view('auth.subusuario.login');
    }

    public function authenticate(Request $request)
    {
        $validator = $request->validate([
            'Usuario'     => 'required',
            //'SubUsuario'     => 'nullable',
            'Clave'  => 'required|min:4',
            'Aplicacion' => 'required'
        ]);

        $idAplicacion = $request->Aplicacion;

       if(Auth::guard('websubusers')->attempt($validator))
        {
            //$request->session()->regenerate();
            Log::info("Mariolog: ingresa attempt en SubUserController");
            switch ($idAplicacion) {
                case 37:
                    $ruta = 'monitors';
                    break;
                
                default:
                    $ruta = 'postVenta';
                    break;
            }

            return redirect()->route($ruta);
        }else
        {
            return redirect()->back()->withInput()->withErrors('Datos incorrectos para la aplicación seleccionada o debe restablecer su contraseña.');
        }  
       
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/externo/login');
    }

}
