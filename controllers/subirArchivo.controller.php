<?php

ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Conexión a la base de datos
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "db_archiPlanillas"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_POST['op'] == 'importarArchivo') {
    if (isset($_FILES['archivoLis']) && $_FILES['archivoLis']['error'] == 0) {
        $archivo = $_FILES['archivoLis']['tmp_name'];

        $handle = fopen($archivo, 'r');
        if (!$handle) {
            echo json_encode(['success' => false, 'message' => 'No se pudo abrir el archivo.']);
            exit();
        }

        $registrosInsertados = 0;

        while (($linea = fgets($handle)) !== false) {
            if (preg_match('/^(Nombres|Apellidos|Documento de Identidad|Provincia|Región|Distrito|Dirección|Teléfono|Correo|RUC|Número de cuenta|Registro Pensionario|Fecha de Afiliación|CUSSP|Entidad Bancaria)/i', $linea)) {
                
                $persona = [];

                // Extraer los campos de la línea
                if (preg_match('/^Nombres\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['nombres'] = trim($matches[1]);
                }
                if (preg_match('/^Apellidos\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['apellidos'] = trim($matches[1]);
                }
                if (preg_match('/\((Lib\.Electoral o D\.N\.)\)\s*(\d{8})/', $linea, $matches)) {
                    $persona['numeroDoc'] = trim($matches[2]);
                }
                if (preg_match('/\((Lib\.Electoral o D\.N\.)\)/', $linea, $matches)) {
                    $persona['tipoDoc'] = 'D'; 
                }
                if (preg_match('/^Provincia\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['provincia'] = trim($matches[1]);
                }
                if (preg_match('/^Región\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['region'] = trim($matches[1]);
                }
                if (preg_match('/^Distrito\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['distrito'] = trim($matches[1]);
                }
                if (preg_match('/^Dirección\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['direccion'] = trim($matches[1]);
                }
                if (preg_match('/^Teléfono\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['telefono'] = trim($matches[1]);
                }
                if (preg_match('/^Correo\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['correo'] = trim($matches[1]);
                }
                if (preg_match('/^RUC\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['ruc'] = trim($matches[1]);
                }
                if (preg_match('/^Número de cuenta\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['numCuenta'] = trim($matches[1]);
                }
                if (preg_match('/^Registro Pensionario\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['regPensionario'] = trim($matches[1]);
                }
                if (preg_match('/^Fecha de Afiliación\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['fechaAfiliacion'] = trim($matches[1]);
                }
                if (preg_match('/^CUSSP\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['cussp'] = trim($matches[1]);
                }
                if (preg_match('/^Entidad Bancaria\s*[:\s]*(.*)$/i', $linea, $matches)) {
                    $persona['entidadBanc'] = trim($matches[1]);
                }

                // Asignar null a los campos vacíos
                $persona = array_map(function ($item) {
                    return empty($item) ? null : $item;
                }, $persona);

                
                // Insertar los datos en la base de datos
                $sql = "INSERT INTO personas (nombres, apellidos, tipoDoc, numeroDoc, provincia, region, distrito, direccion, telefono, correo, ruc, numCuenta, regPensionario, fechaAfiliacion, cussp, entidadBanc)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param('ssssssssssssssss',
                        $persona['nombres'], $persona['apellidos'], $persona['tipoDoc'], $persona['numeroDoc'],
                        $persona['provincia'], $persona['region'], $persona['distrito'], $persona['direccion'],
                        $persona['telefono'], $persona['correo'], $persona['ruc'], $persona['numCuenta'],
                        $persona['regPensionario'], $persona['fechaAfiliacion'], $persona['cussp'], $persona['entidadBanc']
                    );
                    if ($stmt->execute()) {
                        $registrosInsertados++;
                        error_log("Datos guardados: " . json_encode($persona));
                    } else {
                        error_log("Error al guardar datos: " . $stmt->error);
                    }
                } else {
                    error_log("Error al preparar la consulta: " . $conn->error);
                }
            }
        }

        fclose($handle);

        if ($registrosInsertados > 0) {
            echo json_encode(['success' => true, 'message' => "$registrosInsertados registros procesados correctamente."]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se procesaron registros.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cargar el archivo.']);
    }
}

$conn->close();

?>
