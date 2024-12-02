
/* 
* ================================================
* CONFIGURACIÓN DE BOTONES
* ================================================
* */
var buttonsTableMaster = [{
  extend : 'excel',
  text : 'Excel <i class="fas fa-file-excel"></i>',
  titleAttr: 'Exportar Excel',
  className: 'btn btn-success',
  exportOptions: {
      columns: ':visible'
  }
},
{
  extend : 'pdf',
  text : 'PDF <i class="fas fa-file-pdf"></i>',
  titleAttr: 'Exportar PDF',
  className: 'btn btn-danger',
  exportOptions: {
      columns: ':visible'
  }
},
{
  extend : 'print',
  text : 'Imprimir<i class="fas fa-print ml-1"></i>',
  titleAttr: 'Imprimir',
  className: 'btn btn-info',
  exportOptions: {
      columns: ':visible'
  }
}

];


/* 
* ================================================
* CONFIGURACIÓN DEL DOM  
* ================================================
* */
var domtableBasic = '<"top mb-3 d-flex flex-wrap justify-content-sm-between justify-content-center"Brl><"top d-flex flex-wrap justify-content-sm-end justify-content-end"t>tr<"bottom d-flex flex-wrap justify-content-sm-between justify-content-center"ip><"clear">';
var domTableComplete = '<"top mb-3 d-flex flex-wrap justify-content-sm-between justify-content-center"Brfl><"top d-flex flex-wrap justify-content-sm-end justify-content-end"t>tr<"bottom d-flex flex-wrap justify-content-sm-between justify-content-center"ip><"clear">';

/* 
* ================================================
* CONFIGURACIÓN PARA LOS COLUMNDEFS 
* ================================================
* */

var columnDefsConsulta = [
  {
      "data"   : null,
      render : function(data, type, row){
          return `
          <div class="btn-group">
              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  Acciones
              </button>
              <div class="dropdown-menu">
                  <a class="dropdown-item detalle" data-anio ='${data[8]}' data-mimponible ='${data[12]}' data-usuarioRegistro='${data[10]}'  data-idboleta='${data[0]}' href="#"><i class='fas fa-eye mr-2'></i>Montos</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item reporte" data-idboleta='${data[0]}' href="#"><i class='fas fa-print mr-2'></i>Reporte</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item eliminar" data-idboleta='${data[0]}' href="#"><i class='fas fa-trash mr-2'></i>Eliminar</a>
              </div>
          </div>`;
      },
      "targets"    : 10
  },
    /* {
        "data"   : null,
        render : function(data, type, row){
            return `
            <div class="form-check text-center">
            <input class="form-check-input seleccionReporte" data-idboleta='${data[0]}'  type="checkbox"  id="seleccionReporte">
            <label class="form-check-label" for="defaultCheck1">
            </label>
            </div>
            `;
        },
        "targets"    : 11
    }, */

  {
      "data"   : null,
      render : function(data, type, row){

          $tipo = row[7];


          if($tipo == "Activo"){
              $tipo = '<span class="badge badge-primary">Activo</span>';
          }else if($tipo == "Pensionista"){
              $tipo = '<span class="badge badge-warning">Pensionista</span>';
          }
          p
          return `${$tipo}`;
      },
      "targets"    : 7
  },

  {
      "visible" : false , "targets" : 1
  },
  {
      "visible" : false , "targets" : 4
  }
]

var columnDefsInstituciones = [
  {
      "data"   : null,
      render : function(data, type, row){
          return `<a class='btn btn-sm btn-info modificar' data-idinstitucion='${data[0]}' href='#'><i class='fas fa-edit'></i></a>`;
      },
      "targets"    : 5
  }
]

var columnDefsEmpleados = [
  {
      "data"   : null,
      render : function(data, type, row){
          return `<a class='btn btn-sm btn-info modificar' data-idempleado='${data[0]}' href='#'><i class='fas fa-edit'></i></a>`;
      },
      "targets"    : 5    
  }
]

var columnDefsRevision = [
  {
      "data"   : null,
      render : function(data, type, row){
          return `<a class='btn btn-sm btn-info montos' data-anio ='${data[8]}' data-idboleta='${data[0]}' href='#'>Registrar Montos</a>`;
      },
      "targets"    : 11
  },
  {
      "data"   : null,
      render : function(data, type, row){
          

          $usuariomodifico = data[12];

          if ($usuariomodifico == null){
              $usuariomodifico = "Sin modificar";
          }else{
              $usuariomodifico = data[12];
          }


          return `<a class='btn btn-sm btn-outline-primary revisado' data-idboleta='${data[0]}' href='#'><i class="fas fa-check"></i></a>
          <a class='btn btn-sm btn-outline-danger observar' data-idboleta='${data[0]}' href='#'><i class='fas fa-times'></i></a>
          <a class='btn btn-sm btn-outline-success editar' data-idboleta='${data[0]}' data-usuario='${data[11]}' data-usuariom = '${$usuariomodifico}'  href='#'><i class='fas fa-edit'></i></a>
          <a href='${data[11]}' target='_blank'>
                    <i class='fas fa-file-pdf' style='font-size: 1.5em; color: #e74c3c;'></i>
            </a>`;
      },
      "targets"    : 12
  },

  {
      "data"   : null,
      render : function(data, type, row){

          $tipo = row[7];

        

          if($tipo == "Activo"){
              $tipo = '<span class="badge badge-primary">Activo</span>';
          }else if($tipo == "Pensionista"){
              $tipo = '<span class="badge badge-warning">Pensionista</span>';
          }
          
          return `${$tipo}`;
      },
      "targets"    : 7
  },
  {
      "visible" : false , "targets" : 1
  },
  {
      "visible" : false , "targets" : 4
  },
  {
      "visible" : false , "targets" : 10
  }
]

var columnDefsObservadas = [
  {
      "data"   : null,
      render : function(data, type, row){
          console.log(data[8]);
          return `<a class='btn btn-sm btn-info montos' data-anio ='${data[8]}' data-idboleta='${data[0]}' href='#'>Registrar Montos</a>`;
      },
      "targets"    : 11
  },
  {
      "data"   : null,
      render : function(data, type, row){
          
         

          return `<a class='btn btn-sm btn-success editar' data-idboleta='${data[0]}'  href='#'><i class='fas fa-edit'></i></a>
          <a class='btn btn-sm btn-warning comentario ' data-idboleta='${data[0]}'  data-comentario = '${data[10]}' href='#'><i class="fas fa-comment-dots"></i></a>
          <a class='btn btn-sm btn-primary guardar' data-idboleta='${data[0]}'  href='#'><i class="fas fa-save"></i></a>`;
      },
      "targets"    : 12
  },

  {
      "data"   : null,
      render : function(data, type, row){

          $tipo = row[7];

        

          if($tipo == "Activo"){
              $tipo = '<span class="badge badge-primary">Activo</span>';
          }else if($tipo == "Pensionista"){
              $tipo = '<span class="badge badge-warning">Pensionista</span>';
          }
          
          return `${$tipo}`;
      },
      "targets"    : 7
  },
  {
      "visible" : false , "targets" : 1
  },
  {
      "visible" : false , "targets" : 4
  },
  {
      "visible" : false , "targets" : 10
  }
]

