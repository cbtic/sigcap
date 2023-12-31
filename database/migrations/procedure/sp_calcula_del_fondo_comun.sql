CREATE OR REPLACE FUNCTION public.sp_calcula_del_fondo_comun(p_anio integer, p_mes integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	_numero integer;
	idp integer;
	
	_razon_social character varying;
	_total_smr numeric;
	_descuento numeric;

	_mes integer;
	_anio integer;
	_ruc character varying;

	_id_periodo_delegado integer;
	_id_periodo_delegado_detalle integer;

begin

--	Select count(EXTRACT(MONTH FROM payment_date)) as total, EXTRACT(MONTH FROM payment_date), EXTRACT(YEAR FROM payment_date) as año FROM payment 

	--select LPAD('11', 2, '0')

--	_mes:= (select EXTRACT(MONTH FROM fecha) mes from periodo_delegado_detalles where id = pIdDelPeriodoDetalle);
--	_anio:=(select EXTRACT(YEAR FROM fecha) anio from periodo_delegado_detalles where id = pIdDelPeriodoDetalle);
	
	
	_id_periodo_delegado:=(select id_periodo_delegado from periodo_delegado_detalles where denominacion = p_anio::text||LPAD(p_mes::text, 2, '0'));
	_id_periodo_delegado_detalle:=(select id from periodo_delegado_detalles where denominacion = p_anio::text||LPAD(p_mes::text, 2, '0'));

	--_total := to_number(total,'9999999999.99');

CREATE TEMPORARY TABLE temp_fondo_comun (
  id_municipalidad	text,
  municipalidad text,
  importe_bruto numeric,
  igv numeric,
  comision numeric,
  asistencia numeric,
  saldo numeric  
);

INSERT INTO temp_fondo_comun (id_municipalidad, municipalidad,importe_bruto,igv,comision,asistencia,saldo) 
select t2.id, t2.denominacion municipalidad, 
sum(t3.total) importe_bruto, 
sum(t3.igv) igv, 
sum((t3.total-t3.igv)*0.3) comision, 
Sum((t3.total-t3.igv)*0.02) asistencia, 
sum(t3.total-t3.igv-((t3.total-t3.igv)*0.3-((t3.total-t3.igv)*0.02))) saldo
from solicitudes t1 
inner join municipalidades t2  on t2.id = t1.id_municipalidad 
inner join liquidaciones t3 on t3.id_solicitud = t1.id
group by t2.id, t2.denominacion
,t3.fecha
,t3.credipago
having  
EXTRACT(YEAR FROM t3.fecha) = p_anio and
EXTRACT(MONTH FROM t3.fecha) = p_mes and 
t3.credipago is not null;

--select * from delegado_fondo_comuns

delete from delegado_fondo_comuns where id_periodo_delegado_detalle = _id_periodo_delegado_detalle ;

INSERT INTO delegado_fondo_comuns
(id_municipalidad,
id_periodo_delegado, 
id_periodo_delegado_detalle, 
porcentaje_igv, 
porcentaje_comision_cap, 
porcentaje_fondo_asistencia, 
porcentaje_reserva_acuerdo_n5, 
importe_bruto, 
importe_igv, 
importe_comision_cap, 
importe_fondo_asistencia, 
importe_reserva, 
saldo, 
estado, 
id_usuario_inserta)
select
id_municipalidad::int,
_id_periodo_delegado,
_id_periodo_delegado_detalle,
sum(igv)igv,
sum(comision)comision,
sum(asistencia)asistencia,
0,
sum(importe_bruto)importe_bruto,
sum(igv)igv,
sum(comision)comision,
sum(asistencia)asistencia,
0,
sum(saldo)saldo,
1,
1
FROM temp_fondo_comun
group by id_municipalidad, municipalidad
order by 2;

DROP TABLE temp_fondo_comun; 

--select * from delegado_fondo_comuns;


idp:=1;

return idp;

/*

Select sp_crud_factura('T001',0, 'TK', 3070,924,'17.50','119','',0,0,0,0,0,'f',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,5,50,'d',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,4,50,'d',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,1,50,'d',2);


TRUNCATE TABLE facturas RESTART IDENTITY;
TRUNCATE TABLE factura_detalles RESTART IDENTITY;

*/

end;
$function$
;
