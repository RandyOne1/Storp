<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DocumentoModificadoProfesor extends Notification
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
            'mensaje' => 'El alumno "' . $this->documento->nombrealumno .'" ha modificado el documento "' . $this->documento->titulo . '".',
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

