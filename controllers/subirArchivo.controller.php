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

        $contenido = file_get_contents($archivo);

        // Usamos el patrón para identificar las boletas
        $boletas = preg_split('/(DRE\. HUANCAVELICA|GOBIERNO REGIONAL HUANCAVELICA|DIRECCION REGIONAL DE EDUCACIO|DIRECCION REGIONAL DE EDUCACION)/', $contenido);
        array_shift($boletas);  // El primer elemento es vacío, por lo que lo eliminamos

        $registrosInsertados = 0;

        // Procesamos cada boleta
        foreach ($boletas as $boleta) {
            if (empty(trim($boleta))) continue;  // Si la boleta está vacía, saltarla.

            // Inicializamos todos los campos como null
            $persona = [
                'nombres' => null,
                'apellidos' => null,
                'tipoDoc' => 'D', // Supuesto: Documento Nacional
                'numeroDoc' => null,
                'numCuenta' => null,
                'regPensionario' => null,
                'fechaAfiliacion' => null,
                'cussp' => null,
                'entidadBanc' => null,
                'establecimiento' => null, // Campo para el establecimiento
                'regimenLaboral' => null, // Campo para el régimen laboral
                'cargo' => null // Campo para el cargo
            ];

            // Buscar los campos utilizando expresiones regulares
            if (preg_match('/Apellidos\s*[:\s]*(.*)/i', $boleta, $matches)) {
                $persona['apellidos'] = trim($matches[1]);
            }
            if (preg_match('/Nombres\s*[:\s]*(.*)/i', $boleta, $matches)) {
                $persona['nombres'] = trim($matches[1]);
            }
            if (preg_match('/Documento de Identidad.*?(\d{8})/i', $boleta, $matches)) {
                $persona['numeroDoc'] = trim($matches[1]);
            }
            if (preg_match('/Cta\. TeleAhorro o Nro\. Cheque:\s*(.*)/i', $boleta, $matches)) {
                $persona['numCuenta'] = trim($matches[1]);
            }
            if (preg_match('/Reg\.Pensionario.*?AFP\s*([^\/]+)\/(\S+)/i', $boleta, $matches)) {
                $persona['regPensionario'] = trim($matches[1]);
                $persona['cussp'] = trim($matches[2]);
            }
            if (preg_match('/FAfiliacion\s*[:\s]*(\d{2}\/\d{2}\/\d{4})/i', $boleta, $matches)) {
                $persona['fechaAfiliacion'] = trim($matches[1]);
            }

            // Extraer el nombre del establecimiento
            if (preg_match('/Establecimiento\s*[:\s]*(.*)/i', $boleta, $matches)) {
                $persona['establecimiento'] = trim($matches[1]);
            }

            // Extraer el régimen laboral
            if (preg_match('/Regimen\s*Laboral\s*[:\s]*(.*)/i', $boleta, $matches)) {
                $persona['regimenLaboral'] = trim($matches[1]);
            }

            // Extraer el cargo
            if (preg_match('/Cargo\s*[:\s]*(.*)/i', $boleta, $matches)) {
                $persona['cargo'] = trim($matches[1]);
            }

            // Insertar el establecimiento en la base de datos si no existe
            $establecimiento = $persona['establecimiento'];

            // Verificar si el establecimiento ya existe
            $sql_establecimiento = "SELECT idestablecimiento FROM establecimientos WHERE nombre = ?";
            if ($stmt = $conn->prepare($sql_establecimiento)) {
                $stmt->bind_param('s', $establecimiento);
                $stmt->execute();
                $stmt->store_result();
                
                // Si el establecimiento no existe, lo insertamos
                if ($stmt->num_rows == 0) {
                    $sql_insert_establecimiento = "INSERT INTO establecimientos (nombre) VALUES (?)";
                    if ($insert_stmt = $conn->prepare($sql_insert_establecimiento)) {
                        $insert_stmt->bind_param('s', $establecimiento);
                        $insert_stmt->execute();
                    } else {
                        error_log("Error al insertar establecimiento: " . $conn->error);
                    }
                }
                $stmt->close();
            }

            // Insertar el régimen laboral en la base de datos si no existe
            $regimenLaboral = $persona['regimenLaboral'];

            // Verificar si el régimen laboral ya existe
            $sql_regimen = "SELECT idregimenLaboral FROM regimenLaborales WHERE descripcion = ?";
            if ($stmt = $conn->prepare($sql_regimen)) {
                $stmt->bind_param('s', $regimenLaboral);
                $stmt->execute();
                $stmt->store_result();
                
                // Si el régimen laboral no existe, lo insertamos
                if ($stmt->num_rows == 0) {
                    $sql_insert_regimen = "INSERT INTO regimenLaborales (descripcion) VALUES (?)";
                    if ($insert_stmt = $conn->prepare($sql_insert_regimen)) {
                        $insert_stmt->bind_param('s', $regimenLaboral);
                        $insert_stmt->execute();
                    } else {
                        error_log("Error al insertar régimen laboral: " . $conn->error);
                    }
                }
                $stmt->close();
            }

            // Insertar el cargo en la base de datos si no existe
            $cargo = $persona['cargo'];

            // Verificar si el cargo ya existe
            $sql_cargo = "SELECT idcargo FROM cargos WHERE descripcion = ?";
            if ($stmt = $conn->prepare($sql_cargo)) {
                $stmt->bind_param('s', $cargo);
                $stmt->execute();
                $stmt->store_result();
                
                // Si el cargo no existe, lo insertamos
                if ($stmt->num_rows == 0) {
                    $sql_insert_cargo = "INSERT INTO cargos (descripcion) VALUES (?)";
                    if ($insert_stmt = $conn->prepare($sql_insert_cargo)) {
                        $insert_stmt->bind_param('s', $cargo);
                        $insert_stmt->execute();
                    } else {
                        error_log("Error al insertar cargo: " . $conn->error);
                    }
                }
                $stmt->close();
            }

            // Procesar los ingresos y egresos (campos)
            if (preg_match_all('/={3,}\s*(.*?)\s*={3,}/s', $boleta, $secciones)) {
                foreach ($secciones[1] as $seccion) {
                    // Buscar los ingresos y egresos dentro de la sección
                    if (preg_match_all('/([+-])\s*([a-zA-Z_]+)\s+(\d{1,3}(?:[\.,]\d{3})*(?:[\.,]\d{2})?)/', $seccion, $matches)) {
                        foreach ($matches[2] as $index => $nombre) {
                            $tipo = ($matches[1][$index] == '+') ? 'I' : 'E'; // 'I' para ingreso, 'E' para egreso
                            $monto = str_replace(',', '', $matches[3][$index]); // Remover comas en los números
            
                            // Validar si ya existe el campo en la base de datos
                            $sql_campos_check = "SELECT idcampo FROM campos WHERE tipo = ? AND nombre = ?";
                            if ($stmt_check = $conn->prepare($sql_campos_check)) {
                                $stmt_check->bind_param('ss', $tipo, $nombre);
                                $stmt_check->execute();
                                $stmt_check->store_result();
            
                                // Si no existe, insertamos el nuevo ingreso/egreso
                                if ($stmt_check->num_rows == 0) {
                                    $sql_campos_insert = "INSERT INTO campos (tipo, nombre) VALUES (?, ?)";
                                    if ($stmt_insert = $conn->prepare($sql_campos_insert)) {
                                        $stmt_insert->bind_param('ss', $tipo, $nombre);
                                        $stmt_insert->execute();
                                    }
                                }
                                $stmt_check->close();
                            }
                        }
                    }
                }
            }
            


            // Insertar los datos de la persona en la tabla "personas"
            $sql = "INSERT INTO personas (nombres, apellidos, tipoDoc, numeroDoc, numCuenta, regPensionario, fechaAfiliacion, cussp)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param(
                    'ssssssss',
                    $persona['nombres'],
                    $persona['apellidos'],
                    $persona['tipoDoc'],
                    $persona['numeroDoc'],
                    $persona['numCuenta'],
                    $persona['regPensionario'],
                    $persona['fechaAfiliacion'],
                    $persona['cussp']
                );

                if ($stmt->execute()) {
                    $registrosInsertados++;
                } else {
                    error_log("Error al guardar datos: " . $stmt->error);
                }
            } else {
                error_log("Error al preparar la consulta: " . $conn->error);
            }
        }

        echo json_encode(['success' => true, 'message' => "$registrosInsertados registros procesados correctamente."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cargar el archivo.']);
    }
}

$conn->close();

?>
