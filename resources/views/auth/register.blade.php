@extends('dashboard.dashboard_invitados')

@section('content')
<style>
    .container{
        margin-bottom: 25px;
    }
</style>
<head>
    <link href="{{ asset('assets/css/cdn.jsdelivr.net_npm_bootstrap@5.3.0-alpha1_dist_css_bootstrap.min.css')}}" rel="stylesheet">
</head>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">{{ __('Registrarse') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="apellido_paterno" class="form-label">{{ __('Apellido Paterno*') }}</label>
                                <input id="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno">
                                @error('apellido_paterno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="apellido_materno" class="form-label">{{ __('Apellido Materno*') }}</label>
                                <input id="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" required autocomplete="apellido_materno">
                                @error('apellido_materno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="matricula" class="form-label">{{ __('Matrícula*') }}</label>
                                <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') }}" required autocomplete="matricula">
                                @error('matricula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Correo electrónico*') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña*') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirmar contraseña*') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Registrarse') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/vendor/jquery-1.10.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>


    <script src="{{ asset('assets/js/jquery.backstretch.min.js') }}"></script>
    <script>
        jQuery.backstretch([
            "{{ asset('imagenes/fondob7.jpg') }}", "{{ asset('imagenes/fondob2.jpg') }}",
            "{{ asset('imagenes/fondob8.jpg') }}", "{{ asset('imagenes/fondob5.jpg') }}"
        ], {
            duration: 4000,
            fade: 1000
        });
    </script>
@endsection
