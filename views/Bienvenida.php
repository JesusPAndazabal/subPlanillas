<?php

session_start();

$usuario = $_SESSION['nombresuser'];
$nivelAcceso = $_SESSION['nivelacceso']; 


?>



<link href="dist/css/other/styleInicio.css" rel="stylesheet" >

<div class='callout callout-success'>
    <h3 class='text-center'>Módulo de Inicio<i class='fas fa-chart-bar ml-2'></i></h3>
    </div>

    <div class='jumbotron jumbotron-fluid' style='background:#E5E8E8;'>
    
      <div class='contenedor-portada'>
      
        <div class='row'>
          <div class='col-md-6 col-lg-6 col-sm-12'>
          <h1 class='display-3  ml-5'>Bienvenido</h1>
          <div class='hero'>
          <ul class='dynamic-txts'>
            <li><span class="text-bold">a QuerySheet</span></li>
            <li><span class="text-bold"><?php echo $usuario ?></span></li>
            <li><span class="text-bold">a QuerySheet</span></li>
            <li><span class="text-bold"><?php echo $usuario ?></span></li>
          </ul>
        </div>
          <p class='lead ml-5'>Aplicativo Web donde podrás gestionar las boletas de pago historicas de Profesores Activos y Pensionistas.</p>
          </div>
          <div class='col-md-6'>
          <img  class = 'ml-5' src='dist/img/logo-inicio.png' alt='querySheetLogo' style='width:60%;'>
          </div>
        </div>
        
        
      </div>
    </div>

  <div class='row'>
    <div class='col-lg-4 col-6'>
      <!-- small box -->
      <div class='small-box bg-info'>
        <div class='inner'>
          <h4>Registrar Boletas</h4>

          <p>Registro de Boletas , háberes y descuentos</p>
        </div>
        <div class='icon'>
          <i class='fas fa-table'></i>
        </div>
        <a href='main.php?view=registrarboletas-vista' class='small-box-footer'>Ir al Mòdulo<i class='fas fa-arrow-circle-right ml-2'></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class='col-lg-4 col-6'>
      <!-- small box -->
      <div class='small-box bg-success'>
        <div class='inner'>
          <h4>Consulta de Boletas </h4>

          <p>Busqueda y gestión de boletas registradas</p>
        </div>
        <div class='icon'>
          <i class='fas fa-search-plus'></i>
        </div>
        <a href='main.php?view=consultaboletas-vista' class='small-box-footer'>Ir al Módulo<i class='fas fa-arrow-circle-right ml-2'></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class='col-lg-4 col-6'>
      <!-- small box -->
      <?php
        if($nivelAcceso == "Administrador"){
            echo "
            <div class='small-box bg-warning'>
                <div class='inner'>
                <h4>Boletas por Revisar</h4>
        
                <p>Revisión de las boletas registradas</p>
                </div>
                <div class='icon'>
                <i class='fas fa-eye'></i>
                </div>
                <a href='main.php?view=revisionBoletas-vista' class='small-box-footer'>Ir al Módulo<i class='fas fa-arrow-circle-right ml-2'></i></a>
            </div>
            ";
        }else{
            echo "
                <div class='small-box bg-warning'>
                <div class='inner'>
                <h4>Boletas Observadas</h4>
        
                <p>Gestiòn de la boletas por corregir</p>
                </div>
                <div class='icon'>
                <i class='fas fa-eye'></i>
                </div>
                <a href='main.php?view=revisionBoletasEmpleado-vista' class='small-box-footer'>Ir al Módulo<i class='fas fa-arrow-circle-right ml-2'></i></a>
            </div>
            ";
        }
      ?>

    </div>
  </div>

  <div class='row'>
  <div class='col-lg-4 col-6'>
    
  </div>
  <!-- ./col -->
  <div class='col-lg-4 col-6'>
  <div class='small-box bg-primary'>
  <div class='inner'>
    <h4>Mi perfil</h4>

    <p>Configurar datos personales y de cuenta</p>
  </div>
  <div class='icon'>
    <i class='fas fa-id-card-alt'></i>
  </div>
  <a href='main.php?view=perfilUsuario-vista' class='small-box-footer'>Ir al Módulo<i class='fas fa-arrow-circle-right ml-2'></i></a>
</div>
  </div>
  <!-- ./col -->
  <div class='col-lg-4 col-6'>
    
  </div>

  

  
 
</div>