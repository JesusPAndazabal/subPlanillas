function importarArchivo(periodo_id) {
    var formData = new FormData();
    var archivo = $("#archivoLis")[0].files[0];

    if (!archivo) {
        alertWarning('Debe seleccionar un archivo .lis para importar.');
        return;
    }

    formData.append("op", "importarArchivo");
    formData.append("archivoLis", archivo);
    formData.append("periodo_id", periodo_id); // Aquí pasas el periodo_id

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
                    console.log("RESponse", response);
                    let res = JSON.parse(response);
                    console.log("RES.SUCCESS", res);
                    if (res.success) {
                        alertSuccess(res.message);
                    } else {
                        alertError(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    alertError("Error al importar el archivo: " + error);
                }
            });
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
            console.log("Registrar Periodo Response 1", response);
            let res = JSON.parse(response);
            console.log("RESPONSE" , res);
            if (res.success) {
                alertSuccess('Periodo registrado con éxito.' , res.periodo_id);
                importarArchivo(res.periodo_id); // Llama a la función de importar después del registro
            } else {
                alertError(res.message);
            }
        },
        error: function(xhr, status, error) {
            alertError("Error al registrar el periodo: " + error);
        }
    });
}


//Evento para el boton de registrar Usuario
$("#subirArchivo").click(function(){
    console.log("click");
    registrarPeriodo();
});