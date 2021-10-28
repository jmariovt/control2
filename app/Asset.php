<?php

namespace XAdmin;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    protected $fillable = [
        'TipoActivo',
        'Alias',
        'IdMarca',
        'IdModelo',
        'Observaciones',
        'CodSysHunter',
        'Estado',
        'UsuarioIngreso',
        'FechaIngreso',
        'UsuarioModificacion',
        'FechaModificacion',
        'Etiqueta',
        'Foto',
        'Chasis',
        'Motor',
        'Color',
        'Año',
        'TipoVehiculo',
        'FechaUltimoChequeo',
        'FechaUltimoMantenimiento',
        'OdometroUltimoMantenimiento',
        'HorometroUltimoMantenimiento',
        'AvaluoComercial',
        'FechaCompra',
        'BullDog',
        'Zona',
        'ColorSecundario',
        'Carroceria',
        'TipoCombustible',
        'Pasajeros',
        'Peso',
        'Cilindraje',
        'Ejes',
        'Propietario',
        'VelMax',
        'IdOTT',
        'Disco',
        'spUpdate',
        'IdLinea',
        'IdCorredor',
        'idEstadoOperativo',
        'IdCiaAseguradora',
        'IdClase',
        'uid'
      ];
   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Activo';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'IdActivo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    const CREATED_AT = 'FechaIngreso';
    const UPDATED_AT = 'FechaModificacion';
}
