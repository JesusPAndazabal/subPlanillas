<?php

require_once '../core/model.master.php';

class Licencia extends ModelMaster{

    public function obtenerLicencias(array $data){
        try{
            return parent::execProcedure($data , "spu_obtener_licencias",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function actualizarFecha(array $data){
        try{
            parent::execProcedure($data, "spu_modificar_fechaLicencia", false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }


}

?>