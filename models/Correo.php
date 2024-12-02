<?php

use PHPMailer\PHPMailer\PHPMailer;  // Core (Nucleo)
use PHPMailer\PHPMailer\Exception;  // Contralador de expecepiones(Errores)
use PHPMailer\PHPMailer\SMTP;       // Administra protocolo envio correo

require '../libs/PHPMailer/src/Exception.php';
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';

class Mailer{
  // Atributo
  private $mail;

  // Constructor 
  public function __CONSTRUCT(){
      //Instancia 
      $this->mail = new PHPMailer(true);
  }

  // Enviar correo
  function sendMail($email , $numerodni , $usuario){ 
    try{
  
      //Server settings
      $this->mail->SMTPDebug = 0;                                       //Enable verbose debug output
      $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'querysheet1.0@gmail.com';              //SMTP username
      $this->mail->Password   = 'jbwjmrcuaiiqgkeg';                     //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
      //Recipients
      $this->mail->setFrom('querysheet1.0@gmail.com', 'QuerySheet');
    
      // Copias del correo
      $this->mail->addAddress($email);                                   //Destinatarios
    
      //Content
      $this->mail->isHTML(true);                            
      $this->mail->Subject = "Entrega de credenciales";
      $this->mail->Body    = "Hola!". ' ' . $usuario . '<br>' . 
                            "Bienvenido a QuerySheet, a continuación se le envian sus credenciales para el inicio de sesión : " . '<br>' . 
                             '<strong>'."Usuario:".'</strong>' . ' ' . $numerodni . '<br>' . 
                             '<strong>'."Contraseña:</strong>  querysheet22";
    
      $this->mail->CharSet = 'UTF-8';
      $this->mail->send();
      echo "Correo Enviado";
    }
    catch (Exception $e){
      echo "No se ha podido enviar el correo electrónico: {$this->mail->ErrorInfo}";
    }
  }


  
}

/* $mailer = new Mailer();
$mailer->sendMail(); */




?>