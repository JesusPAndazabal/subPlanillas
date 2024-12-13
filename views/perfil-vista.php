<?php

session_start();

?>

<!-- Enlace a los estilos -->
<link href="dist/css/other/styleperfilUsuario.css" rel="stylesheet" >

<!-- Titulo del módulo -->
<div class="callout callout-success">
  <h2 class="text-center" > Módulo de Perfil de Usuario <i class="fas fa-user ml-2"></i></h2>
</div>

<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-info" id="editar">Editar Información<i class="fas fa-user-edit ml-2"></i></button>
  <button type="button" class="btn btn-success" id="guardarPerfil">Guardar cambios<i class="fas fa-save ml-2"></i></button>
</div>

<div class="card">
  <h5 class="card-header">Configuración de cuenta<i class="fas fa-user-cog ml-2"></i></h5>
  <div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <label for="">Nombre de Usuario :</label>
            <input type="text" class="form-control" id="nombresusuario">
        </div>
        <div class="col-md-4">
            <label for="">Dirección de correo :</label>
            <input type="text" class="form-control" id="correoperfil">
        </div>
        <div class="col-md-4">
            <label for="">Nivel de Acceso :</label>
            <input type="text" class="form-control" id="nivelaccesoperfil">
        </div>
    </div><br>
          <label for="">Numero de Contacto - telefono</label>
          <input type="text" class="form-control" id="telefonoperfil">

  </div><!-- Fin del card-body -->
</div><!-- Fin del 2 card -->

<div class="card">
  <h5 class="card-header">Seguridad<i class="fas fa-lock ml-2"></i></h5>
  <div class="card-body">
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn  btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Cambiar contraseña
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <form action="" id="formularioClave">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                      <label for="">Contraseña anterior</label>
                      <input type="password" id="claveaccesoAntigua" class="form-control">
                  </div>
                  <div class="col-md-4">
                      <label for="">Contraseña Nueva</label>
                      <input type="password" id="claveaccesoNueva1" class="form-control">
                  </div>
                  <div class="col-md-4">
                      <label for="">Repita la Contraseña Nueva</label>
                      <input type="password" id="claveaccesoNueva2" class="form-control">
                  </div>
                </div>
              </div>
            </form>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Mostrar contraseñas</label>
            </div>
          </div>
          
          <div class="card-footer">

            <button type="button" class="btn btn-success" id="actualizarClave">Actualizar<i class="fas fa-save ml-2"></i></button>
            <button type="button" class="btn btn-secondary"  id="cancelarClave">Cancelar<i class="fas fa-window-close ml-2"></i></button>   

          </div>
        </div>
      </div>
    </div>
  </div><!-- Fin del card-body -->
</div><!-- Fin del 3 card -->





<script src="dist/js/other/adminUsuarios.js"></script>


