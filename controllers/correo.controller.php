<?php

require_once '../models/Correo.php';

$mailer = new Mailer();

if(isset($_GET['op'])){

    if($_GET['op'] == 'enviarCorreo'){
        $mailer->sendMail($_GET['email'] , $_GET['numerodni'] , $_GET['usuario']);
    }

}





?>