function importarArchivo() {
    var formData = new FormData();
    var archivo = $("#archivoLis")[0].files[0];

    if (!archivo) {
        alertWarning('Debe seleccionar un archivo .lis para importar.');
        return;
    }

    formData.append("op", "importarArchivo");
    formData.append("archivoLis", archivo);

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


//Evento para el boton de registrar Usuario
$("#subirArchivo").click(function(){
    console.log("click");
    importarArchivo();
});