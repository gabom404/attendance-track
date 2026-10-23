<?php
/**
 * AttendanceTrack - Retrieve Employee Photo Path
 */
include("includes/db_connect.php");

if (isset($_GET['id_code'])) {
    $id_code = trim($_GET['id_code']);
    $query = "SELECT img_empleado FROM planilla WHERE cod_empleado = ? LIMIT 1";
    $resultado = safe_query($conn, $query, [$id_code]);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $imagen = !empty($fila['img_empleado']) ? $fila['img_empleado'] : 'images/picture.png';
        header('Content-Type: text/plain');
        echo $imagen;
    } else {
        header('Content-Type: text/plain');
        echo 'images/picture.png';
    }
} else {
    header('Content-Type: text/plain');
    echo 'images/picture.png';
}
