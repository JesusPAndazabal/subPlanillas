<div class='callout callout-success'>
    <h3 class='text-center'>MODULO DE PERSONAS<i class='fas fa-chart-bar ml-2'></i></h3>
</div>


<div class="card border-dark" id="card-docentes">
    <div class="card-body table-responsive p-4">

    <!--  -->
        <table class="table table-valign-middle table-striped text-center" id="tabla-personas">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>N° de Documento</th>
            </tr>
            </thead>
            <tbody id="datos-personas">
                <!-- Se carga de forma asincrona -->
            </tbody>
        </table>
    </div>
</div><!-- Fin del card -->


<!-- Configuracion de alertas personalizadas -->
<script src="dist/js/configAlerts.js"></script> 

<!-- Datatable -->
<script src="dist/js/dataTableConfig.js"></script>

<script src="dist/js/other/personas.js"></script>
