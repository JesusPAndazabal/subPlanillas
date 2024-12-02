
var idusuario = localStorage.getItem("usuarioBoleta");
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
var texcheque;


function configFiltros(){
    $("#card-filtros").addClass('collapsed-card');
    $("#mostrarFiltro").html("Mostrar filtro<i class='fas fa-plus ml-2'></i>");
}

function listarBoletasRevisar(){
    
    var tabla = $("#tabla-boletas").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-boletas").DataTable({
        "processing"    : true,
        "autoWidth"     : false,
        "ordering"      : false,
        "responsive"    : true,
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/boleta.controller.php?op=listadoBoletasObservadas',
        "pageLength"    : 7,
        "lengthChange"  : false,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "searching"     : true,
        "dom"           : domtableBasic,
        "buttons"       : buttonsTableMaster,
        "columnDefs"    : columnDefsObservadas 
    });
 
}

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
            
            if(anioCalcular <= 1991){
                calcularIngresosIntis();
            }else if(anioCalcular >= 1992){
                calcularIngresos();
            }

        }

        }
    });
}

//Calcular los montos a partir de  2 decimales
function calcularIngresos(){
    
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = parseFloat(table.column(1).data().sum()).toFixed(2);
    totalliquido = parseFloat(totalingresos - totalegresos).toFixed(2);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

//Calcula los montos a partir de 3 decimales
function calcularIngresosIntis(){
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = table.column(1).data().sum().toFixed(3);
    totalliquido = (totalingresos - totalegresos).toFixed(3);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

function calcularEgresos(){
    var table = $("#tabla-egresos").DataTable();
    totalegresos = parseFloat(table.column(1).data().sum()).toFixed(2);
    totalliquido = parseFloat(totalingresos - totalegresos).toFixed(2);
    $("#totaldescuento").val(totalegresos);
    $("#totalliquido").val(totalliquido);

}

function calcularEgresosIntis(){
    var table = $("#tabla-egresos").DataTable();
    totalegresos = table.column(1).data().sum().toFixed(3);
    totalliquido = (totalingresos - totalegresos).toFixed(3);
    $("#totaldescuento").val(totalegresos);
    $("#totalliquido").val(totalliquido);

}

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
                type: 'POST',
                data: datos,
                success: function(e){
                    datosNuevosc = true;
                    listarIngresos();
                    listarEgresos();
                }
            });


    }

}

function registrarBoletas(){
    
    var activo          = $("#tipo").val();
    var tipoEmpleado    = $("#tipoEmpleado").val();
    var nivel           = $("#nivel").val();
    var mes             = $("#mes").val();
    var cargo           = $("#cargo").val();
    var anio            = $("#anio").val();
    var montoimponible  = $("#montoimponible").val();
    var cantidad        = $("#cantidad").val();
    


    if( activo == "" || nivel == "" || cargo == "" || anio == "" || mes == "" || montoimponible == ""){
        Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Complete todos los campos!',
        });
    }
    else{
        var datos = {
            'idusuariomodifico' : idusuario,
            'idempleado'        : idempleado,
            'idinstitucion'     : idinstitucion,
            'activo'            : activo,
            'tipoempleado'      : tipoEmpleado,
            'nivel'             : nivel,
            'cargo'             : cargo,
            'anio'              : anio,
            'mes'               : mes,
            'montoimponible'    : montoimponible,
            'cheque'            : cheque,
            'cantidad'          : cantidad
        };

        if(datosNuevos){
            datos['op'] = 'registrarBoletas';
            
        }
        else{
            datos['op'] = 'actualizarBoletas';
            datos['idboleta'] = idboleta;
        }

        sweetAlertConfirmQuestionSave('¿Estas seguro de guardar el Registro?').then((confirm) =>{
            if(confirm.isConfirmed){
                $.ajax({
                    url: 'controllers/boleta.controller.php',
                    type: 'GET',
                    data: datos,
                    success: function(e){
                        listarBoletasRevisar();
                        $("#modal-editarBoleta").modal('hide');
                        datosNuevos = true;
                        idboleta = -1;
                        alertSuccess('Registro guardado con Exito');
                    }
                });
            }
        });
    }
}


$("#buscaranio").keyup(function(){
    var table = $("#tabla-boletas").DataTable();
    table.column($(this).data('index')).search(this.value).draw();
});

$("#nombreempleado").keyup(function(){
    var table = $("#tabla-boletas").DataTable();
    table.column($(this).data('index')).search(this.value).draw();
});

//Limpiar las cajas de texto
$("#btn-limpiar").click(function(){

    $("#buscaranio").val('').focus();
    $("#nombreempleado").val('');

    actualizardatosControlador();
    listarBoletasRevisar();
});

$("#btn-registrarConcepto").click(function(){
    registrarConceptos();
    $("#campo").val('').focus();
    $("#monto").val('');
});

$("#monto").keypress(function(event){

    if(event.keyCode == 13 ){
        registrarConceptos();
        $("#campo").val('').focus();
        $("#monto").val('');
    }
});

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

$("#datosempleado").on("autocomplete.select", function(event, item){
        idempleado = item['idempleado'];
});

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

$("#nombreInstitucion").on("autocomplete.select", function (event, item){
    idinstitucion = item['idinstitucion'];
});

$("#cargo").autoComplete({
    resolverSettings: {
        url: 'views/data-json/cargos.json',
        minLenght: 1,
        noResultsText : "No encontrado"
    }
});

