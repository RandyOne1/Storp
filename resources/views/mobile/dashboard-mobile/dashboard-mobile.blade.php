<!DOCTYPE html>
<html>

<head>
    <title>Tu cuenta</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('asserts/css/w3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glider.min.css') }}">
    <style>
        .menu-button {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu-button img {
            vertical-align: middle;
            transform: translateX(25%);
        }

        .welcome-message {
            width: 80%;
        }

        .welcome-message img {
            margin-bottom: 5px;
        }

        .user-section {
            display: flex;
            align-items: center;
            margin-right: 0px;
        }

        .username {
            margin-left: 5px;
            margin-right: 5px;
        }

        .user-section img {
            margin: 3px;
        }

        .right {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 5px;
            justify-content: flex-end;
            margin-right: 5px;
            transform: translateX(-10%);
        }

        .header-spacer {
            width: 90%;
            height: 70px;
            margin: 0px;
        }

        .right {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 5px;
            justify-content: flex-end;
            margin-right: 0px;
        }
        .header{
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="left">
            <button class="menu-button" onclick="toggleMenu()" style="margin-left: 10px">
                <img src="{{ asset('imagenes/menu.png') }}" alt="Menu" height="40">
            </button>
            <div class="logo">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" height="45" style="margin-left: 5px">
            </div>
        </div>
        <div class="center">

        </div>


        <div class="right">



            <div class="user-section">
                <span class="username">{{ Auth::user()->name }} {{ Auth::user()->apellido_paterno }}</span>
                <img id="userAvatar" src="{{ asset('imagenes/user.png') }}" alt="Usuario" height="40"
                    class="user-avatar" onclick="toggleMenu2()">
            </div>
        </div>



    </div>
    <div class="header-spacer">

    </div>


    @if ($clickCount === 0)
        <div id="welcome-message-container" class="welcome-message">
            <img src="{{ asset('imagenes/Bien.png') }}" alt="Bien" height="40">
            <hr>
            <p> Al sistema tactico de operaciones de registro de proyectos, por favor,
                haz clic en el botón de menú para desplegar las áreas de trabajo </p>
        </div>
    @endif


    <main>
        <!-- Contenido específico de cada vista -->
        @yield('content')
    </main>

    <div class="user-menu" id="userMenu">
        <ul>
            <li><a href="#">Tu cuenta</a></li>
            <li><a href="#">Otra opción</a></li>
            <li>
                <hr class="menu-separator">
            </li>
            <li>
                <form class="logout-form" action="{{ route('logout') }}" method="get">
                    <input type="hidden" name="salir" value="salir">
                    <button class="logout-button">Cerrar sesion</button>
                </form>
                <button class="notification-button">
                    <img src="{{ asset('imagenes/bell.png') }}" alt="Notification" height="25"
                        style="margin: 2px 5px 0px 2px">
                    <span class="notification-count">15</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="sidebar collapsed">
        <div class="menu-toggle">
            <img src="{{ asset('imagenes/menu.png') }}" alt="Menu" height="60" onclick="toggleMenu()"
                style="margin-top: 25px">
        </div>
        <ul class="menu">
            <li><a href="{{ route('search.document') }}" onclick="incrementClickCount()">Busqueda</a></li>
            <li>
                <hr class="menu-separator">
            </li>
            <li><a href="#">Mis documentos</a></li>
            <li>
                <hr class="menu-separator">
            </li>
            <li><a href="{{ route('upload.document.view') }}" onclick="incrementClickCount()">Subir Documento</a></li>
            <li>
                <hr class="menu-separator">
            </li>
            <li><a href="#">Seguimiento</a></li>
            <li>
                <hr class="menu-separator">
            </li>
            <li><a href="#">Ayuda</a></li>
        </ul>
    </div>



    <script src="{{ asset('assets/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/selector.js') }}"></script>
    <script src="{{ asset('assets/js/usermenu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script src="{{ asset('assets/js/glide.js') }}"></script>
    <script src="{{ asset('assets/js/glider.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-1.10.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mousewheel.js') }}"></script>
    <script>
        $(document).ready(function() {
            var glide = new Glide('.glide', {
                type: 'carousel',
                perView: 5,
                focusAt: 'center',
                breakpoints: {
                    768: {
                        perView: 1
                    }
                }
            });

            glide.mount();

            var glideTrack = document.querySelector('.glide__track');
            glideTrack.addEventListener('wheel', function(event) {
                event.preventDefault();
                var delta = Math.sign(event.deltaY);
                if (delta > 0) {
                    glide.go('>');
                } else if (delta < 0) {
                    glide.go('<');
                }
            });
        });
    </script>
    <script>
        // Obtener el contador de clics almacenado en una cookie
        var clickCount = parseInt(getCookie('menu_click_count')) || 0;

        // Incrementar el contador de clics al hacer clic en un enlace del menú
        function incrementClickCount() {
            clickCount++;
            setCookie('menu_click_count', clickCount, 30); // Establecer la cookie con una duración de 30 días
        }

        // Función auxiliar para obtener el valor de una cookie por nombre
        function getCookie(name) {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.indexOf(name + '=') === 0) {
                    return cookie.substring(name.length + 1);
                }
            }
            return null;
        }

        // Función auxiliar para establecer una cookie con un nombre, valor y duración
        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }
    </script>
</body>

</html>
