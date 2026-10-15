<?php
/**
 * AttendanceTrack - Retrieve Employee Photo Path
 */
include("includes/db_connect.php");

if (isset($_GET['id_code'])) {
    $id_code = mysqli_real_escape_string($conn, trim($_GET['id_code']));
    $query = "SELECT img_empleado FROM planilla WHERE cod_empleado = '$id_code' LIMIT 1";
    $resultado = mysqli_query($conn, $query);
    
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
