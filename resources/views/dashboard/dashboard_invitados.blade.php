<!DOCTYPE html>
<html>

<head>
    <title>S.T.O.R.P.</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glider.min.css') }}">
</head>

<body>
    <div class="header">
        <div class="left">
            <button class="menu-button" onclick="toggleMenu()" style="margin-left: 35px">
                <img src="{{ asset('imagenes/menu.png') }}" alt="Menu" height="60">
            </button>
            <div class="logo">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" height="75" style="margin-left: 20px">
            </div>
            <div class="logo2">
                <img src="{{ asset('imagenes/storp.png') }}" alt="Storp" height="75">
            </div>
        </div>
        <div class="center">

        </div>


        <div class="right">



            <div class="user-section">
                <span class="username">Invitado</span>
                <img id="userAvatar" src="{{ asset('imagenes/user.png') }}" alt="Usuario" height="50"
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
            <p>Por favor, haz clic en el botón de menú para poder buscar los trabajos o inicia sesión para poder acceder a todas la funciones.</p>
            <form class="logout-form" action="{{ route('logout') }}" method="get">
                <input type="hidden" name="salir" value="salir">
                <button class="logout-button">Iniciar sesión</button>
            </form>
        </div>
    @endif


    <main>
        <!-- Contenido específico de cada vista -->
        @yield('content')
    </main>

    <div class="user-menu" id="userMenu">
        <ul>
            <li>
                <form class="logout-form" action="{{ route('logout') }}" method="get">
                    <input type="hidden" name="salir" value="salir">
                    <button class="logout-button">Iniciar sesión</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="sidebar collapsed">
        <div class="menu-toggle">
            <img src="{{ asset('imagenes/menu.png') }}" alt="Menu" height="60" onclick="toggleMenu()"
                style="margin-top: 25px">
        </div>
        <ul class="menu">
            <li><a href="{{ route('search.document_invitados') }}" onclick="incrementClickCount()">Busqueda</a></li>
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
                        perView: 2
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
    <script src="{{ asset('assets/js/jquery.backstretch.min.js') }}"></script>
     @if($clickCount === 0)
     <script>
         jQuery.backstretch([
             "{{ asset('imagenes/fondoD2.png') }}",
             "{{ asset('imagenes/fondoD3.png') }}", "{{ asset('imagenes/fondoD1.png') }}",
         ], {
             duration: 4000,
             fade: 1000
         });
     </script>
     @endif

</body>

</html>
