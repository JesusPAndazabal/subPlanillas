CREATE DATABASE db_archiPlanillas;

USE db_archiPlanillas;


CREATE TABLE usuarios
(
	idusuario		INT AUTO_INCREMENT PRIMARY KEY,
	nomuser 		VARCHAR(30) NOT NULL,
	correo			VARCHAR(200) NULL,
	telefono		CHAR(11) NULL,
	nivelacceso		CHAR(1) NOT NULL,
	claveacceso		VARCHAR(200)NOT NULL,
	estado			CHAR(1) NOT NULL DEFAULT '1'
)ENGINE=INNODB;

CREATE TABLE personas
(
	idpersona 	INT AUTO_INCREMENT PRIMARY KEY,
	nombres		VARCHAR(100) NULL,
	apellidos	VARCHAR(100) NULL,
	tipoDoc		CHAR(1) NULL,
	numeroDoc	CHAR(11) NULL,
	fechaNacimiento	DATE NULL,
	provincia	VARCHAR(200) NULL,
	region		VARCHAR(200) NULL,
	distrito 	VARCHAR(200) NULL,
	direccion	VARCHAR(200) NULL,
	telefono	CHAR(11)NULL,
	correo		VARCHAR(200) NULL, -- quitar este campo
	ruc		CHAR(11) NULL,
	numCuenta 	INT NULL,
	regPensionario	VARCHAR(100) NULL,
	fechaAfiliacion	DATE NULL,
	cussp 		VARCHAR(100) NULL,
	entidadBanc	VARCHAR(100) NULL

)ENGINE=INNODB;

CREATE TABLE periodos
(
	idperiodo 	INT AUTO_INCREMENT PRIMARY KEY,
	tipo		VARCHAR(100) NULL,
	mes		INT NULL,
	anio		CHAR(4) NULL,
	fechaInicio	DATE NULL, -- autogenerado - 01
	fechaTermino	DATE NULL, --  1 mes - 31
	numero 		INT NULL, -- numero de boleta- 
	formaPago	CHAR(1) NULL -- CHQ O CIA - CHEQUE O TELEAHORRO/NRO DE CUENTA
)ENGINE= INNODB;

CREATE TABLE establecimientos
(
	idestablecimiento 	INT AUTO_INCREMENT PRIMARY KEY,
	nombre			VARCHAR(100)NULL
	-- numero 			INT NULL
)ENGINE=INNODB;

CREATE TABLE entidades
(
	identidad	INT AUTO_INCREMENT PRIMARY KEY,
	descripcion	VARCHAR(100) NULL,
	direccion	VARCHAR(100) NULL,
	ruc		CHAR(11) NULL,
	numEjecutora	INT NULL,
	region		VARCHAR(200) NULL,
	provincia	VARCHAR(200) NULL
)ENGINE=INNODB;

CREATE TABLE regimenLaborales
(
	idregimenLaboral	INT AUTO_INCREMENT PRIMARY KEY,
	descripcion		VARCHAR(200) NULL
)ENGINE=INNODB;

CREATE TABLE cargos
(
	idcargo			INT AUTO_INCREMENT PRIMARY KEY,
	descripcion		VARCHAR(200) NULL
)ENGINE=INNODB;

CREATE TABLE campos
(
	 idcampo 	INT AUTO_INCREMENT PRIMARY KEY,
	 tipo		CHAR(1) NOT NULL,
	 nombre		VARCHAR(60) NOT NULL
)ENGINE=INNODB;

CREATE TABLE archivos_subidos (
    idarchivo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_archivo VARCHAR(255),
    codigo_unico VARCHAR(64) -- Hash para verificar si el archivo ya fue subido
);


CREATE TABLE boletas
(
	idboleta		INT AUTO_INCREMENT PRIMARY KEY,
	idpersona		INT NULL,
	idcargo			INT NULL,
	idestablecimiento 	INT NULL,
	idregimenLaboral	INT NULL,
	idperiodo		INT NULL,
	dniJud			CHAR(11) NULL,
	tipoServi		VARCHAR(100),
	tiempoServi		DATE NULL,
	essalud			INT NULL,
	fechaIngreso 		DATE NULL,
	fechaTermino		DATE NULL,
	leyendaPermanente	VARCHAR(100) NULL,
	leyendaMensual		VARCHAR(100) NULL,
	escala 			VARCHAR(100) NULL, -- Escala Magistral
	cuenta			VARCHAR(100) NULL,
	totalRemuneracion	DOUBLE(8,2) NULL,
	totalDescuento		DOUBLE(8,2) NULL,
	totalLiquido		DOUBLE(8,2) NULL,
	montoImponible		DOUBLE(8,2) NULL,
	aporteOblig		DOUBLE(8,2) NULL,
	cVariable		DOUBLE(8,2) NULL,
	fDevenge		DOUBLE(8,2) NULL,
	seguro			DOUBLE(8,2) NULL,
	id_archivo		INT NULL, -- Campo para almacenar el id del archivo
	
	CONSTRAINT fk_boletas_personas FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
	CONSTRAINT fk_boletas_cargos FOREIGN KEY (idcargo) REFERENCES cargos(idcargo),
	CONSTRAINT fk_boletas_establecimiento FOREIGN KEY (idestablecimiento) REFERENCES establecimientos(idestablecimiento),
	CONSTRAINT fk_boletas_regimenLaboral FOREIGN KEY (idregimenLaboral) REFERENCES regimenLaborales(idregimenLaboral),
	CONSTRAINT fk_boletas_periodos FOREIGN KEY (idperiodo) REFERENCES periodos(idperiodo),
	CONSTRAINT fk_boletas_archi FOREIGN KEY (id_archivo) REFERENCES archivos_subidos(idarchivo)
)ENGINE=INNODB;

 CREATE TABLE conceptos
(
	 idconcepto	INT AUTO_INCREMENT PRIMARY KEY,
	 idboleta	INT NOT NULL,
	 idcampo	INT NOT NULL,
	 monto		DOUBLE(8,2) NULL,
	 estado		CHAR(1) NOT NULL DEFAULT '1',

	 CONSTRAINT fk_concep_idcamp   FOREIGN KEY (idcampo) REFERENCES campos(idcampo),
	 CONSTRAINT fk_concep_idboleta FOREIGN KEY (idboleta) REFERENCES boletas(idboleta)
)ENGINE=INNODB;




