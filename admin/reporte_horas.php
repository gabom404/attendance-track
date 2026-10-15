<?php
include('config/config.php');

$fecha1 = $_POST['rango1'];
$fecha2 = $_POST['rango2'];

$query = "SELECT e.cod_empleado, e.nombre, ep.nombre_proyecto, GROUP_CONCAT(e.day ORDER BY e.day ASC SEPARATOR '|') AS fechas, GROUP_CONCAT(e.entrada ORDER BY e.day ASC SEPARATOR '|') AS entradas, GROUP_CONCAT(e.salida ORDER BY e.day ASC SEPARATOR '|') AS salidas, GROUP_CONCAT(e.justificacion ORDER BY e.day ASC SEPARATOR '|') AS justificaciones, GROUP_CONCAT(e.justificado_por ORDER BY e.day ASC SEPARATOR '|') AS justificado_por, GROUP_CONCAT(e.notas ORDER BY e.day ASC SEPARATOR '|') AS notas
          FROM empleados e
          LEFT JOIN empleados_proyectos ep ON e.cod_empleado = ep.cod_empleado
          WHERE e.day BETWEEN '$fecha1' AND '$fecha2'
          GROUP BY e.cod_empleado, e.nombre, ep.nombre_proyecto";
$resultado = mysqli_query($conn, $query);

function generarColorClaroAleatorio() {
    $r = mt_rand(200, 255); // Componente rojo en el rango de 200-255
    $g = mt_rand(200, 255); // Componente verde en el rango de 200-255
    $b = mt_rand(200, 255); // Componente azul en el rango de 200-255

    $color = sprintf("#%02x%02x%02x", $r, $g, $b); // Formato hexadecimal

    return $color;
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$fecha1 - $fecha2.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<table border="1">';
echo '<tr style="background-color: #CCCCCC;">';
echo utf8_decode('<th style="background-color: #EEEEEE;">Número de Bloque</th>');
echo '<th style="background-color: #EEEEEE;">Proyecto</th>';
echo utf8_decode('<th style="background-color: #EEEEEE;">Código de Empleado</th>');
echo '<th style="background-color: #EEEEEE;">Nombre</th>';
echo '<th style="background-color: #EEEEEE;">Fechas</th>';
echo '<th style="background-color: #EEEEEE;">Horas de Entrada</th>';
echo '<th style="background-color: #EEEEEE;">Horas de Salida</th>';
echo utf8_decode('<th style="background-color: #EEEEEE;">Horas por Día</th>');
echo '<th style="background-color: #EEEEEE;">Horas Extra</th>';
echo utf8_decode('<th style="background-color: #EEEEEE;">Justificación</th>');
echo '<th style="background-color: #EEEEEE;">Justificado por</th>';
echo '<th style="background-color: #EEEEEE;">Notas</th>';
echo '</tr>';

$blockNumber = 1;

while ($row = mysqli_fetch_assoc($resultado)) {
    $cod_empleado = $row['cod_empleado'];
    $nombre = utf8_decode($row['nombre']);
    $nombre_proyecto = $row['nombre_proyecto'];
    $fechas = explode('|', $row['fechas']);
    $entradas = explode('|', $row['entradas']);
    $salidas = explode('|', $row['salidas']);
    $justificaciones = explode('|', $row['justificaciones']);
    $justificado_por = explode('|', $row['justificado_por']);
    $notas = explode('|', $row['notas']);

    $numRegistros = count($fechas);

    $color = generarColorClaroAleatorio();

    echo '<tr style="background-color: ' . $color . ';">';
    echo '<td rowspan="' . $numRegistros . '">' . $blockNumber . '</td>';
    echo '<td rowspan="' . $numRegistros . '">' . $nombre_proyecto . '</td>';
    echo '<td rowspan="' . $numRegistros . '">' . $cod_empleado . '</td>';
    echo '<td rowspan="' . $numRegistros . '">' . $nombre . '</td>';

    $totalHoras = 0; // Variable para almacenar la suma de las horas trabajadas por día

    for ($i = 0; $i < $numRegistros; $i++) {
        echo '<td>' . $fechas[$i] . '</td>';
        echo '<td>' . date('h:i A', strtotime($entradas[$i])) . '</td>';
echo '<td>' . date('h:i A', strtotime($salidas[$i])) . '</td>';



        // Calcular total de horas trabajadas por día
        $horaEntrada = strtotime($entradas[$i]);
        $horaSalida = strtotime($salidas[$i]);

        // Manejar casos donde la hora de salida es anterior a la hora de entrada (supera las 24 horas)
        if ($horaSalida < $horaEntrada) {
            $horaSalida += 86400; // Agregar 24 horas en segundos
        }

        if (date('H:i:s', $horaSalida) == '00:00:00') {
            echo utf8_decode('<td>Jornada en espera de finalización</td>');
        } else {
            $segundosTrabajados = $horaSalida - $horaEntrada;
            $horasTrabajadas = floor($segundosTrabajados / 3600);
            $minutosTrabajados = floor(($segundosTrabajados % 3600) / 60);
            $segundosRestantes = $segundosTrabajados % 60;
            $totalHoras += $segundosTrabajados;

echo '<td>' . $horasTrabajadas . ':' . $minutosTrabajados . ':' . $segundosRestantes . '</td>';
}

        echo '<td>' . ($horas_extra[$i] > 0 ? $horas_extra[$i] : 'N/A') . '</td>';

        echo '<td>' . utf8_decode($justificaciones[$i]) . '</td>';
        echo '<td>' . utf8_decode($justificado_por[$i]) . '</td>';
        echo '<td>' . utf8_decode($notas[$i]) . '</td>';

        echo '</tr>';

        // Si no es el último registro, imprimir una nueva fila para el siguiente día
        if ($i < $numRegistros - 1) {
            echo '<tr style="background-color: ' . $color . ';">';
        }
    }

    // Calcular las horas totales después de haber recorrido todos los días trabajados
    $horasTotales = floor($totalHoras / 3600);
    $minutosTotales = floor(($totalHoras % 3600) / 60);
    $segundosTotales = $totalHoras % 60;
    $totalHorasFormateadas = date('h:i:s A', strtotime(sprintf('%02d:%02d:%02d', $horasTotales, $minutosTotales, $segundosTotales)));

    echo '<td colspan="6"></td>';
    echo '<td style="background-color: orange;">Total de horas trabajadas</td>'; // Columna Horas Totales
    $totalHorasFormateadas = floor($totalHoras / 3600) . ':' . floor(($totalHoras % 3600) / 60) . ':' . ($totalHoras % 60);
    echo '<td style="background-color: orange;">' . $totalHorasFormateadas . '</td>';

    echo '<td colspan="2"></td>';
    echo '</tr>';

    $blockNumber++;
}

echo '</table>';

mysqli_close($conn);
?>
