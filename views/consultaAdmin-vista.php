<div class="callout callout-success">
  <h4 class="text-center">Módulo de Consultas de Boletas<i class="fas fa-user-tie ml-2"></i></h4>
</div>


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
                 <!-- Aquí se cargarán los detalles con JavaScript -->
                 <div id="spinner-consultaAdmin" style="display: none; text-align: center; margin: 20px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i> Cargando datos, por favor espere...
                </div>
            </tbody>
  </table>
</div>

<div id="contenedor-consultaVista">
  <table class="table table-valign-middle table-striped text-center" id="tabla-consultaVista">
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
                    <!-- Otros campos si es necesario -->
                </tr>
            </thead>
            <tbody id = "datos-consultaVista">
               

            </tbody>
  </table>
</div>
        
        

<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/boletas.js"></script>