
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