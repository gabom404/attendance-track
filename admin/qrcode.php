<?php
include("phpqrcode/qrlib.php");
require_once('tcpdf/tcpdf.php');
include("config/config.php");

$id = $_GET['q'];

// Texto a codificar en el código QR
$texto = $id;

// Ruta donde se guardará el archivo de imagen PNG
$rutaImagen = './qrs/'.$texto.'.png';

QRcode::png($texto, $rutaImagen);

// Genera el código QR en formato PNG
// Muestra el código QR en la página web
// echo '<img src="'.QRcode::png($texto).'" />';
$pdf = new TCPDF('P', 'mm', array(85, 54), true, 'UTF-8', false);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

// Código QR
$qr_code = ''.$id.'';
$qr_size = 0; // tamaño del código qr (igual al ancho de la página)
$qr_error_correction = 'L'; // corrección de errores: L, M, Q, H
$qr_margin = 0; // margen del código qr

$pdf->Image("qrs/cccc-01.png", $x = 0, $y = 0, $w = 54, $h = 85, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
$query = mysqli_query($conn, 'SELECT id, nombre, cod_empleado, img_empleado, rol FROM planilla WHERE cod_empleado="'.$id.'"');
$result = mysqli_fetch_assoc($query);

$image_file = "../".$result['img_empleado']."";
$pdf->Image($image_file, $x = 16, $y = 26.9, $w = 21.9, $h = 28.9, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetXY(9, 61.8);
$pdf->Cell(0, 0, $result['nombre'], 0, 1, 'C');

$pdf->SetFont('Helvetica', 'B', 7);
$pdf->SetXY(10, 69.5);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 0, $result['rol'], 0, 1, 'C');

$pdf->AddPage();
$pdf->Image("qrs/cccc-02.png", $x = 0, $y = 0, $w = 54, $h = 85, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);

$pdf->writeHTMLCell($qr_size, $qr_size, 11, 27, '<img src="https://chart.googleapis.com/chart?cht=qr&chs=100x90&chl='.$qr_code.'&choe=UTF-8&chld='.$qr_error_correction.'|'.$qr_margin.'">', 0, 0, false, true, 'C');

$pdf->Output('Codigo.pdf', 'I');
?>
