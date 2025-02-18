# Diff Details

Date : 2023-08-07 15:38:43

Directory c:\\xampp\\htdocs\\storp\\resources\\views

Total : 47 files,  2697 codes, -106 comments, 241 blanks, all 2832 lines

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details

## Files
| filename | language | code | comment | blank | total |
| :--- | :--- | ---: | ---: | ---: | ---: |
| [app/Http/Controllers/Auth/LoginController.php](/app/Http/Controllers/Auth/LoginController.php) | PHP | -60 | -4 | -9 | -73 |
| [app/Http/Controllers/Auth/RegisterController.php](/app/Http/Controllers/Auth/RegisterController.php) | PHP | -49 | -8 | -14 | -71 |
| [app/Http/Controllers/Controller.php](/app/Http/Controllers/Controller.php) | PHP | -9 | 0 | -4 | -13 |
| [app/Http/Controllers/DashboardController.php](/app/Http/Controllers/DashboardController.php) | PHP | -223 | -27 | -49 | -299 |
| [app/Http/Controllers/DocumentoController.php](/app/Http/Controllers/DocumentoController.php) | PHP | -709 | -104 | -171 | -984 |
| [app/Http/Controllers/NotificacionController.php](/app/Http/Controllers/NotificacionController.php) | PHP | -134 | -24 | -38 | -196 |
| [app/Http/Kernel.php](/app/Http/Kernel.php) | PHP | -43 | -21 | -7 | -71 |
| [app/Http/Middleware/Authenticate.php](/app/Http/Middleware/Authenticate.php) | PHP | -11 | -3 | -4 | -18 |
| [app/Http/Middleware/CheckAdmin.php](/app/Http/Middleware/CheckAdmin.php) | PHP | -15 | 0 | -5 | -20 |
| [app/Http/Middleware/CheckProfesor.php](/app/Http/Middleware/CheckProfesor.php) | PHP | -15 | 0 | -5 | -20 |
| [app/Http/Middleware/EncryptCookies.php](/app/Http/Middleware/EncryptCookies.php) | PHP | -8 | -6 | -4 | -18 |
| [app/Http/Middleware/PreventRequestsDuringMaintenance.php](/app/Http/Middleware/PreventRequestsDuringMaintenance.php) | PHP | -8 | -6 | -4 | -18 |
| [app/Http/Middleware/RedirectIfAuthenticated.php](/app/Http/Middleware/RedirectIfAuthenticated.php) | PHP | -20 | -5 | -6 | -31 |
| [app/Http/Middleware/TrimStrings.php](/app/Http/Middleware/TrimStrings.php) | PHP | -11 | -5 | -4 | -20 |
| [app/Http/Middleware/TrustHosts.php](/app/Http/Middleware/TrustHosts.php) | PHP | -12 | -5 | -4 | -21 |
| [app/Http/Middleware/TrustProxies.php](/app/Http/Middleware/TrustProxies.php) | PHP | -14 | -10 | -5 | -29 |
| [app/Http/Middleware/ValidateSignature.php](/app/Http/Middleware/ValidateSignature.php) | PHP | -8 | -11 | -4 | -23 |
| [app/Http/Middleware/VerifyCsrfToken.php](/app/Http/Middleware/VerifyCsrfToken.php) | PHP | -8 | -6 | -4 | -18 |
| [resources/views/auth/login.blade.php](/resources/views/auth/login.blade.php) | PHP | 131 | 0 | 20 | 151 |
| [resources/views/auth/register.blade.php](/resources/views/auth/register.blade.php) | PHP | 86 | 0 | 14 | 100 |
| [resources/views/dashboard/dashboard.blade.php](/resources/views/dashboard/dashboard.blade.php) | PHP | 168 | 4 | 29 | 201 |
| [resources/views/dashboard/dashboard_administrador.blade.php](/resources/views/dashboard/dashboard_administrador.blade.php) | PHP | 179 | 4 | 20 | 203 |
| [resources/views/dashboard/dashboard_invitados.blade.php](/resources/views/dashboard/dashboard_invitados.blade.php) | PHP | 122 | 0 | 26 | 148 |
| [resources/views/dashboard/dashboard_profesores.blade.php](/resources/views/dashboard/dashboard_profesores.blade.php) | PHP | 172 | 4 | 30 | 206 |
| [resources/views/layaouts/exito.blade.php](/resources/views/layaouts/exito.blade.php) | PHP | 10 | 0 | 2 | 12 |
| [resources/views/layaouts/exito_admin.blade.php](/resources/views/layaouts/exito_admin.blade.php) | PHP | 10 | 0 | 2 | 12 |
| [resources/views/layaouts/mis_documentos.blade.php](/resources/views/layaouts/mis_documentos.blade.php) | PHP | 145 | 0 | 17 | 162 |
| [resources/views/layaouts/mis_documentos_profesor.blade.php](/resources/views/layaouts/mis_documentos_profesor.blade.php) | PHP | 137 | 5 | 16 | 158 |
| [resources/views/layaouts/notificaciones.blade.php](/resources/views/layaouts/notificaciones.blade.php) | PHP | 35 | 3 | 4 | 42 |
| [resources/views/layaouts/notificaciones_admin.blade.php](/resources/views/layaouts/notificaciones_admin.blade.php) | PHP | 35 | 3 | 4 | 42 |
| [resources/views/layaouts/notificaciones_profe.blade.php](/resources/views/layaouts/notificaciones_profe.blade.php) | PHP | 35 | 3 | 4 | 42 |
| [resources/views/layaouts/registro-exitoso.blade.php](/resources/views/layaouts/registro-exitoso.blade.php) | PHP | 10 | 0 | 2 | 12 |
| [resources/views/layaouts/search.blade.php](/resources/views/layaouts/search.blade.php) | PHP | 67 | 0 | 16 | 83 |
| [resources/views/layaouts/search_admin.blade.php](/resources/views/layaouts/search_admin.blade.php) | PHP | 68 | 0 | 14 | 82 |
| [resources/views/layaouts/search_invitado.blade.php](/resources/views/layaouts/search_invitado.blade.php) | PHP | 66 | 0 | 15 | 81 |
| [resources/views/layaouts/search_profesor.blade.php](/resources/views/layaouts/search_profesor.blade.php) | PHP | 69 | 0 | 16 | 85 |
| [resources/views/layaouts/seguimiento_administrador_documentos.blade.php](/resources/views/layaouts/seguimiento_administrador_documentos.blade.php) | PHP | 213 | 14 | 22 | 249 |
| [resources/views/layaouts/seguimiento_administrador_usuarios.blade.php](/resources/views/layaouts/seguimiento_administrador_usuarios.blade.php) | PHP | 191 | 14 | 20 | 225 |
| [resources/views/layaouts/seguimiento_profesor.blade.php](/resources/views/layaouts/seguimiento_profesor.blade.php) | PHP | 213 | 14 | 22 | 249 |
| [resources/views/layaouts/upload-document.blade.php](/resources/views/layaouts/upload-document.blade.php) | PHP | 382 | 21 | 48 | 451 |
| [resources/views/layaouts/upload-document_administrador.blade.php](/resources/views/layaouts/upload-document_administrador.blade.php) | PHP | 382 | 21 | 48 | 451 |
| [resources/views/layaouts/upload-document_profesor.blade.php](/resources/views/layaouts/upload-document_profesor.blade.php) | PHP | 382 | 21 | 48 | 451 |
| [resources/views/mobile/dashboard-mobile/dashboard-mobile.blade.php](/resources/views/mobile/dashboard-mobile/dashboard-mobile.blade.php) | PHP | 215 | 4 | 37 | 256 |
| [resources/views/mobile/dashboard-mobile/dashboard-mobile__invitados.blade.php](/resources/views/mobile/dashboard-mobile/dashboard-mobile__invitados.blade.php) | PHP | 201 | 4 | 38 | 243 |
| [resources/views/mobile/mobile-layouts/mobile-upload-document.blade.php](/resources/views/mobile/mobile-layouts/mobile-upload-document.blade.php) | PHP | 52 | 0 | 3 | 55 |
| [resources/views/mobile/mobile-login.blade.php](/resources/views/mobile/mobile-login.blade.php) | PHP | 160 | 0 | 22 | 182 |
| [resources/views/welcome.blade.php](/resources/views/welcome.blade.php) | PHP | 118 | 0 | 23 | 141 |

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details