<?php

namespace XAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsociarClienteMonitoreoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Hunter Monitoreo - Acceso para Lista Verificación";

    private $terceroNombre;
    private $tercero;
    private $IdMonitoreo;
    private $textoMonitoreo;
    private $clienteNombre;
    private $tipoCliente;
    private $clave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($terceroNombre,$correo,$tercero,$clave,$IdMonitoreo,$textoMonitoreo,$clienteNombre,$tipoCliente)
    {
        $this->terceroNombre = $terceroNombre;
        $this->tercero = $tercero;
        $this->IdMonitoreo = $IdMonitoreo;
        $this->textoMonitoreo = $textoMonitoreo;
        $this->clienteNombre = $clienteNombre;
        $this->tipoCliente = $tipoCliente;
        $this->clave = $clave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $terceroNombre = $this->terceroNombre;
        $tercero = $this->tercero;
        $IdMonitoreo = $this->IdMonitoreo;
        $textoMonitoreo = $this->textoMonitoreo;
        $clienteNombre = $this->clienteNombre;
        $tipoCliente = $this->tipoCliente;   
        $clave = $this->clave;
        return $this->view('mails.clientesmonitoreo',compact('terceroNombre','tercero','clave','IdMonitoreo','textoMonitoreo','clienteNombre','tipoCliente'));
    }
}
