
/* DECLARACIÓN DE VARIABLES GLOBALES */
var idinstitucion = -1;
var datosNuevos = true;
var idinstitucionel;

/* FUNCIONES */

//Funcion para listar las intituciones
function listarInstituciones(){
    var tabla = $("#tabla-institucion").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-institucion").DataTable({
        "processing"    : true,
        "responsive"    : true,
        "autoWidth"     : false,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/institucion.controller.php?op=listarInstituciones',
        "pageLength"    : 8,
        "lengthChange"  : true,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster,
        "columnDefs"    : columnDefsInstituciones
    });
} 

//Funcion para el registro de las Instituciones
function registrarInstituciones(){

    var nombre = $("#nombre").val();
    var codlegacy = $("#codlegacy").val();
    var codactual = $("#codactual").val();

    //Validar si esta vacio
    if(nombre == "" || codlegacy == ""){
        alertWarning("Complete todos los campos porfavor    ");
    }
    else{
        var datos = {
            'nombre'            : nombre,
            'codlegacy'         : codlegacy,
            'codactual'         : codactual
        };

        if(datosNuevos){
            datos['op'] = 'registrarInstitucion';
        }
        else{
            datos['op'] = 'actualizarInstitucion';
            datos['idinstitucion'] = idinstitucion; 
        }

        sweetAlertConfirmQuestionSave('¿Estas seguro de registrar esta Institución?').then((confirm) =>{
            if(confirm.isConfirmed){
                $.ajax({
                    url:'controllers/institucion.controller.php',
                    type: 'POST',
                    data: datos,
                    success: function (e){
                    listarInstituciones();
                    alertSuccess("Institución registrada correctamente");
                    $("#modal-instituciones").modal('hide');
                    datosNuevos = true;
                    idinstitucion = -1;
                    }
                 });
            }
        });

    }

}

/* EVENTOS */

//Evento para el boton de registro 
$("#btn-registrarinstitucion").click(registrarInstituciones); 

//Evento para el click de el boton de modificar
$("#tabla-institucion").on("click", ".modificar", function(){
    
    idinstitucion = $(this).attr("data-idinstitucion");

    $.ajax({
        url:'controllers/institucion.controller.php',
        type:'GET',
        data:'op=obtenerInstitucion&idinstitucion=' + idinstitucion,
        success:function(e){
   
            var datos = JSON.parse(e);
            $("#nombre").val(datos[0].nombre);
            $("#codlegacy").val(datos[0].codlegacy);
            $("#codactual").val(datos[0].codactual);
            $("#modal-instituciones").modal('show');
            datosNuevos = false;
        }
    });
});

//Evento al abrir el modal de registro
$("#abrir-modal-instituciones").click(function(){
    $("#formulario-institucion")[0].reset();
    $("#nombre").focus();
});

listarInstituciones();