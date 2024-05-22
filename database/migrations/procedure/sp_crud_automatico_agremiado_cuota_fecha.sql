CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_cuota_fecha(p_anio character varying)
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
	v_denominacion varchar;
	
	p_i_id_agremiado_cuota integer;


begin
	
	idp:=0;
	
	For entradas_mes in
	select id id_agremiado,id_persona,fecha_colegiado from agremiados a 
	where to_char(fecha_colegiado,'yyyy')=p_anio
	and created_at > (now()::date-1)
	and id_categoria!='90' 
	and id_ubicacion not in (335,336) 
	
	loop
		
		v_dia := to_char(entradas_mes.fecha_colegiado,'dd')::int;
		v_mes := to_char(entradas_mes.fecha_colegiado,'mm')::int;
	
		--if v_dia > 25 then
		if v_dia > 25 and v_mes!=12 then
			v_mes:=v_mes+1;
		end if;
	
		v_fecha_desde=p_anio||'-'||v_mes||'-01';
		v_fecha_hasta=p_anio||'-12-31';
		
		for entradas in 
		select fecha_dias::date from generate_series(v_fecha_desde::date, v_fecha_hasta::date, '1 month'::interval) fecha_dias
		loop
			
			v_mes_agremiado := to_char(entradas.fecha_dias,'mm')::int;
			v_mes_agremiado_ := to_char(entradas.fecha_dias,'mm')::varchar;
		
			select last_day_month into v_last_day_month from last_day_month(p_anio::int, v_mes_agremiado);

			select id,importe,id_moneda, denominacion into v_id_concepto,v_importe,v_id_moneda, v_denominacion from conceptos c where codigo='00006' and periodo=p_anio::varchar;
			
			
			--select count(*) from agremiado_cuotas where id_agremiado=270538 and id_concepto=26411 and periodo='2024' and mes=12 and importe=30
			
			if(select count(*) from agremiado_cuotas where id_agremiado=entradas_mes.id_agremiado and id_concepto=v_id_concepto 
			and periodo=p_anio::varchar and mes=v_mes_agremiado_::int and importe=v_importe)=0 then 
			
		
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta)
			values (entradas_mes.id_agremiado,5,v_id_concepto,v_id_moneda,p_anio::varchar,v_mes_agremiado_::int,v_importe,v_last_day_month::date,'cuota del mes',1,0,0,1,1);
			
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
		
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at, descripcion)
			values (2,p_i_id_agremiado_cuota,v_id_concepto,entradas_mes.id_agremiado,entradas_mes.id_persona,v_importe,v_id_moneda,v_last_day_month::date,now(),1,1,now(),now(), v_denominacion||' '||v_mes_||'-'||v_anio::varchar);
			
			end if;
		
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
