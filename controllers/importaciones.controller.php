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

    if($_GET['op'] == 'generarExcelFonavi'){
        $numeroDoc = $_GET['numeroDoc'];
        $anioInicial = $_GET['anioInicial'];
        $anioFinal = $_GET['anioFinal'];

        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        
        // Estilos comunes
        $boldStyle = ['font' => ['bold' => true]];
        $centerAlign = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]];
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
        $sheet->setCellValue('A8', 'APELLIDOS Y NOMBRES:')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', 'CONISLLA PEÑA FLOR DE MARIA')->mergeCells('C8:K8');
        $sheet->setCellValue('A9', 'INSTITUCION EDUCATIVA:')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', 'Diversas Instituciones')->mergeCells('C9:K9');

        // Encabezado de la tabla (con bordes)
        $sheet->setCellValue('A11', 'Institución Educativa')->mergeCells('A11:B12');
        $sheet->setCellValue('C11', 'Servicios Prestados')->mergeCells('C11:F11');
        $sheet->setCellValue('C12', 'DESDE')->mergeCells('C12:D12');
        $sheet->setCellValue('E12', 'HASTA')->mergeCells('E12:F12');
        $sheet->setCellValue('G11', 'REMUNERACION BRUTA')->mergeCells('G11:H12');
        $sheet->setCellValue('I11', 'DESCUENTO FONAVI')->mergeCells('I11:J12');

        // Rellenar filas vacías (con bordes)
        for ($i = 13; $i <= 20; $i++) {
            $sheet->setCellValue("A$i", '-')->mergeCells("A$i:B$i");
            $sheet->setCellValue("C$i", '-');
            $sheet->setCellValue("E$i", '-');
            $sheet->setCellValue("G$i", '-')->mergeCells("G$i:H$i");
            $sheet->setCellValue("I$i", '-')->mergeCells("I$i:J$i");
        }

        // Aplicar estilos
        $sheet->getStyle('A1:K4')->applyFromArray($centerAlign + $boldStyle); // Títulos principales
        $sheet->getStyle('A6:K9')->applyFromArray($boldStyle); // Datos del trabajador
        $sheet->getStyle('A11:K20')->applyFromArray($borderStyle); // Solo la tabla tiene bordes

        // Ajustar ancho de columnas
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'Formato_Estatico_SinBordesEnTitulos.xlsx';

        // Configuración para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;

    }

 
}

?>