$("#campo").on("autocomplete.select", function(event, item){
    idcampo = item['idcampo'];
});

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
                    alertSuccess("Eliminado correctamente");
                }
            });
        }
    });
});

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
                    alertSuccess("Eliminado correctamente");
                }
            });
        }
    });
});

$("#tabla-boletas").on("click", ".revisado",function(){
    $idboleta = $(this).attr("data-idboleta");
    sweetAlertConfirmQuestionSave("¿Aprobar Boleta?").then((confirm) => {
        if(confirm.isConfirmed){
            $.ajax({
                url: 'controllers/boleta.controller.php',
                type: 'GET',
                data: 'op=boletaRevisada&idboleta=' + $idboleta,
                success: function(e) {
                    listarBoletasRevisar();
                    alertSuccess("Registro enviado a revisión");
                }
            });
        }
    });
});

$("#tabla-boletas").on("click", ".editar", function(){
    idboleta = $(this).attr("data-idboleta");
    $.ajax({
        url: 'controllers/boleta.controller.php',
        type: 'GET',
        dataType: 'JSON',
        data: 'op=obtenerBoletasO&idboleta=' + idboleta,
        success: function(datos){
            idempleado = datos[0].idempleado;
            idinstitucion = datos[0].idinstitucion;

           
            
            $("#datosempleado")             .val(datos[0].empleado);
            $("#nombreInstitucion")         .val(datos[0].nombre);

            if(datos[0].activo == "Pensionista"){
                $("#tipo").val(0);
            }else{
                $("#tipo").val(1);
            }

            $("#nivel")                     .val(datos[0].nivel);
            $("#cargo")                     .val(datos[0].cargo);

            if(datos[0].tipoempleado == "Contratado"){
                $("#tipoEmpleado").val('C');
            }else if(datos[0].tipoempleado == "Nombrado"){
                $("#tipoEmpleado").val('N');
            }


            $("#anio")                      .val(datos[0].anio);
            
            if(datos[0].mes == "Enero"){
                $("#mes").val(1);
            }else if (datos[0].mes == "Febrero"){
                $("#mes").val(2);
            }else if (datos[0].mes == "Marzo"){
                $("#mes").val(3);
            }else if (datos[0].mes == "Abril"){
                $("#mes").val(4);
            }else if (datos[0].mes == "Mayo"){
                $("#mes").val(5);
            }else if (datos[0].mes == "Junio"){
                $("#mes").val(6);
            }else if (datos[0].mes == "Julio"){
                $("#mes").val(7);
            }else if (datos[0].mes == "Agosto"){
                $("#mes").val(8);
            }else if (datos[0].mes == "Setiembre"){
                $("#mes").val(9);
            }else if (datos[0].mes == "Octubre"){
                $("#mes").val(10);
            }else if (datos[0].mes == "Noviembre"){
                $("#mes").val(11);
            }else if (datos[0].mes == "Diciembre"){
                $("#mes").val(12);
            }

            $("#montoimponible")            .val(datos[0].montoimponible);

            if(datos[0].mes == "Unica"){
                $("#cantidad").val('U')
            }else if(datos[0].mes == "Adicional"){
                $("#cantidad").val('A')
            }

            $("#encargado").html(datos[0].usuarioregistro);
            $("#fecharegistro").html(datos[0].fecharegistro);
            $("#encargadom").html(datos[0].usuariomodifico);
            $("#fechamodifico").html(datos[0].fechamodifico); 

            // Cargar el PDF en el iframe
            if (datos[0].archivo_pdf) {
                $("#vista-pdf").attr("src", datos[0].archivo_pdf);
            } else {
                $("#vista-pdf").attr("src", "");
                alert("No hay un archivo PDF disponible.");
            }

            
            $("#modal-editarBoleta").modal('show');

            datosNuevos = false;

        }
    });

});

$("#tabla-boletas").on("click", ".comentario", function(){
    idboleta = $(this).attr("data-idboleta");

    var comentario = $(this).attr("data-comentario");

    if(comentario != "null"){
        $("#comentario").val(comentario);
    }else{
        $("#comentario").val('');
    }
    $("#modal-observaciones").modal('show');
});

$("#tabla-boletas").on("click", ".guardar", function(){
    idboleta = $(this).attr("data-idboleta");
    sweetAlertConfirmQuestionSave("¿Guardar para Revisión?").then((confirm) => {
        if(confirm.isConfirmed){
            $.ajax({
                url: 'controllers/boleta.controller.php',
                type: 'GET',
                data: 'op=boletaRevision&idboleta=' + idboleta,
                success: function(e) {
                    listarBoletasRevisar();
                    alertSuccess("Registro enviado a revisión");
                }
            });
        }
    });
});

$("#btnguardar").click(registrarBoletas);

//Actualizar las variables del controlador
function actualizardatosControlador(){
    datosControlador['search'] = $("#nombreempleado").val().trim();
    datosControlador['anio'] = $("#buscaranio").val();
}

$("#tabla-boletas").on("click", ".montos", function(){
    anioCalcular = $(this).attr("data-anio");
    idboleta = $(this).attr("data-idboleta");
    $("#campo").focus();
    $("#modal-montos").modal('show');
    listarIngresos();
    listarEgresos();
});

listarIngresos();
listarEgresos();
listarBoletasRevisar();
configFiltros();