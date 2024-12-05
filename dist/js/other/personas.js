function listarPeronas(){
    var tabla = $("#tabla-personas").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-personas").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/personas.controller.php?op=listarPersonas',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster
    });
} 


listarPeronas();
