<?php

namespace XAdmin;

use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
    use Notifiable;

    protected $table = 'Puntos_Geocerca';
    //protected $primaryKey = 'IdUsuario';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'IdGeocerca','Secuencia','Lat','Lon','FechaIngreso',
     ];

     
}
