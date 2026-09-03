# Buenas prácticas, código legible y definición de roles y permisos

## Proyecto: NicaSky

**Fecha:** 3 de septiembre de 2026  
**Tecnología principal:** Laravel 13 y PHP 8.3

---

## 1. Introducción

NicaSky es una plataforma de comercio electrónico orientada a conectar compradores, vendedores y proveedores. Debido a que cada persona cumple responsabilidades diferentes dentro del sistema, fue necesario implementar un mecanismo de control de acceso basado en roles.

Este mecanismo permite determinar qué acciones puede realizar cada usuario después de iniciar sesión. La autorización no depende únicamente de ocultar opciones en la interfaz: las rutas también comprueban los permisos desde el servidor.

La implementación contempla tres roles:

1. Administrador.
2. Usuario.
3. Auditor.

---

## 2. Objetivos

### Objetivo general

Implementar un sistema de roles y permisos que controle de forma segura el acceso a las funciones de NicaSky y mantenga una estructura de código clara, reutilizable y verificable.

### Objetivos específicos

- Definir los roles en un único componente del sistema.
- Evitar que un usuario acceda a funciones que no corresponden a sus responsabilidades.
- Proteger las rutas sensibles desde el servidor.
- Adaptar la navegación según el rol autenticado.
- Aplicar el principio de mínimo privilegio.
- Comprobar los permisos mediante pruebas automatizadas.
- Mantener un código organizado y legible.

---

## 3. Definición de roles

### 3.1. Administrador

El administrador posee acceso general a las funciones habilitadas en la plataforma. Puede utilizar el marketplace y actuar como respaldo en el proceso de auditoría de envíos.

Entre sus permisos se encuentran:

- Explorar productos y perfiles públicos.
- Administrar su perfil.
- Crear y editar publicaciones propias.
- Utilizar el carrito y confirmar compras.
- Contratar planes para destacar productos.
- Presentar evidencias de sus envíos.
- Consultar la bandeja de verificaciones.
- Aprobar o rechazar evidencias de envío.

### 3.2. Usuario

Es el rol asignado automáticamente a las personas que se registran en NicaSky. Permite utilizar las funciones comerciales normales de la plataforma como comprador o vendedor.

Entre sus permisos se encuentran:

- Explorar productos y perfiles.
- Administrar su perfil.
- Crear y editar sus propias publicaciones.
- Añadir productos al carrito.
- Confirmar compras.
- Contratar planes.
- Seleccionar productos recomendados según el plan contratado.
- Presentar una evidencia cuando realiza el envío de un pedido.
- Consultar el resultado de la revisión de su evidencia.

Un usuario no puede acceder al panel de auditoría ni aprobar sus propias evidencias.

### 3.3. Auditor

El auditor supervisa las evidencias de envío presentadas por los vendedores. Su función es de revisión y control, por lo que no participa en las operaciones comerciales normales.

Entre sus permisos se encuentran:

- Explorar productos y perfiles públicos.
- Administrar sus datos personales.
- Consultar sus notificaciones.
- Acceder al panel de verificación de envíos.
- Abrir los comprobantes protegidos.
- Aprobar una evidencia.
- Rechazar una evidencia y registrar observaciones.

El auditor no puede crear publicaciones, utilizar el carrito, confirmar compras ni contratar planes.

---

## 4. Matriz de permisos

| Función | Administrador | Usuario | Auditor |
| --- | :---: | :---: | :---: |
| Explorar productos | Sí | Sí | Sí |
| Consultar perfiles públicos | Sí | Sí | Sí |
| Administrar datos personales | Sí | Sí | Sí |
| Crear publicaciones | Sí | Sí | No |
| Editar publicaciones propias | Sí | Sí | No |
| Utilizar el carrito | Sí | Sí | No |
| Confirmar compras | Sí | Sí | No |
| Contratar planes | Sí | Sí | No |
| Presentar evidencia de envío propia | Sí | Sí | No |
| Consultar todas las evidencias | Sí | No | Sí |
| Aprobar o rechazar evidencias | Sí | No | Sí |

---

## 5. Implementación técnica

