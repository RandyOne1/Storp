<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {

        // Realizar la consulta a la base de datos para obtener el nombre del usuario
        $clickCount = 0;
        $user = Auth::user();

        // Obtener las notificaciones del profesor
        $notificaciones = $user->unreadNotifications;
        // Pasar el nombre del usuario a la vista
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.dashboard-mobile.dashboard-mobile', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('dashboard.dashboard', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
    }

    public function indexProfesor()
    {

        // Realizar la consulta a la base de datos para obtener el nombre del usuario
        $clickCount = 0;
        // Pasar el nombre del usuario a la vista
        $agent = new Agent();
        $user = Auth::user();

        // Obtener las notificaciones del profesor
        $notificaciones = $user->unreadNotifications;
        if ($agent->isMobile()) {
            return view('mobile.dashboard-mobile.dashboard-mobile', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('dashboard.dashboard_profesores', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
    }

    public function indexAdministrador()
    {
        // Realizar la consulta a la base de datos para obtener el nombre del usuario
        $clickCount = 0;
        // Pasar el nombre del usuario a la vista
        $agent = new Agent();
        $user = Auth::user();

        // Obtener las notificaciones del profesor
        $notificaciones = $user->unreadNotifications;
        if ($agent->isMobile()) {
            return view('mobile.dashboard-mobile.dashboard-mobile', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('dashboard.dashboard_administrador', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
    }

    public function Obtenernombre()
    {
        // Obtener el ID del usuario desde la sesión

    }



    public function showUploadDocumentView()
    {
        $clickCount = 1;
        // Pasar el nombre del usuario a la vista
        $agent = new Agent();
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        if ($agent->isMobile()) {
            return view('mobile.mobile-layouts.mobile-upload-document', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('layaouts.upload-document', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
    }

    public function showUploadDocumentViewProfesores()
    {
        $clickCount = 1;
        // Pasar el nombre del usuario a la vista
        $agent = new Agent();
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        if ($agent->isMobile()) {
            return view('mobile.mobile-layouts.mobile-upload-document', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('layaouts.upload-document_profesor', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
    }

    public function showSearchView()
    {

        // Realizar la consulta a la base de datos para obtener el nombre del usuario

        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        $clickCount = 1;
        return view('layaouts.search', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ]);
    }

    public function showSearchViewProfesores()
    {

        // Realizar la consulta a la base de datos para obtener el nombre del usuario

        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        $clickCount = 1;
        return view('layaouts.search_profesor', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ]);
    }

    public function showMis_DocuemntosView()
    {
        $clickCount = 1;
        $user = Auth::user();

        $notificaciones = $user->unreadNotifications;
        // Construir el nombre completo del usuario
        $nombreCompleto = $user->name . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno;

        // Obtener los documentos del usuario autenticado
        $documentos = DB::table('docs')
            ->where('nombrealumno', $nombreCompleto)
            ->get();
        return view('layaouts.mis_documentos', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('documentos', $documentos);
    }

    public function showMis_DocuemntosViewProfesores()
    {
        $clickCount = 1;
        $user = Auth::user();

        // Construir el nombre completo del usuario
        $nombreCompleto = $user->name . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno;

        $notificaciones = $user->unreadNotifications;
        // Obtener los documentos del usuario autenticado
        $documentos = DB::table('docs')
            ->where('nombrealumno', $nombreCompleto)
            ->get();
        return view('layaouts.mis_documentos_profesor', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('documentos', $documentos);
    }

    public function showSeguimientoViewProfesores()
    {
        $clickCount = 1;
        $user = Auth::user();

        $notificaciones = $user->unreadNotifications;
        // Construir el nombre completo del usuario
        $nombreCompleto = $user->name . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno;

        // Obtener los documentos del usuario autenticado
        $documentos = DB::table('docs')
            ->where('asesores', 'like', '%' . $nombreCompleto . '%')
            ->get();
        return view('layaouts.seguimiento_profesor', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('documentos', $documentos);
    }

    public function showSeguimientoViewAdministradorDocumentos()
    {
        $clickCount = 1;
        $user = Auth::user();

        $notificaciones = $user->unreadNotifications;
        // Construir el nombre completo del usuario

        // Obtener los documentos del usuario autenticado
        $documentos = DB::table('docs')
            ->get();
        return view('layaouts.seguimiento_administrador_documentos', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('documentos', $documentos);
    }

    public function showSeguimientoViewAdministradorUsuario()
    {
        $clickCount = 1;
        $user = Auth::user();

        $notificaciones = $user->unreadNotifications;
        // Construir el nombre completo del usuario
        $nombreCompleto = $user->name . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno;

        // Obtener los documentos del usuario autenticado
        $usuarios = DB::table('users')
            ->get();
        return view('layaouts.seguimiento_administrador_usuarios', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('usuarios', $usuarios);
    }

    public function showExitoView()
    {
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;

        $clickCount = 1;
        return view('layaouts.exito', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ]);
    }

    public function misDocumentos()
    {
        // Obtener el ID del usuario en sesión desde la sesión
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;

        // Construir el nombre completo del usuario
        $nombreCompleto = $user->name . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno;

        // Obtener los documentos del usuario autenticado
        $documentos = DB::table('docs')
            ->where('nombrealumno', $nombreCompleto)
            ->get();

        return view('mis_documentos', ['notificaciones' => $notificaciones])->with('documentos', $documentos);
    }
    public function InvitadoView()
    {
        $clickCount = 0;
        return view('dashboard.dashboard_invitados', ['clickCount' => $clickCount]);
    }

    public function InvitadoViewMobile()
    {
        $clickCount = 0;
        return view('mobile.dashboard-mobile.dashboard-mobile__invitados', ['clickCount' => $clickCount]);
    }


    public function showSearchViewInvitados()
    {
        $clickCount = 1;
        return view('layaouts.search_invitado', ['clickCount' => $clickCount]);
    }

    public function showUploadDocumentViewAdministrador()
    {
        $clickCount = 1;
        $user = Auth::user();
        $agent = new Agent();
        $notificaciones = $user->unreadNotifications;
        if ($agent->isMobile()) {
            return view('mobile.mobile-layouts.mobile-upload-document', [
                'clickCount' => $clickCount
            ]);
        } else {
            return view('layaouts.upload-document_administrador', [
                'clickCount' => $clickCount, 'notificaciones' => $notificaciones
            ]);
        }
}
}
