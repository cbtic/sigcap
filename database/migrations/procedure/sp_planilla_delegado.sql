
CREATE OR REPLACE FUNCTION public.sp_planilla_delegado(
p_anio character varying,
p_mes character varying
)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	entradas_mes record;
	entradas record;
	idp integer;
	v_cant numeric;
	v_cant_dia numeric;
	_fecha varchar;

	v_fecha_desde varchar;
	v_fecha_hasta varchar;
	
	v_anio integer;
	v_mes integer;
	v_mes_ varchar;
	v_last_day_month varchar;
	
	v_importe decimal;
	v_id_moneda integer;
	v_id_concepto integer;
	v_denominacion varchar;
	
	p_i_id_agremiado_cuota integer;
	
	p_id_computo_sesion integer;
	p_id_planilla_delegado integer;
	
	p_importe_fondo_comun decimal;
	v_dia varchar;

begin
		
	idp:=0;
	
	select to_char(((date_trunc('month', ('01-'||p_mes||'-'||p_anio)::date) + interval '1 month') - interval '1 day'),'dd')::varchar into v_dia;
	
	select id into p_id_computo_sesion from computo_sesiones cs where anio=p_anio and mes=p_mes and estado='1';
	
	select sum(d.saldo)::decimal into p_importe_fondo_comun
	from delegado_fondo_comuns d
	inner join periodo_delegado_detalles p on p.id = d.id_periodo_delegado_detalle and p.id_periodo_delegado = d.id_periodo_delegado   
	where extract(year from p.fecha)::varchar = p_anio 
	and extract(month from  p.fecha)::varchar = p_mes::int::varchar; 
	
	
	insert into planilla_delegados(id_regional,periodo,mes,estado,id_usuario_inserta,created_at,updated_at)
	values (5,p_anio::int,p_mes::int,1,1,now(),now());
	
	p_id_planilla_delegado := (SELECT currval('planilla_delegados_id_seq'));
	
	
	insert into planilla_delegado_detalles(id_planilla,id_comision_delegado,
	sesiones,
	sub_total,
	adelanto,
	reintegro,
	coordinador,
	total_bruto_sesiones,
	movilidad_sesion,
	total_movilidad,
	reintegro_asesor,
	total_bruto,
	ir_cuarta,
	total_honorario,
	descuento,
	saldo,
	id_usuario_inserta)
	
	select p_id_planilla_delegado,id_comision_delegado,sesion_mes_actual,sub_total,adelanto,reintegro,coordinador
	,(sub_total+adelanto+reintegro+coordinador)total_bruto_sesiones
	,movilidad_sesion,total_movilidad,reintegro_asesor
	,((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)total_bruto
	,(((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) ir_cuarta
	,(((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)-(((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08))total_honorario
	,descuento
	,((((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)-(((sub_total+adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08))-descuento)saldo
	,1
	from (
	select id_comision_delegado,sesion_mes_actual
	,case when sesion_mes_actual>0 then (p_importe_fondo_comun/sesion_mes_actual) else 0 end sub_total
	,adelanto
	,case when sesion_meses_anteriores>0 then (p_importe_fondo_comun/sesion_meses_anteriores) else 0 end reintegro
	,0 coordinador
	,0 movilidad_sesion
	,0 total_movilidad
	,0 reintegro_asesor
	,0 descuento
	from (
	select cd.id id_comision_delegado,
	sum(case when to_char(cs.fecha_programado,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	sum(case when to_char(cs.fecha_programado,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	coalesce((select sum(total_adelanto) from adelantos a where id_agremiado=cd.id_agremiado and fecha between ('01-'||p_mes||'-'||p_anio)::date and (v_dia||'-'||p_mes||'-'||p_anio)::date),0)adelanto
	from comision_sesiones cs 
	inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion
	inner join comision_delegados cd on csd.id_delegado=cd.id
	inner join computo_sesiones cs2 on cs.id_computo_sesion=cs2.id
	where id_computo_sesion=p_id_computo_sesion
	and id_aprobar_pago=2
	group by cd.id
	)R
	)S;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
