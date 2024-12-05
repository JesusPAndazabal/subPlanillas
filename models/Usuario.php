<?php

require_once '../core/model.master.php';

class Usuario extends ModelMaster{

    //Login - siempre array 
    public function login(array $data){

        try{    
           return parent::execProcedure($data,"spu_usuarios_login", true);   
        } catch(Exception $error){
            die($error->getMessage());
        }
       
    }

    public function actualizarClave(array $data){

        try{    
           parent::execProcedure($data,"spu_usuarios_actualizarclave", false);   
        } catch(Exception $error){
            die($error->getMessage());
        }
       
    }

    public function listarUsuarios(){
        try{
            return parent::getRows("spu_listar_usuarios");
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function validarCorreo(array $data){
        try{
            return parent::execProcedure($data , "spu_validarCorreo", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function validarDni(array $data){
        try{
            return parent::execProcedure($data , "spu_validarDni", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function obtenerUsuario(array $data){
        try{
            return parent::execProcedure($data, "spu_usuarios_obtener" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function registrarUsuario(array $data){
        try{
            return parent::execProcedure($data ,"spu_registrar_usuario", true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function actualizarUsuario(array $data){
        try{
            parent::execProcedure($data,"spu_modificar_usuarios", false);
        }catch(Exception $error){   
            die($error->getMessage());
        }
    }

    public function eliminarUsuario (array $data){
        try{
            parent::deleteRegister($data, "spu_eliminarUsuario",false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarUsuarios(array $data){
        try{
            return parent::execProcedure($data , "spu_buscarUsuarios" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function estadoUsuario(array $data){
        try{
            parent::execProcedure($data , "spu_estadoUsuario" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function buscarUsuarioRol(array $data){
        try{
            return parent::execProcedure($data , "spu_buscarUsuariosRol" , true);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function nivelAdmin(array $data){
        try{
            parent::execProcedure($data , "spu_nivelAdmin" , false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

    public function nivelUsuario(array $data){
        try{
            parent::execProcedure($data , "spu_nivelUsuario" , false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }
    
    public function nivelRevisador(array $data){
        try{
            parent::execProcedure($data , "spu_nivelRevisador" , false);
        }catch(Exception $error){
            die($error->getMessage());
        }
    }

}



?>