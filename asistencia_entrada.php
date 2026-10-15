<?php
/**
 * AttendanceTrack - Process Check-In (Entrada)
 */
include("includes/db_connect.php");

date_default_timezone_set('America/El_Salvador');

if (!isset($_POST["id_code"]) || empty(trim($_POST["id_code"]))) {
    header("Location: agregar_entrada.php?q=error");
    exit;
}

$cod_empleado = mysqli_real_escape_string($conn, trim($_POST["id_code"]));
$fechaActual  = date("Y-m-d");
$HoraActual   = date("H:i:s");

// Find active employee in master payroll registry
$sql1 = mysqli_query($conn, "SELECT * FROM planilla WHERE cod_empleado = '$cod_empleado' AND status = 'Activo' LIMIT 1");
if (!$sql1 || mysqli_num_rows($sql1) === 0) {
    header("Location: agregar_entrada.php?q=error");
    exit;
}
$result = mysqli_fetch_assoc($sql1);

// Find assigned project
$sqle = mysqli_query($conn, "SELECT nombre_proyecto FROM empleados_proyectos WHERE cod_empleado = '$cod_empleado' LIMIT 1");
$nombre_proyecto = ($sqle && mysqli_num_rows($sqle) > 0) ? mysqli_fetch_assoc($sqle)['nombre_proyecto'] : 'General';

// Check if attendance already recorded today
$sql2 = mysqli_query($conn, "SELECT id FROM empleados WHERE cod_empleado = '$cod_empleado' AND day = '$fechaActual' LIMIT 1");
if ($sql2 && mysqli_num_rows($sql2) > 0) {
    header("Location: agregar_entrada.php?q=already");
    exit;
}

// Day of week schedule lookup
$dayOfWeek = date("l");
$schedule_map = [
    'Monday'    => 'lunes_entrada',
    'Tuesday'   => 'martes_entrada',
    'Wednesday' => 'miercoles_entrada',
    'Thursday'  => 'jueves_entrada',
    'Friday'    => 'viernes_entrada',
    'Saturday'  => 'sabado_entrada',
    'Sunday'    => 'domingo_entrada',
];

$entry_col   = isset($schedule_map[$dayOfWeek]) ? $schedule_map[$dayOfWeek] : 'lunes_entrada';
$horaentrada = !empty($result[$entry_col]) ? $result[$entry_col] : '07:00:00';
$hora_gracia = date('H:i:s', strtotime($horaentrada . ' +15 minutes'));

if ($HoraActual <= $hora_gracia) {
    $status_entrada = "Presente";
    $query_param    = "presente";
} else {
    $status_entrada = "Tarde";
    $query_param    = "tarde";
}

$nombre_emp  = mysqli_real_escape_string($conn, $result['nombre']);
$nombre_proj = mysqli_real_escape_string($conn, $nombre_proyecto);

mysqli_query($conn, "INSERT INTO empleados 
    (nombre, cod_empleado, day, proyecto, entrada, status_entrada) 
    VALUES ('$nombre_emp', '$cod_empleado', '$fechaActual', '$nombre_proj', '$HoraActual', '$status_entrada')");

@mysqli_query($conn, "INSERT INTO asistencias 
    (nombre, cod_empleado, day, proyecto, entrada, status_entrada) 
    VALUES ('$nombre_emp', '$cod_empleado', '$fechaActual', '$nombre_proj', '$HoraActual', '$status_entrada')");

header("Location: agregar_entrada.php?q=$query_param");
exit;
