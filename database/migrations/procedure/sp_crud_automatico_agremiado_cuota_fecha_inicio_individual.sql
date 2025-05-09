CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_cuota_fecha_inicio_individual(p_anio_inicio character varying, p_mes_inicio character varying, p_fecha_fin character varying, p_id_agremiado character varying)
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
	v_mes_agremiado_letra varchar;

begin
	
	idp:=0;
	
	For entradas_mes in
	select id id_agremiado,id_persona/*,fecha_colegiado*/ from agremiados a 
	where 1=1
	and id_categoria!='90' 
	and id_ubicacion not in (335,336) 
	and id=p_id_agremiado::int
	
	loop
		v_fecha_desde= p_anio_inicio||'-'||lpad(p_mes_inicio,2,'0')||'-01';
		--v_fecha_desde=p_fecha_inicio;
		v_fecha_hasta=p_fecha_fin;
		--v_anio:=extract(year from p_fecha_inicio::date)::int;
		
		for entradas in 
		select fecha_dias::date from generate_series(v_fecha_desde::date, v_fecha_hasta::date, '1 month'::interval) fecha_dias
		loop
			
			v_mes_agremiado := to_char(entradas.fecha_dias,'mm')::int;
			v_mes_agremiado_ := to_char(entradas.fecha_dias,'mm')::varchar;
		
			select last_day_month into v_last_day_month from last_day_month(p_anio_inicio::int, v_mes_agremiado);

			select id,importe,id_moneda, denominacion into v_id_concepto,v_importe,v_id_moneda, v_denominacion 
			from conceptos c where codigo='00006' and periodo=(p_anio_inicio::int)::varchar and estado = '1';
			
			
			if(select count(*) from agremiado_cuotas where id_agremiado=entradas_mes.id_agremiado and id_concepto=v_id_concepto 
			and periodo=p_anio_inicio::varchar and mes=v_mes_agremiado_::int and importe=v_importe)=0 then 
			
		
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta)
			values (entradas_mes.id_agremiado,5,v_id_concepto,v_id_moneda,p_anio_inicio::varchar,v_mes_agremiado_::int,v_importe,v_last_day_month::date,'cuota del mes',59,0,0,1,1);
			
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
		
			if v_mes_agremiado_::int=1 then v_mes_agremiado_letra:='ENE'; end if;
			if v_mes_agremiado_::int=2 then v_mes_agremiado_letra:='FEB'; end if;
			if v_mes_agremiado_::int=3 then v_mes_agremiado_letra:='MAR'; end if;
			if v_mes_agremiado_::int=4 then v_mes_agremiado_letra:='ABR'; end if;
			if v_mes_agremiado_::int=5 then v_mes_agremiado_letra:='MAY'; end if;
			if v_mes_agremiado_::int=6 then v_mes_agremiado_letra:='JUN'; end if;
			if v_mes_agremiado_::int=7 then v_mes_agremiado_letra:='JUL'; end if;
			if v_mes_agremiado_::int=8 then v_mes_agremiado_letra:='AGO'; end if;
			if v_mes_agremiado_::int=9 then v_mes_agremiado_letra:='SET'; end if;
			if v_mes_agremiado_::int=10 then v_mes_agremiado_letra:='OCT'; end if;
			if v_mes_agremiado_::int=11 then v_mes_agremiado_letra:='NOV'; end if;
			if v_mes_agremiado_::int=12 then v_mes_agremiado_letra:='DIC'; end if;
		
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at, descripcion)
			values (2,p_i_id_agremiado_cuota,v_id_concepto,entradas_mes.id_agremiado,entradas_mes.id_persona,v_importe,v_id_moneda,v_last_day_month::date,now(),1,1,now(),now(), v_denominacion||' '||v_mes_agremiado_letra||'-'||p_anio_inicio::varchar);
			
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
