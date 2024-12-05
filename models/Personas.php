<?php

require_once '../core/model.master.php';

class Persona extends ModelMaster{

    //Buscar dni del empleado
    public function buscardniPersona(array $data){
        try{
            return parent::execProcedure($data , "spu_buscardni_persona",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }
        
}

?>