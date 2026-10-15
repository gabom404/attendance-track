<?php
include("./config/config.php");
$cod_empleado = $_POST["id_code"];

$fecha = $_POST["fecha"];
// echo $_POST["date"];
date_default_timezone_set('America/El_Salvador');

$HoraActual = date("H:i:s");
$fechaActual = date("Y-m-d");

// $fecha_actual = getdate();
// $hora =  $fecha_actual['hours'] . ":" . $fecha_actual['minutes'];

    

$sql1 = mysqli_query($conn, "SELECT * FROM planilla WHERE cod_empleado = '".$cod_empleado."' AND status='Activo'");
$result = mysqli_fetch_assoc($sql1);

if(mysqli_num_rows($sql1) > 0)
{
    $sql2 = mysqli_query($conn, "SELECT * FROM empleados WHERE cod_empleado = '".$cod_empleado."' AND day = '".$fechaActual."'");    
    if(mysqli_num_rows($sql2) > 0)
    {
        // $resultid = mysqli_fetch_assoc($sql2);
        // $actualizar = mysqli_query($conn, "UPDATE empleados SET salida = '".$HoraActual."' WHERE cod_empleado = '".$cod_empleado."' AND day = '".$fechaActual."' ");
        // header("Location: login.php?q=presentesal");
        $horasalida = $result['hora_salida'];
        if($HoraActual  >= $horasalida){
        $actualizar = mysqli_query($conn, "UPDATE empleados SET salida = '".$HoraActual."', status_salida = 'Completo' WHERE cod_empleado = '".$cod_empleado."' AND day = '".$fechaActual."' ");
        header("Location: login.php?q=salida");
        }else{
        $actualizar = mysqli_query($conn, "UPDATE empleados SET salida = '".$HoraActual."', status_salida = 'Incompleto' WHERE cod_empleado = '".$cod_empleado."' AND day = '".$fechaActual."' ");
        header("Location: login.php?q=salidatemp");   
        }

    }else{
        $horaentrada = $result['hora_entrada'];
        if($HoraActual  <= $horaentrada){
            $insertar = mysqli_query($conn, 'INSERT INTO empleados (nombre, cod_empleado,  day, entrada, status_entrada) VALUES ("'.$result['nombre'].'","'.$result['cod_empleado'].'","'.$fecha.'","'.$HoraActual.'","Prente")');
            header("Location: login.php?q=presente");
        }else{
            $insertar = mysqli_query($conn, 'INSERT INTO empleados (nombre, cod_empleado, day, entrada, status_entrada ) VALUES ("'.$result['nombre'].'","'.$result['cod_empleado'].'","'.$fecha.'","'.$HoraActual.'","Tarde")');
            header("Location: login.php?q=xd");   
        }
    } 
}else{

    header("Location: login.php?q=error");
}
?>

