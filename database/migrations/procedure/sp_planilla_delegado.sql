
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

begin
		
	idp:=0;
	
	select id into p_id_computo_sesion from computo_sesiones cs where anio=p_anio and mes=p_mes and estado='1';
	
	insert into planilla_delegados(id_regional,periodo,mes,estado,id_usuario_inserta,created_at,updated_at)
	values (5,p_anio::int,p_mes::int,1,1,now(),now());
	
	p_id_planilla_delegado := (SELECT currval('planilla_delegados_id_seq'));

	--select periodo,mes,estado,id_usuario_inserta,created_at,updated_at from planilla_delegados pd
	
	insert into planilla_delegado_detalles(id_planilla,id_comision_delegado,sesiones,id_usuario_inserta,adelanto)
	select p_id_planilla_delegado,cd.id id_comision_delegado,count(*) sesiones,1,
	(select sum(total_adelanto) from adelantos a where id_agremiado=cd.id_agremiado and fecha between ('01-'||p_mes||'-'||p_anio)::date and ('31-'||p_mes||'-'||p_anio)::date)adelanto
	from comision_sesiones cs 
	inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion
	inner join comision_delegados cd on csd.id_delegado=cd.id
	where id_computo_sesion=p_id_computo_sesion
	and id_aprobar_pago=2
	group by cd.id;

	/*
	v_fecha_desde=p_anio||'-01-01';
	v_fecha_hasta=p_anio||'-12-31';
	
	For entradas_mes in
	select fecha_dias::date from generate_series(v_fecha_desde::date, v_fecha_hasta::date, '1 month'::interval) fecha_dias
	loop
		
		v_anio := to_char(entradas_mes.fecha_dias,'yyyy')::int;
		v_mes := to_char(entradas_mes.fecha_dias,'mm')::int;
		v_mes_ := to_char(entradas_mes.fecha_dias,'mm')::varchar;
	
		select last_day_month into v_last_day_month from last_day_month(v_anio, v_mes);
		
		for entradas in 
		select id id_agremiado,id_persona 
		from agremiados a
		where to_char(fecha_colegiado,'yyyy')::int < p_anio::int
		and id_categoria!='90'
		
		loop
			
			select id,importe,id_moneda, denominacion into v_id_concepto,v_importe,v_id_moneda, v_denominacion from conceptos c where codigo='00006' and periodo=v_anio::varchar;
			
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta)
			values (entradas.id_agremiado,5,v_id_concepto,v_id_moneda,v_anio::varchar,v_mes_,v_importe,v_last_day_month::date,'cuota del mes',1,0,0,1,1);
			
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
			
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at, descripcion)
			values (2,p_i_id_agremiado_cuota,v_id_concepto,entradas.id_agremiado,entradas.id_persona,v_importe,v_id_moneda,v_last_day_month::date,now(),1,1,now(),now(), v_denominacion||' '||v_mes_||'-'||v_anio::varchar);
		
		end loop;
		
	end loop;
	*/
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
