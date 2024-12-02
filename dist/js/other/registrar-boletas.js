
/* DECLARACION DE VARIABLES GLOBALES */

var totalingresos;
var totalegresos;
var totalliquido;
var idempleadom = -1;
var idinstitucionm = -1;
var datosNuevosb = true;
var datosNuevosc = true;
var idboleta;
var idcampo;
var idconcepto;
let anioCalcular;
var cheque;


/* FUNCIONES */

//Funcion para listar el ultimo registro
function listarUltimoRegistro(){
    $.ajax({
        url:'controllers/boleta.controller.php',
        type: 'GET',
        data: 'op=listarUltimoRegistro',
        success: function(e){
            if(e != ''){
    
                $("#tabla-ultimaBoleta").DataTable().destroy();

                // Agregar datos en cuerpo de la tabla usuario
                $("#datos-ultimaBoleta").html(e);

                // Volver a generar el dataTable
                $("#tabla-ultimaBoleta").DataTable({
                    paging:false,
                    lengthChange: false,
                    language: { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
                    searching: false,
                    /* scrollY: 400, */
                    ordering: false,
                    info: false,
                    autoWidth: false,
                    responsive: false,
                });
            
            }

        }
    });
}

//Funcion para calcular los ingresos con 2 decimales
function calcularIngresos(){
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = parseFloat(table.column(1).data().sum()).toFixed(2);
    totalliquido = parseFloat(totalingresos - totalegresos).toFixed(2);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

//Funcion para calcular los ingresos con 3 decimales
function calcularIngresosIntis(){
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = table.column(1).data().sum().toFixed(3);
    totalliquido = (totalingresos - totalegresos).toFixed(3);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

//Listar los ingresos para el registro de montos
function listarIngresos(){
    $.ajax({
        url:'controllers/conceptos.controller.php',
        type: 'GET',
        data: 'op=obtenerIngresos&idboleta=' + idboleta,
        success: function(e){
        if(e != ''){

            $("#tabla-ingresos").DataTable().destroy();

            // Agregar datos en cuerpo de la tabla usuario
            $("#datos-ingresos").html(e);

            // Volver a generar el dataTable
            $("#tabla-ingresos").DataTable({
                paging:true,
                lengthChange: false,
                language: { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
                searching: false,
                /* scrollY: 400, */
                ordering: false,
                info: false,
                autoWidth: false,
                responsive: false,
                
            });

            //Condicion para el calculo de ingresos
            if(anioCalcular <= 1991){
                calcularIngresosIntis();
            }else if(anioCalcular >= 1992){
                calcularIngresos();
            }
            
        }

        }
    });
}

//Funcion para calcular los egresos con 2 decimales
function calcularEgresos(){
    var table = $("#tabla-egresos").DataTable();
    totalegresos = parseFloat(table.column(1).data().sum()).toFixed(2);
    totalliquido = parseFloat(totalingresos - totalegresos).toFixed(2);
    $("#totaldescuento").val(totalegresos);
    $("#totalliquido").val(totalliquido);

}

//Funcion para calcular los egresos con 3 decimales
function calcularEgresosIntis(){
    var table = $("#tabla-egresos").DataTable();
    totalegresos = table.column(1).data().sum().toFixed(3);
    totalliquido = (totalingresos - totalegresos).toFixed(3);
    $("#totaldescuento").val(totalegresos);
    $("#totalliquido").val(totalliquido);

}

//Listar los egresos para el registro de montos
function listarEgresos(){
    $.ajax({
        url:'controllers/conceptos.controller.php',
        type: 'GET',
        data: 'op=obtenerEgresos&idboleta=' + idboleta,
        success: function(e){
        if(e != ''){
        $("#tabla-egresos").DataTable().destroy();

        // Agregar datos en cuerpo de la tabla usuario
        $("#datos-egresos").html(e);

        // Volver a generar el dataTable
        $("#tabla-egresos").DataTable({
            paging: true,
            lengthChange: false,
            language: { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
            searching: false,
            /* scrollY: 400, */
            ordering: true,
            info: false,
            autoWidth: false,
            responsive: false,
        });
            if(anioCalcular <= 1991){
                calcularEgresosIntis();
            }else if(anioCalcular >= 1992){
                calcularEgresos();
            }
        }

        }
    });
}

//Funcion para validar la existencia de un registro repetido
function validarBoleta(){
    var anio  = $("#anio").val();
    var mes  = $("#mes").val();

    var datos = {
        'op' : 'validarBoleta',
        'idempleado' : idempleado,
        'anio' : anio,
        'mes'   : mes
    };

    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        data: datos,
        success: function(e){
            if(e == 1){
                sweetAlertWarning('QuerySheet', 'Este registro ya existe');
            }else if(e == 2){
                registrarBoletas();
            }else{
                sweetAlertWarning('QuerySheet', 'Ocurrio un error inesperado');
            }
        }
    });

    
}

//Funcion para el registro de la boleta
/* function registrarBoletas(){
    var datosempleado   = $("#datosempleado").val();
    var activo          = $("#tipo").val();
    var tipoEmpleado    = $("#tipoEmpleado").val();
    var nivel           = $("#nivel").val();
    var cargo           = $("#cargo").val();
    var anio            = $("#anio").val();
    var mes             = $("#mes").val();
    var montoimponible  = $("#montoimponible").val();
    var cantidad        = $("#cantidad").val();
    

    if( datosempleado == "" || activo == "" || nivel == "" || cargo == "" || anio == "" || mes == "" || cantidad == ""){
       alertWarning("Completar todos los campos obligatorios");
    }
    else{
        var datos = {
            'idempleado'        : idempleado,
            'idinstitucion'     : idinstitucion,
            'activo'            : activo,
            'tipoempleado'      : tipoEmpleado,
            'nivel'             : nivel,
            'cargo'             : cargo,
            'anio'              : anio,
            'mes'               : mes,
            'montoimponible'    : montoimponible,
            'cantidad'          : cantidad

        };
        

        if(datosNuevosb){
            datos['op'] = 'registrarBoletas';
            
        }

        sweetAlertConfirmQuestionSave('¿Estas seguro de guardar el Registro?').then((confirm) =>{
            if(confirm.isConfirmed){
                $.ajax({
                    url: 'controllers/boleta.controller.php',
                    type: 'GET',
                    data: datos,
                    success: function(e){
                        datosNuevosb = true;
                        listarUltimoRegistro();
                        alertSuccess('Registro guardado correctamente');
                        $("#datosempleado").val('').focus();
                        $("#nombreInstitucion").val('');
                        $("#cargo").val('');
                        $("#anio").val('');
                        $("#montoimponible").val('');
                    }
                });
            }
        });
    }
} */

function registrarBoletas() {
    var datosempleado = $("#datosempleado").val();
    var activo = $("#tipo").val();
    var tipoEmpleado = $("#tipoEmpleado").val();
    var nivel = $("#nivel").val();
    var cargo = $("#cargo").val();
    var anio = $("#anio").val();
    var mes = $("#mes").val();
    var montoimponible = $("#montoimponible").val();
    var cantidad = $("#cantidad").val();
    var archivoBoleta = $("#pdfBoleta")[0].files[0]; // Obtén el archivo

    console.log("archivo boleta", archivoBoleta);

    if (datosempleado == "" || activo == "" || nivel == "" || cargo == "" || anio == "" || mes == "" || cantidad == "") {
        alertWarning("Completar todos los campos obligatorios");
    } else {
        // Crear un objeto FormData para enviar todos los datos incluyendo el archivo
        var formData = new FormData();
        formData.append('idempleado', idempleado);
        formData.append('idinstitucion', idinstitucion);
        formData.append('activo', activo);
        formData.append('tipoempleado', tipoEmpleado);
        formData.append('nivel', nivel);
        formData.append('cargo', cargo);
        formData.append('anio', anio);
        formData.append('mes', mes);
        formData.append('montoimponible', montoimponible);
        formData.append('cantidad', cantidad);
        formData.append('archivo_pdf', archivoBoleta); // Archivo PDF
        formData.append('op', 'registrarBoletas');

        console.log("archivo boleta", archivoBoleta);

        sweetAlertConfirmQuestionSave('¿Estás seguro de guardar el Registro?').then((confirm) => {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: 'controllers/boleta.controller.php',
                    type: 'POST', // Cambiado a POST
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (e) {
                        console.log(e);
                        alertSuccess('Registro guardado correctamente');
                        listarUltimoRegistro();
                    },
                    error: function () {
                        alertError('Hubo un error al guardar el registro');
                    }
                });
            }
        });
    }
}
    

