var numeroUser = localStorage.getItem("nomuserBoleta");

function listarConsultas(numeroUser) {

    console.log(localStorage.getItem("numeroUser"));
    datos = {
        'op': 'obtenerConsulta',
        'codigodni': numeroUser // Pasar el ID de la planilla
    };

    console.log(datos);

    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function (e) {
            $("#tabla-consulta").DataTable().destroy();

            // Agregar datos en el cuerpo de la tabla detalle
            $("#datos-consulta").html(e);

            console.log(e);

            // Volver a generar el dataTable
            $("#tabla-consulta").DataTable({
                paging: true,
                lengthChange: true,
                pageLength: 8,
                language: { url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json' },
                searching: false,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true
            });
        }
    });
}

$("#tabla-consulta").on("click", ".reporte", function(){
    console.log("click");
    idboleta = $(this).attr("data-idboleta");   
    window.open("reports/reporte/"+idboleta);
});


listarConsultas(numeroUser)


