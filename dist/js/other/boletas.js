var numeroDocBoleta = localStorage.getItem("nomuserBoleta");

function listarBoletasConsulta(numeroDocBoleta) {

    console.log(localStorage.getItem("nomuserBoleta"));
    datos = {
        'op': 'buscardetalleDni',
        'numeroDoc': numeroDocBoleta // Pasar el ID de la planilla
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

listarBoletasConsulta(numeroDocBoleta);