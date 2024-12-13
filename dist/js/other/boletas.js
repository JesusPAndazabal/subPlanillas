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

function listarBoletasUsuarios() {
    var anioConsulta = $("#anioConsulta").val();
    var mesConsulta = $("#mesConsulta").val();

    // Mostrar el spinner en el tbody
    $("#datos-consulta").html(`
        <tr>
            <td colspan="10" class="text-center">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i> Cargando datos, por favor espere...
            </td>
        </tr>
    `);

    var datos = {
        'op': 'buscarConsultaUsuarios',
        'numeroDoc': numeroDocBoleta,
        'anio': anioConsulta,
        'mes': mesConsulta
    };


    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function (response) {
            // Destruir el DataTable si ya fue inicializado
            if ($.fn.DataTable.isDataTable("#tabla-consulta")) {
                $("#tabla-consulta").DataTable().destroy();
            }

            // Reemplazar el contenido del tbody con la respuesta
            $("#datos-consulta").html(response);

            $("#tabla-consulta").DataTable({
                paging: true,
                lengthChange: true,
                pageLength: 8,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json',
                    emptyTable: ""  // Evitar el mensaje predeterminado de "No hay datos"
                },
                searching: false,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                dom: domTableComplete,
                buttons: buttonsTableMaster,
                drawCallback: function(settings) {
                    // Mostrar u ocultar el spinner según el contenido de la tabla
                    if (settings.aoData.length === 0) {
                        // Mostrar el spinner en el tbody
                        $("#datos-consulta").html(`
                            <tr>
                                <td colspan="10" class="text-center">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i> Cargando datos, por favor espere...
                                </td>
                            </tr>
                        `);
                    } else {
                        // Si hay datos, ocultar el spinner
                        $("#spinner").hide();
                    }
                }
            });
            
        },
        error: function () {
            // Mostrar mensaje de error en el tbody
            $("#datos-consulta").html(`
                <tr>
                    <td colspan="10" class="text-center">
                        Error al cargar los datos. Intente nuevamente.
                    </td>
                </tr>
            `);
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

function listarConsultasVista(){
    var tabla = $("#tabla-consultaVista").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-consultaVista").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/boleta.controller.php?op=listarConsultasVista',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domtableBasic,
        "buttons"       : buttonsTableMaster
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
                buttons: buttonsTableMaster,
                
            });

             // Mostrar la tabla después de cargar los datos
             $("#contenedor-tabla-consulta").fadeIn();
             $("#contenedor-consultaVista").fadeOut();
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


// Evento keyup para buscar por año
$("#anioConsulta").on("keyup", function () {
    listarBoletasUsuarios();
});

// Evento change para el mes, en caso de que se seleccione un mes
$("#mesConsulta").on("change", function () {
    listarBoletasUsuarios();
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




listarConsultasVista();
listarBoletasConsulta(numeroDocBoleta);
