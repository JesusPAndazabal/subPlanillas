<?php

session_start();

require_once '../models/Periodo.php';
require_once '../models/Serverside.php';

if(isset($_GET['op'])){

    $periodo = new Periodo();

    if($_GET['op'] == 'listarPeriodos'){
        $data = $serverSide->get("vs_periodos", "idperiodo", array("idperiodo", "tipo", "mes" , "anio" ,"fechaInicio", "fechaTermino"));
    } 
    
}




if (isset($_POST['op'])) {
    $periodo = new Periodo();

    if ($_POST['op'] == 'registrarPeriodo') {
        $datosEnviar = [
            "tipo"      => $_POST['tipo'],
            "mes"       => $_POST['mes'],
            "anio"      => $_POST['anio'],
            "numero"    => $_POST['numero'],
            "formaPago" => $_POST['formaPago']
        ];

        try {
            // Registrar el periodo y obtener el ID
            $periodo_id = $periodo->registrarPeriodos($datosEnviar);
            
            // Devolver el ID del periodo junto con un mensaje de éxito
            echo json_encode([
                "success" => true, 
                "message" => "Periodo registrado con éxito.", 
                "periodo_id" => $periodo_id
            ]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }


}
?>