### 5.1. Enumeración de roles

Los roles están centralizados en `app/Enums/UserRole.php` mediante un `enum` de PHP:

```php
enum UserRole: string
{
    case Admin = 'admin';
    case User = 'user';
    case Auditor = 'auditor';
}
```

Esta solución evita escribir los nombres de los roles repetidamente en diferentes archivos y reduce errores causados por valores inválidos o diferencias de escritura.

### 5.2. Modelo de usuario

El modelo `User` convierte automáticamente la columna `role` en un objeto `UserRole`. Además, contiene métodos descriptivos para consultar los permisos:

```php
public function hasRole(UserRole ...$roles): bool
{
    return in_array($this->role, $roles, true);
}

public function isAdmin(): bool
{
    return $this->hasRole(UserRole::Admin);
}

public function isAuditor(): bool
{
    return $this->hasRole(UserRole::Auditor);
}

public function canAudit(): bool
{
    return $this->hasRole(UserRole::Admin, UserRole::Auditor);
}
```

El uso de nombres como `isAuditor()` y `canAudit()` permite comprender la intención del código sin necesidad de comentarios adicionales.

### 5.3. Middleware de autorización

El middleware `EnsureUserHasRole` comprueba el rol antes de permitir que la solicitud llegue al controlador.

```php
abort_unless(
    $request->user() && in_array($request->user()->role, $allowedRoles, true),
    403,
);
```

Cuando el usuario no posee uno de los roles permitidos, Laravel responde con el código HTTP `403 Forbidden`. Esto impide que una persona evada la interfaz escribiendo directamente una URL protegida.

El alias del middleware se registra en `bootstrap/app.php`:

```php
$middleware->alias([
    'role' => EnsureUserHasRole::class,
]);
```

### 5.4. Protección de rutas

Las operaciones comerciales están disponibles para usuarios y administradores:

```php
Route::middleware('role:user,admin')->group(function () {
    // Publicaciones, carrito, planes y evidencias de envío.
});
```

Las operaciones de auditoría están disponibles únicamente para auditores y administradores:

```php
Route::middleware(['auth', 'role:auditor,admin'])
    ->prefix('auditor')
    ->group(function () {
        // Consulta y revisión de evidencias.
    });
```

### 5.5. Asignación de roles

Los usuarios registrados reciben el rol `user` de manera explícita en `RegisteredUserController`.

Los roles especiales se crean mediante:

- `AdminUserSeeder.php` para administradores.
- `AuditorUserSeeder.php` para el auditor.

El auditor de prueba utiliza las siguientes credenciales:

| Campo | Valor |
| --- | --- |
| Correo | `auditor@nicasky.com` |
| Contraseña | `password123` |
| Rol | `auditor` |

Estas credenciales deben utilizarse únicamente en el entorno de desarrollo o demostración.

---

## 6. Flujo de verificación de envío

1. Un comprador confirma una compra.
2. El vendedor recibe una notificación con los datos del pedido.
3. El vendedor selecciona la opción **Confirmar envío**.
4. Adjunta una imagen o un archivo PDF como evidencia.
5. Opcionalmente, registra el número de seguimiento y observaciones.
6. El sistema crea una verificación con estado `pending`.
7. Los auditores y administradores reciben una notificación.
8. Un auditor abre la bandeja **Verificar envíos**.
9. Revisa el comprobante y aprueba o rechaza la evidencia.
10. El sistema registra quién realizó la revisión y cuándo la hizo.
11. El vendedor recibe una notificación con el resultado.

Los estados utilizados son:

| Estado interno | Significado |
| --- | --- |
| `pending` | Evidencia pendiente de revisión. |
| `approved` | Evidencia aceptada por un auditor. |
| `rejected` | Evidencia rechazada; requiere una observación. |

La evidencia no se enlaza públicamente. Solo puede consultarla el vendedor propietario, un auditor o un administrador.

---

## 7. Buenas prácticas aplicadas

### Control de acceso en el servidor

Los permisos se validan mediante middleware. Ocultar botones mejora la experiencia, pero no se considera una medida de seguridad suficiente.

### Principio de mínimo privilegio

