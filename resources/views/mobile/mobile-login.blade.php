<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/w3.css') }}">
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
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
        }

        .button-container {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .button {
            margin-right: 0px;
            flex-grow: 1;
            border: none;
            padding: 0px;
            background-color: #ffffff00;
            color: #ffffff00;
            text-align: center;
            float: center;
            border-radius: 5px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.671);
            margin: 0 20px 10px;
            padding: 10px;
        }

        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #2979ff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container p {
            margin-top: 10px;
            text-align: center;
        }

        .form-container a {
            color: blue;
        }

        .alert {
            float: center;
            color: rgb(255, 85, 85);
            margin: -10px 10px 10px 15px;
            font-size: 11px;
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
        <div style="float: center;margin:20px 20px 0px 20px; background-color: rgb(255, 255, 255); text-align: center;">
            <img src="{{ asset('imagenes/logo.png') }}" border="0" height="80" style="margin:25px 0px 0px 0px;">
            <hr style="width: 90%; margin-left:5%; transform: translateY(-10px);">
            <img src="{{ asset('imagenes/storp-mobile.png') }}" border="0" height="70"
                style="margin: 0px 0px 0px 0px; transform: translateY(-15px);">
        </div>
        <div class="form-container">



            <form class="w3-container" action="{{ route('login') }}" method="post">
                @csrf
                <p>
                    <label class="w3-label">
                        <font color="#00000">Correo</font>
                    </label>
                    <input class="w3-input w3-border" type="email" name="email">
                </p>
                <p>
                    <label class="w3-label">
                        <font color="#000000">Contraseña</font>
                    </label>
                    <input class="w3-input w3-border" type="password" name="password">
                </p>
                <div class="button-container">
                    <button class="button">
                        <input type="hidden" name="entrar" value="entrar">
                        <button class="w3-btn w3-blue" type="submit" style="width: 48%;">Ingresar</button>
                    </button>
                    <button class="button">
                        <input type="hidden" name="registrarse" value="registrar">
                        <a href="{{ route('registro')}}"><button class="w3-btn w3-blue" type="button">Registrarse</button></a>
                    </button>
                </div>
                <p>
                    <a href="backend/cuenta.php">
                        <font color="blue">¿Olvidó su contraseña?</font>
                    </a>
                </p>

            </form>
            @if ($errors->has('message'))
                <div style="text-align: center; font" class="alert">
                    {{ $errors->first('message') }}
                </div>
            @endif
        </div>

        <div class="form-container">
            <form class="w3-container" action="{{ route('dashboard.invitados-m')}}" method="post">
                @csrf
                <p>
                    <font color="#000000">Accede como invitado con el siguiente botón:</font>
                </p>
                <p>
                    <button class="button">
                        <input type="hidden" name="invitado" value="invitado">
                        <button class="w3-btn">Invitado</button>
                    </button>
                </p>
            </form>
        </div>
    </div>

    <footer>
    </footer>
    <script src="{{ asset('assets/js/vendor/jquery-1.10.1.min.js') }}"></script>
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
