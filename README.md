# AttendanceTrack

Sistema web de asistencia por turnos con credenciales QR. Lo desarrollé e implementé para una empresa privada que registraba y consolidaba a mano la asistencia de su personal en distintos proyectos.

*In English: a web attendance system with QR badges and weekly shifts that I built and deployed for a private company.*

## Cómo funciona

**Terminal de marcaje** (raíz del proyecto)

- La cámara lee la credencial QR del empleado, muestra su foto y registra la entrada o la salida según el horario que tiene ese día.
- Si llega después de su hora, la entrada queda como "Tarde". En la salida calcula las horas extra cuando pasan más de 15 minutos de su horario.

**Panel administrativo** (`admin/`)

- Empleados con su horario de lunes a domingo.
- Proyectos con sus encargados y los empleados asignados a cada uno.
- Lista de asistencia donde se pueden registrar justificaciones.
- Credenciales QR listas para imprimir en PDF, en tamaño tarjeta.
- Reporte de horas trabajadas y horas extra por rango de fechas, descargable para Excel.
- Dos niveles de acceso: administrador y encargado de proyecto.

**API** (`api.php`)

Recibe el código del empleado por POST (`id_code`) y responde en JSON si registró una entrada, una salida o si el turno ya estaba cerrado.

## Tecnología

PHP con mysqli y sentencias preparadas, MySQL o MariaDB, JavaScript, html5-qrcode para leer los códigos, phpqrcode y TCPDF para las credenciales, y Bootstrap 4 con la plantilla SB Admin 2.

## Cómo correrlo

Requisitos: PHP 7.4 u 8 con las extensiones `mysqli` y `gd`, y MySQL o MariaDB.

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seeds.sql
cp config.example.php config.php   # también se puede configurar con variables de entorno
php -S localhost:8000
```

- Terminal de marcaje: http://localhost:8000/
- Panel administrativo: http://localhost:8000/admin/

La base de datos real no está en el repositorio. `seeds.sql` trae datos ficticios:

| Usuario | Contraseña | Nivel |
|---|---|---|
| Admin User | `Admin2024!` | Administrador |
| Alice Smith | `password123` | Administrador |
| Bob Johnson | `password123` | Encargado |

Para probar la terminal se pueden generar las credenciales de los empleados `EMP-001`, `EMP-002` y `EMP-003` desde el panel.

## Pendientes

- No tiene pruebas automatizadas.
- El reporte de horas se descarga como una tabla con extensión `.xls`, no como un archivo nativo de Excel.
- Cada empleado tiene un horario fijo por día de la semana; no maneja turnos rotativos.

## Licencia

[MIT](LICENSE)
