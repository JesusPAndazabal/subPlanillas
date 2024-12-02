<?php


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


try{

  $datosObtenidos = $boleta->obtenerBoletaR(['idboleta' => $idboleta]);
  $datosIngresos = $concepto->obtenerIngresos(['idboleta' => $idboleta]);
  $datosIngresosCol1 = $concepto->obtenerIngresosCol1(['idboleta' => $idboleta]);
  $datosIngresosCol2 = $concepto->obtenerIngresosCol2(['idboleta' => $idboleta]);
  $datosEgresos = $concepto->obtenerEgresos(['idboleta' => $idboleta]);
  $sumarIngresos = $concepto->sumarIngresos(['idboleta' => $idboleta]);
  $sumarEgresos = $concepto->sumarEgresos(['idboleta' => $idboleta]);
  $conceptosObtenidos = $concepto->obtenerConcepto(['idboleta' => $idboleta]);


  ob_start();

  

  //IMPORTANTE: Debemos inicializar data
  $data = "";

  //Cargar los estilos
  include './informeConstancia/estilos.html';

  //Páginas:
    include './informeConstancia/page-1.php';
    include './informeConstancia/page-2.php';
/*     include './informe/page-3.php';  */

  //Otras páginas:
  $data .= ob_get_clean();

  //Creando espacio
  $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'utf-8', array(20,10,30,15));
  $html2pdf->setDefaultFont('Arial');
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->writeHTML($data);

  $html2pdf->output('Constancias.pdf');

}
catch(Html2PdfException $e){
  $html2pdf->clean();
  $formatter = new ExceptionFormatter($e);
  echo $formatter->getHtmlMessage();
}

?>