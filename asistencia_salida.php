<?php
/**
 * AttendanceTrack - Process Check-Out (Salida)
 */
include("includes/db_connect.php");

date_default_timezone_set('America/El_Salvador');

if (!isset($_POST["id_code"]) || empty(trim($_POST["id_code"]))) {
    header("Location: agregar_salida.php?q=error");
    exit;
}

$cod_empleado = trim($_POST["id_code"]);
$fechaActual  = date("Y-m-d");
$HoraActual   = date("H:i:s");

// Find active employee
$sql1 = safe_query($conn, 'SELECT * FROM planilla WHERE cod_empleado = ? AND status = \'Activo\' LIMIT 1', [$cod_empleado]);
if (!$sql1 || mysqli_num_rows($sql1) === 0) {
    header("Location: agregar_salida.php?q=error");
    exit;
}
$result = mysqli_fetch_assoc($sql1);

// Verify check-in was recorded today
$sql2 = safe_query($conn, 'SELECT * FROM empleados WHERE cod_empleado = ? AND day = ? LIMIT 1', [$cod_empleado, $fechaActual]);
if (!$sql2 || mysqli_num_rows($sql2) === 0) {
    header("Location: agregar_salida.php?q=res");
    exit;
}

$existing = mysqli_fetch_assoc($sql2);
if (!empty($existing['status_salida']) && $existing['status_salida'] !== 'NULL') {
    header("Location: agregar_salida.php?q=already");
    exit;
}

// Day of week schedule lookup
$dayOfWeek = date("l");
$schedule_map = [
    'Monday'    => 'lunes_salida',
    'Tuesday'   => 'martes_salida',
    'Wednesday' => 'miercoles_salida',
    'Thursday'  => 'jueves_salida',
    'Friday'    => 'viernes_salida',
    'Saturday'  => 'sabado_salida',
    'Sunday'    => 'domingo_salida',
];

$exit_col     = isset($schedule_map[$dayOfWeek]) ? $schedule_map[$dayOfWeek] : 'lunes_salida';
$horasalida   = !empty($result[$exit_col]) ? $result[$exit_col] : '17:00:00';

$actual_ts    = strtotime($HoraActual);
$scheduled_ts = strtotime($horasalida);
$hora_gracia  = date('H:i:s', strtotime($horasalida . ' +15 minutes'));
$diferencia   = ($actual_ts - $scheduled_ts) / 3600;
$horasextra   = round($diferencia, 1);

if ($HoraActual <= $hora_gracia) {
    $status_salida = 'Completo';
    $status_horas  = 'Sin H.E';
    $horas_extra   = 0;
    $query_param   = 'salida';
} elseif ($horasextra > 0 && $horasextra <= 0.25) {
    $status_salida = 'Completo';
    $status_horas  = 'Sin H.E';
    $horas_extra   = 0;
    $query_param   = 'salida';
} elseif ($horasextra > 0.25) {
    $status_salida = 'Completo';
    $status_horas  = 'H.E NO AUTORIZADA';
    $horas_extra   = $horasextra;
    $query_param   = 'salida';
} else {
    $status_salida = 'Incompleto';
    $status_horas  = 'Salida Anticipada';
    $horas_extra   = 0;
    $query_param   = 'salidatemp';
}

safe_query($conn, 'UPDATE empleados SET 
    salida = ?, 
    status_salida = ?, 
    status_horas = ?, 
    horas_extra = ? 
    WHERE cod_empleado = ? AND day = ?', [$HoraActual, $status_salida, $status_horas, $horas_extra, $cod_empleado, $fechaActual]);

@safe_query($conn, 'UPDATE asistencias SET 
    salida = ?, 
    status_salida = ?, 
    status_horas = ?, 
    horas_extra = ? 
    WHERE cod_empleado = ? AND day = ?', [$HoraActual, $status_salida, $status_horas, $horas_extra, $cod_empleado, $fechaActual]);

header("Location: agregar_salida.php?q=$query_param");
exit;
