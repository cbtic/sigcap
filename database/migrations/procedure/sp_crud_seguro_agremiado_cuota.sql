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
	v_mes_agremiado_letra varchar;
	v_mes_ varchar;
	v_last_day_month varchar;
	v_descripcion varchar;
	
	v_importe decimal;
	v_id_moneda integer;
	v_id_concepto integer;
	
	p_i_id_agremiado_cuota integer;

begin
	
	idp:=0;

	For entradas_mes in
	select a.id_persona,sap.id_agremiado,sap.id_plan,1 id_moneda,sp.monto,sa.fecha fecha_inicio,sp.fecha_fin,
	coalesce(ap.apellido_nombre,apellido_paterno||' '||apellido_materno||' '||nombres) nombres,
	sap.id_familia,sp.id_seguro, coalesce(tm2.denominacion,'TITULAR') familia,s.id_concepto,s.nombre nombre_seguro,sp.nombre nombre_plan 
	from seguro_afiliado_parentescos sap 
	inner join seguro_afiliados sa on sa.id=sap.id_afiliacion 
	inner join seguros_planes sp on sap.id_plan = sp.id 
	inner join agremiados a on sap.id_agremiado = a.id
	inner join personas p on a.id_persona = p.id
	left join agremiado_parentecos ap on sap.id_familia = ap.id
	left join tabla_maestras tm2 on ap.id_parentesco = tm2.codigo::int and  tm2.tipo ='12'
	inner join seguros s on sp.id_seguro=s.id
	inner join conceptos c on s.id_concepto::int = c.id
	where sap.id_afiliacion= p_afiliacion
	and sap.estado='1'
	
	loop
		
		if (select count(*) from agremiado_cuotas where id_agremiado=entradas_mes.id_agremiado and id_familia=entradas_mes.id_familia and id_seguro_plan=entradas_mes.id_plan and estado='1') = 0 then 
		
		v_fecha_desde=entradas_mes.fecha_inicio;
		v_fecha_hasta=entradas_mes.fecha_fin;
		
		for entradas in 
		select fecha_dias::date from generate_series(v_fecha_desde::date, v_fecha_hasta::date, '1 month'::interval) fecha_dias
		loop
			
			v_mes_agremiado := to_char(entradas.fecha_dias,'mm')::int;
			v_mes_agremiado_ := to_char(entradas.fecha_dias,'mm')::varchar;
			v_anio := to_char(entradas.fecha_dias,'yyyy')::int;
			--v_anio:='2024';	
		
			select last_day_month 
			into v_last_day_month 
			from last_day_month(v_anio::int, v_mes_agremiado);
		
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta,id_familia)
			values (entradas_mes.id_agremiado,14,entradas_mes.id_concepto::int,entradas_mes.id_moneda,v_anio::varchar,v_mes_agremiado,entradas_mes.monto,v_last_day_month::date,'cuota del mes',1,0,0,entradas_mes.id_plan,1,entradas_mes.id_familia);
		
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
			
			if v_mes_agremiado=1 then v_mes_agremiado_letra:='ENE'; end if;
			if v_mes_agremiado=2 then v_mes_agremiado_letra:='FEB'; end if;
			if v_mes_agremiado=3 then v_mes_agremiado_letra:='MAR'; end if;
			if v_mes_agremiado=4 then v_mes_agremiado_letra:='ABR'; end if;
			if v_mes_agremiado=5 then v_mes_agremiado_letra:='MAY'; end if;
			if v_mes_agremiado=6 then v_mes_agremiado_letra:='JUN'; end if;
			if v_mes_agremiado=7 then v_mes_agremiado_letra:='JUL'; end if;
			if v_mes_agremiado=8 then v_mes_agremiado_letra:='AGO'; end if;
			if v_mes_agremiado=9 then v_mes_agremiado_letra:='SET'; end if;
			if v_mes_agremiado=10 then v_mes_agremiado_letra:='OCT'; end if;
			if v_mes_agremiado=11 then v_mes_agremiado_letra:='NOV'; end if;
			if v_mes_agremiado=12 then v_mes_agremiado_letra:='DIC'; end if;
		
			v_descripcion := entradas_mes.nombre_seguro||' - '||v_mes_agremiado_letra||' '||v_anio::varchar||' DE '||entradas_mes.nombre_plan||' '||entradas_mes.familia;
		
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at,id_familia,descripcion)
			values (4,p_i_id_agremiado_cuota,entradas_mes.id_concepto::int,entradas_mes.id_agremiado,entradas_mes.id_persona,entradas_mes.monto,entradas_mes.id_moneda,v_last_day_month::date,now(),1,1,now(),now(),entradas_mes.id_familia,v_descripcion);
			
		end loop;
		
		end if;
	
	end loop;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;

