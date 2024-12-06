<?php

session_start();

require_once '../models/Regimen.php';
require_once '../models/Serverside.php';

if(isset($_GET['op'])){

    if($_GET['op'] == 'listarRegimenes'){
        $data = $serverSide->get("vs_regimenLaborales", "idregimenLaboral", array("idregimenLaboral", "descripcion"));
    } 
    
}

?>
