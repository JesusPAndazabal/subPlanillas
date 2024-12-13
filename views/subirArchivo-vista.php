<div class='callout callout-success'>
    <h3 class='text-center'>Modulo de Importación de Archivos <i class='fas fa-chart-bar ml-2'></i></h3>
</div>

<div>
    <form id="formularioCarga">

        <!-- 1 ROW -->
        <div class="row">
            <!-- COLUMNA PARA EL TIPO DE PAGO -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tipoPago">Tipo de Boleta:</label>
                    <select class="custom-select" id="tipoPago" name="tipoPago" required>
                        <option value="" disabled selected>Seleccione el tipo de pago</option>
                        <option value="CES/JUD">CES/JUD</option>
                        <option value="CES/SOB">CES/SOB</option>
                        <option value="CES/TIT">CES/TIT</option>
                        <option value="ACT/JUD">ACT/JUD</option>
                        <option value="ACT/OCA">ACT/OCA</option>
                        <option value="ACT/CONT/TIT - ACT/NOMB/TIT">ACT/CONT/TIT - ACT/NOM/TIT</option>
                    </select>
                 </div>
            </div>
            
            <!-- COLUMNA PARA LA FORMA DE PAGO -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="formaPago">Forma de Pago:</label>
                    <select class="custom-select" id="formaPago" name="formaPago" required>
                        <option value="" disabled selected>Seleccione la forma de pago</option>
                        <option value="Teleahorro">TELEAHORRO / CUENTA</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="mes">Mes:</label>
                    <select class="custom-select" id="mes" name="mes" required>
                        <option value="" disabled selected>Seleccione el mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="anio">Año:</label>
                    <input type="number" class="form-control" id="anio" name="anio" min="2000" max="2100" placeholder="Ingrese el año" required />
                    </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                <label for="boleta">Boleta:</label>
                <select id="boleta" class="custom-select" name="boleta" required>
                    <option value="" disabled selected>Seleccione la boleta</option>
                    <option value="1">Primera</option>
                    <option value="2">Adicional 1</option>
                    <option value="3">Adicional 2</option>
                    <option value="4">Adicional 3</option>
                    <option value="5">Adicional 4</option>
                </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="archivoLis">Seleccionar archivo Formato .lis:</label>
                    <input type="file" id="archivoLis" class="form-control-file" name="archivoLis" accept=".lis" required />
                </div>        
            </div>
        </div>

        
        
        <button type="button" id="subirArchivo" class="btn btn-success">Importar Archivo</button>
    </form>
</div>

<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/subirArchivo.js"></script>
