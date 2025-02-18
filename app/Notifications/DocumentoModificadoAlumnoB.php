<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DocumentoModificadoAlumnoB extends Notification
{
    use Queueable;

    public $documento;

    /**
     * Create a new notification instance.
     */
    public function __construct($documento)
    {
        $this->documento = $documento;
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'documento_id' => $this->documento->id,
            'mensaje' => 'Tu documento "' . $this->documento->titulo . '" ha sido BORRADO por el profesor.',
        ]);
    }

    public function via($notifiable)
    {
        // Especifica los canales de entrega que deseas utilizar
        return ['database']; // Muestra la notificación en la base de datos
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
