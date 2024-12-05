<?php

require_once '../core/model.master.php';

class Periodo extends ModelMaster {

    public function registrarPeriodos(array $data) {
        try {
            // Ejecutamos el procedimiento y almacenamos el último ID insertado
            $result = parent::execProcedure($data, "spu_registrar_periodo", true);
            
            // Verificamos si result es un array y obtenemos el primer valor (ID)
            if (is_array($result) && isset($result[0]['periodo_id'])) {
                return $result[0]['periodo_id']; // Devolvemos el valor del ID
            } else {
                throw new Exception("No se obtuvo un ID válido");
            }
        } catch (Exception $error) {
            die($error->getMessage());
        }
    }
}
?>
