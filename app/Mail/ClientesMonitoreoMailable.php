<?php

namespace XAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientesMonitoreoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Hunter Monitoreo - Recordatorio Usuario y Contraseña";

    private $user;
    private $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usr,$passwd)
    {
        $this->user = $usr;
        $this->pass = $passwd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $pass = $this->pass;
        return $this->view('mails.clientesmonitoreo',compact('user','pass'));
    }
}
