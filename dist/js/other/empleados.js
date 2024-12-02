/* DECLARACION DE VARIABLES GLOBALES*/
var idempleado = -1;
var datosNuevos = true;


var datosControlador = {
    op : 'buscarEmpleados',
    search : ''
};

/* FUNCIONES */

function listarEmpleados(){
    var tabla = $("#tabla-empleados").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-empleados").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/empleado.controller.php?op=listarEmpleados',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster,
        "columnDefs"    : columnDefsEmpleados 
    });
} 

//funcion para el registro del empleado
function registrarEmpleados(){

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

/* Eventos */

//evento para el boton de registro de empleado
$("#btn-registrar-empleados").click(registrarEmpleados);

//evento para obtener los datos de un registro
$("#tabla-empleados").on("click", ".modificar", function(){
    idempleado = $(this).attr("data-idempleado");

    $.ajax({
        url: 'controllers/empleado.controller.php',
        type: 'GET',
        data: 'op=obtenerEmpleados&idempleado=' + idempleado,
        success: function(e){
            var datos = JSON.parse(e);
            $("#apellidos")     .val(datos[0].apellidos);
            $("#nombres")       .val(datos[0].nombres);
            $("#codigomodular") .val(datos[0].codigomodular);
            $("#codigodni")     .val(datos[0].codigodni);
            $("#telefono")      .val(datos[0].telefono);
            
            $("#modal-empleados").modal('show');

            datosNuevos = false;

        }
    });
});

//evento para abrir el modal de registro de empleados
$("#abrir-modal-empleados").click(function (){
    $("#formulario-empleado")[0].reset();

    $("#apellidos").focus();
});

listarEmpleados();


