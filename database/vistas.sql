CREATE VIEW vs_personas AS
SELECT  * FROM personas;

CREATE VIEW vs_boletasConsultas AS
SELECT BOL.idboleta , PER.nombres , PER.apellidos , PER.numeroDoc , CARG.descripcion , EST.nombre , REG.descripcion  AS 'regimen', PERI.tipo , 
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
	END 'mes' 
, PERI.anio , PERI.numero
FROM boletas BOL
INNER JOIN personas PER ON PER.idpersona = BOL.idpersona
INNER JOIN cargos CARG ON CARG.idcargo = BOL.idcargo
INNER JOIN establecimientos EST ON EST.idestablecimiento = BOL.idestablecimiento
INNER JOIN regimenLaborales REG ON REG.idregimenLaboral = BOL.idregimenLaboral
INNER JOIN periodos PERI ON PERI.idperiodo = BOL.idperiodo;



create view vs_conceptos as
select CONC.idconcepto , CONC.idboleta , CAMP.tipo , CAMP.nombre , CONC.monto , CONC.estado
from conceptos CONC
left JOIN campos CAMP on CAMP.idcampo = CONC.idcampo;




