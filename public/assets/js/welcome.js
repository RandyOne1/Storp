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
