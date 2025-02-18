# 🗄️ S.T.O.R.P. alpha 0.1.0  

Sistema Tactico de Operaciónes de Registro de Proyectos en Laravel (si lo se, el nombre es malisimo). Esta pagina fue un proyecto para la Universidad Politécnica de Juventino Rosas. Su proposito era almacenar proyectos de investigación y proyectos escolares, su interfaz es accesible y posee 4 niveles de privilegios usando middlewares **"invitado | alumno | profesor | administrador"**. 

El alumno puede subir archivos pero es necesario que el profesor autorice su visualización para los invitados, el alumno puede modificar sus propios documentos subidos pero una vez modificados requerira una aprobación por el profesor, el profesor puede subir, borrar y modificar los archivos subidos por el alumno o el mismo, el administrador puede hacer todo lo anterior aparte de eliminar, agregar y modificar los usuarios existentes. Cada que un alumno sube un documento el profesor recibe una notificación, cada que el profesor autoriza o no el trabajo del alumno el alumno recibe una notificación. Este fue mi proyecto de tesis, espero que sirva para algo, por que en mi universidad nunca fue implementado ni probado por razones que desconosco. Aun no esta terminado al 100%, necesita agregar varias vistas moviles o alguna tecnologia de front end, falta el apartado de ayuda, falta el apartado para que el alumno pueda modificar su cuenta, falta un sistema de recuperación de contraseñas y falta una pantalla para termino de tiempo de sesión.

## 🔧 Requisitos previos  

Antes de instalar, asegúrate de cumplir con los siguientes requisitos:  

### **Servidor y Entorno**  
- Un servidor web como **XAMPP, Apache o Nginx** con **PHP 8.1.21** y **MySQL** o similar.  
- **Composer** instalado 👉 [Descargar Composer](https://getcomposer.org/)  

### **Dependencias Adicionales**  
S.T.O.R.P. usa **Imagick** y **Ghostscript** para la generación de vistas previas de PDFs.  

- **Imagick**: Procesador de imágenes para convertir PDF a imágenes.
  - Para instalar Imagick debes:
  - Descarga php_imagick.dll desde 👉 [PECL Imagick](https://windows.php.net/downloads/pecl/releases/imagick/)
  - Extrae y copia el archivo php_imagick.dll en:
     ```sh
    C:\xampp\php\ext\
  - Copia los archivos CORE_RL_* y IM_MOD_RL_* en:
    ```sh
    C:\xampp\apache\bin\
    C:\xampp\php\
  - Edita `C:\xampp\php\php.ini` y agrega esta línea donde van las extenciones, encuentralas dentro del archivo con `Ctrl + F`:
    ```sh
    extension=imagick
  - Guarda los cambios y reinicia Apache.
  - Verifica que Imagick está instalado con:
    ```sh
    php --ri imagick
- **Ghostscript**: Requerido por Imagick para procesar archivos PDF.
  - Descarga Ghostscript desde 👉 [Ghostscript Official](https://ghostscript.com/releases/gsdnld.html)
  - Instala la versión Ghostscript AGPL Release for Windows (64-bit).
  - **(IMPORTANTE)** Durante la instalación, selecciona la opción "Install Ghostscript to PATH" para que sea accesible desde la terminal.
  - Verifica la instalación ejecutando:
    ```sh
    gswin64c.exe --version
  - Si todo salio bien debería mostrar un número de versión.

### **⚠ IMPORTANTE**  
Si tu versión de PHP es diferente a **8.1.21**, debes reemplazarla para evitar errores con Imagick.  

---

## 📂 **Instalación**  

### **1️⃣ Descomprimir el Proyecto**  
Extrae la carpeta `storp` en la raíz de `htdocs` (si usas XAMPP) para facilitar la integración.  

### **2️⃣ Configurar la Base de Datos**  
1. Importa la base de datos incluida en el paquete.  
2. Una vez importada, vacía todas las tablas para comenzar con datos limpios.  

### **3️⃣ Configurar el Archivo `.env`**  
1. Abre el archivo `.env` en la raíz del proyecto, si no existe crealo.  
2. Modifica las credenciales de la base de datos para que coincidan con tu servidor MySQL:  

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_base
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña

## **⚙ Instalar Dependencias** 
### **4️⃣ Instalar las Dependencias de Laravel**
Ejecuta el siguiente comando en la terminal dentro de la carpeta donde se aloje el proyecto (ejemplo: `C:\xampp\htdocs\storp>`):
   ```sh
   composer install
   ```
(Si no esta correctamente instalado alguna de las dependencias adicionales aquí tirará error.)
### **5️⃣ Generar Clave de Aplicación**
Ejecuta el siguiente aún dentro de la carpeta del proyecto:
   ```sh
   php artisan key:generate
   ```
### 6️⃣ Crear Enlace de Almacenamiento**
Laravel necesita un acceso directo entre `storage` y `public`. Para crearlo, ejecuta:
   ```sh
   php artisan storage:link
   ```
Con esto todo deberia estar listo para ejecutar la aplicación.
## **🚀 Ejecuta la aplicación**
### **7️⃣ Iniciar el Servidor Laravel**
Abre una ventana de comandos y desde la ruta del proyecto ejecuta el siguiente comando:
   ```sh
   php artisan serve --host=0.0.0.0
   ```
Abre tu navegador y visita:
   ```cpp
   http://127.0.0.1:8000/dashboard
   ```
Si la pagina se muestra en tu navegador la pagina se estará ejecutando correctamente.
## **🛠️ Configuración de Usuarios**
1. Como la pagina no tiene nada ni a nadie registrado el primer paso será crear los perfiles de los administradores, eso se hace creando un usuario comun dando a registrar un nuevo usuario dentro de la pagina web, aquí tambien sabremos si laravel se comunica correctamente con la base de datos.
2. Con tu usuario una vez creado en la base de datos, modifica la columna privilegios del usuario recién creado y asigna uno de estos niveles:
   ```nginx
   invitado | alumno | profesor | administrador
   ```
(Esto debe hacerse manualmente en MySQL, una vez asignado un administrador desde la base de datos los administradores pueden cambiar los privilegios de otros usuarios desde la pagina misma).
## **📝 Notas Finales**
**⚠ Problemas Conocidos:**
 - Como mencioné no hay recuperación de contraseñas: Si olvidas tu contraseña, no hay forma de restaurarla.
 - Error de sesión expirada: Después de cierto tiempo inactivo, se mostrará un error. Solución: Recargar la página de inicio de sesión.
 - Vistas de navegador movil sin terminar: Debí usar Vue desde el principio...
 - El apartado "Ayuda" está deshabilitado (no está terminado... ni siquiera lo empecé) en todos los niveles de usuario.

