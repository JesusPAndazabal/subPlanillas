<?php

session_start();

?>

<!-- Enlace a los estilos -->
<link href="dist/css/other/styleperfilUsuario.css" rel="stylesheet" >

<!-- Titulo del módulo -->
<div class="callout callout-success">
  <h2 class="text-center" > Modulo de Reportes <i class="fas fa-user ml-2"></i></h2>
</div>


<div class="card text-center">
  <div class="card-header">
      Impresion de Formatos
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <label for="">Numero de Documento</label>
            <input type="number" class="form-control" id="numeroDocPrint">
        </div>
        <div class="col-md-4">
            <label for="">Año Inicial</label>
            <input type="date" class="form-control" id="anioInicial">
        </div>
        <div class="col-md-4">
            <label for="">Año Final</label>
            <input type="date" class="form-control" id="anioFinal">
        </div>
    </div>
  </div>
  <div class="card-footer text-muted">
    Elija el formato a descargar
  </div>
</div>

<div class="row">
    <div class="col-md-6">
      <button type="button" class="btn btn-success" id="descargarFonavi" style="margin-left: 40%;">APORTACIONES AL FONAVI <i class="fas fa-file-excel"></i></button>
    </div>
    <div class="col-md-6">
      <button type="button" class="btn btn-success" id="descargarPreparacion" style="margin-left: 30%;">PREPARACIÓN DE CLASES <i class="fas fa-file-excel"></i></button>
    </div>
  </div>


<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/boletas.js"></script>
