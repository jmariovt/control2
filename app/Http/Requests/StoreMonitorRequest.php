<?php

namespace XAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreMonitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * $monitor->idActivo = $request->input('alias');
        $monitor->FechaHoraInicio = $request->input('FechaHoraInicio');
        $monitor->FechaHoraFin = $request->input('FechaHoraFin');
        $monitor->Estado = $request->input('Estado');
        $monitor->TipoMonitoreo = $request->input('TipoMonitoreo');
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required',
            //'FechaHoraInicio' => 'required',
            //'FechaHoraFin' => 'required',
            'Estado' => 'required',
            'TipoMonitoreo' => 'required',
            'idActivo' => 'required',
            'producto' => 'required',
            'LimiteVelocidad' => 'numeric',
            'Kilometros' => 'numeric',
            'FechaHoraInicioFinCreate' => 'required'           
            
        
        ];
    }
}
