<?php

require_once '../core/model.master.php';

class Boleta extends ModelMaster {

    public function buscarplanillaDni(array $data){
        try{
            return parent::execProcedure($data , "spu_buscarDniPlanilla",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    //Obtener el registro por el id de la boleta
    public function obtenerBoleta(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_boleta" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    

}

?>