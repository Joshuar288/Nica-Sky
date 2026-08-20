
# NicaSky - README Técnico

## Descripción General

**NicaSky** es un marketplace web diseñado para conectar emprendedores, compradores y proveedores en un solo entorno digital. La plataforma busca facilitar la comercialización de productos y servicios, promoviendo el crecimiento de pequeñas y medianas empresas mediante una interfaz accesible, centralizada y eficiente.

El sistema permite a los usuarios registrarse como compradores o vendedores, publicar productos, explorar ofertas disponibles y establecer contacto directo para concretar transacciones.

---

## Tecnologías Utilizadas

### Backend
- Laravel (Framework PHP)
- PHP 8+

### Frontend
- Blade (motor de plantillas de Laravel)
- HTML5
- CSS3
- JavaScript
- Tailwind

### Base de Datos
- MySQL

### Requerimientos previos
- Composer 
- Node.js y NPM
- Git

---

## Instalación Básica

### 1. Clonar el repositorio
Ejecuta en la terminal del sistema o en la terminal de Visual Studios Code
git clone https://github.com/tu-usuario/NicaSky.git

Luego accede al repositorio
cd NicaSky
code .

### 2. Instalar dependencias de PHP
Dentro instala y actualiza las dependencias
composer install o composer update

### 3. Instalar dependencias de frontend

npm install o npm update

### 4. Configurar variables de entorno

Copiar el archivo `.env.example` a `.env`:

cp .env.example .env

Luego configurar los datos de conexión a la base de datos en el archivo `.env`.

### 5. Generar clave de la aplicación

php artisan key:generate

### 6. Ejecutar migraciones

php artisan migrate

---

## Ejecución del Sistema

### 1. Compilar assets y activar vite

npm run dev

### 2. Levantar el servidor


php artisan serve

### 3. Acceder a la aplicación

Abrir en el navegador:

http://localhost:8000

---

## Notas Adicionales

* Existen muchos servicios de para trabajar en entorno local web. Se recomienda utilizar XAMPP o LARAGON.
* Asegurarse de que MySQL esté activo antes de ejecutar migraciones.

---


Proyecto desarrollado como parte de una solución para fomentar el emprendimiento digital impulsado por el evento HACKATHON 2026.

---



