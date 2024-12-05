<?php

session_start();

if ($_SESSION['acceso'] == false){

  
  header('Location:index.php');
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QuerySheet</title>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css2?family=Lora&family=Maven+Pro&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
<!--   <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
  <link rel="stylesheet" href="dist/css/user-account.css">
  <link rel="stylesheet" href="dist/css/switch-dark-mode.css">
  <link rel="stylesheet" href="dist/css/themes.css">
  <link rel="stylesheet" href="dist/css/preloader.css">
  <link rel="stylesheet" href="dist/css/loader.css">
<!--   <link rel="stylesheet" href="dist/css/datatables-estilos.css"> -->

    <!-- Sweetalert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">


  
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

<div class="preloader flex-column justify-content-center align-items-center">
<div class="container">
    <div class="container-loader">
      <div class="loader"></div>
      <span class="text-loader" id="text-message-loader">Cargando...</span>
      </div>
    </div>
  </div>
  </div>

<!-- <div class="preloader flex-column justify-content-center align-items-center">
<div class="contenedor">

  <div class="loader">

        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
    </div>
  </div>
  </div>
</div> -->
  <!-- Preloader -->
<!--  <div class="preloader flex-column justify-content-center align-items-center">
    <div class="content-xbox">
      <img src="dist/img/logo-ugel-chincha1.png" alt="" id="loader-img">
      <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>
  </div>   -->
  
<!--   <div class="contenedor">
    <div class="loader">
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
    </div>
  </div>
 -->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <!-- Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      <!-- Switch -->
      <li class="nav-item item-switch-darkmode ml-2">
        <div class="theme-switch-wrapper nav-link dropdown-toggle">
          <label class="theme-switch" for="checkbox-theme">
            <input type="checkbox" id="checkbox-theme" />
            <span class="slider round">
              <i class="fa fa-solid fa-sun"></i>
              <i class="fa fa-solid fa-moon"></i>
            </span>
          </label>
        </div>
      </li> 



      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


 
      <!-- User Account: style can be found in dropdown.less -->
      <li class="nav-item dropdown user user-menu">
        
        <a a href="#" class="nav-link text-overflow" data-toggle="dropdown" >
          <span class="hidden-xs "><?= $_SESSION['nombresuser'] , " " , $_SESSION['apellidosuser']; ?></span>
        </a>

          <div class="dropdown-menu">
            <a class="dropdown-item" href='main.php?view=perfilUsuario-vista' data-idusuario = "<?php echo $_SESSION['idusuario'] ?>" id="perfil">Mi Perfil<i class="fas fa-user ml-2"></i></a>
            <a class="dropdown-item" href="controllers/usuario.controller.php?op=cerrar-sesion">Cerrar sesión<i class="fas fa-power-off ml-2"></i></a>
          </div>

      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" >
          
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notificaciones</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Tienes 4 Boletas observadas
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
    
        </div>
      </li>

      <!-- Config -->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <!-- <img src="dist/img/logo-editado-5.png" alt="" class="logo"> -->

  
      <h4 class="brand-text font-weight-bold text-center mt-4" style="color:white"><i class="fas fa-clipboard-list"></i> QuerySheet </h4>
    
    </a>

    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" >
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color:white"><?= $_SESSION['nombresuser'] , " " , $_SESSION['apellidosuser'];  ?></a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar text-sm flex-column nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
          <div class="card" style="width: 14.5rem;">
            <ul class="list-group list-group-flush">
              <li class="list-group-item" style="background-color: #17a2b8;"><h5 class="text-center text-white mb-2 text-bold"><?= $_SESSION['nivelacceso'];?><i class="fas fa-user-lock ml-2"></i></h5></li>
            </ul>
          </div>
        <!-- <h5 class="text-center text-white mb-5 text-bold"><?= $_SESSION['nivelacceso'];?><i class="fas fa-user-lock"></i></h5> -->
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


               <li class='nav-item'>
                <a href='main.php' class='nav-link' style='color:white'>
                  <i class='nav-icon fas fa-home' ></i>
                  <p>
                    Inicio
                  </p>
                </a>
              </li>

              <li class='nav-header'>PLANILLAS</li>

              <?php
                  if($_SESSION['nivelacceso'] == "Administrador" ){
                      echo "
                        <li class='nav-item'>
                          <a href='main.php?view=subirArchivo-vista' class='nav-link btn-profile-index' style='color:white'>
                          <i class='nav-icon fas fa-file-archive'></i>
                            <p>
                              IMPORTAR BOLETA
                            </p>
                          </a>                  
                        </li>
                      ";
                  }
                ?>  

              

              <?php
                  if($_SESSION['nivelacceso'] == "Consultas" ){
                      echo "
                        <li class='nav-item'>
                          <a href='main.php?view=consulta-vista  ' class='nav-link btn-profile-index' style='color:white'>
                          <i class='nav-icon fas fa-file-archive'></i>
                            <p>
                              Consultar Boletas
                            </p>
                          </a>                  
                        </li>
                      ";
                  }
              ?> 

              <?php
                  if($_SESSION['nivelacceso'] == "Administrador" ){
                      echo "
                        <li class='nav-header'>MENU</li>
              
              <li class='nav-item'>
                <a href='main.php?view=personas-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      PERSONAL
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=periodos-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      PERIODOS
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=establecimientos-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      ESTABLECIMIENTOS
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=regimenesLaborales-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      REGIMENES LABO.
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=cargos-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      CARGOS
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=campos-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      CAMPOS
                  </p>
                </a>                  
              </li>

              <li class='nav-item'>
                <a href='main.php?view=conceptos-vista' class='nav-link btn-profile-index' style='color:white'>
                <i class='nav-icon fas fa-file-archive'></i>
                  <p>
                      CONCEPTOS
                  </p>
                </a>                  
              </li>
                      ";
                  }
                ?>  

              

              <?php
                if($_SESSION['nivelacceso'] == "Administrador" ){
                    echo "
                      <li class='nav-header'>ACCESOS</li>
                      <li class='nav-item'>
                        <a href='main.php?view=usuarios-vsta' class='nav-link btn-profile-index' style='color:white'>
                        <i class='nav-icon fas fa-file-archive'></i>
                          <p>
                            USUARIOS
                          </p>
                        </a>                  
                      </li>
                    ";
                }
              ?>  
          
                
              
               
    
              
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper text-sm" id="content-body">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
   
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="content-data">
        <!-- Aqui se cargan los datos dinamicos -->        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Subir al inicio -->
    <a id="back-to-top" href="#content-body" class="btn btn-dark back-to-top d-none" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="overflow: hidden;">
    <!-- Control sidebar content goes here -->
    <div class="p-3 control-sidebar-content text-sm" style="height: fit-content;">
      <h5>Configuración</h5>
      <hr class="mb-2"/>

      <h6>Barra lateral izquierdo</h6>

      <div class="mb-1">
        <input type="checkbox" class="mr-1" checked id="cbox-sidebar-mini">
        <span>Pequeño</span>
      </div>
      <div class="mb-1">
        <input type="checkbox" class="mr-1" id="cbox-sidebar-flat-style">
        <span>Estilo flat</span>
      </div>
      <div class="mb-4">
        <input type="checkbox" class="mr-1" id="cbox-sidebar-disable-focus">
        <span>Deshabilitar autoexpansión</span>
      </div>

      <h6>Reducir el tamaño del texto</h6>

      <div class="mb-1">
        <input type="checkbox" class="mr-1" checked id="cbox-small-text-content-wrapper">
        <span>Contenido</span>
      </div>
      <div class="mb-1">
        <input type="checkbox" class="mr-1" id="cbox-small-text-sidebar" checked>
        <span>Barra lateral (Izq, Der)</span>
      </div>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <strong>Copyright &copy; 2022 <a href="">QuerySheet</a>.</strong>
    Todos los derechos reservados JPA.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>  -->
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- Configuracion de alertas personalizadas -->
<script src="./dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="./dist/js/dataTableConfig.js"></script>


<!-- Cargar pagina incrustada -->
<script src="./dist/js/loadweb.js"></script>

<!-- plugins - Datatable -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->  <!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="dist/js/DataTables/DataTables-1.11.5/css/dataTables.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="dist/js/DataTables/Buttons-2.2.2/css/buttons.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="dist/js/DataTables/SearchPanes-2.0.0/css/searchPanes.bootstrap4.css"/>

<!-- <script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script> -->
 
<script type="text/javascript" src="dist/js/DataTables/JSZip-2.5.0/jszip.js"></script>
<script type="text/javascript" src="dist/js/DataTables/pdfmake-0.1.36/pdfmake.js"></script>
<script type="text/javascript" src="dist/js/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script> 
<script type="text/javascript" src="dist/js/DataTables/DataTables-1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="dist/js/DataTables/DataTables-1.11.5/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="dist/js/DataTables/Buttons-2.2.2/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="dist/js/DataTables/Buttons-2.2.2/js/buttons.bootstrap4.js"></script>
<script type="text/javascript" src="dist/js/DataTables/Buttons-2.2.2/js/buttons.html5.js"></script>
<script type="text/javascript" src="dist/js/DataTables/Buttons-2.2.2/js/buttons.print.js"></script>

<script src="https://cdn.datatables.net/plug-ins/1.11.3/api/sum().js"></script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="dist/js/sweet-alert-2.js"></script>
  <!-- /. plugins - Datatable -->

  <!-- Plugin para el autcompletado de los Empleados - Instituciones y campos -->
  <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<!-- Config theme -->
<script src="./dist/js/config.js"></script>


<script>
  $(document).ready(function (){
    var view = getParam("view");

    if (view != false)
      $("#content-data").load(`views/${view}.php`);
    else
      $("#content-data").load(`views/inicio.php`);
  });

      localStorage.setItem("usuarioBoleta" , <?php echo $_SESSION['idusuario'];?>);
      localStorage.setItem("nomuserBoleta", "<?php echo htmlspecialchars($_SESSION['nomuser']); ?>");

 
</script>
</body>
</html>
