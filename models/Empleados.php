<?php

require_once '../core/model.master.php';

class Empleado extends ModelMaster{

    public function listarEmpleados(){
        try{
           return parent::getRows("spu_listar_empleados");
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerEmpleados(array $data){
        try{
            return parent::execProcedure($data , "spu_empleados_obtener",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function registrarEmpleados(array $data){
        try{
            return parent::execProcedure($data, "spu_registrar_empleados", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function actualizarEmpleados(array $data){
        try{
            parent::execProcedure($data, "spu_modificar_empleados", false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarEmpleados(array $data){
       try{
            return parent::execProcedure($data, "spu_buscar_empleados", true);
       }catch(Exception $error){
            die($error->getMessage());
       } 
    }

    public function buscarProfesoresNivel(array $data){
        try{
            return parent::execProcedure($data, "spu_buscar_profesores_nivel" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarcodigoModular(array $data){
        try{
            return parent::execProcedure($data , "spu_buscarcodigoModular",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function busquedaEmpleados(array $data){
        try{
            return parent::execProcedure($data , "spu_empleados_buscar", true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    //Buscar dni del empleado
    public function buscardniEmpleado(array $data){
        try{
            return parent::execProcedure($data , "spu_buscardni_empleado",true);

        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    
}

?>