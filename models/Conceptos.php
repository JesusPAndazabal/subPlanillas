<?php

require_once '../core/model.master.php';

class Concepto extends ModelMaster{

    public function obtenerConcepto(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_conceptos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerIngresos(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_ingresos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerIngresosCol1(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_ingresosCol1" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerIngresosCol2(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_ingresosCol2" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerEgresos(array $data){
        try{
            return parent::execProcedure($data, "spu_obtener_egresos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function registrarConceptos(array $data){
        try{
            return parent::execProcedure($data, "spu_registrar_conceptos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function eliminarConceptos(array $data){
        try{
             parent::deleteRegister($data, "spu_eliminar_concepto");
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function sumarIngresos(array $data){
        try{
            return parent::execProcedure($data, "spu_sumarIngresos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function sumarEgresos(array $data){
        try{
            return parent::execProcedure($data, "spu_sumarEgresos" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
}





?>