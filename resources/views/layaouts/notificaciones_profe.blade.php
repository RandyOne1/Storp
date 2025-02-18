<style>
    /* Estilo para la lista de notificaciones */
    ul.notificaciones-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Estilo para cada elemento de notificación */
    ul.notificaciones-list li {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    /* Estilo para el último elemento de notificación */
    ul.notificaciones-list li:last-child {
        border-bottom: none;
    }
</style>
<ul class="notificaciones-list">
    @foreach ($notificaciones as $notificacion)
        <li>
            {{ $notificacion->data['mensaje'] }}
            <form action="{{ route('delete.notification-p', $notificacion->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $notificacion->id }}">
                <button type="submit" class="eliminar-notificacion">Eliminar</button>
            </form>

        </li>
    @endforeach
    @if (count($notificaciones) > 2)
        <form action="{{ route('delete.notification-all') }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="text-align: center; margin-top: 20px;" type="submit" class="eliminar-notificacion">Eliminar
                todas las notificaciones</button>
        </form>
    @endif
</ul>
