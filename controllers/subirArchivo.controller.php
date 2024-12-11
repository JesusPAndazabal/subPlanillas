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
        
        $periodo_id = $_POST['periodo_id'];
        $archivo = $_FILES['archivoLis']['tmp_name'];

        $contenido = file_get_contents($archivo);
        $codigo_unico = hash('sha256', $contenido);

    
        // Verificar si el archivo ya fue procesado
        $sql_check_archivo = "SELECT idarchivo FROM archivos_subidos WHERE codigo_unico = ?";
        if ($stmt_check = $conn->prepare($sql_check_archivo)) {
            $stmt_check->bind_param('s', $codigo_unico);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                echo json_encode(['success' => false, 'message' => 'El archivo ya fue procesado anteriormente.']);
                $stmt_check->close();
                $conn->close();
                exit;
            }
            $stmt_check->close();
        }

        $sql_insert_archivo = "INSERT INTO archivos_subidos (nombre_archivo, codigo_unico) VALUES (?, ?)";
        if ($stmt_insert_archivo = $conn->prepare($sql_insert_archivo)) {
            $nombre_archivo = $_FILES['archivoLis']['name']; // Nombre del archivo subido
            $idboleta = null; // No asignar idboleta en este momento, lo haremos más tarde.

            // Depuración: Mostrar el nombre del archivo
            error_log("Nombre del archivo: " . $nombre_archivo);
        
            $stmt_insert_archivo->bind_param('ss', $nombre_archivo, $codigo_unico);
            if ($stmt_insert_archivo->execute()) {
                $id_archivo = $stmt_insert_archivo->insert_id; // Obtener el id_archivo recién insertado
                // Depuración: Mostrar el id del archivo insertado
                error_log("ID del archivo insertado: " . $id_archivo);
            } else {
                error_log("Error al registrar archivo: " . $stmt_insert_archivo->error);
                echo json_encode(['success' => false, 'message' => 'Error al registrar el archivo.']);
                $stmt_insert_archivo->close();
                $conn->close();
                exit;
            }
            $stmt_insert_archivo->close();
        }
        

        // Usamos el patrón para identificar las boletas
        $boletas = preg_split('/(DRE\. HUANCAVELICA|GOBIERNO REGIONAL HUANCAVELICA|DIRECCION REGIONAL DE EDUCACIO|DIRECCION REGIONAL DE EDUCACION)/', $contenido);
        array_shift($boletas);  // El primer elemento es vacío, por lo que lo eliminamos

        $registrosInsertados = 0;

         // Iniciar la transacción
         $conn->begin_transaction();

         try{
                // Procesamos cada boleta
            foreach ($boletas as $boleta) {
                if (empty(trim($boleta))) continue;  // Si la boleta está vacía, saltarla.

                // Inicializamos todos los campos como null
                $persona = [
                    'nombres' => null,
                    'apellidos' => null,
                    'tipoDoc' => 'D', // Supuesto: Documento Nacional
                    'numeroDoc' => null,
                    'fechaNacimiento' => null,
                    'numCuenta' => null,
                    'regPensionario' => null,
                    'fechaAfiliacion' => null,
                    'cussp' => null,
                    'entidadBanc' => null,
                    'establecimiento' => null, // Campo para el establecimiento
                    'regimenLaboral' => null, // Campo para el régimen laboral
                    'cargo' => null, // Campo para el cargo
                    'idpersona' => null, // Este es el ID de la persona insertada
                    'idcargo' => null,
                    'idestablecimiento' => null,
                    'idregimenLaboral' => null,
                    'dniJud' => null,
                    'tipoServidor' => null,
                    'tiempoServi' => null,
                    'essalud' => null,
                    'fechaIngreso' => null,
                    'fechaTermino' => null,
                    'leyendaPermanente' => null,
                    'leyendaMensual' => null,
                    'escala' => null,
                    'cuenta' => null,
                    'totalRemuneracion' => null,
                    'totalDescuento' => null,
                    'totalLiquido' => null,
                    'montoImponible' => null,
                    'aporteOblig'  => null,
                    'cVariable' => null,
                    'fDevenge' => null,
                    'seguro' => null,
                    'idboleta' => null,
                ];

                // Depuración: Mostrar boleta procesada - BORRAR
                //error_log("Procesando boleta: " . substr($boleta, 0, 100)); // Mostrar los primeros 100 caracteres

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

                // Extraer el régimen pensionario
                if (preg_match('/Reg(?:\.|imen)?\s*Pensionario\s*[:\s]*(AFP\s[^\/\n]+|Ley\s\d+)/i', $boleta, $matches)) {
                    $persona['regPensionario'] = trim($matches[1]);
                }

                // Extraer el CUSSP si es un AFP
                if (isset($persona['regPensionario']) && stripos($persona['regPensionario'], 'AFP') !== false) {
                    if (preg_match('/FAfiliacion\s*:\s*(\d{2}\/\d{2}\/\d{4})/', $boleta, $cusspMatch)) {
                        $persona['cussp'] = trim($cusspMatch[1]);
                    }
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

                if (preg_match('/Tiempo de Servicio\s*\(AA-MM-DD\):\s*(\d{2}-\d{2}-\d{2})\s*ESSALUD\s*:\s*(\d+)/', $boleta, $matches)) {
                    $persona['tiempoServi'] = trim($matches[1]);
                    $persona['essalud'] = trim($matches[2]);
                }

                // Buscar Fecha de Ingreso y Fecha de Término
                if (preg_match('/Fecha de Registro.*?(Ingr\.\s*:\s*(\d{2}\/\d{2}\/\d{4})|Cese\s*:\s*(\d{2}\/\d{2}\/\d{4})).*?Termino\s*:\s*(\d{2}\/\d{2}\/\d{4}|)/i', $boleta, $matches)) {
                    // Fecha de Ingreso o Cese
                    $fechaIngreso = null;
                    if (!empty($matches[2])) {
                        $fechaIngreso = DateTime::createFromFormat('d/m/Y', trim($matches[2]))->format('Y-m-d');
                    } elseif (!empty($matches[3])) {
                        $fechaIngreso = DateTime::createFromFormat('d/m/Y', trim($matches[3]))->format('Y-m-d');
                    }

                    // Fecha de Término
                    $fechaTermino = null;
                    if (isset($matches[5]) && !empty(trim($matches[5]))) {
                        $fechaTermino = DateTime::createFromFormat('d/m/Y', trim($matches[5]))->format('Y-m-d');
                    }

                    $persona['fechaIngreso'] = $fechaIngreso;
                    $persona['fechaTermino'] = $fechaTermino;
                }


                // Extraer cuenta o número de cheque
                if (preg_match('/Cta\. TeleAhorro o Nro\. Cheque:\s*(CTA-\s*\d+|CHQ-\s*\d+)/i', $boleta, $matches)) {
                    $persona['cuenta'] = trim($matches[1]);  // Asignar cuenta o número de cheque
                } else {
                    $persona['cuenta'] = null;  // Si no se encuentra, asignar null
                }

                // Extraer los totales de la boleta
                if (preg_match('/T-REMUN\s+([\d,.]+)/i', $boleta, $matches)) {
                    $persona['totalRemuneracion'] = str_replace(',', '', $matches[1]);
                }
                if (preg_match('/T-DSCTO\s+([\d,.]+)/i', $boleta, $matches)) {
                    $persona['totalDescuento'] = str_replace(',', '', $matches[1]);
                }
                if (preg_match('/T-LIQUI\s+([\d,.]+)/i', $boleta, $matches)) {
                    $persona['totalLiquido'] = str_replace(',', '', $matches[1]);
                }
                if (preg_match('/MImponible\s+([\d,.]+)/i', $boleta, $matches)) {
                    $persona['montoImponible'] = str_replace(',', '', $matches[1]);
                }

                // Extraer el Tipo de Servidor o Tipo de Pensionista
                if (preg_match('/Tipo\s+de\s+(Servidor|Pensionista)\s*:\s*(.+)/i', $boleta, $matches)) {
                    $persona['tipoServidor'] = trim($matches[2]);
                }


                // Extraer y validar la Fecha de Nacimiento
                if (preg_match('/Fecha\s+de\s+Nacimiento\s*:\s*(\d{2}\/\d{2}\/\d{4})/i', $boleta, $matches)) {
                    $fechaExtraida = trim($matches[1]); // Ejemplo: "31/01/1971"

                    // Validar el formato de la fecha (DD/MM/YYYY)
                    $fechaPartes = explode('/', $fechaExtraida); // Divide la fecha en día, mes y año
                    if (count($fechaPartes) === 3) {
                        $dia = (int)$fechaPartes[0];
                        $mes = (int)$fechaPartes[1];
                        $anio = (int)$fechaPartes[2];

                        // Verificar si es una fecha válida
                        if (checkdate($mes, $dia, $anio)) {
                            // Convertir a formato Y-m-d (por ejemplo: "1971-01-31")
                            $persona['fechaNacimiento'] = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
                        } else {
                            // Fecha no válida
                            $persona['fechaNacimiento'] = null; // Puedes asignar un valor predeterminado si lo necesitas
                        }
                    } else {
                        // Fecha no válida
                        $persona['fechaNacimiento'] = null;
                    }
                } else {
                    // Si no se encuentra la fecha en el texto
                    $persona['fechaNacimiento'] = null;
                }


                // Extraer Leyenda Permanente
                if (preg_match('/Leyenda Permanente\s*[:|-]\s*(.*?)(?=\s*Leyenda Mensual|\s*$)/i', $boleta, $matches)) {
                    $leyendaPermanente = trim($matches[1]);

                    // Si la leyenda está vacía o contiene solo espacios, asignar null
                    if (empty($leyendaPermanente)) {
                        $persona['leyendaPermanente'] = null;
                    } else {
                        $persona['leyendaPermanente'] = $leyendaPermanente;
                    }
                } else {
                    $persona['leyendaPermanente'] = null; // Si no se encuentra, dejar vacío
                }

                // Extraer el Aporte Obligatorio
                if (preg_match('/Aporte\s+Oblg:\s+([\d\.]+)/i', $boleta, $matches)) {
                    $persona['aporteOblig'] = trim($matches[1]);
                }

                // Extraer el C Variable
                if (preg_match('/CVariable\s*:\s*([\d\.]+)/i', $boleta, $matches)) {
                    $persona['cVariable'] = trim($matches[1]);
                }

                // Extraer el F Devengue
                if (preg_match('/FDevengue\s*:\s*([\d\/]+)/i', $boleta, $matches)) {
                    $persona['fDevengue'] = trim($matches[1]);
                }

                // Extraer el Seguro
                if (preg_match('/Seguro\s*:\s*([\d\.]+)/i', $boleta, $matches)) {
                    $persona['seguro'] = trim($matches[1]);
                }

            // Extraer Leyenda Mensual
            if (preg_match('/Leyenda Mensual\s*[:|-]\s*(.*?)(?=\s*Reg.Pensionario|\s*$)/i', $boleta, $matches)) {
                $leyendaMensual = trim($matches[1]);

                // Si la leyenda está vacía o contiene solo espacios, asignar null
                if (empty($leyendaMensual)) {
                    $persona['leyendaMensual'] = null;
                } elseif (ctype_digit($leyendaMensual)) {
                    // Si es numérico, procesar como boleta adicional o fecha
                    $anio = substr($leyendaMensual, 0, 4); // Primeros 4 dígitos: Año
                    $mes = intval(substr($leyendaMensual, 4)); // Restantes: Mes o indicador adicional

                    if ($mes > 12) {
                        // Calcular el mes real (restamos 20)
                        $mesReal = $mes - 20;

                        // Calcular el número de adicional (por cada 20 sumados al mes original)
                        $adicional = floor(($mes - 13) / 20) + 1; // El número de adicional

                        // Convertir el número de mes real a nombre del mes
                        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                        $mesRealNombre = $meses[$mesReal - 1];  // El índice del mes comienza desde 0

                        // Asignamos la leyenda
                        $persona['leyendaMensual'] = "Año: $anio, Mes Real: $mesRealNombre (Adicional $adicional)";
                    } else {
                        // Si es un mes normal
                        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                        $mesNombre = $meses[$mes - 1];  // El índice del mes comienza desde 0

                        $persona['leyendaMensual'] = "Año: $anio, Mes: $mesNombre";
                    }
                } else {
                    // Si no es numérico, tomar el texto literal
                    $persona['leyendaMensual'] = $leyendaMensual;
                }
                } else {
                    $persona['leyendaMensual'] = null; // Si no se encuentra, dejar vacío
                }

            
                // 2. Insertar Establecimiento si no existe y Obtener idestablecimiento
                $establecimiento = $persona['establecimiento'];
                $sql_establecimiento = "SELECT idestablecimiento FROM establecimientos WHERE nombre = ?";
                if ($stmt = $conn->prepare($sql_establecimiento)) {
                    $stmt->bind_param('s', $establecimiento);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows == 0) {
                        // Si no existe, insertamos el establecimiento
                        $sql_insert_establecimiento = "INSERT INTO establecimientos (nombre) VALUES (?)";
                        if ($insert_stmt = $conn->prepare($sql_insert_establecimiento)) {
                            $insert_stmt->bind_param('s', $establecimiento);
                            $insert_stmt->execute();
                            $persona['idestablecimiento'] = $insert_stmt->insert_id;  // Obtener el ID insertado
                            $insert_stmt->close();
                        }
                    } else {
                        $stmt->bind_result($persona['idestablecimiento']);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }

                // 4. Insertar Régimen Laboral si no existe y Obtener idregimenLaboral
                $regimenLaboral = $persona['regimenLaboral'];
                $sql_regimen = "SELECT idregimenLaboral FROM regimenLaborales WHERE descripcion = ?";
                if ($stmt = $conn->prepare($sql_regimen)) {
                    $stmt->bind_param('s', $regimenLaboral);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows == 0) {
                        // Si no existe, insertamos el régimen
                        $sql_insert_regimen = "INSERT INTO regimenLaborales (descripcion) VALUES (?)";
                        if ($insert_stmt = $conn->prepare($sql_insert_regimen)) {
                            $insert_stmt->bind_param('s', $regimenLaboral);
                            $insert_stmt->execute();
                            $persona['idregimenLaboral'] = $insert_stmt->insert_id;  // Obtener el ID insertado
                            $insert_stmt->close();
                        }
                    } else {
                        $stmt->bind_result($persona['idregimenLaboral']);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }

                // 3. Insertar Cargo si no existe y Obtener idcargo
                $cargo = $persona['cargo'];
                $sql_cargo = "SELECT idcargo FROM cargos WHERE descripcion = ?";
                if ($stmt = $conn->prepare($sql_cargo)) {
                    $stmt->bind_param('s', $cargo);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows == 0) {
                        // Si no existe, insertamos el cargo
                        $sql_insert_cargo = "INSERT INTO cargos (descripcion) VALUES (?)";
                        if ($insert_stmt = $conn->prepare($sql_insert_cargo)) {
                            $insert_stmt->bind_param('s', $cargo);
                            $insert_stmt->execute();
                            $persona['idcargo'] = $insert_stmt->insert_id;  // Obtener el ID insertado
                            $insert_stmt->close();
                        }
                    } else {
                        $stmt->bind_result($persona['idcargo']);
                        $stmt->fetch();
                    }
                    $stmt->close();
                }

                $campos = []; // Este es el arreglo que contendrá los campos (ingresos/egresos)

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
                                            // Agregar el idcampo y el monto a la lista de campos
                                            $campos[] = ['idcampo' => $stmt_insert->insert_id, 'monto' => $monto];
                                        }
                                        $stmt_insert->close();
                                    } else {
                                        // Si ya existe, obtenemos el idcampo y lo agregamos al arreglo con el monto
                                        $stmt_check->bind_result($idcampo);
                                        $stmt_check->fetch();
                                        $campos[] = ['idcampo' => $idcampo, 'monto' => $monto];
                                    }
                                    $stmt_check->close();
                                }
                            }
                        }
                    }
                }
                
                // Verificar si la persona ya existe (por ejemplo, por su número de documento)
                $sql = "SELECT idpersona FROM personas WHERE numeroDoc = ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param('s', $persona['numeroDoc']);  // Usamos el número de documento para la búsqueda

                    $stmt->execute();
                    $stmt->store_result();

                    // Si la persona ya existe, obtenemos su ID
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($idpersona);
                        $stmt->fetch(); // Esto obtiene el idpersona de la persona existente
                        $persona['idpersona'] = $idpersona;
                    } else {
                        // Si no existe, insertamos la persona
                        $sql = "INSERT INTO personas (nombres, apellidos, tipoDoc, numeroDoc, fechaNacimiento ,numCuenta, regPensionario, fechaAfiliacion, cussp)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?)";

                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param(
                                'sssssssss',
                                $persona['nombres'],
                                $persona['apellidos'],
                                $persona['tipoDoc'],
                                $persona['numeroDoc'],
                                $persona['fechaNacimiento'],
                                $persona['numCuenta'],
                                $persona['regPensionario'],
                                $persona['fechaAfiliacion'],
                                $persona['cussp']
                            );

                            if ($stmt->execute()) {
                                // Si se insertó correctamente, obtenemos el ID de la persona recién insertada
                                $persona['idpersona'] = $stmt->insert_id;
                            } else {
                                error_log("Error al guardar datos: " . $stmt->error);
                            }
                        } else {
                            error_log("Error al preparar la consulta: " . $conn->error);
                        }
                    }
                } else {
                    error_log("Error al preparar la consulta: " . $conn->error);
                }


                // Insertar la boleta en la tabla boletas
                $sql_boleta = "INSERT INTO boletas (
                    idpersona, idcargo, idestablecimiento, idregimenLaboral, idperiodo, dniJud, tipoServi,
                    tiempoServi, essalud, fechaIngreso, fechaTermino, leyendaPermanente, 
                    leyendaMensual, escala, cuenta, totalRemuneracion, totalDescuento, 
                    totalLiquido, montoImponible , aporteOblig , cVariable , fDevenge , seguro , id_archivo
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? , ? , ? , ? , ? )";
                if ($stmt_boleta = $conn->prepare($sql_boleta)) {
                    $stmt_boleta->bind_param(
                        'iiiiissssssssssssssssssi',
                        $persona['idpersona'],      // idpersona
                        $persona['idcargo'],         // idcargo
                        $persona['idestablecimiento'], // idestablecimiento
                        $persona['idregimenLaboral'], // idregimenLaboral
                        $periodo_id                 , // idperiodo
                        $persona['dniJud'],          // dniJud
                        $persona['tipoServidor'],          // dniJud
                        $persona['tiempoServi'],     // tiempoServi
                        $persona['essalud'],         // essalud
                        $persona['fechaIngreso'],    // fechaIngreso
                        $persona['fechaTermino'],    // fechaTermino
                        $persona['leyendaPermanente'], // leyendaPermanente
                        $persona['leyendaMensual'],  // leyendaMensual
                        $persona['escala'],          // escala
                        $persona['cuenta'],          // cuenta
                        $persona['totalRemuneracion'], // totalRemuneracion
                        $persona['totalDescuento'],  // totalDescuento
                        $persona['totalLiquido'],    // totalLiquido
                        $persona['montoImponible'],  // montoImponible
                        $persona['aporteOblig'],  // montoImponible
                        $persona['cVariable'],  // montoImponible
                        $persona['fDevengue'],  // montoImponible
                        $persona['seguro'],  // montoImponible
                        $id_archivo
                    );

                    // Verificar que el bind_param no haya fallado
                    if ($stmt_boleta === false) {
                        error_log("Error al vincular los parámetros en la sentencia SQL: " . $conn->error);
                    }

                    if ($stmt_boleta->execute()) {
                        // Después de la ejecución, obtener el id de la boleta insertada
                        $persona['idboleta'] = $stmt_boleta->insert_id;
                        $registrosInsertados++;
                        error_log("Boleta insertada exitosamente. ID de boleta: " . $persona['idboleta'] . $id_archivo);
                    } else {
                        error_log("Error al insertar boleta: " . $stmt_boleta->error);
                    }

                    // No cierres la sentencia aquí, ya que la vamos a usar más tarde para insertar los conceptos.
                    //$stmt_boleta->close(); 
                }

                // Después de insertar la boleta, insertar los conceptos con valores nulos
                $sql_conceptos = "INSERT INTO conceptos (idboleta, idcampo, monto) VALUES (?, ?, ?)";

                // Preparamos la consulta de inserción de conceptos
                if ($stmt_conceptos = $conn->prepare($sql_conceptos)) {
                    // Suponiendo que $campos es un arreglo de objetos o datos con 'idcampo'
                    foreach ($campos as $campo) {
                        // Insertar los conceptos con el idboleta actual y los idcampo obtenidos
                        $stmt_conceptos->bind_param(
                            'iid', 
                            $persona['idboleta'], 
                            $campo['idcampo'],
                            $campo['monto'] // Aquí pasamos el monto de cada campo
                        );
                        $stmt_conceptos->execute();
                    }
                    $stmt_conceptos->close(); // Aquí se cierra después de la inserción de todos los conceptos.
                }

                // Cerrar la sentencia de la boleta solo después de haber insertado los conceptos
                $stmt_boleta->close(); // Ahora puedes cerrarla, porque ya no la necesitas
            }
        // Confirmar la transacción si todo fue bien
        $conn->commit();
        echo json_encode(['success' => true, 'message' => "$registrosInsertados registros procesados correctamente."]);
        }catch (Exception $e) {
            // Revertir los cambios si algo falla
            $conn->rollback();
            error_log("Error en la transacción: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al procesar los registros.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cargar el archivo.']);
    }
}

// En periodo.controller.php
if ($_POST['op'] == 'eliminarPeriodo') {
    $periodo_id = $_POST['periodo_id'];
    // Lógica para eliminar el periodo por id
    $sql = "DELETE FROM periodos WHERE idperiodo = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $periodo_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el periodo.']);
        }
    }
}






$conn->close();

?>