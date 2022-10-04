<?php

namespace XAdmin\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

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
            'Usuario'     => 'nullable',
            //'SubUsuario'     => 'nullable',
            'Clave'  => 'required|min:4',
            'Aplicacion' => 'required'
        ]);

        $idAplicacion = $request->Aplicacion;

        Log::info('Estoy en LoginController');
        
        if($request->Usuario)
        {
            Log::info('Entré a request->Usuario en LoginController');
            if (Auth::guard('web')->attempt($validator)) {
            
                //return $validator;
                //return redirect()->route('monitors');
                $hojaRuta_id = 0;
                $hojaRuta_nombreCliente = "";
                $hojaRuta_tipoCliente = "";
                try {
                    $usuarioHojaRuta = DB::select('exec spUsuarioHojaRutaConsultarLv ?,?',array($request->Usuario, $request->Clave));    
                    $hojaRuta_id = $usuarioHojaRuta[0]->ID;
                    $hojaRuta_nombreCliente = $usuarioHojaRuta[0]->NombreCompleto;
                    $hojaRuta_tipoCliente = $usuarioHojaRuta[0]->TipoCliente;
                    Log::info('MarioLogHojaRuta: Guardo datos de Hoja de Ruta de '.$request->Usuario.' Tipo de Cliente: '.$hojaRuta_tipoCliente);
                } catch (\Throwable $th) {
                    Log::info('MarioLogHojaRuta: Error al traer datos de Hoja de Ruta de '.$request->Usuario);
                }
                
                session(['hojaRuta_Id' => $hojaRuta_id]);
                session(['hojaRuta_NombreCliente' => $hojaRuta_nombreCliente]);
                session(['hojaRuta_TipoCliente' => $hojaRuta_tipoCliente]);

                Log::info('Voy a switch LoginController. Aplicacion: '.$idAplicacion);
                switch ($idAplicacion) {
                    case 37:
                        $ruta = 'monitors';
                        break;
                    case 7:
                        $ruta = 'postVenta';
                        break;
                    case 15:
                        $ruta = 'adminCliente';
                        return redirect()->route($ruta,['cliente'=>$request->Usuario]);
                        break;
                    default:
                        //$ruta = 'postVenta';
                        break;  
                }
                Log::info('Voy a switch LoginController. Ruta: '.$ruta);
                return redirect()->route($ruta);//->with('cliente',$request->Usuario);//$request->Usuario);

            }else
            {
                Log::info('Error en autorizacion LoginController');
                return redirect()->back()->withInput()->withErrors('Datos incorrectos para la aplicación seleccionada.');
            }
        }/*else if(Auth::guard('subusers')->attempt($validator))
        {
            //$request->session()->regenerate();
            switch ($idAplicacion) {
                case 37:
                    $ruta = 'monitors';  
                    break;
                
                default:
                    $ruta = 'postVenta';
                    break;
            }

            return redirect()->route($ruta);
        }*/else
        {
            Log::info('Error en LoginController');
            return redirect()->back()->withInput()->withErrors('Datos incorrectos para la aplicación seleccionada o debe restablecer su contraseña.');
        }  
       
    }




    /*public function authenticateExt(Request $request)
    {
        $validator = $request->validate([
            'SubUsuario'     => 'required',
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


        }else if(Auth::guard('subusers')->attempt($validator))
        {
            //$request->session()->regenerate();
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
        }  
       
    }*/

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return back();
    }
}
