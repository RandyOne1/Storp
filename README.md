# 🗄️ S.T.O.R.P. alpha 0.1.0  

Sistema de almacenamiento y gestión de documentos con generación de vistas previas en Laravel.  

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
Si tu versión de PHP es diferente a **8.1.21**, debes reemplazarla por la incluida en el paquete (dentro del RAR) para evitar errores con Imagick.  

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
