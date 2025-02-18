# 🗄️ S.T.O.R.P. alpha 0.1.0  

Sistema de almacenamiento y gestión de documentos con generación de vistas previas en Laravel. Esta pagina fue un proyecto para la Universidad Politécnica de Juventino Rosas. Su proposito era almacenar proyectos de investigación y proyectos escolares, su interfaz es accesible y posee 4 niveles de privilegios **"invitado | alumno | profesor | administrador"** el alumno puede subir archivos pero es necesario que el profesor autorice su visualización para los invitados, el alumno puede modificar sus propios documentos subidos pero una vez modificados requerira una aprobación por el profesor, el profesor puede subir, borrar y modificar los archivos subidos por el alumno o el mismo, el administrador puede hacer todo lo anterior aparte de eliminar, agregar y modificar los usuarios existentes. Cada que un alumno sube un documento el profesor recibe una notificación, cada que el profesor autoriza o no el trabajo del alumno el alumno recibe una notificación. Este fue mi proyecto de tesis, espero que sirva para algo, por que en mi universidad nunca fue implementado ni probado por razones que desconosco. Aun no esta terminado al 100%, necesita agregar varias vistas moviles o alguna tecnologia de front end, falta el apartado de ayuda, falta el apartado para que el alumno pueda modificar su cuenta, falta un sistema de recuperación de contraseñas y falta una pantalla para termino de tiempo de sesión.

## 🔧 Requisitos previos  

Antes de instalar, asegúrate de cumplir con los siguientes requisitos:  

### **Servidor y Entorno**  
- Un servidor web como **XAMPP, Apache o Nginx** con **PHP 8.1.21** y **MySQL** o similar.  
- **Composer** instalado 👉 [Descargar Composer](https://getcomposer.org/)  

### **Dependencias Adicionales**  
S.T.O.R.P. usa **Imagick** y **Ghostscript** para la generación de vistas previas de PDFs.  

- **Imagick**: Procesador de imágenes para convertir PDF a imágenes.  
- **Ghostscript**: Requerido por Imagick para procesar archivos PDF.  

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
1. Abre el archivo `.env` en la raíz del proyecto.  
2. Modifica las credenciales de la base de datos para que coincidan con tu servidor MySQL:  

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_base
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
