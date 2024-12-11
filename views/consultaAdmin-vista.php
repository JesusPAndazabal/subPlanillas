<div class="callout callout-success">
  <h4 class="text-center">Módulo de Consultas de Boletas<i class="fas fa-user-tie ml-2"></i></h4>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalImpresiones">
  Imprimir Formatos Excel
</button>

<!-- Modal -->
<div class="modal fade" id="modalImpresiones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">IMPRESIÓN DE FORMATOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

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
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="descargarFonavi">APORTACIONES AL FONAVI</button>
        <button type="button" class="btn btn-success" id="descargarPreparacion">PREPARACIÓN DE CLASES</button>
      </div>
    </div>
  </div>
</div>


<hr>

<div class="row">
    <div class="col-md-4">
        <label for="">Numero de Documento</label>
        <input type="text" class="form-control" id="numeroDoc" data-index="3">
    </div>
    <div class="col-md-4">
        <label for="">Año</label>
        <input type="text" class="form-control" id="anio" data-index="8">
    </div>
    <div class="col-md-4">
        <label for="">Mes</label>
        <select class="custom-select custom-select" id="mes" data-index="7">
            <option value="" selected>Seleccionar Mes</option>
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Setiembre">Setiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
        </select>
    </div>
</div><br>

<div id="contenedor-tabla-consulta" style="display: none;">
  <table class="table table-valign-middle table-striped text-center" id="tabla-consultaAdmin">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>N° Documento</th>
                    <th>Cargo</th>
                    <th>Establecimiento</th>
                    <th>Tipo</th>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Reportes</th>
                    <!-- Otros campos si es necesario -->
                </tr>
            </thead>
            <tbody id = "datos-consultaAdmin">
                <!-- Aquí se cargarán los detalles con JavaScript -->
            </tbody>
  </table>
</div>
        

<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/boletas.js"></script>