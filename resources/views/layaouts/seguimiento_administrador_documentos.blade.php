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
        @if (isset($documentos) && count($documentos) > 0)
            <h1 class="title">Todos los documentos en DB:</h1>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th class="column-header">Título</th>
                        <th class="column-header">Status</th>
                        <th class="column-header">Tipo</th>
                        <th class="column-header">Asesores</th>
                        <th class="column-header">Alumno</th>
                        <th class="column-header">Integrantes</th>
                        <th class="column-header">Matricula</th>
                        <th class="column-header">Categoria</th>
                        <th class="column-header">Fecha</th>
                        <th class="column-header">Avance</th>
                        <th class="column-header">Acciones</th> <!-- Agregamos columna para acciones -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $documento)
                        <tr>
                            <td class="document-title">
                                <a href="{{ asset('storage/' . $documento->ubicacion_archivo) }}">
                                    {{ $documento->titulo }}
                                </a>
                            </td>
                            <td>{{ $documento->status }}</td>
                            <td>{{ $documento->tipo }}</td>
                            <td>{{ $documento->asesores }}</td>
                            <td>{{ $documento->nombrealumno }}</td>
                            <td>{{ $documento->integrantes }}</td>
                            <td>{{ $documento->matricula }}</td>
                            <td>{{ $documento->categoria }}</td>
                            <td>Año: {{ $documento->año }} Mes: {{ $documento->mes }}</td>
                            <td>{{ $documento->porcentajeavance }}%</td>
                            <td class="actions">
                                <!-- Agregamos botones de modificar y borrar -->
                                <button class="btn btn-edit"
                                    onclick="toggleResubirDocumento('row-{{ $documento->Id }}')">Modificar</button>
                                    <form action="{{ route('delete.document-mpa', ['documento_id' => $documento->Id]) }}" method="post" onsubmit="return confirmarBorrado()">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-delete" style="background-color:#FF0000">Borrar</button>
                                    </form>
                            </td>
                        </tr>
                        <!-- Agregamos una nueva fila para el formulario de resubir documento -->
                        <tr class="hidden-row" id="row-{{ $documento->Id }}">
                            <td colspan="4">
                                <form id="form-{{ $documento->Id }}" class="hidden-form"
                                    action="{{ route('resubirDocumento.documentAMPS') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="documento_id" value="{{ $documento->Id }}">
                                    <label for="document">Nuevo documento o revision:</label>
                                    <input type="file" id="document" name="nuevodocument" accept=".pdf">
                                    <label for="titulo">Nuevo título:</label>
                                    <input type="text" name="titulo" value="{{ $documento->titulo }}">
                                    <label for="nombre_alumno">Nuevo nombre del alumno:</label>
                                    <input type="text" name="nombre_alumno" value="{{ $documento->nombrealumno }}">
                                    <label for="matricula">Nueva porcentaje de avance:</label>
                                    <input type="text" name="porcentaje_avance"
                                        value="{{ $documento->porcentajeavance }}">
                                    <label for="asesores">Nueva matricula:</label>
                                    <input type="text" name="matricula" value="{{ $documento->matricula }}">
                                    <label for="asesores">Nuevos asesores:</label>
                                    <input type="text" name="asesores" value="{{ $documento->asesores }}">
                                    <label for="integrantes">Nuevos integrantes:</label>
                                    <input type="text" name="integrantes" value="{{ $documento->integrantes }}">
                                    <label for="status">Nuevo status:</label>
                                    <input type="text" name="status" value="revisado">
                                    <label for="tipo">Nuevo año:</label>
                                    <input type="text" name="año" value="{{ $documento->año }}">
                                    <label for="tipo">Nuevo mes:</label>
                                    <input type="text" name="mes" value="{{ $documento->mes }}">
                                    <label for="tipo">Nueva categoria:</label>
                                    <input type="text" name="categoria" value="{{ $documento->categoria }}">
                                    <!-- Agrega aquí más campos para modificar según tus necesidades -->
                                    <button type="submit">Guardar cambios</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-documents-msg">No hay documentos asociados al usuario.</p>
            <!-- Puedes mostrar aquí un mensaje o realizar otras acciones -->
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
        function toggleResubirDocumento(rowId) {
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
