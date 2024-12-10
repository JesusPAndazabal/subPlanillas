<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php'; // Ruta corregida
require_once '../models/Boletas.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if(isset($_GET['op'])){

    $boleta = new Boleta();

    if ($_GET['op'] == 'generarExcelFonavi') {
        $numeroDoc = $_GET['numeroDoc'];
        $anioInicial = $_GET['anioInicial'];
        $anioFinal = $_GET['anioFinal'];
    
        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Obtener datos desde la base de datos
        $data = [
            'numeroDoc'   => $numeroDoc,
            'fechaInicio' => $anioInicial . '-01-01',
            'fechaFin'    => $anioFinal . '-12-31'
        ];
    
        $resultados = $boleta->obtenerFormatos($data); // Aquí llamamos al procedimiento almacenado
    
        // Estilos comunes
        $boldStyle = ['font' => ['bold' => true]];
        $rightAlign = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER]];
        $borderStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => '000000']],
            ],
        ];
    
        // Títulos principales (sin bordes)
        $sheet->setCellValue('A1', 'EL AREA DE GESTION ADMINISTRATIVA, EQUIPO DE TESORERIA Y REMUNERACIONES')
            ->mergeCells('A1:K1');
        $sheet->setCellValue('A2', 'DE LA UNIDAD DE GESTION EDUCATIVA LOCAL HUAYTARA, SUSCRIBE LA PRESENTE:')
            ->mergeCells('A2:K2');
        $sheet->setCellValue('A4', 'CONSTANCIA DE PAGOS Y REMUNERACIONES')->mergeCells('A4:K4');
    
        // Encabezado de expediente y asunto (sin bordes)
        $sheet->setCellValue('A6', 'EXPEDIENTE N°:')->mergeCells('A6:B6');
        $sheet->setCellValue('C6', '000001')->mergeCells('C6:E6');
        $sheet->setCellValue('F6', 'ASUNTO:')->mergeCells('F6:G6');
        $sheet->setCellValue('H6', 'Motivos Particulares')->mergeCells('H6:K6');
    
        // Encabezado de datos del trabajador (sin bordes)
        $apellidosYnombres = $resultados[0]['apellidos'] . ' ' . $resultados[0]['nombres']; // Concatenar apellidos y nombres
        $sheet->setCellValue('A8', 'APELLIDOS Y NOMBRES:')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', $apellidosYnombres)->mergeCells('C8:K8');
        $sheet->setCellValue('A9', 'INSTITUCION EDUCATIVA:')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', 'Diversas Instituciones')->mergeCells('C9:K9');
    
        // Encabezado de la tabla (con bordes)
        $sheet->setCellValue('A11', 'Institución Educativa')->mergeCells('A11:B12');
        $sheet->setCellValue('C11', 'Servicios Prestados')->mergeCells('C11:H11');
        $sheet->setCellValue('C12', 'DESDE')->mergeCells('C12:E12');
        $sheet->setCellValue('F12', 'HASTA')->mergeCells('F12:H12');
        $sheet->setCellValue('C13', 'D')->setCellValue('D13', 'M')->setCellValue('E13', 'A');
        $sheet->setCellValue('F13', 'D')->setCellValue('G13', 'M')->setCellValue('H13', 'A');
        $sheet->setCellValue('I11', 'REMUNERACION BRUTA')->mergeCells('I11:J13');
        $sheet->setCellValue('K11', 'DESCUENTO FONAVI')->mergeCells('K11:L13');
    
        // Recorrer los resultados de la base de datos para llenar las filas de la tabla
        $row = 14; // Comenzamos en la fila 14, que es donde empiezan los datos
        
        foreach ($resultados as $resultado) {
            $institucionEducativa = $resultado['nombre']; // Obtener el nombre de la institución
    
            // Colocar el nombre de la institución en la columna "A"
            $sheet->setCellValue("A$row", $institucionEducativa)->mergeCells("A$row:B$row");

            // Extraer las fechas de fechaInicio y terminoPeriodo
            $fechaInicio = $resultado['fechaInicio']; // Por ejemplo, '2004-12-01'
            $terminoPeriodo = $resultado['terminoPeriodo']; // Por ejemplo, '2004-12-31'
    
            // Separar las fechas en Día, Mes y Año
            $fechaInicioArr = explode('-', $fechaInicio); // '2004-12-01' -> ['2004', '12', '01']
            $terminoPeriodoArr = explode('-', $terminoPeriodo); // '2004-12-31' -> ['2004', '12', '31']
    
            // Día, Mes y Año de "DESDE"
            $diaInicio = (int)$fechaInicioArr[2]; // Convertir a número para evitar formato de texto
            $mesInicio = (int)$fechaInicioArr[1]; // Convertir a número
            $anioInicio = (int)$fechaInicioArr[0]; // Convertir a número
    
            // Día, Mes y Año de "HASTA"
            $diaTermino = (int)$terminoPeriodoArr[2]; // Convertir a número
            $mesTermino = (int)$terminoPeriodoArr[1]; // Convertir a número
            $anioTermino = (int)$terminoPeriodoArr[0]; // Convertir a número
    
            // Colocar las fechas en las celdas correspondientes (DESDE y HASTA)
            $sheet->setCellValue("C$row", $diaInicio);
            $sheet->setCellValue("D$row", $mesInicio);
            $sheet->setCellValue("E$row", $anioInicio);
            $sheet->setCellValue("F$row", $diaTermino);
            $sheet->setCellValue("G$row", $mesTermino);
            $sheet->setCellValue("H$row", $anioTermino);
    
            // Aplicar alineación (a la derecha)
            $sheet->getStyle("C$row")->applyFromArray($rightAlign);
            $sheet->getStyle("D$row")->applyFromArray($rightAlign);
            $sheet->getStyle("E$row")->applyFromArray($rightAlign);
            $sheet->getStyle("F$row")->applyFromArray($rightAlign);
            $sheet->getStyle("G$row")->applyFromArray($rightAlign);
            $sheet->getStyle("H$row")->applyFromArray($rightAlign);

            // Aplicar bordes a las celdas de las instituciones y fechas
            $sheet->getStyle("A$row:B$row")->applyFromArray($borderStyle);
            $sheet->getStyle("C$row:H$row")->applyFromArray($borderStyle);
    
            // Incrementar la fila para la siguiente entrada
            $row++;
        }
    
        // Aplicar estilos
        $sheet->getStyle('A1:K4')->applyFromArray($rightAlign + $boldStyle); // Títulos principales
        $sheet->getStyle('A6:K9')->applyFromArray($boldStyle); // Datos del trabajador
        $sheet->getStyle('A11:L20')->applyFromArray($borderStyle); // Solo la tabla tiene bordes
        $sheet->getStyle('C13:H13')->applyFromArray($rightAlign + $boldStyle); // Etiquetas de D, M, A
    
        // Alineación para las celdas de "DESDE" y "HASTA" (día, mes, año)
        $sheet->getStyle('C12:E12')->applyFromArray($rightAlign); // "DESDE"
        $sheet->getStyle('F12:H12')->applyFromArray($rightAlign); // "HASTA"
        $sheet->getStyle('C13:E13')->applyFromArray($rightAlign); // Día, Mes, Año para "DESDE"
        $sheet->getStyle('F13:H13')->applyFromArray($rightAlign); // Día, Mes, Año para "HASTA"

        // Ajustamos el ancho de la columna A basándonos en el texto más largo
        $sheet->getColumnDimension('A')->setWidth(65); // Agrega un margen de 5 a la longitud máxima
         
         // Aplicamos bordes a la tabla completa
         $sheet->getStyle('A11:L' . $row)->applyFromArray($borderStyle);

        // Ajustar ancho de columnas
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    
        // Guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'Formato_Estatico_ConEtiquetasDMA.xlsx';
    
        // Configuración para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }
    
    
    
    
    

 
}

?>