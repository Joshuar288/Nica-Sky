# NicaSky

NicaSky es un marketplace web orientado a conectar emprendedores, compradores y proveedores en un entorno digital centralizado. La plataforma busca facilitar la publicación, promoción y compra de productos, apoyando especialmente a pequeñas y medianas empresas.

> Proyecto desarrollado para HACKATHON Nicaragua Kronnox 2026.

## Estado del proyecto

NicaSky cuenta con un marketplace funcional y herramientas de administración y auditoría. La instancia publicada en Azure está disponible en [http://158.23.62.47](http://158.23.62.47). Los pagos, la contratación de planes y las devoluciones representan un flujo de demostración; todavía no procesan movimientos de dinero mediante una pasarela real.

### Funciones implementadas

- Registro, autenticación y administración del perfil.
- Perfil público del usuario o tienda, con descripción y catálogo.
- Roles de usuario, administrador y auditor, con permisos comprobados en el servidor.
- Compra y venta desde una cuenta con rol de usuario.
- Creación, edición y exploración de publicaciones, con reemplazo de imagen y control de propiedad.
- Moderación de publicaciones: al crearlas o editarlas quedan pendientes de aprobación. Solo las aprobadas aparecen en el catálogo y pueden comprarse.
- Panel administrativo para buscar, filtrar, aprobar, rechazar con motivo y eliminar publicaciones.
- Consulta, búsqueda y eliminación de usuarios no administrativos; las cuentas administrativas están protegidas frente a esta eliminación.
- Imágenes de productos almacenadas en `storage` o servidas desde `public/images` para datos de prueba.
- Filtros por precio, departamento, ciudad y categoría.
- Búsqueda por producto, descripción, categoría, vendedor o tienda.
- Conteo de visitas únicas por usuario y publicación.
- Productos populares seleccionados entre los más visitados.
- Carrito almacenado en la sesión.
- Checkout y confirmación de pago simulado, con datos de contacto y dirección de entrega.
- Notificaciones al vendedor después de una compra.
- Planes Gratuito, Plan Plus, Plan Pro y Plan Nica.
- Selección de productos recomendados según el límite del plan.
- Paneles personalizados para administrador y auditor, con métricas y actividad reciente.
- Registro de evidencias de envío en JPG, PNG, WebP o PDF de hasta 5 MB, con seguimiento y notas opcionales.
- Revisión de evidencias por auditores o administradores, con aprobación o rechazo, observaciones, responsable y fecha de revisión.
- Notificaciones de compra, presentación y revisión de evidencias, y devolución registrada.
- Vencimiento de compras sin comprobante de envío: registra la devolución simulada y notifica al comprador. El plazo predeterminado es de tres días y se configura con `SHIPMENT_DEADLINE_DAYS`.

### Funciones planificadas

- Integración con una pasarela para pagos reales.
- Retención temporal y liberación segura del pago.
- Integración con servicios de paquetería como CargoTrans.
- Seguimiento automático del pedido mediante integración con una empresa de transporte.
- Reembolsos reales a través de la pasarela de pago.

## Funcionamiento actual

## Roles y permisos

| Función | Administrador | Usuario | Auditor |
| --- | :---: | :---: | :---: |
| Explorar productos y perfiles de tiendas | Sí | Sí | No |
| Editar su perfil desde la plataforma | Sí | Sí | No |
| Crear y editar publicaciones propias | Sí | Sí | No |
| Utilizar carrito y confirmar compras | Sí | Sí | No |
| Comprar planes y destacar publicaciones | Sí | Sí | No |
| Adjuntar evidencia de un envío propio | Sí | Sí | No |
| Revisar evidencias de envío | Sí | No | Sí |
| Aprobar o rechazar una evidencia | Sí | No | Sí |
| Acceder a toda la administración | Sí | No | No |
| Moderar y eliminar publicaciones | Sí | No | No |
| Consultar y eliminar usuarios no administrativos | Sí | No | No |

### Responsabilidades

- **Administrador:** posee acceso general a la plataforma y puede respaldar las tareas de auditoría.
- **Usuario:** utiliza el marketplace como comprador o vendedor, administra sus publicaciones y presenta evidencias de sus envíos.
- **Auditor:** supervisa los comprobantes de envío y registra una decisión desde su panel. Puede consultar notificaciones y las evidencias autorizadas; las rutas comerciales y de edición del perfil están restringidas.

El sistema aplica el principio de mínimo privilegio: cada cuenta recibe únicamente los permisos necesarios. Los usuarios nuevos reciben el rol `user`; los roles `admin` y `auditor` se asignan mediante seeders o por administración controlada de la base de datos.

### Perfiles comerciales

Las cuentas nuevas reciben el rol `user`, que permite comprar y vender sin cambiar de rol. El perfil permite actualizar nombre, correo, teléfono, ciudad, nombre del negocio y descripción. Los roles administrativos y de auditoría son independientes de estas actividades comerciales.

### Publicaciones y perfiles públicos

Los usuarios pueden crear publicaciones con título, descripción, categoría, precio, disponibilidad, estado e imagen. Cada publicación enlaza al perfil público de su creador, donde se muestra la información de la tienda, su descripción y el resto de sus productos.

Al crear o editar una publicación, su estado de moderación pasa a `pending`. Un administrador puede aprobarla (`approved`) o rechazarla (`rejected`) indicando el motivo. Las publicaciones pendientes o rechazadas no se ofrecen en el catálogo; el propietario puede consultarlas y editarlas desde su perfil.

### Compra, pago y envío

El carrito permite añadir productos, actualizar cantidades, eliminar artículos y vaciar la selección. Al confirmar el checkout simulado, se genera una notificación por vendedor con sus productos solicitados, los datos del comprador y la dirección indicada. Solo se registra la terminación de la tarjeta; no se guarda el número completo ni el CVV.

Desde la notificación de compra, el vendedor puede adjuntar un comprobante de despacho y, opcionalmente, un número de seguimiento y observaciones. El auditor o administrador revisa la evidencia una sola vez, registra su decisión y notifica al vendedor. El rechazo requiere observaciones. La consulta mediante la ruta de evidencias comprueba que la cuenta sea del vendedor propietario o tenga permisos de auditoría; los archivos se guardan actualmente en el disco público de Laravel.

El comando `php artisan purchases:expire-unshipped` procesa las compras cuyo plazo venció y que no tienen ninguna evidencia registrada. Marca el pago como devuelto y notifica al comprador, sin ejecutar un reembolso bancario real. Una evidencia registrada, incluso pendiente o rechazada, excluye la compra de este procesamiento automático. El comando está programado cada hora en `routes/console.php` y requiere que el programador de Laravel se ejecute en el servidor.

### Productos recomendados y planes

Los productos recomendados obtienen mayor visibilidad en la página de inicio. El cupo depende del plan del vendedor:

Los usuarios del Plan Plus y Plan Pro pueden seleccionar publicaciones recomendadas al crearlas o editarlas. Plan Plus permite hasta 5 y Plan Pro hasta 15. Plan Nica no tiene límite: al contratarlo se destacan las publicaciones existentes y las nuevas se marcan automáticamente como recomendadas; al editar una publicación se puede desmarcar esa selección. La contratación simulada permite ascender a un plan superior al actual. La moderación también se aplica a las publicaciones recomendadas.

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
git clone https://github.com/Joshuar288/Nica-Sky.git
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

## Despliegue en Azure

La dirección pública de la instancia en Azure, proporcionada por el responsable del proyecto, es [http://158.23.62.47](http://158.23.62.47).

### Datos del despliegue

| Dato | Estado documentado |
| --- | --- |
| Dirección pública | `http://158.23.62.47` |
| Código fuente | [Joshuar288/Nica-Sky](https://github.com/Joshuar288/Nica-Sky), rama `main` |
| Artefacto disponible en el repositorio | `dist/NicaSky-web-build-2026-10-08.zip` |
| Contenido verificado del ZIP | Aplicación Laravel, dependencias PHP en `vendor` y recursos compilados en `public/build`, incluido `manifest.json` |
| Servicio de Azure, sistema operativo y servidor web | Pendientes de confirmar con el responsable del despliegue |
| Ubicación y configuración de la base de datos | Pendientes de confirmar; el proyecto incluye configuración para MySQL |
| Método utilizado para publicar la instancia | Pendiente de confirmar; la presencia del ZIP no demuestra que se haya utilizado en Azure |
| Commit ejecutado en Azure | Pendiente de verificar en el servidor |

La URL y el paquete disponible están documentados. El repositorio no contiene una configuración de infraestructura o un flujo de despliegue que permita identificar los demás datos de la instancia. Esta sección debe completarse con la configuración real del servidor para dejar constancia de cómo quedó desplegado.

### Actualización del Repositorio

El código final que está funcionando en Azure debe ser exactamente el mismo que está subido a la rama principal de GitHub, y el documento README debe explicar cómo quedó desplegado el proyecto en Azure.

Para cumplir este requisito, cada publicación debe partir de un commit de `main` ya subido a GitHub. Los cambios hechos en el servidor deben incorporarse al repositorio y volver a desplegarse desde esa versión. Las credenciales, la configuración del entorno, los datos de la base y los archivos subidos por usuarios se administran por separado del código fuente.

En una copia de trabajo destinada a preparar la publicación, comprueba la versión:

```bash
git switch main
git pull --ff-only origin main
git status --short
git rev-parse HEAD
git rev-parse origin/main
```

La copia debe estar limpia y ambos identificadores deben coincidir. Si la publicación utiliza un ZIP, debe regenerarse a partir de ese commit; un ZIP anterior no se actualiza cuando cambia `main`. Registra el identificador del commit publicado junto con la fecha, el método de publicación y el recurso de Azure utilizado. Si el servidor conserva una copia Git, comprueba allí `git rev-parse HEAD` y `git status --short`; para una publicación por ZIP, compara los archivos de aplicación desplegados con los del commit registrado. Hasta realizar esa comprobación, la coincidencia entre Azure y `main` no se considera verificada.

### Preparación de la aplicación para producción

Estos pasos describen los requisitos de la aplicación y deben adaptarse al servicio de Azure realmente utilizado; no constituyen un registro de comandos ya ejecutados en la instancia.

1. Instalar las dependencias desde los archivos de bloqueo y compilar los recursos antes de publicar el paquete:

   ```bash
   composer install --no-dev --prefer-dist --optimize-autoloader
   npm ci
   npm run build
   ```

2. Configurar el servidor web para servir únicamente el directorio `public` y enviar las rutas de la aplicación a `public/index.php`.
3. Configurar el entorno de producción con `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` igual a la dirección publicada, una `APP_KEY` persistente y las credenciales de la base de datos. Mantener la misma clave en las actualizaciones.
4. Asegurar almacenamiento persistente y permisos de escritura para `storage` y `bootstrap/cache`. Conservar las imágenes y evidencias entre publicaciones.
5. Ejecutar los comandos de preparación con el entorno de producción configurado:

   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize
   ```

6. Configurar la ejecución de `php artisan schedule:run` cada minuto. Laravel invoca cada hora `purchases:expire-unshipped`; sin este proceso, las devoluciones simuladas por vencimiento no se ejecutan automáticamente.
7. Comprobar la respuesta de `/up`, el inicio de sesión, la carga de recursos e imágenes, la moderación y el flujo de evidencias. Registrar los resultados con el commit publicado.

Los seeders generales incluyen cuentas con contraseñas conocidas y productos de demostración. En producción se deben cargar los catálogos necesarios y crear las cuentas administrativas con credenciales propias, sin ejecutar indiscriminadamente la carga de demostración.

## Pruebas automatizadas

```bash
php artisan test
```

La suite incluye pruebas de permisos por rol, administración y moderación, edición de productos, actualización de perfiles, autenticación y vencimiento de compras sin evidencia. Estas pruebas comprueban el comportamiento de la aplicación; la publicación en Azure también requiere las comprobaciones del entorno descritas anteriormente.

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


> Proyecto desarrollado como una solución para fomentar el emprendimiento digital en el contexto de HACKATHON Nicaragua Kronnox 2026.
