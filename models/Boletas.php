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

}

?>