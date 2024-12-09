function listarCargos(){
    var tabla = $("#tabla-cargos").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-cargos").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/cargos.controller.php?op=listarCargos',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster
    });
} 


listarCargos();