//Funcion para el registro de montos(ingresos-egresos) y campos
function registrarConceptos(){
    
    var monto = $("#monto").val();
    let campo = $("#campo").val();

    if(monto == "" || campo == ""){
        alertWarning("Complete el monto");
    }
    else{
        var datos = {
            'idboleta'  : idboleta,
            'idcampo'   : idcampo,
            'monto'     : monto
        };
        if(datosNuevosc){
            datos['op'] = 'registrarConceptos';
            datos['idboleta'] = idboleta;
            datos['idcampo']  = idcampo;
        }
            $.ajax({
                url: 'controllers/conceptos.controller.php',
                type: 'GET',
                data: datos,
                success: function(e){
                    datosNuevosc = true;
                    listarIngresos();
                    listarEgresos();
                    $("#campo").val('').focus();
                    $("#monto").val('');
                }
            });


    }

}


/* EVENTOS */


//evento para el boton de registro de boletas
$("#btn-registrarboletas").click(function(){
    console.log("CLICK");
    registrarBoletas();
    validarBoleta(); 
});

//Evento click para el registro de boleta
$("#montoimponible").keypress(function(event){

    if(event.keyCode == 13){
        registrarBoletas();
        $("#datosempleado").val('').focus();
        $("#nombreInstitucion").val('');
        $("#cargo").val('');
        $("#anio").val('');
        //$("#mes").val('');
        $("#montoimponible").val('');
    }
});

