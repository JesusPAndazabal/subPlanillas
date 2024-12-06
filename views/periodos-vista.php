<div class='callout callout-success'>
    <h3 class='text-center'>MODULO DE PERIODOS<i class='fas fa-chart-bar ml-2'></i></h3>
</div>



<div class="card border-dark" id="card-docentes">
    <div class="card-body table-responsive p-4">

    <!--  -->
        <table class="table table-valign-middle table-striped text-center" id="tabla-periodos">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tipo</th>
                <th>Mes</th>
                <th>Anio</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Termino</th>
            </tr>
            </thead>
            <tbody id="datos-periodos">
                <!-- Se carga de forma asincrona -->
            </tbody>
        </table>
    </div>
</div><!-- Fin del card -->


<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/periodos.js"></script>
