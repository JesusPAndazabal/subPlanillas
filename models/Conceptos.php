<?php

require_once '../core/model.master.php';

class Concepto extends ModelMaster{ 

    public function obtenerConcepto(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_concepto" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    
}

?>