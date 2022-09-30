<?php

namespace XAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon; 


class ConfirmarHojaRutaClienteMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject ;//= "Notificaciones: Obtencion de registros de recorrido de la unidad "."GeoSyS realizada por el usuario: ";

    private $placa;
    private $cliente;
    private $idMonitoreo;
    private $nombreArchivo;
    private $cuerpo;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cliente,$placa,$idMonitoreo,$nombreArchivo,$asunto,$cuerpo)
    {
        
        
        $this->placa = $placa;
        $this->cliente = $cliente;
        $this->idMonitoreo = $idMonitoreo;
        $this->nombreArchivo = $nombreArchivo;
        $this->cuerpo = $cuerpo;
        
        
        $this->subject = $asunto;// "Hunter Monitoreo - Ingreso Monitoreo";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $placa = $this->placa;
        
        $cliente = $this->cliente;
        $idMonitoreo = $this->idMonitoreo;
        $nombreArchivo = $this->nombreArchivo;
        $cuerpo = $this->cuerpo;
        
        

        return $this->from('geosys@huntermonitoreo.com','CENTRAL HUNTER MONITOREO')->view('mails.hojaRutaCliente',compact('placa','cliente','idMonitoreo','cuerpo'))->attachFromStorage($nombreArchivo);
    }
}
