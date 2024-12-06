function listarPeriodos(){
    var tabla = $("#tabla-periodos").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-periodos").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/periodo.controller.php?op=listarPeriodos',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster
    });
} 


listarPeriodos();
