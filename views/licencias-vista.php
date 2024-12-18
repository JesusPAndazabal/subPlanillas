<div class="callout callout-success">
  <h4 class="text-center">Gestión de Licencias<i class="fas fa-school ml-2"></i></h4>
</div>

     <!-- Modal para el registro de Instituciones-->
     <div class="modal fade" id="modal-licencias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="staticBackdropLabel">Registro de Empleados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="formulario-empleado">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="">Clave :</label>
                                    <input type="text" class="form-control" id="clave">
                                </div>
                                <div class="col-md-5">
                                    <label for="">Fecha de Vencimiento</label>
                                    <input type="date" class="form-control" id="fechaVencimiento">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Estado:</label>
                                    <input type="text" class="form-control" id="estado">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="btn-actualizarFecha">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>



<!-- Tabla para el listado de instituciones -->
<table class="table table-valign-middle table-striped text-center" id="tabla-licencias">
    <thead>
    <tr>
        <th>Id</th>
        <th>Clave</th>
        <th>Fecha de Vencimiento</th>
        <th>Estado</th>
        <th>Fecha de Registro</th>
        <th>Comentario</th>
        <th>Opciones</th>

    </tr>
    </thead>
    <tbody id="datos-licencias">
        <!-- Se carga de forma asincrona -->
    </tbody>
</table>


<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/licencias.js"></script>
