<?php

session_start();

require_once '../models/Serverside.php';
require_once '../models/Boletas.php';

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
                        <td>{$row['regimen']}</td>
                        <td>{$row['tipo']}</td>
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




    if ($_GET['op'] == 'buscardetalleDni') {
        $params = [
            'numeroDoc' => $_GET['numeroDoc'] ?? null
        ];

        $data = $boleta->buscarplanillaDni($params);
        listarBoletasConsulta($data);
    }

}

?>