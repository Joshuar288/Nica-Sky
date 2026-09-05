# NicaSky

NicaSky es un marketplace web orientado a conectar emprendedores, compradores y proveedores en un entorno digital centralizado. La plataforma busca facilitar la publicación, promoción y compra de productos, apoyando especialmente a pequeñas y medianas empresas.

> Proyecto desarrollado para HACKATHON Nicaragua Kronnox 2026.

## Estado del proyecto

NicaSky se encuentra en desarrollo. Algunas funciones ya son utilizables y otras describen el flujo previsto para versiones futuras.

### Funciones implementadas

- Registro, autenticación y administración del perfil.
- Perfil público del usuario o tienda, con descripción y catálogo.
- Roles diferenciados de comprador y vendedor.
- Cambio controlado de comprador a vendedor.
- Creación y exploración de publicaciones.
- Imágenes de productos almacenadas en `storage` o servidas desde `public/images` para datos de prueba.
- Filtros por precio, departamento, ciudad y categoría.
- Búsqueda por producto, descripción, categoría, vendedor o tienda.
- Conteo de visitas únicas por usuario y publicación.
- Productos populares seleccionados entre los más visitados.
- Carrito almacenado en la sesión.
- Checkout y confirmación de pago.
- Notificaciones al vendedor después de una compra.
- Planes Gratuito, Plan Plus, Plan Pro y Plan Nica.
- Selección de productos recomendados según el límite del plan.

### Funciones planificadas

- Integración con una pasarela para pagos reales.
- Retención temporal y liberación segura del pago.
- Integración con servicios de paquetería como CargoTrans.
- Registro de evidencia del envío y seguimiento del pedido.
- Reembolsos cuando el vendedor no complete el envío dentro del plazo establecido.

## Funcionamiento previsto

## Roles y permisos

| Función | Administrador | Usuario | Auditor |
| --- | :---: | :---: | :---: |
| Explorar productos y perfiles públicos | Sí | Sí | Sí |
| Administrar su perfil | Sí | Sí | Sí |
| Crear y editar publicaciones propias | Sí | Sí | No |
| Utilizar carrito y confirmar compras | Sí | Sí | No |
| Comprar planes y destacar publicaciones | Sí | Sí | No |
| Adjuntar evidencia de un envío propio | Sí | Sí | No |
| Revisar evidencias de envío | Sí | No | Sí |
| Aprobar o rechazar una evidencia | Sí | No | Sí |
| Acceder a toda la administración | Sí | No | No |

### Responsabilidades

- **Administrador:** posee acceso general a la plataforma y puede respaldar las tareas de auditoría.
- **Usuario:** utiliza el marketplace como comprador o vendedor, administra sus publicaciones y presenta evidencias de sus envíos.
- **Auditor:** supervisa los comprobantes de envío y registra una decisión. No puede comprar, publicar productos ni contratar planes.

El sistema aplica el principio de mínimo privilegio: cada cuenta recibe únicamente los permisos necesarios. Los usuarios nuevos reciben el rol `user`; los roles `admin` y `auditor` se asignan mediante seeders o por administración controlada de la base de datos.

### Perfiles comerciales planificados

El usuario podrá registrarse como comprador o vendedor. Ambos roles compartirán las herramientas generales, mientras que el vendedor podrá administrar la información de su negocio y sus publicaciones. También se contempla permitir el cambio de comprador a vendedor.

### Publicaciones y perfiles públicos

Los usuarios pueden crear publicaciones con título, descripción, categoría, precio, disponibilidad, estado e imagen. Cada publicación enlaza al perfil público de su creador, donde se muestra la información de la tienda, su descripción y el resto de sus productos.

### Compra, pago y envío

Permite añadir productos al carrito, realizar compras y confirmacion del mismo. Al confirmar, el vendedor recibe una notificación con los productos solicitados, los datos del comprador y la dirección indicada.

El pago será procesado mediante una pasarela de pago y permanecerá retenido mientras el vendedor realiza el envío mediante un servicio como CargoTrans. El vendedor deberá presentar evidencia del despacho. Después de verificarla, la plataforma podrá liberar el dinero, sin embargo si el envío no se completa dentro del plazo establecido, se contempla devolverlo al comprador.

### Productos recomendados y planes

Los productos recomendados obtienen mayor visibilidad en la página de inicio. El cupo depende del plan del vendedor:

