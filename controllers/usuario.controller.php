<?php

session_start();

require_once '../models/Usuario.php';

if(isset ($_GET['op'])){

    $usuario = new Usuario();

    function listarUsuarios($data){
        if(count($data) <= 0){
            echo "<td>No hay datos en esta tabla</td>";
        }else{
            foreach($data as $row){

                $nivelacceso = $row['nivelacceso'];
                $estado = $row['estado'] == '1' ? 'checked' : '0';

                if($nivelacceso == "A"){
                    $nivelacceso = "Administrador";
                    $menu = "<button class='dropdown-item usuario' data-idusuario='{$row['idusuario']}' type='button'>Usuario</button>
                    <button class='dropdown-item revisador' data-idusuario='{$row['idusuario']}'  type='button'>Revisador</button>";
                }else if($nivelacceso == "C"){
                    $nivelacceso = "Usuario-Consultas";
                    $menu = "<button class='dropdown-item admin' data-idusuario='{$row['idusuario']}'  type='button'>Administrador</button>
                    <button class='dropdown-item revisador' data-idusuario='{$row['idusuario']}' type='button'>Revisador</button>";
                }

                echo "
                    <tr>
                        <td>{$row['idusuario']}</td>
                        <td>{$row['nomuser']}</td>
                        <td>{$row['correo']}</td>
                        <td class='text-success text-bold'>$nivelacceso</td>
                        <td>
                            <div class='custom-control custom-switch'>
                                <input type='checkbox' class='custom-control-input switch-role estado' data-idusuario='{$row['idusuario']}' {$estado}>
                                <label class='custom-control-label' for='{$row['idusuario']}'></label>
                            </div>
                        </td>
                    </tr>
                ";

                
            }
        }
    }

    if($_GET['op'] == 'login'){
        $resultado = $usuario->login(["nomuser" => $_GET['nomuser']]);

        if($resultado){
            

            $registro = $resultado[0];
            //var_dump($registro);

            //Savems que el usuario existe
            $claveValidar = $_GET['claveacceso'];


            if(password_verify($claveValidar, $registro['claveacceso'])){

                $_SESSION['acceso'] =  true;

                $rol = $registro['nivelacceso'];

                if($rol == 'A'){
                    $rol = "Administrador";
                }elseif($rol == 'C'){
                    $rol = "Consultas";
                } elseif($rol == 'S'){
                    $rol = "SuperAdmin";
                } 


               //La clave es correcta
               $_SESSION['idusuario'] = $registro['idusuario'];
               $_SESSION['nomuser'] = $registro['nomuser'];
               $_SESSION['claveacceso'] = $registro['claveacceso'];
               $_SESSION['nivelacceso'] = $rol;

             


            }else{
                $_SESSION['acceso'] =  false;
                $_SESSION['idusuario'] = '';
                $_SESSION['nomuser'] = '';
                $_SESSION['claveacceso'] ='';
                $_SESSION['nivelacceso'] ='';

                echo "La clave ingresada es incorrecta";
            }


        }else{
                $_SESSION['acceso'] =  false;
                $_SESSION['idusuario'] = '';
                $_SESSION['nomuser'] = '';
                $_SESSION['claveacceso'] ='';
                $_SESSION['nivelacceso'] ='';

            echo "El usuario no existe";
        }
       
    }

    if($_GET['op'] == 'cerrar-sesion'){
        session_destroy();
        session_unset();
        header('Location:../');
    }

    if($_GET['op'] == 'listarUsuarios'){
    
        $data;

        if ($_GET['nivelacceso'] == '')
        $data = $usuario->buscarUsuarios(["search" => $_GET['search']]);
        else
        $data = $usuario->buscarUsuarioRol(["nivelacceso" => $_GET['nivelacceso'], "search" => $_GET['search']]);

        listarUsuarios($data);
    }

    if($_GET['op'] == 'validarCorreo'){
        $data = $usuario->validarCorreo(["correo" => $_GET['correo']]);
      
        if(count($data) == 0){
          echo 2;
          return true;
        }else{
          echo 1;
          return false;
        }
    }

    if($_GET['op'] == 'validarDni'){
        $data = $usuario->validarDni(["numerodni" => $_GET['numerodni']]);
      
        if(count($data) == 0){
          echo 2;
          return true;
        }else{
          echo 1;
          return false;
        }
    }

    if($_GET['op'] == 'obtenerUsuario'){
        $data = $usuario->obtenerUsuario(["idusuario" => $_GET['idusuario']]);

        if($data){
            echo json_encode($data);
        }
    }

    if($_GET['op'] == 'nivelAdmin'){
        $data;

        $data = $usuario->nivelAdmin(["idusuario" => $_GET['idusuario']]);
    }

    if($_GET['op'] == 'nivelUsuario'){
        $data;

        $data = $usuario->nivelUsuario(["idusuario" => $_GET['idusuario']]);
    }

    if($_GET['op'] == 'nivelRevisador'){
        $data;

        $data = $usuario->nivelRevisador(["idusuario" => $_GET['idusuario']]);
    }

    if($_GET['op'] == 'estadoUsuario'){
        $data;

        $data = $usuario->estadoUsuario(["idusuario" => $_GET['idusuario'] , "estado" => $_GET['estado']]);
    }

    if($_GET['op'] == 'actualizarClave'){

        $claveaccesoAntigua = $_GET['claveaccesoAntigua'];
        $claveaccesoNueva   = $_GET['claveaccesoNueva'];

        if(password_verify($claveaccesoAntigua, $_SESSION['claveacceso'])){
            
            $datos = [
                "idusuario"     => $_SESSION['idusuario'] , 
                "claveacceso"   => password_hash($claveaccesoNueva, PASSWORD_BCRYPT)
            ];
            
            $usuario->actualizarClave($datos);
            echo "";

        }else{
            echo "La clave anterior  no es correcta";
        }
    }
}

