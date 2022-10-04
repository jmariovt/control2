<?php

namespace Illuminate\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

class EloquentUserProvider implements UserProvider
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        return $this->newModelQuery($model)
                    ->where($model->getAuthIdentifierName(), $identifier)
                    ->first();
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        $retrievedModel = $this->newModelQuery($model)->where(
            $model->getAuthIdentifierName(), $identifier
        )->first();

        if (! $retrievedModel) {
            return;
        }

        $rememberToken = $retrievedModel->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token)
                        ? $retrievedModel : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        $user->setRememberToken($token);

        $timestamps = $user->timestamps;

        $user->timestamps = false;

        $user->save();

        $user->timestamps = $timestamps;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            Str::contains($this->firstCredentialKey($credentials), 'password'))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if($key<>'Aplicacion')  // Validación puesta para que no agregue campo 'Aplicacion' a columnas a validar en Base de datos 06/08/2021
            {
                if (Str::contains($key, 'password')) {
                    continue;
                }
    
                if (is_array($value) || $value instanceof Arrayable) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
            
        }

        return $query->first();
    }

    /**
     * Get the first key from the credential array.
     *
     * @param  array  $credentials
     * @return string|null
     */
    protected function firstCredentialKey(array $credentials)
    {
        foreach ($credentials as $key => $value) {
            return $key;
        }
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        /***
         * 1002	SUPERVISOR CONTROL
         * 1003	AGENTE CONTROL
         */

        //$plain = $credentials['password']; original
        //try {
            $usuario = $credentials['Usuario'];
        //} catch (\Throwable $th) {
        //    $usuario = $credentials['SubUsuario'];
        //}
        
        $plain = $credentials['Clave'];
        $idAplicacion = 37;//$credentials['Aplicacion']; //37
        $ejecucion = 0;
        $mensaje = "";
        $ipAddr=\Request::ip();
        $ejecucionOut="";
        $mensajeOut="";
        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Ejecuta spMSAMpAutenticacionV2, usuario '.$usuario.' - '.$fechaAhora);
        //$resultado = DB::select('exec spAutenticacionMOBILEDEVICE ?,?,?,?,?,?',array($usuario,$plain,$idAplicacion,$ipAddr,$ejecucionOut,$mensajeOut));
        
        try{
            //$resultado = DB::select('exec spMSAMpAutenticacionV2 ?,?,?,?,?,?,?,?,?,?,?,?,?',array($usuario,$plain,$idAplicacion,'','','','','',$ipAddr,0.0,0.0,$ejecucionOut,$mensajeOut));
            $resultado = DB::select('exec spAutenticacionMOBILEDEVICE ?,?,?,?,?,?',array($usuario,$plain,$idAplicacion,$ipAddr,$ejecucionOut,$mensajeOut));
        } catch (\Throwable $th) {
            return false;
        }

        
        $fechaAhora = Carbon::now();
        $fechaAhora = $fechaAhora->format('d/m/Y H:i:s');
        Log::info('Lentitud. Ha ejecutado spMSAMpAutenticacionV2, usuario '.$usuario.' - '.$fechaAhora);

        

        
        
        try {
            if( $resultado[0]->Ejecucion == 0 || $resultado[0]->Ejecucion == 1)
            {
                $ejecucion = $resultado[0]->Ejecucion;
                $mensaje = $resultado[0]->Mensaje;
                Log::info('Mensaje: '.$mensaje);
                if($ejecucion==1)
                    $perfiles = $resultado[0]->Perfiles;

            }      
        } catch (\Throwable $th) {
            $ejecucion = 1;
        }

        if($ejecucion==1)
        {
            $perfiles = $resultado[0]->Perfiles;
            $tipoUsuario = $resultado[0]->TipoUsuario;
            $IdUsuario = $resultado[0]->IdUsuario;
            $idSubUsuario = $resultado[0]->IdSubUsuario;
            $idCategoria = $resultado[0]->IdCategoria;
            $descripcionCategoria = $resultado[0]->DescripcionCategoria;
            if($idSubUsuario=="0")
            {
                $nombre = $resultado[0]->NombreCompleto;
            }else
            {
                $registroNombre = DB::table('SubUsuario')->select('NombreCompleto')->where('IdUsuario','=',$IdUsuario)->where('IdSubUsuario','=',$idSubUsuario)->get();
                $nombre = $registroNombre[0]->NombreCompleto;
            }
            
            

            session(['idApp' => $idAplicacion]);
            session(['perfil' => $perfiles]);
            session(['idUsuario' => $IdUsuario]);
            session(['tipoUsuario' => $tipoUsuario]);  // (1) Usuario interno - (2) SubUsuario
            session(['idSubUsuario' => $idSubUsuario]); // (0) Usuario interno - (>0) SubUsuario
            session(['idCategoria' => $idCategoria]);   // (0) Usuario interno - (9) Supervisor - (10) Operador
            session(['descripcionCategoria' => $descripcionCategoria]);
            session(['nombre'=>$nombre]);
            session(['usuario'=>$usuario]);
            Log::info('Mariolog: Ha entrado subuser en validateCredentials-EloquentUserProvider '.$usuario.' plain: '.$plain.' nombre: '.$nombre.' perfiles: '.$perfiles);
            //Auth::guard('subusers')->login($user);
        }

        
        return ($plain == $user->getAuthPassword() && $ejecucion==1);
        //return ( true);
        
    }

    /** 
     * Get a new query builder for the model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newModelQuery($model = null)
    {
        return is_null($model)
                ? $this->createModel()->newQuery()
                : $model->newQuery();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * Gets the hasher implementation.
     *
     * @return \Illuminate\Contracts\Hashing\Hasher
     */
    public function getHasher()
    {
        return $this->hasher;
    }

    /**
     * Sets the hasher implementation.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @return $this
     */
    public function setHasher(HasherContract $hasher)
    {
        $this->hasher = $hasher;

        return $this;
    }

    /**
     * Gets the name of the Eloquent user model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the name of the Eloquent user model.
     *
     * @param  string  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
