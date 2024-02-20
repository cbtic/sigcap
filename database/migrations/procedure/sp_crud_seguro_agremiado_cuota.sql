
--select * from sp_crud_seguro_agremiado_cuota(11);
--select max(id) from agremiado_cuotas
--SELECT setval('agremiado_cuotas_id_seq', 2583062)

CREATE OR REPLACE FUNCTION public.sp_crud_seguro_agremiado_cuota(p_afiliacion integer)
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
	
	v_dia integer;
	v_anio integer;
	v_mes integer;
	v_mes_agremiado integer;
	v_mes_agremiado_ varchar;
	v_mes_ varchar;
	v_last_day_month varchar;
	
	v_importe decimal;
	v_id_moneda integer;
	v_id_concepto integer;
	
	p_i_id_agremiado_cuota integer;

begin
	
	idp:=0;

	For entradas_mes in
	select a.id_persona,R.id_agremiado,id_familia,id_plan,1 id_moneda,monto,id_concepto,sp.fecha_inicio,sp.fecha_fin  
	from(
	select id_agremiado,0 id_familia,id_plan  
	from seguro_afiliados sa 
	where id=p_afiliacion 
	union all 
	select id_agremiado,id_familia,id_plan 
	from seguro_afiliado_parentescos sap 
	where id_afiliacion=p_afiliacion
	)R inner join seguros_planes sp on R.id_plan=sp.id 
	inner join seguros s on sp.id_seguro=s.id 
	inner join agremiados a on R.id_agremiado=a.id 
	
	loop
		
		v_fecha_desde=entradas_mes.fecha_inicio;
		v_fecha_hasta=entradas_mes.fecha_fin;
		
		for entradas in 
		select fecha_dias::date from generate_series(v_fecha_desde::date, v_fecha_hasta::date, '1 month'::interval) fecha_dias
		loop
			
			v_mes_agremiado := to_char(entradas.fecha_dias,'mm')::int;
			v_mes_agremiado_ := to_char(entradas.fecha_dias,'mm')::varchar;
			
			v_anio:='2024';	
		
			select last_day_month 
			into v_last_day_month 
			from last_day_month(v_anio::int, v_mes_agremiado);
		
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta,id_familia)
			values (entradas_mes.id_agremiado,14,entradas_mes.id_concepto::int,entradas_mes.id_moneda,v_anio::varchar,v_mes_agremiado_,entradas_mes.monto,v_last_day_month::date,'cuota del mes',1,0,0,entradas_mes.id_plan,1,entradas_mes.id_familia);
		
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
			
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at,id_familia)
			values (4,p_i_id_agremiado_cuota,entradas_mes.id_concepto::int,entradas_mes.id_agremiado,entradas_mes.id_persona,entradas_mes.monto,entradas_mes.id_moneda,v_last_day_month::date,now(),1,1,now(),now(),entradas_mes.id_familia);
			
		end loop;
		
	end loop;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;

