<?php
/**
 * AttendanceTrack - Attendance REST API
 *
 * Endpoint: POST /api.php
 * Parameters:
 *   - id_code (string, required): Employee identifier (e.g. EMP-001)
 *   - fecha (string, optional): Timestamp or date string (Y-m-d H:i:s)
 *
 * Response (JSON):
 *   - status: "success" | "error" | "info"
 *   - action: "check_in" | "check_out" | "already_recorded"
 *   - message: Descriptive status message
 *   - data: Event details
 */

header('Content-Type: application/json; charset=utf-8');
include("includes/db_connect.php");

date_default_timezone_set('America/El_Salvador');

if (!isset($_POST["id_code"]) || empty(trim($_POST["id_code"]))) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required parameter 'id_code'."
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$cod_empleado = trim($_POST["id_code"]);
$fechaActual  = date("Y-m-d");
$HoraActual   = date("H:i:s");
$fecha        = isset($_POST["fecha"]) && !empty($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d H:i:s");

// Verify active employee in master registry
$sql_emp = safe_query($conn, 'SELECT * FROM planilla WHERE cod_empleado = ? AND status = \'Activo\' LIMIT 1', [$cod_empleado]);
if (!$sql_emp || mysqli_num_rows($sql_emp) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Employee with code '$cod_empleado' not found or is inactive."
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$emp = mysqli_fetch_assoc($sql_emp);

// Query assigned project
$sql_proj = safe_query($conn, 'SELECT nombre_proyecto FROM empleados_proyectos WHERE cod_empleado = ? LIMIT 1', [$cod_empleado]);
$nombre_proyecto = ($sql_proj && mysqli_num_rows($sql_proj) > 0) ? mysqli_fetch_assoc($sql_proj)['nombre_proyecto'] : 'General Operations';

// Map day of week to schedule columns
$dayOfWeek = date("l");
$schedule_map = [
    'Monday'    => ['in' => 'lunes_entrada',     'out' => 'lunes_salida'],
    'Tuesday'   => ['in' => 'martes_entrada',    'out' => 'martes_salida'],
    'Wednesday' => ['in' => 'miercoles_entrada', 'out' => 'miercoles_salida'],
    'Thursday'  => ['in' => 'jueves_entrada',    'out' => 'jueves_salida'],
    'Friday'    => ['in' => 'viernes_entrada',   'out' => 'viernes_salida'],
    'Saturday'  => ['in' => 'sabado_entrada',    'out' => 'sabado_salida'],
    'Sunday'    => ['in' => 'domingo_entrada',   'out' => 'domingo_salida'],
];

$in_col  = isset($schedule_map[$dayOfWeek]) ? $schedule_map[$dayOfWeek]['in'] : 'lunes_entrada';
$out_col = isset($schedule_map[$dayOfWeek]) ? $schedule_map[$dayOfWeek]['out'] : 'lunes_salida';

$scheduled_in  = $emp[$in_col];
$scheduled_out = $emp[$out_col];

// Check existing attendance for today
$sql_check = safe_query($conn, 'SELECT * FROM empleados WHERE cod_empleado = ? AND day = ? LIMIT 1', [$cod_empleado, $fechaActual]);

if ($sql_check && mysqli_num_rows($sql_check) > 0) {
    $record = mysqli_fetch_assoc($sql_check);

    // If check-out is already logged
    if (!empty($record['status_salida']) && $record['status_salida'] !== 'NULL') {
        echo json_encode([
            "status" => "info",
            "action" => "already_recorded",
            "message" => "Shift attendance already finalized for today.",
            "data" => [
                "employee" => $emp['nombre'],
                "cod_empleado" => $cod_empleado,
                "day" => $fechaActual,
                "entrada" => $record['entrada'],
                "salida" => $record['salida'],
                "status_entrada" => $record['status_entrada'],
                "status_salida" => $record['status_salida']
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Process Check-Out (Salida)
    $actual_time_ts    = strtotime($HoraActual);
    $scheduled_out_ts  = strtotime($scheduled_out);
    $grace_out_time    = date('H:i:s', strtotime($scheduled_out . ' +15 minutes'));
    $hours_diff        = ($actual_time_ts - $scheduled_out_ts) / 3600;
    $overtime          = round($hours_diff, 1);

    if ($HoraActual <= $grace_out_time) {
        $status_salida = 'Completo';
        $status_horas  = 'Sin H.E';
        $horas_extra   = 0;
    } elseif ($overtime > 0 && $overtime <= 0.25) {
        $status_salida = 'Completo';
        $status_horas  = 'Sin H.E';
        $horas_extra   = 0;
    } elseif ($overtime > 0.25) {
        $status_salida = 'Completo';
        $status_horas  = 'H.E NO AUTORIZADA';
        $horas_extra   = $overtime;
    } else {
        $status_salida = 'Incompleto';
        $status_horas  = 'Salida Anticipada';
        $horas_extra   = 0;
    }

    $update_query = "UPDATE empleados SET 
        salida = ?, 
        status_salida = ?, 
        status_horas = ?, 
        horas_extra = ? 
        WHERE cod_empleado = ? AND day = ?";
    safe_query($conn, $update_query, [$HoraActual, $status_salida, $status_horas, $horas_extra, $cod_empleado, $fechaActual]);

    // Synchronize to asistencias if available
    @safe_query($conn, 'UPDATE asistencias SET 
        salida = ?, 
        status_salida = ?, 
        status_horas = ?, 
        horas_extra = ? 
        WHERE cod_empleado = ? AND day = ?', [$HoraActual, $status_salida, $status_horas, $horas_extra, $cod_empleado, $fechaActual]);

    echo json_encode([
        "status" => "success",
        "action" => "check_out",
        "message" => "Check-out logged successfully.",
        "data" => [
            "employee" => $emp['nombre'],
            "cod_empleado" => $cod_empleado,
            "day" => $fechaActual,
            "salida" => $HoraActual,
            "status_salida" => $status_salida,
            "status_horas" => $status_horas,
            "horas_extra" => $horas_extra
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;

} else {
    // Process Check-In (Entrada)
    $grace_in_time = date('H:i:s', strtotime($scheduled_in . ' +15 minutes'));

    if ($HoraActual <= $grace_in_time) {
        $status_entrada = "Presente";
    } else {
        $status_entrada = "Tarde";
    }

    $emp_nombre = $emp['nombre'];
    $proj_safe  = $nombre_proyecto;

    $insert_query = "INSERT INTO empleados 
        (nombre, cod_empleado, day, proyecto, entrada, status_entrada) 
        VALUES (?, ?, ?, ?, ?, ?)";
    safe_query($conn, $insert_query, [$emp_nombre, $cod_empleado, $fechaActual, $proj_safe, $HoraActual, $status_entrada]);

    @safe_query($conn, 'INSERT INTO asistencias 
        (nombre, cod_empleado, day, proyecto, entrada, status_entrada) 
        VALUES (?, ?, ?, ?, ?, ?)', [$emp_nombre, $cod_empleado, $fechaActual, $proj_safe, $HoraActual, $status_entrada]);

    echo json_encode([
        "status" => "success",
        "action" => "check_in",
        "message" => "Check-in logged successfully.",
        "data" => [
            "employee" => $emp['nombre'],
            "cod_empleado" => $cod_empleado,
            "day" => $fechaActual,
            "entrada" => $HoraActual,
            "status_entrada" => $status_entrada,
            "proyecto" => $nombre_proyecto
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
