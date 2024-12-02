<?php

require_once '../core/model.master.php';

class Boleta extends ModelMaster {

public function listarBoletas(){
    try{
        return parent::getRows("spu_listar_boletas");
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function obtenerBoleta(array $data){
    try{
        return parent::execProcedure($data, "spu_obtener_boletas" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function obtenerBoletaR(array $data){
    try{
        return parent::execProcedure($data, "spu_obtener_boletasR" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function obtenerConsultas(array $data){
    try{
        return parent::execProcedure($data, "spu_obtenerConsulta" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function obtenerBoletaAlterna(array $data){
    try{
        return parent::execProcedure($data, "spu_obtener_boletaAlterna" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function obtenerBoletaO(array $data){
    try{
        return parent::execProcedure($data, "spu_obtener_boletasO" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function validarBoleta(array $data){
    try{
        return parent::execProcedure($data , "spu_validarBoleta", true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function buscarboletaEmpleados(array $data){
    try{
        return parent::execProcedure($data , "spu_buscarBoletaempleados", true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function buscarfechaEmpleados(array $data){
    try{
        return parent::execProcedure($data , "spu_buscafechaempleados" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function buscarfechaEmpleadosRevisar(array $data){
    try{
        return parent::execProcedure($data , "spu_buscafechaempleadosRevisar" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function buscarfechaObservadas(array $data){
    try{
        return parent::execProcedure($data , "spu_buscafechaObservadas" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function buscarAnioEmpleados(array $data){
    try{
        return parent::execProcedure($data , "spu_buscarAnioempleados" , true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function registrarBoletas(array $data){
    try{
        return parent::execProcedure($data , "spu_registrar_boletas", true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function actualizarBoletas(array $data){
    try{
        parent::execProcedure($data, "spu_modificar_boletas", false);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function listarUltimoRegistro(array $data){
    try{
        return parent::execProcedure($data,"spu_listarUltimoregistro", true);
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function boletaRevisada(array $data){
    try{
            parent::deleteRegister($data, "spu_boletaRevisada");
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function boletaObservada(array $data){
    try{
            parent::deleteRegister($data, "spu_boletaObservada");
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function boletaRevision(array $data){
    try{
            parent::deleteRegister($data, "spu_boletaRevision");
    }catch(Exception $error){
        die($error->getMessage());
    }
}

public function eliminarBoletas(array $data){
    try{
            parent::deleteRegister($data, "spu_eliminar_boletas ");
    }catch(Exception $error){
        die($error->getMessage());
    }
}


    

}

?>