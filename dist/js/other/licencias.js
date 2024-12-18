function listarLicencias(){
    var tabla = $("#tabla-licencias").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-licencias").DataTable({
        "processing"    : true,
        "responsive"    : true,
        "autoWidth"     : false,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/licencias.controller.php?op=listarLicencias',
        "pageLength"    : 8,
        "lengthChange"  : true,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster,
        "columnDefs"    : columnDefLicencias
    });
} 

function actualizarLicencia(){
    var fechaVencimiento = $("#fechaVencimiento").val();
    var estadoLicencia = $("#estado").val();

    var datos = {
        'op' : 'actualizarFecha',
        'idlicencia' : idlicencia,
        'fecha_vencimiento' : fechaVencimiento,
        'estado'            : estadoLicencia
    }

    console.log(datos, "datos de actualizacion");

    sweetAlertConfirmQuestionSave('¿Estas seguro de actualizar los datos?').then((confirm) =>{
        if(confirm.isConfirmed){
            $.ajax({
                url:'controllers/licencias.controller.php',
                type: 'GET',
                data: datos,
                success: function(e){
                    listarLicencias();
                    alertSuccess("Fecha actualizada correctamente");
                    $("#modal-licencias").modal('hide');
                }
            });
        }
    });
}

//evento para obtener los datos de un registro
$("#tabla-licencias").on("click", ".modificar", function(){
    idlicencia = $(this).attr("data-idlicencia");

    console.log(idlicencia);

    $.ajax({
        url: 'controllers/licencias.controller.php',
        type: 'GET',
        data: 'op=obtenerLicencia&idlicencia=' + idlicencia,
        success: function(e){
            var datos = JSON.parse(e);
            console.log(datos);

            $("#clave").val(datos[0].clave);
            $("#fechaVencimiento").val(datos[0].fecha_vencimiento);
            $("#estado").val(datos[0].estado);
            
            
            $("#modal-licencias").modal('show');

        }
    });
});

//evento para el boton de registro de empleado
$("#btn-actualizarFecha").click(actualizarLicencia);

/* function registrarEmpleados(){

    var apellidos       = $("#apellidos").val();
    var nombres         = $("#nombres").val();
    var codigomodular   = $("#codigomodular").val();
    var codigodni       = $("#codigodni").val();
    var telefono        = $("#telefono").val(); 

    //Validamos si esta vacio las cajas de texto
    if(nombres == "" || apellidos == "" || codigomodular == ""){
        alertWarning("Complete los datos");
    }
    else{
        var datos = {
            'apellidos'     : apellidos,
            'nombres'       : nombres,
            'codigomodular' : codigomodular,
            'codigodni'     : codigodni,
            'telefono'      : telefono
        };


        if(datosNuevos){
            datos['op'] = 'registrarEmpleados';
        }
        else{
            datos['op'] = 'actualizarEmpleados';
            datos['idempleado'] = idempleado;
        }

        sweetAlertConfirmQuestionSave('¿Estas seguro de guardar los datos?').then((confirm) =>{
            if(confirm.isConfirmed){
                $.ajax({
                    url:'controllers/empleado.controller.php',
                    type: 'GET',
                    data: datos,
                    success: function(e){
                        listarEmpleados();
                        alertSuccess("Empleado registrado correctamente");
                        $("#modal-empleados").modal('hide');

                        datosNuevos = true;
                        idempleado = -1;
                    }
                });
            }
        });

    }
}
 */

listarLicencias();
