<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar el facade Auth
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.mobile-login');
        } else {
            return view('auth.login');
        }
    }

    public function showRegistroForm()
    {
        $clickCount = 1;
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.mobile-registro');
        } else {
            return view('auth.register' , [
                'clickCount' => $clickCount
            ]);
        }
    }

    public function login(Request $request)
    {
        $agent = new Agent();
        // Validar las credenciales del usuario
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Autenticación exitosa
            $user = Auth::user();

            if ($user->privilegios === 'alumno') {
                return redirect()->route('dashboard');
            } elseif ($user->privilegios === 'profesor') {
                return redirect()->route('dashboard-profesor');
            } elseif ($user->privilegios === 'administrador') {
                return redirect()->route('dashboard-administrador');
            }
        } else {
            // Las credenciales no son válidas
            return redirect()->back()->withErrors(['message' => 'Correo o contraseña incorrectos, verifique por favor.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cerrar la sesión del usuario
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('mobile.mobile-login');
        } else {
            return view('auth.login');
        }
    }
}
