const contextnivelUsuario = $("#nivelesUsuario").get(0).getContext("2d");
const chartnivelUsuario = new Chart(contextnivelUsuario, {
  type: 'doughnut',
  data: {
    labels: ["Dem1", "Dem2", "Dem3"],
    datasets: [{
      label: 'Niveles de Usuario',
      data: [5, 60, 58],
      backgroundColor: listBgColor,
      borderColor: listBrColor,
      borderWidth: 1
    }],
  },
  options: optionsChart
});

const contextboletasUsuario = $("#boletasUsuario").get(0).getContext("2d");
const chartboletasUsuario = new Chart(contextboletasUsuario, {
  type: 'polarArea',
  data: {
    labels: [],
    datasets: [{
      label:'',
      data: [],
      backgroundColor: listBgColor,
      borderColor: listBrColor,
      borderWidth: 1
    }],
  },
  options: optionsChart
});

const contextoboletasEstado = $("#boletasEstado").get(0).getContext("2d");
const chartboletasEstado = new Chart(contextoboletasEstado, {
    type: 'pie',
    data: {
      labels : [],
      datasets : [{
        label : '',
        data : [],
        backgroundColor : listBgColor,
        borderColor : listBrColor,
        borderWidth : 1
      }],
    },
    options : optionsChart
});

// usuarios por niveles
function nivelesUsuario(dataSend) {
    let dataLabels = [];
    let dataSource = [];
  
    $.ajax({
      url: 'controllers/graficos.controller.php',
      type: 'GET',
      data: dataSend,
      success: function (result) {
        if (result == "") {
          chartnivelUsuario.data.labels = ["Sin datos"];
          chartnivelUsuario.data.datasets[0].data = [0];
          chartnivelUsuario.update();
        }
        else {
          let dataController = JSON.parse(result);
  
          // Recorrer el arreglo
          dataController.forEach(value => {
            dataLabels.push(value.nivelacceso);
            dataSource.push(value.Total);
          });
  
          // Asignando datos al gráfico
          chartnivelUsuario.data.labels = dataLabels;
          chartnivelUsuario.data.datasets[0].data = dataSource;
          chartnivelUsuario.update();
        }
      }
    }); // fin ajax
}

// Total de usuarioes por servicio
function boletasUsuario(dataSend) {

  let dataLabels = [];
  let dataSource = [];

  $.ajax({
    url: 'controllers/graficos.controller.php',
    type: 'GET',
    data: dataSend,
    success: function (result) {
      if (result == "") {
  
        chartboletasUsuario.data.labels = ["Sin datos"];
        chartboletasUsuario.data.datasets[0].label = 'Sin datos';
        chartboletasUsuario.data.datasets[0].data = [0];
        chartboletasUsuario.update();
      } else {

        let dataController = JSON.parse(result);
   
        // Recorrer el array
        dataController.forEach(value => {
          dataLabels.push(value.Usuario);
          dataSource.push(value.Total);
        });

        console.log(dataController);

        // Asignar datos al grafico
        chartboletasUsuario.data.labels = dataLabels;
        chartboletasUsuario.data.datasets[0].label = 'Boletas por usuario';
        chartboletasUsuario.data.datasets[0].data = dataSource;
        chartboletasUsuario.update();
      }
    }
  });
}

function boletasEstado(dataSend){
   let dataSource = [];
   let dataLabels = [];
   
   $.ajax({
      url: 'controllers/graficos.controller.php',
      type:'GET',
      data: dataSend,
      success: function (result){


        if(result == ""){
          chartboletasEstado.data.dataLabels = ["Sin datos"];
          chartboletasEstado.data.datasets[0].label = 'Sin datos';
          chartboletasEstado.data.datasets[0].data = [0];
          chartboletasEstado.update();
        }else{
  
           let dataController = JSON.parse(result);

           //Recorremos el array 
           dataController.forEach(value =>{
              dataLabels.push(value.estadoBoletas);
              dataSource.push(value.totalBoletas);
           });

           console.log(dataController);

           chartboletasEstado.data.labels = dataLabels;
           chartboletasEstado.data.datasets[0].label = dataLabels;
           chartboletasEstado.data.datasets[0].data = dataSource;
           chartboletasEstado.update();

        }
      }
   });

}


// Filtrar por fecha
$("#filtered").click(function () {
  if (datesIsEmpty()) {
    alertWarning("Fechas no validas");
  } else {
    if(!dateIsValid()){
      alertError("Fecha de inicio no puede ser mayor o igual al final");
    } else {
      let dates = getDatesFilter();
    
      // Grafico 3
      nivelesUsuario({
        op: 'nivelesUsuario',
        fechainicio: dates.dateStart,
        fechafin: dates.dateEnd
      });

      boletasUsuario({
        op: 'boletasUsuario',
        fechainicio: dates.dateStart,
        fechafin: dates.dateEnd
      });

      boletasEstado({
        op: 'boletasEstado',
        fechainicio: dates.dateStart,
        fechafin: dates.dateEnd
      });

      
    }
  }
});

// Datos por defecto
$("#default").click(function () {
  boletasUsuario({ op: 'boletasUsuario' });
  nivelesUsuario({ op: 'nivelesUsuario' });
  boletasEstado({ op: 'boletasEstado' });
/*   $("#year-start").val('');
  $("#month-start").val('');
  $("#year-end").val('');
  $("#month-end").val(''); */
});

// Obtener fecha
function getDatesFilter() {
  let yearStart = $("#year-start").val();
  let monthStart = $("#month-start").val();
  let yearEnd = $("#year-end").val();
  let monthEnd = $("#month-end").val();

  monthStart = monthStart < 10 ? "0" + monthStart : monthStart;
  monthEnd = monthEnd < 10 ? "0" + monthEnd : monthEnd;

  let dates = {
    dateStart: yearStart + "-" + monthStart + "-" + "01",
    dateEnd: yearEnd + "-" + monthEnd + "-" + "01"
  }

  return dates;
}

// validar fechas obtenidas
function datesIsEmpty() {
  return $("#year-start").val() == "" || $("#month-start").val() == "" || $("#year-end").val() == "" || $("#month-end").val() == "";
}

// Comprueba fechas validas
function dateIsValid(){
  let yearStart = $("#year-start").val();
  let yearEnd = $("#year-end").val();
  let monthStart = $("#month-start").val();
  let monthEnd = $("#month-end").val();

  return (yearStart < yearEnd) || (yearStart == yearEnd && parseInt(monthStart) < parseInt(monthEnd));
}

  nivelesUsuario({ op: 'nivelesUsuario' });
  boletasUsuario({ op: 'boletasUsuario' });
  boletasEstado({ op: 'boletasEstado' });