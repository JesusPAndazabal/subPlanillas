<?php

//Requerimos del modelo maestro
require_once '../core/model.master.php';

class Institucion extends ModelMaster{

    public function listarInstituciones(){
        try{
            return parent::getRows("spu_listar_instituciones"); 
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerInstitucion(array $data){
        try{
            return parent::execProcedure($data , "spu_instituciones_obtener", true); 
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function registrarInstitucion(array $data){
        try{
            return parent::execProcedure($data,"spu_registrar_instituciones", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function actualizarInstitucion(array $data){
        try{
            parent::execProcedure($data, "spu_modificar_instituciones",false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function eliminarInstitucion(array $data){
        try{
            parent::deleteRegister($data,"spu_instituciones_eliminar");
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarEstadoInstitucion(array $data){
        try{
            return parent::execProcedure($data, "spu_buscar_nombres_estado", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarNombreInstitucion(array $data){
        try{
            return parent::execProcedure($data, "spu_buscar_instituciones", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    
    public function buscarcodigoInstitucion(array $data){
        try{
            return parent::execProcedure($data , "spu_buscar_codigoInstitucion", true); 
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarInstituciones(array $data){
        try{
            return parent::execProcedure($data , "spu_instituciones_buscar", true); 
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    
}



?>