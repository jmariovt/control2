<?php

namespace XAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon; 


class MensajeRegistrosRecorridoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject ;//= "Notificaciones: Obtencion de registros de recorrido de la unidad "."GeoSyS realizada por el usuario: ";

    private $placa;
    private $usuario;
    private $fechaDesde;
    private $fechaHasta;
    private $horaActual;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($placa,$usuario,$fechaDesde,$fechaHasta)
    {
        
        
        $this->placa = $placa;
        $this->usuario = $usuario;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
        
        
        $this->subject = "Notificaciones: Obtencion de registros de recorrido de la unidad ".$placa." GeoSyS realizada por el usuario: ".$usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuario = $this->usuario;
        
        $fechaDesde = $this->fechaDesde;
        $fechaHasta = $this->fechaHasta;
        
        $horaActual = Carbon::now();
        $horaActual = $horaActual->format('H:i:s');

        $placa = $this->placa;

        return $this->from('geosys@huntermonitoreo.com',)->view('mails.registrosRecorrido',compact('usuario','fechaDesde','fechaHasta','horaActual','placa'));
    }
}
