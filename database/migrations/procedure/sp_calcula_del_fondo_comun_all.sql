
CREATE OR REPLACE FUNCTION public.sp_calcula_del_fondo_comun_all(p_id_periodo character varying, p_anio character varying, p_mes character varying)
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

	_id_periodo_comision integer;
	_id_periodo_comision_detalle integer;

begin

--	Select count(EXTRACT(MONTH FROM payment_date)) as total, EXTRACT(MONTH FROM payment_date), EXTRACT(YEAR FROM payment_date) as año FROM payment 

	--select LPAD('11', 2, '0')

--	_mes:= (select EXTRACT(MONTH FROM fecha) mes from periodo_delegado_detalles where id = pIdDelPeriodoDetalle);
--	_anio:=(select EXTRACT(YEAR FROM fecha) anio from periodo_delegado_detalles where id = pIdDelPeriodoDetalle);
	
	
	--_id_periodo_comision:=(select id_periodo_comision from periodo_comision_detalles where denominacion = p_anio||p_mes);
	_id_periodo_comision:=(select id_periodo_comision from periodo_comision_detalles where denominacion = p_anio||p_mes and id_periodo_comision = p_id_periodo::int);
	--_id_periodo_comision_detalle:=(select id from periodo_comision_detalles where denominacion = p_anio||p_mes);
	_id_periodo_comision_detalle:=(select id from periodo_comision_detalles where denominacion = p_anio||p_mes and id_periodo_comision = p_id_periodo::int);

	--_total := to_number(total,'9999999999.99');



CREATE TEMPORARY TABLE temp_fondo_comun (
  id_ubigeo	text,
  distrito text,
  importe_bruto numeric,
  igv numeric,
  comision numeric,
  asistencia numeric,
  saldo numeric  
);

INSERT INTO temp_fondo_comun (id_ubigeo, distrito,importe_bruto,igv,comision,asistencia,saldo)
select id_ubigeo, distrito, sum(importe_bruto)importe_bruto, sum(igv)igv, sum(comision)comision, sum(asistencia)asistencia, sum(saldo)saldo
from (
	select u.id_ubigeo, u.desc_ubigeo distrito, 
	sum(l.total) importe_bruto, 
	sum(l.igv) igv, 
	sum((l.total-l.igv)*0.3) comision, 
	Sum((l.total-l.igv)*0.02) asistencia, 
	sum(l.total-l.igv-((l.total-l.igv)*0.3)-((l.total-l.igv)*0.02)) saldo
  -- select v.*
	from 
	--comision_sesion_dictamenes csd 
--	inner join comision_sesiones cs on csd.id_comision_sesion =cs.id
--	inner join comision_sesion_delegados t6 on t6.id_comision_sesion = cs.id
--	inner join comisiones t7 on t7.id = cs.id_comision 
  --inner join solicitudes s2 on s2.id =csd.id_solicitud
    solicitudes s2
--	inner join proyectos p on p.id=s2.id_proyecto  
	inner join liquidaciones l on l.id_solicitud =s2.id
	inner join valorizaciones v on v.id_modulo = 7 and v.pk_registro = l.id 
	inner join comprobantes c on c.id = v.id_comprobante
	inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
	
	group by c.fecha_pago, u.id_ubigeo, u.desc_ubigeo,v.pagado, s2.id_tipo_solicitud --, id_aprobar_pago, cs.fecha_ejecucion, cs.id_periodo_comisione
	having 
	--where
	--to_char(cs.fecha_ejecucion,'yyyy') = '2024'
	--And to_char(cs.fecha_ejecucion,'mm')= '03'
	--and cs.id_periodo_comisione = 7
	to_char(c.fecha_pago,'yyyy') = p_anio
	And to_char(c.fecha_pago,'mm')= p_mes		
	--and t6.id_aprobar_pago=2
	and v.pagado = '1'
	and s2.id_tipo_solicitud = '123'


/*
	select u.id_ubigeo, u.desc_ubigeo distrito, 
	sum(l.total) importe_bruto, 
	sum(l.igv) igv, 
	sum((l.total-l.igv)*0.3) comision, 
	Sum((l.total-l.igv)*0.02) asistencia, 
	sum(l.total-l.igv-((l.total-l.igv)*0.3-((l.total-l.igv)*0.02))) saldo
	from comision_sesion_dictamenes csd 
	inner join comision_sesiones cs on csd.id_comision_sesion =cs.id
--	inner join comision_sesion_delegados t6 on t6.id_comision_sesion = cs.id
	inner join comisiones t7 on t7.id = cs.id_comision 
	inner join solicitudes s2 on s2.id =csd.id_solicitud  
	inner join proyectos p on p.id=s2.id_proyecto  
	inner join liquidaciones l on l.id_solicitud =s2.id
	inner join valorizaciones v on v.id_modulo = 7 and v.pk_registro = l.id 
	inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo 
	group by u.id_ubigeo, u.desc_ubigeo, cs.fecha_ejecucion, cs.id_periodo_comisione, v.pagado --,id_aprobar_pago
	having 
	to_char(cs.fecha_ejecucion,'yyyy') = p_anio
	And to_char(cs.fecha_ejecucion,'mm')= p_mes
	and cs.id_periodo_comisione = p_id_periodo::integer
	--and t6.id_aprobar_pago=2
	and v.pagado = '1'
	*/
)
group by id_ubigeo, distrito;


/*
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
*/
--select * from delegado_fondo_comuns

delete from delegado_fondo_comuns where id_periodo_comision_detalle = _id_periodo_comision_detalle ;

INSERT INTO delegado_fondo_comuns
(id_ubigeo,
id_periodo_comision, 
id_periodo_comision_detalle, 
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
id_ubigeo,
_id_periodo_comision,
_id_periodo_comision_detalle,
igv,
comision,
asistencia,
0,
importe_bruto,
igv,
comision,
asistencia,
0,
saldo,
1,
1
FROM temp_fondo_comun
order by 2;

DROP TABLE temp_fondo_comun; 

--select * from delegado_fondo_comuns;



idp:=1;

return idp;


end;
$function$
;
