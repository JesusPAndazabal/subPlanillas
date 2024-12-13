
DELIMITER $$
CREATE PROCEDURE spu_usuarios_login(IN _nomuser VARCHAR(30))
BEGIN
	SELECT *
	FROM usuarios WHERE nomuser = _nomuser AND estado = '1';
END $$

-- Registrar usuarios
DELIMITER $$
CREATE PROCEDURE spu_registrar_usuario
(
	IN _nomuser 		VARCHAR(30),
	IN _correo		VARCHAR(200),
	IN _telefono		CHAR(11),
	IN _nivelacceso		CHAR(1)
)
BEGIN 
	INSERT INTO usuarios (nomuser , correo , telefono , nivelacceso ,claveacceso)
		VALUES ( _nomuser , _correo , _telefono , _nivelacceso , '$2y$10$J7gowuuVf0ofrzV.eP.hEO9vexj7ccfi.I.wqf7i7u1HTpSroGqrC');
END $$

DELIMITER $$
CREATE PROCEDURE spu_buscarUsuarios
(
	IN _search 	VARCHAR(50)
)
BEGIN
	SELECT * FROM usuarios
		WHERE nomuser LIKE CONCAT('%', _search ,'%');
END $$

DELIMITER $$
CREATE PROCEDURE spu_buscarUsuariosRol
(
	IN _nivelacceso CHAR(1),
	IN _search 	VARCHAR(50)
)
BEGIN
	SELECT * FROM usuarios
		WHERE nivelacceso = _nivelacceso AND nomuser LIKE CONCAT('%', _search ,'%');
END $$


DELIMITER $$
CREATE PROCEDURE spu_buscardni_persona ( IN _numeroDoc CHAR(11))
BEGIN 
	SELECT * FROM personas 
		WHERE numeroDoc = _numeroDoc;
END $$



-- Procedimiento para crear un periodo 
DELIMITER $$
CREATE PROCEDURE spu_registrar_periodo
(
    IN _tipo        VARCHAR(50),
    IN _mes         INT,
    IN _anio        CHAR(4),
    IN _numero      INT, -- número de boleta
    IN _formaPago   CHAR(1) -- CHQ (Cheque) o CIA (Teleahorro)
)
BEGIN
    -- Calcula la fecha de inicio y término
    DECLARE _fechaInicio DATE;
    DECLARE _fechaTermino DATE;

    SET _fechaInicio = STR_TO_DATE(CONCAT(_anio, '-', LPAD(_mes, 2, '0'), '-01'), '%Y-%m-%d');
    SET _fechaTermino = LAST_DAY(_fechaInicio);

    -- Inserta el periodo en la tabla
    INSERT INTO periodos (tipo, mes, anio, fechaInicio, fechaTermino, numero, formaPago)
    VALUES (_tipo, _mes, _anio, _fechaInicio, _fechaTermino, _numero, _formaPago);

    -- Retorna el ID del último periodo insertado
    SELECT LAST_INSERT_ID() AS periodo_id;

END $$

DELIMITER $$
CREATE PROCEDURE spu_buscarDniPlanilla(IN _numeroDoc VARCHAR(11))
BEGIN 
	SELECT *
	FROM vs_boletasConsultas WHERE numeroDoc = _numeroDoc;
END $$

-- Procedimientos para las boletas - Para obtener un registro para el reporte
DELIMITER $$
CREATE PROCEDURE spu_obtener_boleta(IN _idboleta INT)
BEGIN 
	SELECT * FROM vs_boletasConsultas
		WHERE idboleta = _idboleta;
END $$

-- Procedimiento para poder obtener los conceptos de una boleta
DELIMITER $$
CREATE PROCEDURE spu_obtener_concepto(IN _idboleta INT)
BEGIN 
	SELECT * FROM vs_conceptos
		WHERE idboleta = _idboleta;
END $$


-- Procedimientos para el rango de fechas
DELIMITER $$
CREATE PROCEDURE spu_obtener_formatos
(
	IN _p_numeroDoc  	CHAR(11),
	IN _p_fechaInicio  	DATE,
	IN _p_fechaFin 		DATE
)
BEGIN 
	SELECT *
	FROM vs_boletasConsultas
	WHERE numeroDoc = _p_numeroDoc
	  AND fechaInicio BETWEEN _p_fechaInicio AND _p_fechaFin;
END $$

	
	
DELIMITER $$
CREATE PROCEDURE spu_filtroConsultas 
(
	IN _numeroDoc CHAR(11),
	IN _anio 	CHAR(4),
	IN _mes		VARCHAR(40)
)
BEGIN 

	-- Si _mes es una cadena vacía, lo convertimos en NULL
	    IF _mes = '' THEN
		SET _mes = NULL;
	    END IF;
	    
	       -- Si _anio es una cadena vacía, lo convertimos en NULL
	    IF _anio = '' THEN
		SET _anio = NULL;
	    END IF;
	    
	SELECT * 
	FROM vs_boletasConsultas
	WHERE (numeroDoc = _numeroDoc OR _numeroDoc IS NULL)
	  AND (anio = _anio OR _anio IS NULL)
	  AND (mes = _mes OR _mes IS NULL);
END $$

-- Filtro para usuarios externos
DELIMITER $$
CREATE PROCEDURE spu_filtroConsultasUsuarios
(
	IN _numeroDoc CHAR(11),
	IN _anio 	CHAR(4),
	IN _mes		VARCHAR(40)
)
BEGIN 

	-- Si _mes es una cadena vacía, lo convertimos en NULL
	    IF _mes = '' THEN
		SET _mes = NULL;
	    END IF;
	    
	       -- Si _anio es una cadena vacía, lo convertimos en NULL
	    IF _anio = '' THEN
		SET _anio = NULL;
	    END IF;
	    
	SELECT * 
	FROM vs_boletasConsultas
	WHERE (numeroDoc = _numeroDoc OR _numeroDoc IS NULL)
	  AND (anio = _anio OR _anio IS NULL)
	  AND (mes = _mes OR _mes IS NULL);
END $$




     