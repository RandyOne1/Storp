@extends('dashboard.dashboard_profesores')

@section('content')
    <head>
        <title>Documentos</title>
    </head>
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

        .hidden-row {
            display: none;
        }
    </style>

    <div class="container">
        @if (isset($documentos) && count($documentos) > 0)
            <h1 class="title">Mis documentos</h1>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th class="column-header">Título</th>
                        <th class="column-header">Status</th>
                        <th class="column-header">Tipo</th>
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
                            <td>{{ $documento->porcentajeavance }}%</td>
                            <td class="actions">
                                <!-- Agregamos botones de modificar y borrar -->
                                <button class="btn btn-edit"
                                    onclick="toggleResubirDocumento('row-{{ $documento->Id }}')">Modificar</button>
                                <a href="#" class="btn btn-delete"
                                    onclick="borrarDocumento({{ $documento->Id }})">Borrar</button>
                            </td>
                        </tr>
                        <!-- Agregamos una nueva fila para el formulario de resubir documento -->
                        <tr class="hidden-row" id="row-{{ $documento->Id }}">
                            <td colspan="4">
                                <form id="form-{{ $documento->Id }}" class="hidden-form"
                                    action="{{ route('resubirDocumento.documentMP') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="documento_id" value="{{ $documento->Id }}">
                                    <input type="file" id="document" name="nuevodocument" accept=".pdf">
                                    <label for="titulo">Nuevo título:</label>
                                    <input type="text" name="titulo" value="{{ $documento->titulo }}">
                                    <label for="nombre_alumno">Nuevo nombre del alumno:</label>
                                    <input type="text" name="nombre_alumno" value="{{ $documento->nombrealumno }}">
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
@endsection
