<?php

session_start();

require_once '../models/Establecimiento.php';
require_once '../models/Serverside.php';

if(isset($_GET['op'])){

    if($_GET['op'] == 'listarEstablecimientos'){
        $data = $serverSide->get("vs_establecimientos", "idestablecimiento", array("idestablecimiento", "nombre"));
    } 
    
}

?>
