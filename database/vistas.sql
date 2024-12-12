CREATE VIEW vs_personas AS
SELECT  * FROM personas;

CREATE VIEW vs_periodos AS
SELECT idperiodo , tipo , 
 CASE 
			WHEN mes = '1' THEN 'Enero'
			WHEN mes = '2' THEN 'Febrero'
			WHEN mes = '3' THEN 'Marzo'
			WHEN mes = '4' THEN 'Abril'
			WHEN mes = '5' THEN 'Mayo'
			WHEN mes = '6' THEN 'Junio'
			WHEN mes = '7' THEN 'Julio'
			WHEN mes = '8' THEN 'Agosto'
			WHEN mes = '9' THEN 'Setiembre'
			WHEN mes = '10' THEN 'Octubre'
			WHEN mes = '11' THEN 'Noviembre'
			WHEN mes = '12' THEN 'Diciembre'
	END 'mes' , anio , fechaInicio , fechaTermino , numero , formaPago
FROM periodos;

-- ESTABLECIMIENTOS
CREATE VIEW vs_establecimientos AS
SELECT * 
FROM establecimientos;

-- REGIMENES LABORALES
CREATE VIEW vs_regimenLaborales AS 
SELECT * FROM regimenLaborales;

-- CARGOS
CREATE VIEW vs_cargos AS
SELECT * FROM cargos;

CREATE VIEW vs_conceptos_bono AS
SELECT CONC.idconcepto , CONC.idboleta , CAMP.tipo , CAMP.nombre , CONC.monto , CONC.estado
FROM conceptos CONC
LEFT JOIN campos CAMP ON CAMP.idcampo = CONC.idcampo
WHERE CAMP.nombre = 'bonesp';



CREATE VIEW vs_boletasConsultas AS
SELECT 
    BOL.idboleta,
    PER.nombres,
    PER.apellidos,
    PER.numeroDoc,
    CARG.descripcion,
    EST.nombre,
    REG.descripcion AS 'regimen',
    PERI.tipo,
    CASE 
        WHEN mes = '1' THEN 'Enero'
        WHEN mes = '2' THEN 'Febrero'
        WHEN mes = '3' THEN 'Marzo'
        WHEN mes = '4' THEN 'Abril'
        WHEN mes = '5' THEN 'Mayo'
        WHEN mes = '6' THEN 'Junio'
        WHEN mes = '7' THEN 'Julio'
        WHEN mes = '8' THEN 'Agosto'
        WHEN mes = '9' THEN 'Setiembre'
        WHEN mes = '10' THEN 'Octubre'
        WHEN mes = '11' THEN 'Noviembre'
        WHEN mes = '12' THEN 'Diciembre'
    END AS 'mes',
    PERI.anio,
    PERI.numero,
    PERI.fechaInicio,
    PERI.fechaTermino AS 'terminoPeriodo',
    PER.regPensionario,
    BOL.cuenta,
    BOL.tiempoServi,
    BOL.fechaIngreso,
    BOL.fechatermino,
    BOL.totalRemuneracion,
    BOL.totalDescuento,
    BOL.totalLiquido,
    montoImponible,
    PER.cussp,
    BOL.leyendaMensual,
    BOL.leyendaPermanente,
    BOL.tipoServi,
    CONC.nombre AS 'nombreConcepto',
    CONC.monto
FROM boletas BOL
INNER JOIN personas PER ON PER.idpersona = BOL.idpersona
INNER JOIN cargos CARG ON CARG.idcargo = BOL.idcargo
INNER JOIN establecimientos EST ON EST.idestablecimiento = BOL.idestablecimiento
INNER JOIN regimenLaborales REG ON REG.idregimenLaboral = BOL.idregimenLaboral
INNER JOIN periodos PERI ON PERI.idperiodo = BOL.idperiodo
LEFT JOIN vs_conceptos_bono CONC ON CONC.idboleta = BOL.idboleta
-- ORDER BY PERI.anio;

SELECT * FROM vs_boletasConsultasLivi WHERE numeroDoc = 21408702

SELECT * FROM vs_boletasConsultas WHERE numeroDoc = 21456705

