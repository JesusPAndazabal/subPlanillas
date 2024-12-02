<?php

require_once '../models/Conceptos.php';
require_once '../models/Boletas.php';

if(isset($_GET['op'])){

    $concepto = new Concepto();
    $boleta = new Boleta();

function listarConceptos($data){
    if(count($data) <= 0){
        echo "<td>No hay datos</>";
    }else{
        foreach($data as $row){

            $anio = $row['anio'];
            $monto = $row['monto'];

            if($anio <= 1991){
                $numeroConvertido = number_format($monto,3);
            }else if($anio >=1992 ){
                $numeroConvertido = number_format($monto,2);
            }

            echo "
            <tr>
                <td>{$row['nombre']}</td>
                <td class='text-center'>$numeroConvertido</td>
                <td class='text-rigth'>  
                    <a  class='btn btn-outline-danger btn-sm  eliminar ' href='#' data-idconcepto='{$row['idconcepto']}'><i class='fas fa-trash'></i></a>  
                </td>
            </tr>
            ";
        }
    }
}

function listardetalleConceptos($data){
    if(count($data) <= 0){
        echo "<td>No hay datos</>";
    }else{
        foreach($data as $row){

            $anio = $row['anio'];
            $monto = $row['monto'];

            if($anio <= 1991){
                $numeroConvertido = number_format($monto,3);
            }else if($anio >=1992 ){
                $numeroConvertido = number_format($monto,2);
            }

            
            echo "
            <tr>
                <td>{$row['nombre']}</td>
                <td class='text-center'>$numeroConvertido</td>
            </tr>
            ";
        }
    }
}

if($_GET['op'] == 'registrarConceptos'){

    $datosEnviar = [
        "idboleta"      => $_GET['idboleta'],
        "idcampo"       => $_GET['idcampo'],
        "monto"         => $_GET['monto']
    ];

    $concepto->registrarConceptos($datosEnviar);
}

if($_GET['op'] == 'obtenerConcepto'){
    
    $data;

    $data = $concepto->obtenerConcepto(["idboleta" => $_GET['idboleta']]);

    listarConceptos($data);
}

//Obtener la vista en el registrar el ingresos
if($_GET['op'] == 'obtenerIngresos'){
    
    $data;

    $data = $concepto->obtenerIngresos(["idboleta" => $_GET['idboleta']]);

    listarConceptos($data);
}

//Ontener la vista en el detalle de ingresos
if($_GET['op'] == 'obtenerdetalleIngresos'){
    
    $data;

    $data = $concepto->obtenerIngresos(["idboleta" => $_GET['idboleta']]);

    listardetalleConceptos($data);
}

//Obtener la visya en el registrar egresos
if($_GET['op'] == 'obtenerEgresos'){
    
    $data;

    $data = $concepto->obtenerEgresos(["idboleta" => $_GET['idboleta']]);

    listarConceptos($data);

    
}


//Obtener la vista para el detalle del egresos
if($_GET['op'] == 'obtenerdetalleEgresos'){
    
    $data;

    $data = $concepto->obtenerEgresos(["idboleta" => $_GET['idboleta']]);

    listardetalleConceptos($data);
}

if($_GET['op'] == 'eliminarConceptos'){
    $data;

    $data = $concepto->eliminarConceptos(["idconcepto" => $_GET['idconcepto']]);
}


}

if(isset($_POST['op'])){
$concepto = new Concepto();
$boleta = new Boleta();

if($_POST['op'] == 'registrarConceptos'){

    $datosEnviar = [
        "idboleta"      => $_POST['idboleta'],
        "idcampo"       => $_POST['idcampo'],
        "monto"         => $_POST['monto']
    ];

    $concepto->registrarConceptos($datosEnviar);
}

}




?>