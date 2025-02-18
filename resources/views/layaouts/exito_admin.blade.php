@extends('dashboard.dashboard_administrador')

@section('content')
    <div id="welcome-message-container" class="welcome-message">
        <img src="{{ asset('imagenes/exito.png') }}" alt="Bien" height="40">
        <hr>
        <p>Ahora su documento se ha registrado correctamente en la base de datos espere a su respectiva aprobación para
            poder visualizarlo en el apartado de ‘búsqueda’.
        </p>
    </div>
@endsection