SELECT * FROM boletas 


DELETE FROM periodos WHERE idperiodo = 240
SELECT * FROM periodos 
SELECT * FROM archivos

CREATE VIEW vs_boletasConsultasVista AS
SELECT 
    BOL.idboleta,
    PER.nombres,
    PER.apellidos,
    PER.numeroDoc,
    CARG.descripcion,
    EST.nombre,
    REG.descripcion AS 'regimen',
    PERI.tipo,
    CASE 
        WHEN mes = '1' THEN 'Enero'
        WHEN mes = '2' THEN 'Febrero'
        WHEN mes = '3' THEN 'Marzo'
        WHEN mes = '4' THEN 'Abril'
        WHEN mes = '5' THEN 'Mayo'
        WHEN mes = '6' THEN 'Junio'
        WHEN mes = '7' THEN 'Julio'
        WHEN mes = '8' THEN 'Agosto'
        WHEN mes = '9' THEN 'Setiembre'
        WHEN mes = '10' THEN 'Octubre'
        WHEN mes = '11' THEN 'Noviembre'
        WHEN mes = '12' THEN 'Diciembre'
    END AS 'mes',
    PERI.anio,
    PERI.numero,
    PERI.fechaInicio,
    PERI.fechaTermino AS 'terminoPeriodo',
    PER.regPensionario,
    BOL.cuenta,
    BOL.tiempoServi,
    BOL.fechaIngreso,
    BOL.fechatermino,
    BOL.totalRemuneracion,
    BOL.totalDescuento,
    BOL.totalLiquido,
    montoImponible,
    PER.cussp,
    BOL.leyendaMensual,
    BOL.leyendaPermanente,
    BOL.tipoServi,
    CONC.nombre AS 'nombreConcepto',
    CONC.monto
FROM boletas BOL
INNER JOIN personas PER ON PER.idpersona = BOL.idpersona
INNER JOIN cargos CARG ON CARG.idcargo = BOL.idcargo
INNER JOIN establecimientos EST ON EST.idestablecimiento = BOL.idestablecimiento
INNER JOIN regimenLaborales REG ON REG.idregimenLaboral = BOL.idregimenLaboral
INNER JOIN periodos PERI ON PERI.idperiodo = BOL.idperiodo
INNER JOIN vs_conceptos_bono CONC ON CONC.idboleta = BOL.idboleta
ORDER BY BOL.idboleta DESC LIMIT 30;



CREATE VIEW vs_boletasConsultasLivi AS
SELECT 
    BOL.idboleta,
    PER.nombres,
    PER.apellidos,
    PER.numeroDoc,
    CARG.descripcion,
    EST.nombre,
    CASE 
        WHEN mes = '1' THEN 'Enero'
        WHEN mes = '2' THEN 'Febrero'
        WHEN mes = '3' THEN 'Marzo'
        WHEN mes = '4' THEN 'Abril'
        WHEN mes = '5' THEN 'Mayo'
        WHEN mes = '6' THEN 'Junio'
        WHEN mes = '7' THEN 'Julio'
        WHEN mes = '8' THEN 'Agosto'
        WHEN mes = '9' THEN 'Setiembre'
        WHEN mes = '10' THEN 'Octubre'
        WHEN mes = '11' THEN 'Noviembre'
        WHEN mes = '12' THEN 'Diciembre'
    END AS 'mes',
    PERI.anio,
    BOL.tipoServi
FROM boletas BOL
INNER JOIN personas PER ON PER.idpersona = BOL.idpersona
INNER JOIN cargos CARG ON CARG.idcargo = BOL.idcargo
INNER JOIN establecimientos EST ON EST.idestablecimiento = BOL.idestablecimiento
INNER JOIN periodos PERI ON PERI.idperiodo = BOL.idperiodo;





  



CREATE VIEW vs_conceptos AS
SELECT CONC.idconcepto , CONC.idboleta , CAMP.tipo , CAMP.nombre , CONC.monto , CONC.estado
FROM conceptos CONC
LEFT JOIN campos CAMP ON CAMP.idcampo = CONC.idcampo;






