function listarRegimenes(){
    var tabla = $("#tabla-regimenes").DataTable();
    tabla.destroy();    

    tabla = $("#tabla-regimenes").DataTable({
        "processing"    : true,
        "order"         : [[0, "desc"]],
        "serverSide"    : true,
        "sAjaxSource"   : 'controllers/regimenLaboral.controller.php?op=listarRegimenes',
        "lengthChange"  : true,
        "pageLength"    : 8,
        "language"      : { url : '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
        "dom"           : domTableComplete,
        "buttons"       : buttonsTableMaster
    });
} 


listarRegimenes();
