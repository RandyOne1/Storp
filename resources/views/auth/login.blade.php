<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/w3.css')}}">
    <style>
        body {
            padding-top: 100px;
            padding-bottom: 40px;
            opacity: 0.9;
        }

        .content {
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
        }

        .column {
            width: 48%;
            float: left;
            margin: 0 auto;
            padding: 10px;
        }

        button-container {
            display: flex;
            float: center;
        }

        button {
            margin-right: 10px;
            flex-grow: 1;
            border: none;
            padding: 0px;
            background-color: #ffffff00;
            color: #ffffff00;
            text-align: center;
            float: center;
            border-radius: 5px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-responsive.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="{{ asset('assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<body>
    <header>

    </header>


    <div class="content">
        <div style="width: 50%; float: center;margin:20px 20px 0px 350px; background-color: rgb(255, 255, 255);">
            <img src="{{ asset('imagenes/logo.png') }}" border="5" height="100"
                style="margin: 20px 20px 30px 40px;">
            <img src="{{ asset('imagenes/storp.png') }}" border="0" height="90"
                style="margin: 10px 20px 30px 10px;">
        </div>
        <div class="content"
            style="background-color: rgba(255, 255, 255, 0.671); width: 50%;margin:0px 20px 10px 350px;">
            <div class="column" style="margin:0px 0px 0px 15px;">
                <form class="w3-container" action="{{ route('login') }}" method="post">
                    @csrf
                    <p style="margin: 10px 0px 0px 0px; width: 100%;">
                        <label class="w3-label">
                            <font color="#00000">Correo</font>
                        </label>
                        <input class="w3-input w3-border " type="email" name="email">
                    </p>
                    <p style="width: 100%;">
                        <label class="w3-label">
                            <font color="#000000">Contraseña</font>
                        </label>
                        <input class="w3-input w3-border" type="password" name="password">
                    </p>
                    <div class="button-container">
                        <button class="button" style="margin: 0px 0px 0px 0px;">
                            <input type="hidden" name="entrar" value="entrar">
                            <button class="w3-btn w3-blue" type="submit">Ingresar</button>
                        </button>
                        <button class="button" style="margin: 0px 0px 5px 10px;">
                            <input type="hidden" name="registrarse" value="registrar">
                            <a href="{{ route('registro')}}"><button class="w3-btn w3-blue" type="button">Registrarse</button></a>
                        </button>
                    </div>

                    <p>
                        <a href="backend/cuenta.php">
                            <font color="blue"><span style="text-decoration: line-through;">¿Olvidó su contraseña?</span></font>
                        </a>
                    </p>

                </form>
                @if ($errors->has('message'))
                    <div class="alert alert-danger"
                        style="float: center; color:rgb(255, 85, 85); margin: -10px 0px 10px 15px; font-size: 9px; ">
                        {{ $errors->first('message') }}
                    </div>
                @endif
            </div>
            <img src="{{ asset('imagenes/separador.png') }}" border="0" height="260"
                style="margin: 0px 0px 0px 0px; float: left;">
            <div class="column">
                <form class="w3-container" action="{{ route('dashboard.invitados')}}" method="post">
                    @csrf
                    <p style="margin: 20px 0px 0px 0px; text-align: center;">
                        <font color="#000000">Accede como invitado con el siguiente boton:</font>
                    </p>
                    <p style="margin: 20px 0px 0px 0px; float: center;">
                        <button class="button" style="float: center; margin: 20px 0px 0px 80px;">
                            <input type="hidden" name="invitado" value="invitado">
                            <button class="w3-btn"
                                style="background-color: #ff8800; color: rgb(255, 255, 255);">Invitado</button>
                        </button>
                    </p>
                </form>
            </div>

        </div>

    </div>


    <footer>

    </footer>
    <script src="{{asset('assets/js/vendor/jquery-1.10.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>


    <script src="{{ asset('assets/js/jquery.backstretch.min.js') }}"></script>
    <script>
        jQuery.backstretch([
            "{{ asset('imagenes/fondob.png') }}", "{{ asset('imagenes/fondob2.jpg') }}",
            "{{ asset('imagenes/fondob4.jpg') }}", "{{ asset('imagenes/fondob5.jpg') }}", "{{ asset('imagenes/fondob8.jpg') }}", "{{ asset('imagenes/fondob9.jpg') }}"
        ], {
            duration: 4000,
            fade: 1000
        });
    </script>
</body>

</html>