if(isset($_POST['op'])){

    $usuario = new Usuario();

    /* if($_POST['op'] == 'registrarPersona'){

    
        $datosEnviar = [
            "tipoDoc"               => $_POST['tipoDoc'],
            "numeroDoc"             => $_POST['numeroDoc'],
            "nombres"               => $_POST['nombres'],
            "apellidosMat"          => $_POST['apellidosMat'],
            "apellidosPat"          => $_POST['apellidosPat'],
            "provincia"             => $_POST['provincia'],
            "region"                => $_POST['region'],
            "distrito"              => $_POST['distrito'],
            "direccion"             => $_POST['direccion'],
            "telefono"              => $_POST['telefono'],
            "correo"                => $_POST['correo'],
            "ruc"                   => $_POST['ruc'],
            "numCuenta"             => $_POST['numCuenta'],
            "regiPensionario"       => $_POST['regiPensionario'],
            "fechaFiliacionAfp"     => $_POST['fechaFiliacionAfp'],
            "cussp"                 => $_POST['cussp'],
            "tipoComision"          => $_POST['tipoComision'],
        ];

        $usuario->registrarPersona($datosEnviar);
        echo $datosEnviar;
    }

    if($_POST['op'] == 'registrarUsuario'){

        $datosEnviar = [
            "nomuser"       => $_POST['nomuser'],
            "correo"        => $_POST['correo'],
            "telefono"      => $_POST['telefono'],
            "nivelacceso"   => $_POST['nivelacceso']
        ];

        $usuario->registrarUsuario($datosEnviar);
    } */

    if($_POST['op'] == 'actualizarUsuario'){


        $datosEnviar = [
            "idusuario"     => $_SESSION['idusuario'],
            "nomuser"       => $_POST['nomuser'],
            "correo"        => $_POST['correo'],
            "nivelacceso"   => $_POST['nivelacceso'],
            "telefono"      => $_POST['telefono']

        ];

        $usuario->actualizarUsuario($datosEnviar);
    }

    if($_POST['op'] == 'registrarUsuario'){

        $datosEnviar = [
            "nomuser"       => $_POST['nomuser'],
            "correo"        => $_POST['correo'],
            "telefono"      => $_POST['telefono'],
            "nivelacceso"   => $_POST['nivelacceso']
        ];

        $usuario->registrarUsuario($datosEnviar);
    }

}
  
?>