<?php

session_start();



require_once '../models/Serverside.php';
require_once '../models/Boletas.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_GET['op'])){

    $boleta = new Boleta();

    function listarBoletasConsulta($data){
        if(count($data) <= 0){
            echo "<td>No hay datos en esta tabla</td>";
        }else{
            
            foreach($data as $row){
                echo "
                    <tr>
                        <td>{$row['idboleta']}</td>
                        <td>{$row['nombres']}</td>
                        <td>{$row['apellidos']}</td>
                        <td>{$row['numeroDoc']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['tipoServi']}</td>
                        <td>{$row['mes']}</td>
                        <td>{$row['anio']}</td>
                        <td class='text-center reporte' data-idboleta='{$row['idboleta']}'>  
                            <button type='button'><i class='fas fa-print'></i></button>
                        </td>
                    </tr>
                ";
            }
        }
    }

/*     if($_GET['op'] == 'listarConsultasAdmin'){
        $data = $serverSide->get("vs_boletasConsultasLivi", "idboleta", array("idboleta", "nombres", "apellidos", "numeroDoc" , "descripcion", "nombre", "tipoServi", "mes", "anio"));
    }  */

    // Opción para listar las consultas administrativas
    if ($_GET['op'] == 'listarConsultasAdmin') {
    // Recoger los parámetros de los filtros desde la URL (si están presentes)
        $numeroDoc = isset($_GET['numeroDoc']) ? $_GET['numeroDoc'] : null;
        $anio = isset($_GET['anio']) ? $_GET['anio'] : null;
        $mes = isset($_GET['mes']) ? $_GET['mes'] : null;

        // Crear el array de parámetros a enviar a la función de búsqueda
        $params = [
            'numeroDoc' => $numeroDoc,
            'anio' => $anio,
            'mes' => $mes
        ];

        // Llamar al modelo para ejecutar el procedimiento almacenado
        $data = $boleta->buscarBoleta($params);

        // Listar los resultados
        listarBoletasConsulta($data);
    }

    if ($_GET['op'] == 'buscardetalleDni') {
        $params = [
            'numeroDoc' => $_GET['numeroDoc'] ?? null
        ];

        $data = $boleta->buscarplanillaDni($params);
        listarBoletasConsulta($data);
    }

 
}

?>