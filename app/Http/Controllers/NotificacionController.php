<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;

class NotificacionController extends Controller
{
    public function mostrarNotificaciones()
    {
        // Obtener el usuario autenticado (profesor actual)
        {
            // Obtener el usuario autenticado (profesor actual)
            $user = Auth::user();

            // Obtener las notificaciones del profesor relacionadas con documentos modificados
            $notificaciones = $user->unreadNotifications->filter(function ($notification) {
                return $notification->type === DocumentoModificadoProfesor::class;
            });

            $notificacionesB = $user->unreadNotifications->filter(function ($notification) {
                return $notification->type === DocumentoModificadoAlumnoB::class;
            });

            // Obtener la información de los documentos relacionados con las notificaciones
            $documentos = [];
            foreach ($notificaciones as $notificacion) {
                $documentoId = $notificacion->data['Id'];
                $documento = Documento::find($documentoId);
                if ($documento) {
                    $documentos[] = $documento;
                }
            }
            foreach ($notificacionesB as $notificacion) {
                $documentoId = $notificacion->data['Id'];
                $documento = Documento::find($documentoId);
                if ($documento) {
                    $documentos[] = $documento;
                }
            }

            // Marcar las notificaciones como leídas
            $user->unreadNotifications->markAsRead();

            return view('layaouts.notificaciones', [
                'notificaciones' => $notificaciones,
                'documentos' => $documentos,
            ]);
        }
    }

    public function mostrarNotificacionesA()
    {
        // Obtener el usuario autenticado (profesor actual)
        {
            // Obtener el usuario autenticado (profesor actual)
            $user = Auth::user();

            // Obtener las notificaciones del profesor relacionadas con documentos modificados
            $notificaciones = $user->unreadNotifications->filter(function ($notification) {
                return $notification->type === DocumentoModificadoAlumno::class;
            });

            $notificacionesB = $user->unreadNotifications->filter(function ($notification) {
                return $notification->type === DocumentoModificadoProfesorB::class;
            });

            // Obtener la información de los documentos relacionados con las notificaciones
            $documentos = [];
            foreach ($notificaciones as $notificacion) {
                $documentoId = $notificacion->data['Id'];
                $documento = Documento::find($documentoId);
                if ($documento) {
                    $documentos[] = $documento;
                }
            }

            foreach ($notificacionesB as $notificacion) {
                $documentoId = $notificacion->data['Id'];
                $documento = Documento::find($documentoId);
                if ($documento) {
                    $documentos[] = $documento;
                }
            }

            // Marcar las notificaciones como leídas
            $user->unreadNotifications->markAsRead();

            return view('layaouts.notificaciones', [
                'notificaciones' => $notificaciones, 'notificacionesB' => $notificacionesB,
                'documentos' => $documentos,
            ]);
        }
    }

    public function eliminarNotificacionP(Request $request)
    {
        $id = $request->input('id');

        // Obtener el usuario autenticado
        $user = Auth::user();


        // Buscar la notificación por su ID y verificar que pertenezca al usuario autenticado
        $notificacion = $user->notifications()->where('id', $id)->first();

        if ($notificacion) {
            // Marcar la notificación como leída antes de eliminarla
            $notificacion->markAsRead();

            // Eliminar la notificación de la base de datos
            $notificacion->delete();
        }

        $notificaciones = $user->unreadNotifications->filter(function ($notification) {
            return $notification->type === DocumentoModificadoAlumno::class;
        });

        $notificacionesB = $user->unreadNotifications->filter(function ($notification) {
            return $notification->type === DocumentoModificadoProfesorB::class;
        });
        foreach ($notificaciones as $notificacion) {
            $documentoId = $notificacion->data['Id'];
            $documento = Documento::find($documentoId);
            if ($documento) {
                $documentos[] = $documento;
            }
        }

        foreach ($notificacionesB as $notificacion) {
            $documentoId = $notificacion->data['Id'];
            $documento = Documento::find($documentoId);
            if ($documento) {
                $documentos[] = $documento;
            }
        }
        // Redirigir de vuelta a la página de notificaciones
        return redirect()->route('dashboard-profesor');
    }

    public function eliminarNotificacion(Request $request)
    {
        $id = $request->input('id');

        // Obtener el usuario autenticado
        $user = Auth::user();


        // Buscar la notificación por su ID y verificar que pertenezca al usuario autenticado
        $notificacion = $user->notifications()->where('id', $id)->first();

        if ($notificacion) {
            // Marcar la notificación como leída antes de eliminarla
            $notificacion->markAsRead();

            // Eliminar la notificación de la base de datos
            $notificacion->delete();
        }

        $notificaciones = $user->unreadNotifications->filter(function ($notification) {
            return $notification->type === DocumentoModificadoAlumno::class;
        });

        foreach ($notificaciones as $notificacion) {
            $documentoId = $notificacion->data['Id'];
            $documento = Documento::find($documentoId);
            if ($documento) {
                $documentos[] = $documento;
            }
        }

        // Redirigir de vuelta a la página de notificaciones
        return redirect()->route('dashboard');
    }

    public function eliminarNotificacionTodas(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Marcar todas las notificaciones como leídas
        $user->unreadNotifications->markAsRead();

        // Eliminar todas las notificaciones de la base de datos
        $user->notifications()->delete();

        // Redirigir de vuelta a la página de notificaciones
        return redirect()->route('dashboard');
    }
}
