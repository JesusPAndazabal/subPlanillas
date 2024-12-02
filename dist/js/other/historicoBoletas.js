function listarHistoricoBoletas(){
    var tabla = $("#tabla-historico").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-historico").DataTable({
        "processing"    : true,
        "ordering"      : false,
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/boleta.controller.php?op=listarHistoricoBoletas',
        "pageLength"    : 10,
        "lengthChange"  : true,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : 'Bfrtip',
        "buttons"       : [ 'print', 'excel', 'pdf' ],
/*         "columnDefs"    : [
            {
                "data"   : null,
                render : function(data, type, row){
                    return `<a class='btn btn-sm btn-info modificar' data-idinstitucion='${data[0]}' href='#'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-sm btn-danger' data-id='${data[0]}' href='#'><i class='fas fa-trash'></i></a>`;
                },
                "targets"    : 5
            }
        ] */
    });
} 

listarHistoricoBoletas();