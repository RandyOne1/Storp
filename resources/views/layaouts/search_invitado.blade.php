@extends('dashboard.dashboard_invitados')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <style>
        .texto-medio {
            text-align: left;
        }
    </style>

    <!-- Resto del código de la vista -->
    <form action="{{ route('buscar_invitado') }}" method="GET" id="form-busqueda">
    <div class="search-bar">
        <div class="menu-items">
            <label class="control-label col-sm-2"></label>

            <label class="control-label col-sm-2">Busqueda:</label>

        </div>
        <input type="text" name="q" placeholder="Busqueda por Titulo/Tipo/Nombre/Carrera..." class="search-input">
        <button type="submit" onclick="buscarDocumentos()">Mostrar</button>
    </div>
    </form>
    <div class="dashboard-container" style="background-color: #fff;">

        <div id="welcome-message-container" class="welcome-message" style="z-index: -1; background-color: #fff;">
            <img src="{{ asset('imagenes/Busq.png') }}" alt="Bien" height="40">
            <hr>
            <p>Por favor, utiliza la barra para buscar algun trabajo o da click a mostrar para desplegar todos los trabajos. </p>
        </div>



        <div class="glide" style="background-color: #fff">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @if (isset($resultados) && count($resultados) > 0)
                        @foreach ($resultados as $resultado)
                            <li class="glide__slide">
                                <div class="pdf-item">
                                    {{-- <img src="{{ asset('imagenes/medalla.png') }}" class="medalla" alt="Medalla" height="20"> --}}
                                    <a href="{{ asset('storage/' . $resultado->ubicacion_archivo) }}" target="_blank">
                                        <img src="{{ asset($resultado->u_vistaprevia) }}" alt="Vista previa">
                                    </a>
                                    <div class="texto-medio">
                                        <h4>{{ Str::limit($resultado->titulo), 110 }}</h4>
                                        <p>{{ Str::limit($resultado->descripcion, 100) }}</p>
                                        <!-- Limitar a 100 caracteres -->
                                        <p>Por: <b>{{ $resultado->nombrealumno }}</b></p>
                                        <p>Tipo: <b>{{ $resultado->tipo }}</b></p>
                                        <p>Carrera: <b>{{ $resultado->carrera }}</b></p>
                                        <p>Año: <b>{{ $resultado->año }}</b></p>
                                        <p>Mes: <b>{{ $resultado->mes }}</b></p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="glide__slide">
                            <div class="pdf-item">

                                <img src="{{ asset('imagenes/sin2.png') }}" alt="Preview">
                                <h3>No se encontraron resultados</h3>
                                <p>Intente realizar una búsqueda.</p>
                            </div>
                        </li>
                    @endif
                    <!-- Agrega más elementos PDF según sea necesario -->
                </ul>
            </div>
        </div>





    </div>
@endsection
