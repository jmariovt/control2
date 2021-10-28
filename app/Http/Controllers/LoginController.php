<?php

namespace XAdmin\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function showpv()
    {
        return view('auth.loginpostventa');
    }

    public function authenticate(Request $request)
    {
        $validator = $request->validate([
            'Usuario'     => 'required',
            'Clave'  => 'required|min:4',
            'Aplicacion' => 'required'
        ]);

        $idAplicacion = $request->Aplicacion;

        if (Auth::attempt($validator)) {
            
            //return $validator;
            //return redirect()->route('monitors');


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
            return redirect()->back()->withInput()->withErrors('Usuario o clave incorrectos para la aplicación seleccionada.');
        }  // Comentado 06 de agosto de 2021

        /*$usuario = $request->Usuario;
        $plain = $request->Clave;
        $idAplicacion = $request->Aplicacion;
        $ejecucion = 0;
        $mensaje = "";

        try {
            $resultado = DB::select('exec spAutenticacionMOBILEDEVICELv ?,?,?',array($usuario,$plain,$idAplicacion));
        } catch (\Throwable $th) {
            //throw $th;
        }

        
        
        try {
            if( $resultado[0]->Ejecucion)
            {
                $ejecucion = $resultado[0]->Ejecucion;
                $mensaje = $resultado[0]->Mensaje;
            }      
        } catch (\Throwable $th) {
            $ejecucion = 1;
        }

        if($ejecucion)
        {
            switch ($idAplicacion) {
                case 37:
                    $ruta = 'monitors';
                    break;
                
                default:
                    $ruta = 'postVenta';
                    break;
            }

            return redirect()->route($ruta);
        }else {
            return redirect()->back()->withInput()->withErrors('Usuario o clave incorrectos para la aplicación seleccionada.');
        }*/
        
        
        
        
        
        /*
        $user = DB::table('Usuario')->where('Usuario','=', $request->Usuario)->where('Clave', $request->Clave)->first();

        

        if($user) 
        {
            //Auth::loginUsingId($user->id);
            // -- OR -- //
            Auth::login($user);
            return redirect()->route('home');
        } else 
        {
            return redirect()->back()->withInput();
        }*/
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return back();
    }
}
