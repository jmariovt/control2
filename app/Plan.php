<?php

namespace XAdmin;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PlanAccionMonitoreo';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = 'IdMonitoreo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    //const CREATED_AT = 'FechaIngreso';
}
