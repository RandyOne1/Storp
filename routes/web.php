<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\NotificacionController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login')->with('success', '¡Has cerrado sesión exitosamente!');
})->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/upload-document', [DashboardController::class, 'showUploadDocumentView'])->name('upload.document.view');
    Route::post('/upload', [DocumentoController::class, 'upload'])->name('upload.document');
    Route::post('/re-upload', [DocumentoController::class, 'resubirDocumento'])->name('resubirDocumento.document');
    Route::get('/search', [DashboardController::class, 'showSearchView'])->name('search.document');
    Route::get('/buscar', [DocumentoController::class, 'buscar'])->name('buscar');
    Route::get('/exito', [DashboardController::class, 'showExitoView'])->name('exito.document');
    Route::get('/mis_documentos', [DashboardController::class, 'showMis_DocuemntosView'])->name('mis_documentos.document.view');
    Route::delete('/delete-document', [DocumentoController::class, 'delete'])->name('delete.document');
    Route::delete('/delete-notification', [NotificacionController::class, 'eliminarNotificacion'])->name('delete.notification');
    Route::delete('/delete-notificationA', [NotificacionController::class, 'eliminarNotificacionTodas'])->name('delete.notification-all');
});

Route::middleware(['auth', 'check.profesor'])->group(function () {
    // Aquí van las rutas que solo pueden ser accedidas por usuarios con privilegios de 'profesor'
    Route::get('/buscar-p', [DocumentoController::class, 'buscarP'])->name('buscar-profesores');
    Route::get('/mis_documentos-p', [DashboardController::class, 'showMis_DocuemntosViewProfesores'])->name('mis_documentos.document.view-Profe');
    Route::get('/upload-document-p', [DashboardController::class, 'showUploadDocumentViewProfesores'])->name('upload.document.view-Profe');
    Route::get('/seguimiento-p', [DashboardController::class, 'showSeguimientoViewProfesores'])->name('seguimiento.document.view-Profe');
    Route::delete('/delete-document-p', [DocumentoController::class, 'deleteMP'])->name('delete.document-p');
    Route::delete('/delete-notification-p', [NotificacionController::class, 'eliminarNotificacionP'])->name('delete.notification-p');
    Route::get('/search-p', [DashboardController::class, 'showSearchViewProfesores'])->name('search.document-profesores');
    Route::post('/re-upload-mp', [DocumentoController::class, 'resubirDocumentoMP'])->name('resubirDocumento.documentMP');
    Route::post('/re-upload-mps', [DocumentoController::class, 'resubirDocumentoMPS'])->name('resubirDocumento.documentMPS');
    Route::get('/dashboard-p', [DashboardController::class, 'indexProfesor'])->name('dashboard-profesor');
});
Route::middleware(['auth', 'check.admin'])->group(function () {
    // Aquí van las rutas que solo pueden ser accedidas por usuarios con privilegios de 'administrador'
    Route::get('/buscar-a', [DocumentoController::class, 'buscarA'])->name('buscar-administrador');
    Route::get('/dashboard-a', [DashboardController::class, 'indexAdministrador'])->name('dashboard-administrador');
    Route::get('/upload-document-a', [DashboardController::class, 'showUploadDocumentViewAdministrador'])->name('upload.document.view-administrador');
    Route::get('/upload-a', [DocumentoController::class, 'uploadAdmin'])->name('upload.document-administrador');
    Route::get('/seguimiento-au', [DashboardController::class, 'showSeguimientoViewAdministradorUsuario'])->name('seguimiento.document.view-administrador-usuarios');
    Route::post('/re-upload-au', [DocumentoController::class, 'resubirDocumentoAU'])->name('resubirDocumento.documentAU');
    Route::delete('/delete-document-au', [DocumentoController::class, 'deleteU'])->name('delete.user-au');
    Route::post('/re-upload-amps', [DocumentoController::class, 'resubirDocumentoAMPS'])->name('resubirDocumento.documentAMPS');
    Route::get('/seguimiento-ad', [DashboardController::class, 'showSeguimientoViewAdministradorDocumentos'])->name('seguimiento.document.view-administrador-documentos');
    Route::delete('/delete-document-mpa', [DocumentoController::class, 'deleteMPA'])->name('delete.document-mpa');
});



Route::get('/search_invitado', [DashboardController::class, 'showSearchViewInvitados'])->name('search.document_invitados');
Route::get('/notificaciones', [NotificacionController::class, 'mostrarNotificaciones'])->name('notificaciones');
Route::get('/notificacionesA', [NotificacionController::class, 'mostrarNotificacionesA'])->name('notificacionesA');
Route::post('/search', 'DashboardController@showSearchView')->name('search.view');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/dashboard/invitados', [DashboardController::class, 'InvitadoView'])->name('dashboard.invitados');
Route::post('/dashboard/invitados-m', [DashboardController::class, 'InvitadoViewMobile'])->name('dashboard.invitados-m');
Route::get('/buscar_invitado', [DocumentoController::class, 'buscarInvitados'])->name('buscar_invitado');

Route::get('/registro-exitoso', function () {
    $clickCount = 1;
    return view('layaouts.registro-exitoso', ['clickCount' => $clickCount]);
})->name('registro-exitoso');


Route::post('registro', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/registro', [LoginController::class, 'showRegistroForm'])->name('registro');
Route::post('/login', [LoginController::class, 'login']);
