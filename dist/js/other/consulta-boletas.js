

//Declaraciones de variables globales
var totalingresos;
var totalegresos;
var totalliquido;
var idboleta =  -1;
var montoimponible;
var monto;
let anioCalcular;
const idboletas = [];



function configFiltros(){

    $("#card-filtros").addClass('collapsed-card');
    $("#mostrarFiltro").html("Mostrar filtro<i class='fas fa-plus ml-2'></i>");
}

//Lista las boletas - Serverside
function listarBoletas(){

    var tabla = $("#tabla-boletas").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-boletas").DataTable({
        "processing"    : true,
        "responsive"    : true,
        "autoWidth"     : false,
        "ordering"      : false,
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/boleta.controller.php?op=listadoBoletas',
        "pageLength"    : 8,
        "lengthChange"  : true,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "searching"     : true,
        "dom"           : domtableBasic,
        "buttons"       : buttonsTableMaster,
        "columnDefs"    : columnDefsConsulta
    });
} 

//calcular los ingresos con 2 decimales
function calcularIngresos(){
    
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = parseFloat(table.column(1).data().sum()).toFixed(2);
    totalliquido = parseFloat(totalingresos - totalegresos).toFixed(2);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

//calcula los ingresos con 3 decimales
function calcularIngresosIntis(){
    var table = $("#tabla-ingresos").DataTable();
    totalingresos = table.column(1).data().sum().toFixed(3);
    totalliquido = (totalingresos - totalegresos).toFixed(3);
    $("#totalhaberes").val(totalingresos);
    $("#totalliquido").val(totalliquido);
}

//Listar todos los Ingresos para el detalle de la boleta
function listarIngresos(){
    $.ajax({
        url:'controllers/conceptos.controller.php',
        type: 'GET',
        data: 'op=obtenerdetalleIngresos&idboleta=' + idboleta,
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

//Listar todos los Egresos para el detalle de la boleta
function listarEgresos(){
    $.ajax({
        url:'controllers/conceptos.controller.php',
        type: 'GET',
        data: 'op=obtenerdetalleEgresos&idboleta=' + idboleta,
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
                    ordering: false,
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

    $("#buscaranio").val('');
    $("#nombreempleado").val('').focus();

    listarBoletas();
});



//Evento para el check de seleccion de reporte
/* $("#tabla-boletas").on("click", ".seleccionReporte", function(){
    
    let seleccionReporte = $("#seleccionReporte").is(":checked");

    if(seleccionReporte == true){
        let idboleta = $(this).attr("data-idboleta");
        idboletas.push(idboleta);
        // console.log(idboletas);
        console.log(seleccionReporte);
    }else if (seleccionReporte == false){
        console.log("Sin seleccion");
        console.log(seleccionReporte);
    }

}); */


//Icono para observar el detalle
$("#tabla-boletas").on("click", ".detalle", function(){
    
    idboleta = $(this).attr("data-idboleta");
    anioCalcular = $(this).attr("data-anio");
    usuarioRegistro = $(this).attr("data-usuarioRegistro");
    let montoimponible = $(this).attr("data-mimponible");

    $("#montoimponible").val(montoimponible);

    $("#modal-detalle").modal('show');

    $("#encargado").html(usuarioRegistro);
    
    listarIngresos();
    listarEgresos();

});

$("#tabla-boletas").on("click", ".reporte", function(){
    idboleta = $(this).attr("data-idboleta");
    window.open("reports/reporte/"+idboleta);
});

$("#tabla-boletas").on("click", ".eliminar" , function(){
     $idboleta = $(this).attr("data-idboleta");
    
     sweetAlertConfirmQuestionSave("¿Estas seguro de eliminar este registro ?").then((confirm) => {
        if(confirm.isConfirmed){
            $.ajax({
                url: 'controllers/boleta.controller.php',
                type: 'GET',
                data: 'op=eliminarBoleta&idboleta=' + $idboleta,
                success: function(e) {
                    listarBoletas();
                    alertSuccess("Eliminado correctamente");
                }
            });
        }
    });
});

$("#tabla-boletas").on("click", ".constancia", function(){
    idboleta = $(this).attr("data-idboleta");
    window.open("reports/reporteConstancia.php?idboleta="+idboleta);

});

$("#tabla-boletas").on("click", ".reporte", function(){

    idboleta = $(this).attr("data-idboleta");
    window.open("reports/reporte/"+idboleta);
});


listarEgresos();
listarIngresos();
listarBoletas();
configFiltros();