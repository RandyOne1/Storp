@extends('mobile.dashboard-mobile.dashboard-mobile')

@section('content')
<div id="welcome-message-container" class="welcome-message">
    <img src="{{ asset('imagenes/Subida.png') }}" alt="Bien" height="40">
    <hr>
    <p>Por favor, rellena todos los campos requeridos para poder subir el archivo correctamente. Los campos requeridos están marcados por un *.</p>
</div>
    <div class="upload-parameters">
        <label class="control-label col-sm-2">Tipo*</label>
        <div class='select-wrapper2'>
            <select class='form-control' id='tipo_dm' onchange="updateSubmenuOptions()" required="required">
                <option value="proyecto">Proyecto integrador</option>
                <option value="tesis">Tesis</option>
                <option value="tesina">Tesina</option>
                <option value="estadias">Reporte de estadias</option>
                <option value="otro">Otro</option>
            </select>
            <div class="select-arrow2"></div>
        </div>
        <div class='parameter'>
            <label class='control-parameter' for='titulo'>Titulo*</label>
            <div class='upload-parameter'>
                <input type='text' class='w3-input w3-border' id='titulo' required="required">
            </div>
        </div>
        <div class='parameter'>
            <label class='control-parameter' for='matricula'>Matricula*</label>
            <div class='upload-parameter'>
                <input type='text' class='w3-input w3-border' id='matricula' required="required">
            </div>
        </div>
        <div class='parameter'>
            <label class='control-parameter' for='matricula'>Matricula*</label>
            <div class='upload-parameter'>
                <input type='text' class='w3-input w3-border' id='matricula' required="required">
            </div>
        </div>
    </div>

    <div class="upload-section">
        <h2 style="color: #00809d">Subir Documento</h2>
        <form action="{{ route('upload.document') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="document">Seleccionar archivo:</label>
                <input type="file" id="document" name="document" accept=".pdf">
            </div>
            <div class="form-group">
                <button type="submit">Subir</button>
            </div>
        </form>
    </div>
@endsection
