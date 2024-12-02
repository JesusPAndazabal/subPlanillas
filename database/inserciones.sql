INSERT INTO usuarios (nivelacceso , nomuser , correo , claveacceso)VALUES
			('A' ,'jesus', 'jesusmauricio@gmail.com', '123456');
			
			
UPDATE usuarios
	SET claveacceso = '$2y$10$J7gowuuVf0ofrzV.eP.hEO9vexj7ccfi.I.wqf7i7u1HTpSroGqrC'
	WHERE idusuario = 1;
	
	
SELECT * FROM usuarios
SELECT * FROM personas