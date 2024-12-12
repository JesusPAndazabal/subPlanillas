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

function importacionFonavi() {
    // Obtener valores del formulario
    var numeroDoc = $("#numeroDocPrint").val();
    var anioInicial = $("#anioInicial").val();
    var anioFinal = $("#anioFinal").val();

    // Validar campos
    if (numeroDoc === "") {
        alertWarning("Complete el número de documento");
        return;
    }

    // Enviar datos al backend
    var datos = {
        'op': 'generarExcelFonavi',
        'numeroDoc': numeroDoc,
        'anioInicial': anioInicial,
        'anioFinal': anioFinal
    };

    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function () {
            // Redirigir para descargar el archivo
            var url = `controllers/importaciones.controller.php?op=generarExcelFonavi&numeroDoc=${numeroDoc}&anioInicial=${anioInicial}&anioFinal=${anioFinal}`;
            window.open(url, '_blank'); // Abre el archivo en una nueva pestaña o lo descarga
        },
        error: function (xhr, status, error) {
            // Manejo de errores
            console.error("Error al generar el Excel:", error);
            alertError("Ocurrió un error al generar el archivo. Intente nuevamente.");
        }
    });
}

function importacionPreparacionClases() {
    // Obtener valores del formulario
    var numeroDoc = $("#numeroDocPrint").val();
    var anioInicial = $("#anioInicial").val();
    var anioFinal = $("#anioFinal").val();

    // Validar campos
    if (numeroDoc === "") {
        alertWarning("Complete el número de documento");
        return;
    }

    // Enviar datos al backend
    var datos = {
        'op': 'generarExcelPreparacionClases',
        'numeroDoc': numeroDoc,
        'anioInicial': anioInicial,
        'anioFinal': anioFinal
    };

    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function () {
            // Redirigir para descargar el archivo
            var url = `controllers/importaciones.controller.php?op=generarExcelPreparacionClases&numeroDoc=${numeroDoc}&anioInicial=${anioInicial}&anioFinal=${anioFinal}`;
            window.open(url, '_blank'); // Abre el archivo en una nueva pestaña o lo descarga
        },
        error: function (xhr, status, error) {
            // Manejo de errores
            console.error("Error al generar el Excel:", error);
            alertError("Ocurrió un error al generar el archivo. Intente nuevamente.");
        }
    });
}

function listarConsultasAdmin() {
    var numeroDocFiltro = $("#numeroDoc").val();
    var anioFiltro = $("#anio").val();
    var mesFiltro = $("#mes").val();

    var datos = {
        'op': 'listarConsultasAdmin',
        'numeroDoc': numeroDocFiltro,
        'anio': anioFiltro,
        'mes': mesFiltro  
    }

    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function (e) {
            $("#tabla-consultaAdmin").DataTable().destroy();

            // Agregar datos en cuerpo de la tabla usuario
            $("#datos-consultaAdmin").html(e);

            console.log(e);

            // Volver a generar el dataTable
            $("#tabla-consultaAdmin").DataTable({
                paging: true,
                lengthChange: true,
                pageLength: 8,
                language: { url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json' },
                searching: false,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                dom: domTableComplete,
                buttons: buttonsTableMaster
            });

             // Mostrar la tabla después de cargar los datos
             $("#contenedor-tabla-consulta").fadeIn();
        }
    });
}


// Evento keyup para buscar por número de documento
$("#numeroDoc").on("keyup", function () {
    console.log("evento");
    listarConsultasAdmin();
}); 

// Evento keyup para buscar por año
$("#anio").on("keyup", function () {
    listarConsultasAdmin();
});

// Evento change para el mes, en caso de que se seleccione un mes
$("#mes").on("change", function () {
    listarConsultasAdmin();
});

// Asociar el evento al botón
$("#descargarFonavi").click(function () {
    importacionFonavi();
});

// Asociar el evento al botón
$("#descargarPreparacion").click(function () {
    importacionPreparacionClases();
});



$("#tabla-consulta").on("click", ".reporte", function () {
    let idboleta = $(this).attr("data-idboleta");
    console.log("click en el reporte", idboleta);
    window.open("reports/reporte.php?idboleta=" + idboleta);
});

$("#tabla-consultaAdmin").on("click", ".reporte", function () {
    let idboleta = $(this).attr("data-idboleta");
    console.log("click en el reporte", idboleta);
    window.open("reports/reporte.php?idboleta=" + idboleta);
});





listarBoletasConsulta(numeroDocBoleta);
