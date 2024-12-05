
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
CREATE PROCEDURE spu_usuarios_login(IN _nomuser VARCHAR(30))
BEGIN
	SELECT *
	FROM usuarios WHERE nomuser = _nomuser AND estado = '1';
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



