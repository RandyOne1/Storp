<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected function redirectTo()
{
    // Si existe un mensaje de éxito en la sesión flash, redirige al usuario a la vista de éxito
     // Borra el mensaje de éxito de la sesión flash
        return route('registro-exitoso'); // Redirige a la vista de éxito

}



    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $clickCount = 1;
        return User::create([
            'name' => $data['name'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'matricula' => $data['matricula'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nombre_concatenado' => $data['name'] . ' ' . $data['apellido_paterno'] . ' ' . $data['apellido_materno'],
        ]);
        Session::flash('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');

        // Redirigir al usuario nuevamente a la vista de registro
        return view('layaouts.registro-exitoso', ['clickCount' => $clickCount]);
    }

    // Optionally, you can override the register method if needed.
    // public function register(Request $request)
    // {
    //     // Custom registration logic here
    // }
}