Cada rol recibe únicamente las capacidades necesarias para cumplir su función. Por ejemplo, un auditor puede verificar envíos, pero no puede realizar compras.

### Separación de responsabilidades

- Los modelos representan y relacionan los datos.
- Los controladores procesan las solicitudes.
- El middleware controla el acceso.
- Las notificaciones informan los eventos.
- Las vistas presentan la información.
- Los seeders crean cuentas de demostración.
- Las pruebas verifican el comportamiento esperado.

### Nombres descriptivos

Las clases y métodos utilizan nombres como `EnsureUserHasRole`, `ShipmentVerification`, `canAudit` y `review`, que permiten reconocer rápidamente su responsabilidad.

### Validación de datos

Los formularios validan el tipo y tamaño de los archivos, los estados permitidos y la longitud de las observaciones. Una evidencia solo puede aprobarse o rechazarse una vez.

### Protección de archivos

Antes de entregar un comprobante, el servidor verifica que la persona autenticada sea el vendedor propietario o que tenga permisos de auditoría.

### Formato consistente

Los archivos PHP relacionados fueron procesados con Laravel Pint para conservar el estándar de estilo del framework.

### Pruebas automatizadas

Los permisos se comprueban mediante pruebas de integración para evitar que futuras modificaciones eliminen accidentalmente una restricción.

---

## 8. Pruebas realizadas

El archivo `tests/Feature/RolePermissionsTest.php` comprueba los siguientes escenarios:

1. Un usuario no puede acceder al panel de auditoría.
2. Un auditor puede acceder al panel de auditoría.
3. Un administrador puede acceder al panel de auditoría.
4. Un auditor no puede publicar, comprar ni contratar planes.
5. Un usuario puede utilizar las funciones comerciales.

Comando utilizado:

```bash
php artisan test tests/Feature/RolePermissionsTest.php
```

Resultado obtenido:

```text
Tests: 5 aprobadas
Verificaciones: 9 aprobadas
```

También se validó la sintaxis, se compilaron las vistas Blade y se revisó el formato del código.

---

## 9. Evidencias visuales recomendadas

Para la presentación final se recomienda insertar capturas de:

1. El menú de un usuario normal.
2. El menú del auditor con la opción **Verificar envíos**.
3. El formulario utilizado por el vendedor para adjuntar evidencia.
4. La bandeja de verificaciones del auditor.
5. Los botones **Aprobar** y **Rechazar**.
6. La notificación que recibe el vendedor después de la revisión.
7. La respuesta `403 Forbidden` cuando un auditor intenta acceder al carrito o crear una publicación.
8. La terminal mostrando las cinco pruebas aprobadas.

---

## 10. Archivos principales

| Archivo | Responsabilidad |
| --- | --- |
| `app/Enums/UserRole.php` | Define los tres roles. |
| `app/Models/User.php` | Convierte y consulta el rol del usuario. |
| `app/Http/Middleware/EnsureUserHasRole.php` | Autoriza o rechaza solicitudes según el rol. |
| `bootstrap/app.php` | Registra el alias del middleware. |
| `routes/web.php` | Asigna permisos a las rutas. |
| `app/Http/Controllers/ShipmentVerificationController.php` | Gestiona la presentación y revisión de evidencias. |
| `app/Models/ShipmentVerification.php` | Representa una verificación de envío. |
| `app/Notifications/ShipmentVerificationNotification.php` | Notifica a auditores y vendedores. |
| `resources/views/auditor/shipments/index.blade.php` | Presenta la bandeja del auditor. |
| `tests/Feature/RolePermissionsTest.php` | Verifica automáticamente los permisos. |

---

## 11. Conclusión

La implementación permite diferenciar claramente las responsabilidades del administrador, usuario y auditor. Las restricciones se aplican desde el servidor y se complementan con una interfaz adaptada a cada rol.

El uso de enumeraciones, middleware, validaciones, componentes separados, formato estándar y pruebas automatizadas mejora la seguridad y facilita el mantenimiento del proyecto. De esta manera, NicaSky cumple con el requisito de buenas prácticas, código legible y definición de tres roles con permisos específicos.
