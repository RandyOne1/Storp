@extends('dashboard.dashboard_invitados')

@section('content')
    <div id="welcome-message-container" class="welcome-message">
        <img src="{{ asset('imagenes/exitosubida.png') }}" alt="Bien" height="100">
        <hr>
        <p>Ahora se ha registrado correctamente su usuario ya puede iniciar sesión.
        </p>
        <a href="{{ route('logout') }}"><button class="logout-button">Iniciar sesión</button></a>
    </div>
@endsection
