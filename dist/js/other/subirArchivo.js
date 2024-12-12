function importarArchivo(periodo_id, callback) {
    var formData = new FormData();
    var archivo = $("#archivoLis")[0].files[0];
    var tipoSeleccionado = $("#tipoPago").val();

    console.log(tipoSeleccionado , "tIPO SELECCIONADO");

    if (!archivo) {
        alertWarning('Debe seleccionar un archivo .lis para importar.');
        callback(false);  // Si no hay archivo, llamamos el callback con false
        return;
    }

    formData.append("op", "importarArchivo");
    formData.append("archivoLis", archivo);
    formData.append("periodo_id", periodo_id); // Aquí pasas el periodo_id
    formData.append("tipoPago", tipoSeleccionado); 

    sweetAlertConfirmQuestionSave("¿Está seguro de importar este archivo?").then((confirm) => {
        if (confirm.isConfirmed) {
            $.ajax({
                url: 'controllers/subirArchivo.controller.php',  // Apunta a tu controlador PHP que procesará el archivo
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.success) {
                        alertSuccess(res.message);
                        callback(true);  // Llamamos el callback con `true` si la importación fue exitosa
                    } else {
                        alertError(res.message);
                        callback(false); // Llamamos el callback con `false` si hay un error
                    }
                },
                error: function(xhr, status, error) {
                    alertError("Error al importar el archivo: " + error);
                    callback(false); // Llamamos el callback con `false` en caso de error
                }
            });
        } else {
            callback(false);  // Si el usuario cancela la importación
        }
    });
}

function registrarPeriodo() {
    var tipo = $("#tipoPago").val();
    var mes = $("#mes").val();
    var anio = $("#anio").val();
    var numero = $("#boleta").val();
    var formaPago = $("#formaPago").val();

    if (!tipo || !mes || !anio || !numero || !formaPago) {
        alertWarning('Debe completar todos los campos antes de registrar.');
        return;
    }

    // Intentamos importar el archivo antes de registrar el periodo
    var periodo_id = null;  // Para almacenar el ID del periodo que se registrará
    $.ajax({
        url: 'controllers/periodo.controller.php', // Controlador PHP
        type: 'POST',
        data: {
            op: 'registrarPeriodo',
            tipo: tipo,
            mes: mes,
            anio: anio,
            numero: numero,
            formaPago: formaPago
        },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.success) {
                periodo_id = res.periodo_id;
                alertSuccess('Periodo registrado con éxito.');
                // Ahora que tenemos el ID del periodo, intentamos importar el archivo
                importarArchivo(periodo_id, function(importSuccess) {
                    console.log(importSuccess , "Importacion", res.success);
                    if (!importSuccess) {
                        // Si la importación falla, eliminamos el periodo
                        eliminarPeriodo(periodo_id);
                        //alertError('El archivo no se pudo importar. El periodo ha sido eliminado.');
                    }
                });
            } else {
                alertError(res.message);
            }
        },
        error: function(xhr, status, error) {
            alertError("Error al registrar el periodo: " + error);
        }
    });
}

// Esta función elimina el periodo si la importación falla
function eliminarPeriodo(periodo_id) {
    $.ajax({
        url: 'controllers/subirArchivo.controller.php', // Controlador para eliminar periodo
        type: 'POST',
        data: {
            op: 'eliminarPeriodo',
            periodo_id: periodo_id
        },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.success) {
                //alertSuccess('Periodo eliminado correctamente.');
            } else {
                alertError('No se pudo eliminar el periodo.');
            }
        },
        error: function(xhr, status, error) {
            alertError("Error al eliminar el periodo: " + error);
        }
    });
}

// Evento para el boton de registrar Usuario
$("#subirArchivo").click(function(){
    registrarPeriodo();
});
