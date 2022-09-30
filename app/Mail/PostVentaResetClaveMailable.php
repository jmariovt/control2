<?php

namespace XAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon; 


class PostVentaResetClaveMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject ;//= "Notificaciones: Obtencion de registros de recorrido de la unidad "."GeoSyS realizada por el usuario: ";

    
    private $usuario;
    private $clave;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario,$clave)
    {
        
        
        $this->clave = $clave;
        $this->usuario = $usuario;
        
        
        $this->subject = "Notificaciones: Envio de contraseña nueva GeoSyS realizada por el usuario: ".$usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuario = $this->usuario;
        
        $clave = $this->clave;
        
        
        $fecha = Carbon::now();
        $fecha = $fecha->format('H:i:s');

        
        return $this->from('geosys@huntermonitoreo.com',)->view('mails.postventaresetclave',compact('usuario','clave','fecha'));
    }
}
