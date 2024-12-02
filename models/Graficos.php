<?php

require_once '../core/model.master.php';

class Grafico extends ModelMaster{


//niveles de usuario
public function nivelesUsuario(){
    try{
      return parent::getRows("nivelesUsuario");
    }
    catch(Exception $error){
      die($error->getMessage());
    }
}

// Niveles de usuario por fecha
public function nivelesUsuarioFecha(array $data){
  try{
    return parent::execProcedure($data, "spu_nivlesUsuario_fecha", true);
  }
  catch(Exception $error){
    die($error->getMessage());
  }
}

//boletas por usuario registradas
public function boletasUsuario(){
    try{
      return parent::getRows("spu_boletasUsuario");
    }
    catch(Exception $error){
      die($error->getMessage());
    }   
}

//boletas pos usuario registradas por fecha
public function boletasUsuarioFecha(array $data){
  try{
    return parent::execProcedure($data, "spu_boletasUsuarioFecha", true);
  }
  catch(Exception $error){
    die($error->getMessage());
  }
}

//total de boletas por revisar , revisadas y observadas
public function boletasEstado(){
  try{
    return parent::getRows("spu_boletasEstado");
  }
  catch(Exception $error){
    die($error->getMessage());
  }
}

public function boletasEstadoFecha(array $data){
  try{
    return parent::execProcedure($data , "spu_boletasEstadoFecha" , true);
  }
  catch(Exception $error){
    die($error->getMessage());
  }
}


}
?>