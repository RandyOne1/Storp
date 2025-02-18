<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento; // Asegúrate de importar el modelo adecuado
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use App\Notifications\DocumentoModificadoAlumno;
use App\Notifications\DocumentoModificadoProfesor;
use App\Notifications\DocumentoModificadoProfesorB;
use App\Notifications\DocumentoModificadoAlumnoB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DocumentoController extends Controller
{
    public function upload(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'tipo' => 'required',
            'titulo' => 'required',
            'matricula' => 'required',
            'nombrei' => 'required',
            'año' => 'required',
            'mes' => 'required',
            'categoria' => 'required',
            'tipo3' => 'required',
            'document' => 'required|mimes:pdf|max:30000', // Ajusta el tamaño máximo del documento según tus necesidades
        ]);
        if ($request->input('tipo') === 'otro') {
            $request->validate([
                'tipo2' => 'required',
                'empresa' => 'required',
            ]);
        } else {
            if ($request->input('tipo') === 'Tesis' || 'Tesina' || 'Estadias') {
                $request->validate([
                    'empresa' => 'required_if:tipo,==,tesis|required_if:tipo,==,tesina|required_if:tipo,==,estadias|', // Validar que el valor del líder esté dentro del array de integrantes
                ]);
            } elseif ($request->input('tipo') === 'Proyecto') {
                $request->validate([
                    'lider' => 'required_if:tipo,==,proyecto',
                    'integrante' => 'required_without:lider|array|min:1',
                    'integrante.*' => 'string|max:255',  // Validar que el valor del líder esté dentro del array de integrantes
                ]);
            }

        }
        $request->validate([
            'asesor' => 'required|array|min:1',
            'asesor.*' => 'required|string|max:255',
        ]);


        // Crear una instancia del modelo Documento y asignar los datos del formulario
        $documento = new Documento();
        $documento->titulo = $request->input('titulo');
        $documento->matricula = $request->input('matricula');
        $documento->año = $request->input('año');
        $documento->mes = $request->input('mes');
        $documento->carrera = $request->input('tipo3');
        $documento->nombrealumno = $request->input('nombrei');
        $documento->empresa = $request->input('empresa'); // Si no se proporciona el valor, se establece como cadena vacía
        $documento->categoria = $request->input('categoria');
        $documento->descripcion = $request->input('descripcion');
        $documento->tipo = $request->input('tipo');
        if ($request->input('tipo') === 'otro') {
            if (!in_array($request->input('tipo2'), ['reposervicio'])) {
                $documento->rservicio = 1;
            }
            if (!in_array($request->input('tipo2'), ['repoestancias'])) {
                $documento->restancias = 1;
            }
            if (!in_array($request->input('tipo2'), ['poster'])) {
                $documento->poster = 1;
            }
        }
        if ($request->input('tipo') === 'Proyecto') {
            $integrantes = $request->input('integrante');
            $liderIndex = $request->input('lider');

            // Crear un array para los integrantes del equipo con el líder marcado
            $integrantesConLider = [];
            foreach ($integrantes as $key => $integrante) {
                $esLider = $key == $liderIndex ? true : false;
                $integrantesConLider[] = [
                    'nombre' => $integrante,
                    'lider' => $esLider,
                ];
                $esLider = in_array($integrante, $liderIndex) ? 1 : 0;
            }
            $documento->liderdeequipo = $esLider;
            $integrantesString = implode(',', $integrantes);
            $documento->integrantes = $integrantesString;
        }


        // Obtener los integrantes del equipo y el líder seleccionado

        // Convertir los asesores en una cadena separada por comas
        $asesoresString = implode(',', $request->input('asesor'));

        // Guardar los integrantes y asesores como cadenas en la base de datos

        $documento->asesores = $asesoresString;


        // Subir el archivo al servidor y guardar la ruta en la base de datos
        $file = $request->file('document');
        // Generar un nombre único para el archivo
        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
        $filePath = $file->storeAs('pdfs', $fileName, 'public');
        $pdfp = new Pdf(storage_path('app/public/' . $filePath));
        $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
        $pdfp->saveImage(public_path('previews/' . $previewFileName));

        // Asignar la ubicación de la vista previa al objeto $documento
        $documento->u_vistaprevia = 'previews/' . $previewFileName;

        // Asignar la ubicación del archivo al objeto $documento
        $documento->ubicacion_archivo = $filePath;

        // Guardar el registro en la base de datos
        $documento->save();

        // Redirigir a la vista de éxito
        return redirect()->route('exito.document');
    }

    public function buscar(Request $request)
    {
        // Obtener el valor de búsqueda
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        $clickCount = 1;
        $tipoDocumento = $request->input('tipo_dm');
        $busquedaPor = $request->input('busqueda_dm');
        $query = $request->input('q');
        $queryBuilder = Documento::query();

        // Verificar si se proporcionó un valor para la búsqueda
        if ($query !== null && $query !== '') {
            $queryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%')
                    ->orWhere('año', 'like', '%' . $query . '%')
                    ->orWhere('mes', 'like', '%' . $query . '%')
                    ->orWhere('empresa', 'like', '%' . $query . '%')
                    ->orWhere('categoria', 'like', '%' . $query . '%')
                    ->orWhere('integrantes', 'like', '%' . $query . '%')
                    ->orWhere('liderdeequipo', 'like', '%' . $query . '%')
                    ->orWhere('matricula', 'like', '%' . $query . '%')
                    ->orWhere('tipo', 'like', '%' . $query . '%')
                    ->orWhere('nombrealumno', 'like', '%' . $query . '%')
                    ->orWhere('carrera', 'like', '%' . $query . '%');
            });
        }

        // Agregar la condición para el estado 'aprobado' y aquellos que no tengan estado (status = null)
        $queryBuilder->where(function ($queryBuilder) {
            $queryBuilder->where('status', 'aprobado')
                ->orWhereNull('status');
        });

        $resultados = $queryBuilder->get();
        return view('layaouts.search', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('resultados', $resultados);
    }

    public function buscarP(Request $request)
    {
        // Obtener el valor de búsqueda
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        $clickCount = 1;
        $tipoDocumento = $request->input('tipo_dm');
        $busquedaPor = $request->input('busqueda_dm');
        $query = $request->input('q');
        $queryBuilder = Documento::query();

        // Verificar si se proporcionó un valor para la búsqueda
        if ($query !== null && $query !== '') {
            $queryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%')
                    ->orWhere('año', 'like', '%' . $query . '%')
                    ->orWhere('mes', 'like', '%' . $query . '%')
                    ->orWhere('empresa', 'like', '%' . $query . '%')
                    ->orWhere('categoria', 'like', '%' . $query . '%')
                    ->orWhere('integrantes', 'like', '%' . $query . '%')
                    ->orWhere('liderdeequipo', 'like', '%' . $query . '%')
                    ->orWhere('matricula', 'like', '%' . $query . '%')
                    ->orWhere('tipo', 'like', '%' . $query . '%')
                    ->orWhere('nombrealumno', 'like', '%' . $query . '%')
                    ->orWhere('carrera', 'like', '%' . $query . '%');
            });
        }

        // Agregar la condición para el estado 'aprobado' y aquellos que no tengan estado (status = null)
        $queryBuilder->where(function ($queryBuilder) {
            $queryBuilder->where('status', 'aprobado')
                ->orWhereNull('status');
        });

        $resultados = $queryBuilder->get();
        return view('layaouts.search_profesor', [
            'clickCount' => $clickCount,
            'resultados' => $resultados, 'notificaciones' => $notificaciones // Pasamos los resultados filtrados a la vista
        ]);
    }

    public function buscarInvitados(Request $request)
    {
        // Obtener el valor de búsqueda

        $clickCount = 1;
        $tipoDocumento = $request->input('tipo_dm');
        $busquedaPor = $request->input('busqueda_dm');
        $query = $request->input('q');
        $queryBuilder = Documento::query();

        // Verificar si se proporcionó un valor para la búsqueda
        if ($query !== null && $query !== '') {
            $queryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%')
                    ->orWhere('año', 'like', '%' . $query . '%')
                    ->orWhere('mes', 'like', '%' . $query . '%')
                    ->orWhere('empresa', 'like', '%' . $query . '%')
                    ->orWhere('categoria', 'like', '%' . $query . '%')
                    ->orWhere('integrantes', 'like', '%' . $query . '%')
                    ->orWhere('liderdeequipo', 'like', '%' . $query . '%')
                    ->orWhere('matricula', 'like', '%' . $query . '%')
                    ->orWhere('tipo', 'like', '%' . $query . '%')
                    ->orWhere('nombrealumno', 'like', '%' . $query . '%')
                    ->orWhere('carrera', 'like', '%' . $query . '%');
            });
        }

        // Agregar la condición para el estado 'aprobado' y aquellos que no tengan estado (status = null)
        $queryBuilder->where(function ($queryBuilder) {
            $queryBuilder->where('status', 'aprobado')
                ->orWhereNull('status');
        });

        $resultados = $queryBuilder->get();
        return view('layaouts.search_invitado', [
            'clickCount' => $clickCount
        ])->with('resultados', $resultados);
    }

    public function resubirDocumento(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
            'nuevodocument' => 'nullable|mimes:pdf|max:30000', // Archivo PDF de hasta 30 MB
            'titulo' => 'nullable|string|max:255',
            'nombre_alumno' => 'nullable|string|max:255',
            // Agrega aquí las validaciones para los demás campos a modificar
        ]);

        // Obtener el documento a modificar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('mis_documentos.document.view')->with('error', 'Documento no encontrado.');
        }

        // Actualizar los campos del documento con los nuevos valores si se han proporcionado
        if ($request->has('titulo')) {
            $documento->titulo = $request->titulo;
        }

        if ($request->has('nombre_alumno')) {
            $documento->nombrealumno = $request->nombre_alumno;
        }

        // Agrega aquí la actualización de los demás campos a modificar

        // Resubir el nuevo documento si se ha proporcionado uno
        if ($request->hasFile('nuevodocument')) {
            $file = $request->file('nuevodocument');
            // Generar un nombre único para el archivo
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
            $filePath = $file->storeAs('pdfs', $fileName, 'public');
            $pdfp = new Pdf(storage_path('app/public/' . $filePath));
            $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $pdfp->saveImage(public_path('previews/' . $previewFileName));

            // Asignar la ubicación de la vista previa al objeto $documento
            $documento->u_vistaprevia = 'previews/' . $previewFileName;

            // Asignar la ubicación del archivo al objeto $documento
            $documento->ubicacion_archivo = $filePath;
        }
        Log::info('Documento ID: ' . $documento->Id);
        Log::info('Nuevo título: ' . $request->titulo);
        Log::info('Titulo: ' . $documento->titulo);
        Log::info('Nombre del alumno antes de entrar al documento: ' . $request->nombre_alumno);

        $documento->status = 'actualizado';

        // Guardar el documento actualizado en la base de datos
        $documento->save();
        // Notificar a los profesores asesores del documento
        $nombresProfesores = explode(',', $documento->asesores);
        foreach ($nombresProfesores as $nombreProfesor) {
            $nombreProfesor = str_replace('Dr. ', '', $nombreProfesor); // Eliminar el prefijo 'Dr.' del nombre

            $profesor = User::where('nombre_concatenado', 'LIKE', '%' . $nombreProfesor . '%')
                ->first();

            if ($profesor) {
                $profesor->notify(new DocumentoModificadoProfesor($documento));
            }else {
                // Aquí puedes manejar el caso en el que el profesor no fue encontrado
                // Puedes mostrar un mensaje de error, registrar un log, etc.
                // Por ejemplo:
                Log::error('Profesor no encontrado: ' . $nombreProfesor);
            }
        }
        Log::info('completo:' . $documento);
        DB::update('UPDATE docs SET status = ? ,titulo = ?, nombrealumno = ?, ubicacion_archivo = ?, u_vistaprevia = ? WHERE Id = ?', [
            $documento->status,
            $request->titulo,
            $request->nombre_alumno,
            $documento->ubicacion_archivo,
            $documento->u_vistaprevia,
            $request->documento_id
        ]);




        // Redirigir de vuelta a la página de mis documentos con un mensaje de éxito
        return redirect()->route('mis_documentos.document.view')->with('success', 'Documento actualizado exitosamente.');
    }

    public function resubirDocumentoMP(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
            'nuevodocument' => 'nullable|mimes:pdf|max:30000', // Archivo PDF de hasta 30 MB
            'titulo' => 'nullable|string|max:255',
            'nombre_alumno' => 'nullable|string|max:255',
            // Agrega aquí las validaciones para los demás campos a modificar
        ]);

        // Obtener el documento a modificar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('mis_documentos.document.view')->with('error', 'Documento no encontrado.');
        }

        // Actualizar los campos del documento con los nuevos valores si se han proporcionado
        if ($request->has('titulo')) {
            $documento->titulo = $request->titulo;
        }

        if ($request->has('nombre_alumno')) {
            $documento->nombrealumno = $request->nombre_alumno;
        }

        // Agrega aquí la actualización de los demás campos a modificar

        // Resubir el nuevo documento si se ha proporcionado uno
        if ($request->hasFile('nuevodocument')) {
            $file = $request->file('nuevodocument');
            // Generar un nombre único para el archivo
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
            $filePath = $file->storeAs('pdfs', $fileName, 'public');
            $pdfp = new Pdf(storage_path('app/public/' . $filePath));
            $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $pdfp->saveImage(public_path('previews/' . $previewFileName));

            // Asignar la ubicación de la vista previa al objeto $documento
            $documento->u_vistaprevia = 'previews/' . $previewFileName;

            // Asignar la ubicación del archivo al objeto $documento
            $documento->ubicacion_archivo = $filePath;
        }
        Log::info('Documento ID: ' . $documento->Id);
        Log::info('Nuevo título: ' . $request->titulo);
        Log::info('Titulo: ' . $documento->titulo);
        Log::info('Nombre del alumno antes de entrar al documento: ' . $request->nombre_alumno);

        $documento->status = 'actualizado';

        // Guardar el documento actualizado en la base de datos
        $documento->save();
        Log::info('completo:' . $documento);
        DB::update('UPDATE docs SET status = ? ,titulo = ?, nombrealumno = ?, ubicacion_archivo = ?, u_vistaprevia = ? WHERE Id = ?', [
            $documento->status,
            $request->titulo,
            $request->nombre_alumno,
            $documento->ubicacion_archivo,
            $documento->u_vistaprevia,
            $request->documento_id
        ]);




        // Redirigir de vuelta a la página de mis documentos con un mensaje de éxito
        return redirect()->route('mis_documentos.document.view-Profe')->with('success', 'Documento actualizado exitosamente.');
    }

    public function deleteMP(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
        ]);

        // Obtener el documento a eliminar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('seguimiento.document.view-Profe')->with('error', 'Documento no encontrado.');
        }

        $alumno = User::where('nombre_concatenado', 'LIKE', '%' . $documento->nombrealumno . '%')
            ->first();
        if ($alumno) {
            $alumno->notify(new DocumentoModificadoAlumnoB($documento));
        }

        Log::info('Documento ID: ' . $documento->Id);
        // Eliminar el documento de la base de datos
        $documento->delete();

        // Redirigir de vuelta a la página de mis documentos con un mensaje de éxito
        return redirect()->route('seguimiento.document.view-Profe')->with('success', 'Documento eliminado exitosamente.');
    }

    public function deleteU(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'usuario_id' => 'required|exists:users,id', // Asegurarse de que el usuario exista
        ]);

        // Obtener el usuario a eliminar
        $usuario = User::find($request->usuario_id);
        if(!$usuario){
            return redirect()->route('usuarios.view')->with('error', 'Usuario no encontrado.');
        }

        $usuario->delete();

        return redirect()->route('seguimiento.document.view-administrador-usuarios')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function delete(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
        ]);

        // Obtener el documento a eliminar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('mis_documentos.document.view')->with('error', 'Documento no encontrado.');
        }

        $nombresProfesores = explode(',', $documento->asesores);
        foreach ($nombresProfesores as $nombreProfesor) {
            $nombreProfesor = str_replace('Dr. ', '', $nombreProfesor);
            $nombreProfesor = str_replace('M.I. ', '', $nombreProfesor);
            $nombreProfesor = str_replace('Ing. ', '', $nombreProfesor); // Eliminar el prefijo 'Dr.' del nombre

            $profesor = User::where('nombre_concatenado', 'LIKE', '%' . $nombreProfesor . '%')
                ->first();

            if ($profesor) {
                $profesor->notify(new DocumentoModificadoProfesorB($documento));
            }else {
                // Aquí puedes manejar el caso en el que el profesor no fue encontrado
                // Puedes mostrar un mensaje de error, registrar un log, etc.
                // Por ejemplo:
                Log::error('Profesor no encontrado: ' . $nombreProfesor);
            }
        }
        Log::info('Nombre del profesor notiicado:' . $nombreProfesor);

        Log::info('Documento ID: ' . $documento->Id);
        // Eliminar el documento de la base de datos
        $documento->delete();

        // Redirigir de vuelta a la página de mis documentos con un mensaje de éxito
        return redirect()->route('mis_documentos.document.view')->with('success', 'Documento eliminado exitosamente.');
    }

    public function resubirDocumentoMPS(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
            'nuevodocument' => 'nullable|mimes:pdf|max:30000', // Archivo PDF de hasta 30 MB
            'titulo' => 'nullable|string|max:255',
            'nombre_alumno' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'porcentaje_avance' => 'nullable|string|max:255',
            'asesores' => 'nullable|string|max:255',
            'integrantes' => 'nullable|string|max:255',
            'matricula' => 'nullable|string|max:255',
            'año' => 'nullable|string|max:255',
            'mes' => 'nullable|string|max:255',
        ]);

        // Obtener el documento a modificar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('mis_documentos.document.view')->with('error', 'Documento no encontrado.');
        }

        // Actualizar los campos del documento con los nuevos valores si se han proporcionado
        if ($request->has('titulo')) {
            $documento->titulo = $request->titulo;
        }

        if ($request->has('nombre_alumno')) {
            $documento->nombrealumno = $request->nombre_alumno;
        }

        // Agrega aquí la actualización de los demás campos a modificar
        if ($request->has('porcentaje_avance')) {
            $documento->porcentajeavance = $request->porcentaje_avance;
        }

        if ($request->has('asesores')) {
            $documento->asesores = $request->asesores;
        }

        if ($request->has('integrantes')) {
            $documento->integrantes = $request->integrantes;
        }

        if ($request->has('matricula')) {
            $documento->matricula = $request->matricula;
        }

        if ($request->has('año')) {
            $documento->año = $request->año;
        }

        if ($request->has('mes')) {
            $documento->mes = $request->mes;
        }

        if ($request->has('status')) {
            $documento->status = $request->status;
        }

        // Resubir el nuevo documento si se ha proporcionado uno
        if ($request->hasFile('nuevodocument')) {
            $file = $request->file('nuevodocument');
            // Generar un nombre único para el archivo
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
            $filePath = $file->storeAs('pdfs', $fileName, 'public');
            $pdfp = new Pdf(storage_path('app/public/' . $filePath));
            $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $pdfp->saveImage(public_path('previews/' . $previewFileName));

            // Asignar la ubicación de la vista previa al objeto $documento
            $documento->u_vistaprevia = 'previews/' . $previewFileName;

            // Asignar la ubicación del archivo al objeto $documento
            $documento->ubicacion_archivo = $filePath;
        }

        Log::info('Documento ID: ' . $documento->Id);
        Log::info('Nuevo título: ' . $request->titulo);
        Log::info('Titulo: ' . $documento->titulo);
        Log::info('Nombre del alumno antes de entrar al documento: ' . $request->nombre_alumno);


        // Guardar el documento actualizado en la base de datos
        $documento->save();
        $alumno = User::where('matricula', 'LIKE', '%' . $documento->matricula . '%')->first();
        if ($alumno) {
            $alumno->notify(new DocumentoModificadoAlumno($documento));
        }

        DB::update('UPDATE docs SET status = ? ,titulo = ?, nombrealumno = ?, ubicacion_archivo = ?, porcentajeavance = ?, asesores = ?, integrantes = ?, matricula = ?, año = ?, mes = ?, u_vistaprevia = ? WHERE Id = ?', [
            $documento->status,
            $request->titulo,
            $request->nombre_alumno,
            $documento->ubicacion_archivo,
            $request->porcentaje_avance,
            $request->asesores,
            $request->integrantes,
            $request->matricula,
            $request->año,
            $request->mes,
            $documento->u_vistaprevia,
            $request->documento_id
        ]);

        return redirect()->route('seguimiento.document.view-Profe')->with('success', 'Documento actualizado exitosamente.');
    }

    public function uploadAdmin(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'tipo' => 'required',
            'titulo' => 'required',
            'matricula' => 'required',
            'nombrei' => 'required',
            'año' => 'required',
            'mes' => 'required',
            'categoria' => 'required',
            'tipo3' => 'required',
            'document' => 'required|mimes:pdf|max:30000', // Ajusta el tamaño máximo del documento según tus necesidades
        ]);
        if ($request->input('tipo') === 'otro') {
            $request->validate([
                'tipo2' => 'required',
                'empresa' => 'required',
            ]);
        } else {
            if ($request->input('tipo') === 'Tesis' || 'Tesina' || 'Estadias') {
                $request->validate([
                    'empresa' => 'required_if:tipo,==,tesis|required_if:tipo,==,tesina|required_if:tipo,==,estadias|', // Validar que el valor del líder esté dentro del array de integrantes
                ]);
            } elseif ($request->input('tipo') === 'Proyecto') {
                $request->validate([
                    'lider' => 'required_if:tipo,==,proyecto',
                    'integrante' => 'required_without:lider|array|min:1',
                    'integrante.*' => 'string|max:255',  // Validar que el valor del líder esté dentro del array de integrantes
                ]);
            }

        }
        $request->validate([
            'asesor' => 'required|array|min:1',
            'asesor.*' => 'required|string|max:255',
        ]);


        // Crear una instancia del modelo Documento y asignar los datos del formulario
        $documento = new Documento();
        $documento->titulo = $request->input('titulo');
        $documento->matricula = $request->input('matricula');
        $documento->año = $request->input('año');
        $documento->mes = $request->input('mes');
        $documento->carrera = $request->input('tipo3');
        $documento->nombrealumno = $request->input('nombrei');
        $documento->empresa = $request->input('empresa'); // Si no se proporciona el valor, se establece como cadena vacía
        $documento->categoria = $request->input('categoria');
        $documento->descripcion = $request->input('descripcion');
        $documento->tipo = $request->input('tipo');
        if ($request->input('tipo') === 'otro') {
            if (!in_array($request->input('tipo2'), ['reposervicio'])) {
                $documento->rservicio = 1;
            }
            if (!in_array($request->input('tipo2'), ['repoestancias'])) {
                $documento->restancias = 1;
            }
            if (!in_array($request->input('tipo2'), ['poster'])) {
                $documento->poster = 1;
            }
        }
        if ($request->input('tipo') === 'Proyecto') {
            $integrantes = $request->input('integrante');
            $liderIndex = $request->input('lider');

            // Crear un array para los integrantes del equipo con el líder marcado
            $integrantesConLider = [];
            foreach ($integrantes as $key => $integrante) {
                $esLider = $key == $liderIndex ? true : false;
                $integrantesConLider[] = [
                    'nombre' => $integrante,
                    'lider' => $esLider,
                ];
                $esLider = in_array($integrante, $liderIndex) ? 1 : 0;
            }
            $documento->liderdeequipo = $esLider;
            $integrantesString = implode(',', $integrantes);
            $documento->integrantes = $integrantesString;
        }


        // Obtener los integrantes del equipo y el líder seleccionado

        // Convertir los asesores en una cadena separada por comas
        $asesoresString = implode(',', $request->input('asesor'));

        // Guardar los integrantes y asesores como cadenas en la base de datos

        $documento->asesores = $asesoresString;


        // Subir el archivo al servidor y guardar la ruta en la base de datos
        $file = $request->file('document');
        // Generar un nombre único para el archivo
        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
        $filePath = $file->storeAs('pdfs', $fileName, 'public');
        $pdfp = new Pdf(storage_path('app/public/' . $filePath));
        $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
        $pdfp->saveImage(public_path('previews/' . $previewFileName));

        // Asignar la ubicación de la vista previa al objeto $documento
        $documento->u_vistaprevia = 'previews/' . $previewFileName;

        // Asignar la ubicación del archivo al objeto $documento
        $documento->ubicacion_archivo = $filePath;

        // Guardar el registro en la base de datos
        $documento->save();

        // Redirigir a la vista de éxito
        return redirect()->route('exito.document');
    }

    public function buscarA(Request $request)
    {
        // Obtener el valor de búsqueda
        $user = Auth::user();
        $notificaciones = $user->unreadNotifications;
        $clickCount = 1;
        $tipoDocumento = $request->input('tipo_dm');
        $busquedaPor = $request->input('busqueda_dm');
        $query = $request->input('q');
        $queryBuilder = Documento::query();

        // Verificar si se proporcionó un valor para la búsqueda
        if ($query !== null && $query !== '') {
            $queryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descripcion', 'like', '%' . $query . '%')
                    ->orWhere('año', 'like', '%' . $query . '%')
                    ->orWhere('mes', 'like', '%' . $query . '%')
                    ->orWhere('empresa', 'like', '%' . $query . '%')
                    ->orWhere('categoria', 'like', '%' . $query . '%')
                    ->orWhere('integrantes', 'like', '%' . $query . '%')
                    ->orWhere('liderdeequipo', 'like', '%' . $query . '%')
                    ->orWhere('matricula', 'like', '%' . $query . '%')
                    ->orWhere('tipo', 'like', '%' . $query . '%')
                    ->orWhere('nombrealumno', 'like', '%' . $query . '%')
                    ->orWhere('carrera', 'like', '%' . $query . '%');
            });
        }

        // Agregar la condición para el estado 'aprobado' y aquellos que no tengan estado (status = null)


        $resultados = $queryBuilder->get();
        return view('layaouts.search_admin', [
            'clickCount' => $clickCount, 'notificaciones' => $notificaciones
        ])->with('resultados', $resultados);
    }

    public function resubirDocumentoAU(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'id' => 'required|exists:users,id', // Asegurarse de que el usuario exista
            'name' => 'required',
            'email' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'email' => 'required',
            'privilegios' => 'required',
            'matricula' => 'nullable',
        ]);

        $user = User::find($request->id);

        if(!$user) {
            return redirect()->route('seguimiento.document.view-administrador-usuarios')->with('error', 'Usuario no encontrado.');
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if($request->has('apellido_paterno')) {
            $user->apellido_paterno = $request->apellido_paterno;
        }

        if($request->has('apellido_materno')) {
            $user->apellido_materno = $request->apellido_materno;
        }

        if($request->has('email')) {
            $user->email = $request->email;
        }

        if($request->has('privilegios')) {
            $user->privilegios = $request->privilegios;
        }

        if($request->has('matricula')) {
            $user->matricula = $request->matricula;
        }

        $nombre_concatenado = $request->name . ' ' . $request->apellido_paterno . ' ' . $request->apellido_materno;

        $user->save();

        DB::update('UPDATE users SET name = ?, apellido_paterno = ?, apellido_materno = ?, email = ?, privilegios = ?, matricula = ?, nombre_concatenado = ? WHERE id = ?', [
            $request->name,
            $request->apellido_paterno,
            $request->apellido_materno,
            $request->email,
            $request->privilegios,
            $request->matricula,
            $nombre_concatenado,
            $request->user_id
        ]);

        return redirect()->route('seguimiento.document.view-administrador-usuarios')->with('success', 'Usuario actualizado exitosamente.');

    }

    public function resubirDocumentoAMPS(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
            'nuevodocument' => 'nullable|mimes:pdf|max:30000', // Archivo PDF de hasta 30 MB
            'titulo' => 'nullable|string|max:255',
            'nombre_alumno' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'porcentaje_avance' => 'nullable|string|max:255',
            'asesores' => 'nullable|string|max:255',
            'integrantes' => 'nullable|string|max:255',
            'matricula' => 'nullable|string|max:255',
            'año' => 'nullable|string|max:255',
            'mes' => 'nullable|string|max:255',
        ]);

        // Obtener el documento a modificar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('mis_documentos.document.view')->with('error', 'Documento no encontrado.');
        }

        // Actualizar los campos del documento con los nuevos valores si se han proporcionado
        if ($request->has('titulo')) {
            $documento->titulo = $request->titulo;
        }

        if ($request->has('nombre_alumno')) {
            $documento->nombrealumno = $request->nombre_alumno;
        }

        // Agrega aquí la actualización de los demás campos a modificar
        if ($request->has('porcentaje_avance')) {
            $documento->porcentajeavance = $request->porcentaje_avance;
        }

        if ($request->has('asesores')) {
            $documento->asesores = $request->asesores;
        }

        if ($request->has('integrantes')) {
            $documento->integrantes = $request->integrantes;
        }

        if ($request->has('matricula')) {
            $documento->matricula = $request->matricula;
        }

        if ($request->has('año')) {
            $documento->año = $request->año;
        }

        if ($request->has('mes')) {
            $documento->mes = $request->mes;
        }

        if ($request->has('status')) {
            $documento->status = $request->status;
        }

        // Resubir el nuevo documento si se ha proporcionado uno
        if ($request->hasFile('nuevodocument')) {
            $file = $request->file('nuevodocument');
            // Generar un nombre único para el archivo
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Guardar el archivo en la ubicación deseada dentro de la carpeta "storage"
            $filePath = $file->storeAs('pdfs', $fileName, 'public');
            $pdfp = new Pdf(storage_path('app/public/' . $filePath));
            $previewFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $pdfp->saveImage(public_path('previews/' . $previewFileName));

            // Asignar la ubicación de la vista previa al objeto $documento
            $documento->u_vistaprevia = 'previews/' . $previewFileName;

            // Asignar la ubicación del archivo al objeto $documento
            $documento->ubicacion_archivo = $filePath;
        }

        Log::info('Documento ID: ' . $documento->Id);
        Log::info('Nuevo título: ' . $request->titulo);
        Log::info('Titulo: ' . $documento->titulo);
        Log::info('Nombre del alumno antes de entrar al documento: ' . $request->nombre_alumno);


        // Guardar el documento actualizado en la base de datos
        $documento->save();
        $alumno = User::where('matricula', 'LIKE', '%' . $documento->matricula . '%')->first();
        if ($alumno) {
            $alumno->notify(new DocumentoModificadoAlumno($documento));
        }

        DB::update('UPDATE docs SET status = ? ,titulo = ?, nombrealumno = ?, ubicacion_archivo = ?, porcentajeavance = ?, asesores = ?, integrantes = ?, matricula = ?, año = ?, mes = ?, u_vistaprevia = ? WHERE Id = ?', [
            $documento->status,
            $request->titulo,
            $request->nombre_alumno,
            $documento->ubicacion_archivo,
            $request->porcentaje_avance,
            $request->asesores,
            $request->integrantes,
            $request->matricula,
            $request->año,
            $request->mes,
            $documento->u_vistaprevia,
            $request->documento_id
        ]);

        return redirect()->route('seguimiento.document.view-Profe')->with('success', 'Documento actualizado exitosamente.');
    }

    public function deleteMPA(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'documento_id' => 'required|exists:docs,Id', // Asegurarse de que el documento exista
        ]);

        // Obtener el documento a eliminar
        $documento = Documento::find($request->documento_id);

        if (!$documento) {
            return redirect()->route('seguimiento.document.view-Profe')->with('error', 'Documento no encontrado.');
        }

        $alumno = User::where('nombre_concatenado', 'LIKE', '%' . $documento->nombrealumno . '%')
            ->first();
        if ($alumno) {
            $alumno->notify(new DocumentoModificadoAlumnoB($documento));
        }

        Log::info('Documento ID: ' . $documento->Id);
        // Eliminar el documento de la base de datos
        $documento->delete();

        // Redirigir de vuelta a la página de mis documentos con un mensaje de éxito
        return redirect()->route('seguimiento.document.view-administrador-documentos')->with('success', 'Documento eliminado exitosamente.');
    }

}
