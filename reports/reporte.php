<?php
// Inicia el buffer de salida
ob_start();

require_once '../vendor/autoload.php';
require_once '../models/Boletas.php';
require_once '../models/Conceptos.php';

$boleta = new Boleta();
$concepto = new Concepto();

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if(isset($_GET["idboleta"])){
  $idboleta = $_GET["idboleta"];
}


try {
  $datosObtenidos = $boleta->obtenerBoleta(['idboleta' => $idboleta]);

  $conceptosObtenidos = $concepto->obtenerConcepto(['idboleta' => $idboleta]);

    // IMPORTANTE: Debemos inicializar data
    $data = "";

    // Cargar los estilos
    include './informe/estilos.html';

    // Páginas:
    include './informe/page-1.php';

    // Otras páginas:
    $data .= ob_get_clean(); // Limpia el buffer de salida y guarda el contenido

    // Creando espacio
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'utf-8', array(20, 15, 20, 15));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($data);

    // Salida del PDF
    $html2pdf->output('Reporte-Boleta.pdf');

    // Asegúrate de detener la ejecución aquí para evitar más salida
    exit;

} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>
