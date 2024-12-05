<!-- <link href="dist/css/other/styleadminUsuarios.css" rel="stylesheet" > -->

<div class="callout callout-success">
  <h4 class="text-center">Módulo de Administración de Usuarios <i class="fas fa-user ml-2"></i></h4>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg ">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="staticBackdropLabel">Registrar nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-3">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalbuscarEmpleado">
                Cargar Persona
              </button>
            </div>
          </div>
            <div class="row">
              <div class="col-md-6">
                <label for="">Username del Usuario :</label>
                <input type="text" class="form-control" id ="nomuser" autocomplete = "off">
              </div>
              <div class="col-md-6">
                <label for="">Direcciòn de correo :</label>
                <input type="email"  class="form-control" id="correo" autocomplete = "off">
                <!-- <label for="">Nombre de Usuario :</label>
                <input type="text"  class="form-control" id="nomuser" autocomplete = "off"> -->
              </div>
      
            </div><br>
          <div class="row">
            <div class="col-md-6">
              <label for="nivelacceso">Tipo de usuario:</label>
                <select class="custom-select" id="nivelacceso">
                  <option value="A">Administrador</option>
                  <option value="C" selected>Usuario - Consulta</option>
                </select>
            </div>
            <div class="col-md-6">
              <label for="">Numero de Telefono - Celular :</label>
              <input type="text"  class="form-control" id="telefono" placeholder = "Opcional" maxlength = "11" autocomplete = "off">  
              
            </div>
          </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="registrarUsuario" >Registrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para buscar empleado -->
 <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="modalbuscarEmpleado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Persona</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label for="nivelacceso">Ingrese el Dni de la Persona:</label>
          </div>
          <div class="col-md-6">
            <input type="text"  class="form-control" id="dniEmpleadoBuscar" autocomplete = "off">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnCargarEmpleado">Cargar Datos</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de carga para el correo -->
<div class="modal" tabindex="-1" id="modal-cargaCorreo"  data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <h6><strong>Enviando credenciales al Correo , espere porfavor...</strong></h6>
          <div class="spinner-border ml-auto text-success" role="status" aria-hidden="true"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <!-- Button trigger modal -->
   
    <div class="card card-success">
        <div class="card-header ui-sortable-handle">
          <h3 class="card-title text-uppercase">FILTRAR POR</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-4">
          <div class="row">
            <div class="col-md-12 mb-1">
              <div class="form-group">
                <label for="typeuser">Tipo de usuario</label>
                <select class="custom-select" id="typeuser">
                  <option value="">Todos</option>
                  <option value="A">Administradores</option>
                  <option value="C">Usuario - Consulta</option>
                </select>
              </div>
            </div>
          </div><!-- Fin del 1 row -->
          <div class="row">
            <div class="col-md-10">
                  <input type="text" class="form-control" id="input-search" maxlength="20" autocomplete="off" placeholder="Nombre del Usuario">
            </div><!-- Fin del col -->
            <div class="col-md-2">
                <button type="button" class="btn btn-success" id="btn-limpiar">
                <i class="fas fa-broom"></i>
                </button>
            </div><!-- Fin del col -->
          </div><!-- Fin del 2 row -->
        </div>
      </div>
    </div><!-- Fin del row princiopal -->
  
  <div class="col-md-9">
    <div class="card">
        <div class="header">
        <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#staticBackdrop">
          Añadir usuario<i class="fas fa-users ml-2"></i>
        </button>
        </div>
      <div class="card-body ">
        <table class="table table-valign-middle table-striped " id="tabla-usuarios" style="font-size:15px">
            <thead>
            <tr>
                <th>Nª</th>
                <th>Nombre de Usuario</th>
                <th>Correo</th>
                <th>Nivel de Acceso</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody id="datos-usuarios">
                <!-- Se carga de forma asincrona -->
            </tbody>
        </table>
      </div>
    </div>
      
  </div><!-- Fin del col -->
</div>


<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>



<script src="dist/js/other/adminUsuarios.js"></script>
