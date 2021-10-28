<?php

namespace XAdmin\Http\Controllers\Auth;

use XAdmin\Http\Controllers\Controller;
use XAdmin\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    //protected $Usuario;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Get Usuario property.
     *
     * @return string
     */
    /*public function Usuario()
    {
        return $this->Usuario;
    }*/

    public function authenticate(Request $request)
    {

        $user = DB::table('Usuario')->where('Usuario','=', $request->Usuario)->where('Clave', $request->Clave)->first();

        /*$user = User::where('Usuario', $request->Usuario)
            ->where('Clave', $request->Clave)
            ->first();*/

        if($user) 
        {
            //Auth::loginUsingId($user->id);
            // -- OR -- //
            Auth::login($user);
            $usuarioHojaRuta = DB::select('exec spUsuarioHojaRutaConsultar ?,?',array($request->Usuario, $request->Clave));
            session(['ID' => $usuarioHojaRuta->ID]);
            session(['NombreCliente' => $usuarioHojaRuta->NombreCliente]);
            session(['TipoCliente' => $usuarioHojaRuta->TipoCliente]);
            //$this->NombreCliente=$usuarioHojaRuta->NombreCliente;
            //$this->TipoCliente=$usuarioHojaRuta->TipoCliente;
           
            return redirect()->route('monitors');
        } else 
        {
            return redirect()->back()->withInput();
        }
    }
}
