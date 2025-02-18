@extends('dashboard.dashboard_administrador')
@section('content')
    <style>
        .container {
            padding: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #00809d;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .column-header {
            background-color: #f2f2f2;
            font-weight: bold;
            padding: 10px;
        }

        .document-title a {
            color: #1E90FF;
            text-decoration: none;
            transition: color 0.3s;
        }

        .document-title a:hover {
            color: #0070c0;
        }

        .no-documents-msg {
            font-size: 18px;
            color: #777;
            margin-top: 20px;
        }

        .actions {
            display: flex;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 8px;
        }

        .btn-edit {
            background-color: #1E90FF;
        }

        .btn-delete {
            background-color: #FF0000;
        }

        /* Estilos para la fila oculta */
        .hidden-row {
            display: none;
            background-color: #f9f9f9;
            /* Color de fondo */
            border: 1px solid #ddd;
            /* Borde */
            padding: 10px;
            /* Espaciado interno */
            transition: height 0.3s ease-in-out;
            /* Transición suave en altura */
        }

        /* Estilos para los campos dentro de la fila oculta */
        .hidden-form label {
            display: block;
            margin-bottom: 5px;
        }

        .hidden-form input[type="text"],
        .hidden-form input[type="file"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .hidden-form button {
            background-color: #1E90FF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Estilos para el botón de mostrar/ocultar fila */
        .toggle-button {
            background-color: #1E90FF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            margin-left: 5px;
        }

        /* Cambiar el cursor al pasar por encima del botón */
        .toggle-button:hover {
            background-color: #0070c0;
        }

        /* Agregar una sombra al botón para darle un efecto de elevación */
        .toggle-button:focus {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
    <div class="container">
        @if (isset($usuarios) && count($usuarios) > 0)
            <h1 class="title">Usuarios</h1>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th class="column-header">Id</th>
                        <th class="column-header">Nombre</th>
                        <th class="column-header">Apellido Paterno</th>
                        <th class="column-header">Apellido Materno</th>
                        <th class="column-header">Correo</th>
                        <th class="column-header">Privilegios</th>
                        <th class="column-header">Matricula</th>
                        <th class="column-header">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td class="document-title">{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->apellido_paterno }}</td>
                            <td>{{ $usuario->apellido_materno }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->privilegios }}</td>
                            <td>{{ $usuario->matricula }}</td>
                            <td class="actions">
                                <button class="btn btn-edit"
                                    onclick="toggleResubirDocumentoU('row-{{ $usuario->id }}')">Modificar</button>
                                <form action="{{ route('delete.user-au', ['usuario_id' => $usuario->id]) }}" method="POST" onsubmit="return confirmarBorrado()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="background-color:#FF0000">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <tr class="hidden-row" id="row-{{ $usuario->id }}">
                            <td colspan="4">
                                <form id="form-{{ $usuario->id }}" class="hidden-form" action="{{ route('resubirDocumento.documentAU') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $usuario->id }}">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name" id="name" value="{{ $usuario->name }}">
                                    <label for="apellido_paterno">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" id="apellido_paterno"
                                        value="{{ $usuario->apellido_paterno }}">
                                    <label for="apellido_materno">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" id="apellido_materno"
                                        value="{{ $usuario->apellido_materno }}">
                                    <label for="email">Correo</label>
                                    <input type="text" name="email" id="email" value="{{ $usuario->email }}">
                                    <label for="privilegios">Privilegios</label>
                                    <input type="text" name="privilegios" id="privilegios"
                                        value="{{ $usuario->privilegios }}">
                                    <label for="matricula">Matricula</label>
                                    <input type="text" name="matricula" id="matricula"
                                        value="{{ $usuario->matricula }}">
                                    <button type="submit">Guardar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-documents-msg">No hay usuarios registrados.</p>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <script>
        // Función para mostrar u ocultar el formulario de resubir documento
        /* function toggleForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        } */
        function toggleResubirDocumentoU(rowId) {
            const row = document.getElementById(rowId);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
    <script>
        function confirmarBorrado() {
            return confirm('¿Estás seguro de que deseas borrar este documento?');
        }
    </script>
@endsection
