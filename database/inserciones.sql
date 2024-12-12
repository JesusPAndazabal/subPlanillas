INSERT INTO usuarios (nivelacceso , nomuser , correo , claveacceso)VALUES
			('A' ,'jesus', 'jesusmauricio@gmail.com', '123456');
			
			
UPDATE usuarios
	SET claveacceso = '$2y$10$J7gowuuVf0ofrzV.eP.hEO9vexj7ccfi.I.wqf7i7u1HTpSroGqrC'
	WHERE idusuario = 1;
	
	
SELECT * FROM usuarios
SELECT * FROM personas
SELECT * FROM establecimientos
SELECT * FROM regimenLaborales
SELECT * FROM cargos
SELECT * FROM campos
SELECT * FROM periodos
SELECT * FROM vs_boletasConsultas WHERE numeroDoc = 21456705
SELECT * FROM conceptos
SELECT * FROM archivos_subidos
SELECT * FROM boletas WHERE idpersona = 2389

SELECT * FROM personas WHERE numeroDoc = 21456705 2389

SELECT * FROM boletas
WHERE idregimenLaboral IS NULL
   OR idcargo IS NULL
   OR idestablecimiento IS NULL;

SELECT * FROM boletas WHERE idpersona = 193	
SELECT * FROM boletas WHERE idpersona = 828
202
1072
1762

SELECT * FROM vs_boletasConsultas WHERE numeroDoc = 21527635
SELECT * FROM periodos;


DELETE FROM  personas;
DELETE FROM periodos WHERE idperiodo = 219