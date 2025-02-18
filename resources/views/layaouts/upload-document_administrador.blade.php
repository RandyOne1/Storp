@extends('dashboard.dashboard_administrador')

@section('content')
    <form action="{{ route('upload.document') }}" method="POST" enctype="multipart/form-data">
        <style>
            .parameter-textarea {
                width: 100%;
                margin-bottom: 10px;
            }

            .parameter-empresa {
                width: 100%;
                margin-bottom: 10px;
            }

            .welcome-message {
                margin-left: 125px;
            }

            .select-wrapper3 {
                position: relative;
                margin-bottom: 10px;
            }

            .select-wrapper3 select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #fff;
            }

            .select-wrapper4 {
                position: relative;
                margin-bottom: 10px;
            }

            .select-wrapper4 select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #fff;
            }

            .select-arrow3 {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(0%);
                width: 10px;
                height: 10px;
                border-top: 2px solid #555;
                border-right: 2px solid #555;
                transition: transform 0.3s ease-in-out;
                pointer-events: none;
            }

            .select-wrapper3:hover .select-arrow3 {
                transform: translateY(0%) rotate(90deg);
            }

            .select-wrapper4:hover .select-arrow3 {
                transform: translateY(0%) rotate(90deg);
            }

            .select-wrapper2 {
                position: relative;
                margin-bottom: 10px;
            }

            .select-wrapper2 select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #fff;
            }

            .select-arrow2 {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                width: 10px;
                height: 10px;
                border-top: 2px solid #555;
                border-right: 2px solid #555;
                transition: transform 0.3s ease-in-out;
                pointer-events: none;
            }

            .select-wrapper2:hover .select-arrow2 {
                transform: translateY(-50%) rotate(90deg);
            }

            /* Estilos para el contenedor de la barra de progreso */
            .progress-container {
                position: relative;
                width: 100%;
            }

            /* Estilos para la barra de progreso */
            progress {
                width: 100%;
                height: 10px;
                appearance: none;
                background-color: #f0f0f0;
                border: none;
                border-radius: 5px;
            }

            progress::-webkit-progress-value {
                background-color: #007bff;
                /* Color azul */
                border-radius: 5px;
            }

            progress::-moz-progress-bar {
                background-color: #007bff;
                /* Color azul */
                border-radius: 5px;
            }

            /* Estilos para la etiqueta de porcentaje */
            #progressLabel {
                font-size: 16px;
                color: #000000;
            }
        </style>
        <div id="welcome-message-container" class="welcome-message">
            <img src="{{ asset('imagenes/Subida.png') }}" alt="Bien" height="40">
            <hr>
            <p>Por favor, rellena todos los campos requeridos para poder subir el archivo correctamente. Los campos
                requeridos
                están marcados por un *.</p>
        </div>
        <div class="upload-parameters">
            <div class="upload-column">
                <label class="control-label col-sm-2">Tipo*</label>
                <div class='select-wrapper2'>
                    <select class='form-control' id='otros' name='tipo' required="required">
                        <option value="Proyecto Integrador" name='Proyecto Integrador'>Proyecto integrador</option>
                        <option value="Tesis" name='Tesis'>Tesis</option>
                        <option value="Tesina" name='Tesina'>Tesina</option>
                        <option value="Estadías" name='Estadías'>Reporte de Estadías</option>
                        <option value="otro" name='otro'>Otro</option>
                    </select>
                    <div class="select-arrow2"></div>
                </div>

                <div class='select-wrapper3'>
                    <label class="control-label col-sm-2">Seleccione una opcion:*</label>
                    <select class='form-control' id='tipo2' name='tipo2' required="required">
                        <option value="reposervicio" name='reposervicio'>Reporte de servicio social</option>
                        <option value="repoestancias" name='repoestancias'>Reporte de estancias</option>
                        <option value="poster" name='poster'>Poster</option>
                    </select>
                    <div class="select-arrow3"></div>
                </div>
                <div class='select-wrapper4'>
                    <label class="control-label col-sm-2">Carrera:*</label>
                    <select class='form-control' id='tipo3' name="tipo3" required="required">
                        <option value="Ingeniería en Redes y Telecomunicaciones" name='Ingeniería en Redes y Telecomunicaciones'>Ingeniería en Redes y Telecomunicaciones</option>
                        <option value="Ingeniería en Metalurgia" name='Ingeniería en Metalurgia'>Ingeniería en Metalurgia</option>
                        <option value="Ingeniería en Plasticos" name='Ingeniería en Plasticos'>Ingeniería en Plasticos</option>
                        <option value="Ingeniería Financiera" name='Ingeniería Financiera'>Ingeniería Financiera</option>
                        <option value=">Ingeniería en Sistemas Automotrices" name='>Ingeniería en Sistemas Automotrices'>Ingeniería en Sistemas Automotrices</option>
                        <option value="Ingeniería en Manofactura Avanzada" name='Ingeniería en Manofactura Avanzada'>Ingeniería en Manofactura Avanzada</option>
                        <option value="Lic. en Administración y Gestión Empresarial" name='Lic. en Administración y Gestión Empresarial'>Lic. en Administración y Gestión Empresarial
                        </option>
                        <option value="Maestría en Ingeniería" name='Maestría en Ingeniería'>Maestría en Ingeniería</option>
                    </select>
                    <div class="select-arrow3"></div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='titulo'>Titulo*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='titulo' name='titulo' required="required">
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='nombrei'>Nombre*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='nombrei' name='nombrei' required="required">
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='matricula'>Matricula*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='matricula' name='matricula'
                            required="required">
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='año'>Año*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='año' name='año' required="required">
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='mes'>Mes*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='mes' name='mes'
                            required="required">
                    </div>
                </div>


            </div>
            <div class="upload-column">
                <div class='parameter-empresa'>
                    <label class='control-parameter' for='empresa'>Empresa*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='empresa' name='empresa'
                            required="required">
                    </div>
                </div>
                <div class='parameter-textarea'>
                    <label class='control-parameter' for='integrantes'>Integrantes del equipo*:</label>
                    <div class='upload-parameter'>
                        <div id="integrantes-container">
                            <!-- El input original del líder -->
                            <div>
                                <input type='text' class='w3-input w3-border' name='integrante[]'>
                                <input type="checkbox" class="lider-checkbox" name="lider[]" value="integrante1"
                                    required="" checked>
                                Líder del equipo?
                            </div>
                        </div>
                        <button type="button" id="add-integrante" style="border-radius: 3px;margin-top:2px;">+</button>
                        <button type="button" id="remove-integrante"
                            style="border-radius: 3px;margin-top:2px;">-</button>
                    </div>
                </div>



                <div class='parameter'>
                    <label class='control-parameter' for='asesores'>Asesor/es*:</label>
                    <div class='upload-parameter'>
                        <div id="asesores-container">
                            <input type='text' class='w3-input w3-border' name='asesor[]' required="required">
                        </div>
                        <button type="button" id="add-asesor" style="border-radius: 3px; margin-top:2px;">+</button>
                        <button type="button" id="remove-asesor" style="border-radius: 3px;margin-top:2px;">-</button>
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='descripcion'>Descripción:</label>
                    <div class='upload-parameter'>
                        <textarea name="descripcion" class="w3-input" id="descripcion" rows="4"
                            placeholder="Escribe una descripción del proyecto... " style="height: 100px; resize:none;"></textarea>
                    </div>
                </div>
                <div class='parameter'>
                    <label class='control-parameter' for='categoria'>Categoria:*</label>
                    <div class='upload-parameter'>
                        <input type='text' class='w3-input w3-border' id='categoria' name='categoria'
                            required="required">
                    </div>
                </div>
                <input type="hidden" id="lider_nombre" name="lider_nombre">

            </div>


        </div>

        <div class="upload-section">
            <h2 style="color: #00809d">Subir Documento</h2>
            @csrf
            <div class="form-group">
                <label for="document">Seleccionar archivo:</label>
                <input type="file" id="document" name="document" accept=".pdf">
            </div>
            <p style="text-align: center; font-size: 10px;">Tamaño máximo 30mb</p>
            <progress id="progressBar" value="0" max="100"></progress>
            <span id="progressLabel">0%</span>
            <div class="form-group">
                <button type="submit" style="margin-top: 10px;">Subir</button>
            </div>
        </div>
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script>
            // Función para mostrar u ocultar el textarea según el valor seleccionado en el select
            function toggleTextareaVisibility() {
                var selectElement = document.getElementById('otros');
                var textareaContainer = document.querySelector('.parameter-textarea');
                var otroContainer = document.querySelector('.select-wrapper3');
                var empresaContainer = document.querySelector('.parameter-empresa');

                if (selectElement.value === 'Tesis' || selectElement.value === 'Tesina' || selectElement.value === 'Estadías') {
                    textareaContainer.style.display = 'none';
                    document.getElementById('integrantes-container').querySelectorAll('input').forEach(function(input) {
                        input.removeAttribute('required');
                    });
                    document.getElementById('tipo2').removeAttribute('required'); // Ocultar el textarea
                } else {
                    document.getElementById('integrantes-container').querySelectorAll('input').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                    document.getElementById('tipo2').setAttribute('required', 'required');

                    textareaContainer.style.display = 'block'; // Mostrar el textarea
                }
                if (selectElement.value === 'otro') {
                    document.getElementById('integrantes-container').querySelectorAll('input').forEach(function(input) {
                        input.removeAttribute('required');
                    });
                    textareaContainer.style.display = 'none';
                    otroContainer.style.display = 'block'; // Ocultar el textarea
                    document.getElementById('empresa').removeAttribute('required'); // Quitar el atributo required
                } else {
                    document.getElementById('tipo2').removeAttribute('required');
                    otroContainer.style.display = 'none';
                    empresaContainer.style.display = 'none'; // Mostrar el textarea
                }
                if (selectElement.value === 'Proyecto Integrador') {
                    document.getElementById('integrantes-container').querySelectorAll('input').forEach(function(input) {
                        input.removeAttribute('required');
                    });
                    empresaContainer.style.display = 'none';
                    document.getElementById('empresa').removeAttribute('required'); // Quitar el atributo required
                } else {
                    empresaContainer.style.display = 'block'; // Mostrar el textarea
                }
            }

            // Agregar el evento onchange al select para llamar a la función cuando se seleccione una opción
            document.getElementById('otros').addEventListener('change', toggleTextareaVisibility);

            // Llamar a la función una vez para asegurarnos de que el textarea esté en el estado correcto inicialmente
            toggleTextareaVisibility();
        </script>

        <script>
            $(document).ready(function() {
                // Establecer el número máximo de integrantes
                var maxIntegrantes = 5;

                // Obtener el contenedor de integrantes
                var integrantesContainer = $("#integrantes-container");

                // Función para agregar un nuevo campo de texto para un integrante
                $("#add-integrante").click(function() {
                    var integrantesCount = integrantesContainer.find("input[name='integrante[]']").length;
                    if (integrantesCount < maxIntegrantes) {
                        var newInput = $(
                            "<div><input type='text' class='w3-input w3-border' name='integrante[]' required='required' style='margin-top:5px;'> <input type='checkbox' class='lider-checkbox' name='lider[]' value='integrante" +
                            (integrantesCount + 1) + "'> Líder del equipo?</div>"
                        );
                        integrantesContainer.append(newInput);
                        // Agregar el evento change a la nueva casilla de verificación
                        newInput.find(".lider-checkbox").on("change", function() {
                            // Desmarcar todas las casillas excepto la que está siendo marcada como líder
                            $(".lider-checkbox").not(this).prop("checked", false);
                            // Si el checkbox actual está marcado, asegurarse de que el campo de texto asociado sea requerido
                            $(this).siblings("input[name='integrante[]']").prop("required", $(this)
                                .prop("checked"));
                        });
                    }
                });

                // Función para eliminar el último campo de texto para un integrante
                $("#remove-integrante").click(function() {
                    var integrantesCount = integrantesContainer.find("input[name='integrante[]']").length;
                    if (integrantesCount > 1) {
                        integrantesContainer.find("div:last-child").remove();
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                // Establecer el número máximo de integrantes
                var maxAsesores = 2;

                // Obtener el contenedor de integrantes
                var asesoresContainer = $("#asesores-container");

                // Función para agregar un nuevo campo de texto para un integrante
                $("#add-asesor").click(function() {
                    var asesoresCount = asesoresContainer.find("input[name='asesor[]']").length;
                    if (asesoresCount < maxAsesores) {
                        var newInput = $(
                            "<input type='text' class='w3-input w3-border' name='asesor[]' required='required' style='margin-top:5px;'>"
                        );
                        asesoresContainer.append(newInput);
                    }
                });

                // Función para eliminar el último campo de texto de un integrante
                $("#remove-asesor").click(function() {
                    var asesoresCount = asesoresContainer.find("input[name='asesor[]']").length;
                    if (asesoresCount > 1) {
                        asesoresContainer.find("input[name='asesor[]']:last-child").remove();
                    }
                });
            });
        </script>
        <script>
            document.getElementById('document').addEventListener('change', function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onloadstart = function() {
                    document.getElementById('progressBar').value = 0;
                    document.getElementById('progressLabel').innerText = '0%';
                };

                reader.onprogress = function(event) {
                    if (event.lengthComputable) {
                        var percentLoaded = (event.loaded / event.total) * 100;
                        document.getElementById('progressBar').value = percentLoaded;
                        document.getElementById('progressLabel').innerText = percentLoaded.toFixed(2) + '%';
                    }
                };

                reader.onload = function(event) {
                    // Auxiliaaaaarrr
                };

                // Leer el archivo seleccionado
                reader.readAsDataURL(file);
            });
        </script>

    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
