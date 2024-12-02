<?php

require_once '../core/model.master.php';

class Campo extends ModelMaster{

    public function buscarCampos(array $data){
        try{
            return parent::execProcedure($data , "spu_buscar_campos", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }


}

?>