Los usuarios del Plan Plus y Plan Pro pueden decidir al crear una publicación si desean utilizar uno de sus cupos para hacer que esa publicacion aperesca en recomendados. Donde Plan Plus tendra 5 cupos para 5 publicaciones, el Plan Pro tendra 15. El Plan Nica incluye automáticamente todas las publicaciones en la seccion de recomendados.

## Tecnologías

### Backend

- PHP 8.3 o superior compatible.
- Laravel 13.
- Laravel Breeze.
- Eloquent ORM y Blade.

### Frontend

- Tailwind CSS.
- Bootstrap Icons.
- Vite 8.
- JavaScript, HTML5 y CSS3.

### Persistencia

- MySQL como base de datos principal de desarrollo.
- Sesiones, caché, trabajos y notificaciones almacenados en base de datos.
- Disco público de Laravel para imágenes subidas por usuarios.

## Requisitos previos

- Extensiones PHP habituales de Laravel: Ctype, DOM, Fileinfo, Mbstring, OpenSSL, PDO, PDO MySQL, Tokenizer y XML.
- Composer 2.
- Node.js 20.19 o superior y npm.
- MySQL 8 o MariaDB compatible.
- Git.

Para Windows se recomienda Laragon. También puede utilizarse XAMPP u otro entorno que proporcione PHP y MySQL compatibles.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Tu-Nombre/Nica-Sky.git
cd Nica-Sky
```

Opcionalmente, abre el proyecto en Visual Studio Code:

```bash
code .
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

No es necesario ejecutar `composer update` ni `npm update` durante una instalación normal. Los archivos de bloqueo mantienen las versiones comprobadas por el proyecto.

### 3. Crear el archivo de entorno

Linux, macOS o Git Bash:

```bash
cp .env.example .env
```

PowerShell:

```powershell
Copy-Item .env.example .env
```

Configura al menos el nombre y la URL de la aplicación:

```dotenv
APP_NAME=NicaSky
APP_URL=http://localhost:8000
```

### 4. Crear y configurar la base de datos

Después configura `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nicasky
DB_USERNAME=root
DB_PASSWORD=
```

Ajusta usuario, contraseña y puerto según tu instalación. MySQL debe estar iniciado antes de continuar.

### 5. Generar la clave

```bash
php artisan key:generate
```

### 6. Crear tablas, datos de prueba y/o Datos importantes (Categorias, ciudades, roles)

Para una instalación nueva:

```bash
php artisan migrate --seed
```
Si no existe la base de datos en mysql, la ejecucion de este comando le permitira crearlo con una confirmacion de su parte.
Los seeders crean ciudades, categorías, usuarios administrativos y 100 productos de prueba con imágenes tomadas de `public/images`.

Si deseas reconstruir completamente una base de desarrollo existente:

### 7. Crear el enlace de almacenamiento

```bash
php artisan storage:link
```

Este enlace es necesario para mostrar las imágenes que los usuarios suban al crear publicaciones.

### 8. Compilar los recursos

Durante el desarrollo:

```bash
npm run dev
```

Para generar recursos optimizados:

```bash
npm run build
```

## Ejecución

Usa dos terminales:

```bash
# Terminal 1
npm run dev
```

```bash
# Terminal 2
php artisan serve
```

Abre:

```text
http://localhost:8000
```

Como alternativa, el proyecto incluye un comando que inicia servidor, Vite, cola y visor de logs:

```bash
composer run dev
```

## Usuarios de prueba

Después de ejecutar los seeders:

| Usuario | Correo | Contraseña |
| --- | --- | --- |
| Joshuar | `joshuar@admin.com` | `password123` |
| Ulises | `ulises@admin.com` | `password123` |
| Auditor | `auditor@nicasky.com` | `password123` |

Estas credenciales son únicamente para desarrollo. No deben utilizarse en producción.

## Consideraciones importantes

- Nunca se almacena el CVV ni el número completo de tarjeta.
- Las visitas se contabilizan una sola vez por usuario y producto.
- Las imágenes del seeder se sirven desde `public/images`.
- Las imágenes subidas se guardan en `storage/app/public/products`.
- La configuración predeterminada usa sesiones, caché y cola en base de datos; sus tablas se crean con las migraciones incluidas.

## Licencia y contexto

Proyecto desarrollado como una solución para fomentar el emprendimiento digital en el contexto de HACKATHON Nicaragua Kronnox 2026.
