<?php

session_start();

if(isset($_SESSION['acceso'])){
	if($_SESSION['acceso'] == true){
		header('Location:main.php');
	}
	
}
else{
	$_SESSION['acceso'] = false;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - QuerySheet</title>

    <link href="dist/css/other/stylelogin.css" rel="stylesheet" >

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <!-- Sweetalert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="dist/img/LOGO UGEL HUAYTARA.jpg" style="width: 400px;" alt="">
      </div>
      <div class="back">
        <img class="backImg" src="dist/img/ugel.jpg" alt="">
        <div class="text">
         
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Iniciar Sesión</div>
          <form>
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Nombre de usuario" id="nombreusuario" autocomplete="off">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Contraseña" id="claveacceso">
              </div>
              <!-- <div class="text"><a>Olvidó su contraseña?</a></div> -->
              <div class="button input-box">
                <input type="button" value="Acceder" id="acceder">
              </div>
              
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Registrar</div>
        <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Apellidos" id ="apellidosuser" autocomplete = "off">
              </div>
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Nombres" id="nombresuser" autocomplete = "off">
              </div>
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Nombre de usuario" id="nomuser" autocomplete = "off">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Contraseña" id="claveacceso1" autocomplete = "off">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Repetir contraseña" id="claveacceso2" autocomplete = "off">
              </div>
              <div class="button input-box" id="registrarUsuario">
                <input type="submit" value="Registrarse" >
              </div>
              <div class="text sign-up-text">¿Ya tiene un cuenta? <label for="flip">Iniciar Sesión</label></div>
            </div>
        </form>
    </div>
    </div>
    </div>
  </div>

    <!-- Configuracion de alertas personalizadas -->
    <script src="dist/js/configAlerts.js"></script> 

    <!-- Datatable -->
    <script src="dist/js/dataTableConfig.js"></script>

    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="dist/js/sweet-alert-2.js"></script>
    
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="dist/js/other/adminUsuarios.js"></script>
    

</body>
</html>