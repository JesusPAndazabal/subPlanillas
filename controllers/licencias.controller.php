<?php

require_once '../models/Serverside.php';
require_once '../models/Licencias.php';


if(isset($_GET['op'])){

    $licencia = new Licencia();

    if($_GET['op'] == 'listarLicencias'){
        $data = $serverSide->get("vs_licencias", "idlicencia", array("idlicencia", "clave", "fecha_vencimiento", "estado" , "fecharegistro", "comentario"));
    }

    if($_GET['op'] == 'obtenerLicencia'){
        $data = $licencia->obtenerLicencias(["idlicencia" => $_GET['idlicencia']]);

        if($data){
            echo json_encode($data);
        }
    }

    if($_GET['op'] == 'actualizarFecha'){

        $datosEnviar = [
            "idlicencia"        => $_GET["idlicencia"],
            "fecha_vencimiento"     => $_GET["fecha_vencimiento"],
            "estado"        => $_GET["estado"]
        ];

        $licencia->actualizarFecha($datosEnviar);
    }   

}




?>