//Evento para el boton de registro de montos y campos
$("#btn-registrarConcepto").click(function(){
    registrarConceptos();
});

//Evento click para el registro de montos y campos
$("#monto").keypress(function(event){
    if(event.keyCode == 13 ){
        registrarConceptos();
    }
});

//Evento para el autocompletado de las instituciones
$("#nombreInstitucion").autoComplete({
    resolver: 'custom',
    minLenght: 3,
    noResultsText : "No encontrado",
    events: {
        search: function(query, callback){
            $.ajax({
                url:'controllers/boleta.controller.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'op' : 'buscarInstituciones',
                    'search' : query
                }
            }).done(function(res){
                callback(res);
            });
        }
    }
});

//Evento para seleccionar el id de la institucion
$("#nombreInstitucion").on("autocomplete.select", function (event, item){
    idinstitucion = item['idinstitucion'];
});

//Evento para el autocompletado de los empleados
$("#datosempleado").autoComplete({
    resolver: 'custom',
    minLenght: 3,
    noResultsText : "No encontrado",
    events: {
        search: function(query, callback){
            $.ajax({
                url:'controllers/boleta.controller.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'op' : 'busquedaEmpleados',
                    'search' : query
                }
            }).done(function(res){
                callback(res);
            });
        }
    }
});

//Evento para seleccionar el id de el empleado
$("#datosempleado").on("autocomplete.select", function(event, item){
    idempleado = item['idempleado'];
});

//Evento para el autocompletado de los campos de ingresos e egresos
$("#campo").autoComplete({
    resolver: 'custom',
    minLenght: 3,
    noResultsText : "No encontrado",
    events: {
        search: function(query, callback){
            $.ajax({
                url:'controllers/boleta.controller.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'op' : 'buscarCampos',
                    'search' : query
                }
            }).done(function(res){
                callback(res);
            });
        }
    }
});

//Evento para seleccionar el id de los campos ingresos e egresos
$("#campo").on("autocomplete.select", function(event, item){
    idcampo = item['idcampo'];
});

//Evento para el autocompletado de los cargos - json
$("#cargo").autoComplete({
    resolverSettings: {
        url: 'views/data-json/cargos.json',
        minLenght: 1,
        noResultsText : "No encontrado"
    }
});

//Evento para el boton eliminar - eliminar ingresos
$("#tabla-ingresos").on("click", ".eliminar",function(){

    $idconcepto = $(this).attr("data-idconcepto");

    sweetAlertConfirmQuestionSave("¿Estas seguro de eliminar este registro?").then((confirm) => {
        if(confirm.isConfirmed){
            $.ajax({
                url: 'controllers/conceptos.controller.php',
                type: 'GET',
                data: 'op=eliminarConceptos&idconcepto=' + $idconcepto,
                success: function(e) {
                    listarIngresos();
                    alertSuccess("Ingreso eliminado correctamente");
                }
            });
        }
    });
});

//Evento para el boton eliminar - eliminar egresos
$("#tabla-egresos").on("click", ".eliminar",function(){
    $idconcepto = $(this).attr("data-idconcepto");

    sweetAlertConfirmQuestionSave("¿Estas seguro de eliminar este registro ?").then((confirm) => {
        if(confirm.isConfirmed){
            $.ajax({
                url: 'controllers/conceptos.controller.php',
                type: 'GET',
                data: 'op=eliminarConceptos&idconcepto=' + $idconcepto,
                success: function(e) {
                    listarEgresos();
                    alertSuccess("Egreso eliminado correctamente");
                }
            });
        }
    });
});

//Evento para abrir el modal de registro de montos
$("#datos-ultimaBoleta").on("click", ".montos", function(){

    idboleta = $(this).attr("data-idboleta");
    anioCalcular = $(this).attr("data-anio");
    $("#campo").focus();
    $("#modal-montos").modal('show');
    listarUltimoRegistro();
    listarEgresos();
    listarIngresos();

});

listarIngresos();
listarEgresos();
listarUltimoRegistro();
