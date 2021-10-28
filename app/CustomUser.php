<?php

namespace XAdmin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'Usuario';
    protected $primaryKey = 'IdUsuario';
    //protected $table = 'RQ_Agentes';

    protected $fillable = [
        'Usuario','IdUsuario','Nombre','Clave'
    ];

    /*protected $hidden = [
        'Clave', 'remember_token',
    ];*/

    public function getAuthPassword()
    {
      return $this->Clave;
    }
}
