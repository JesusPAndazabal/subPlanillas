<?php

session_start();

require_once '../models/Cargos.php';
require_once '../models/Serverside.php';

if(isset($_GET['op'])){

    $cargo = new Cargos();

    if($_GET['op'] == 'listarCargos'){
        $data = $serverSide->get("vs_cargos", "idcargo", array("idcargo", "descripcion"));
    } 
    
}

?>
