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
	select a.id_persona,R.id_agremiado,id_familia,
	(select sp2.id from seguros_planes sp2 where sp2.id_seguro = s.id limit 1) id_plan,1 id_moneda,
	(select sp5.monto from seguros_planes sp5 where sp5.id_seguro = s.id limit 1) monto,id_concepto, s.nombre nombre_seguro,
	--(select sp3.fecha_inicio from seguros_planes sp3 where sp3.id_seguro = s.id limit 1) fecha_inicio,
	(select fecha from seguro_afiliados where id=p_afiliacion) fecha_inicio,
	(select sp4.fecha_fin from seguros_planes sp4 where sp4.id_seguro = s.id limit 1) fecha_fin,nombres
	
	from(
	select sa.id_agremiado, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres,0 id_familia,id_seguro 
	from seguro_afiliados sa 
	inner join agremiados a on sa.id_agremiado = a.id 
	inner join personas p on a.id_persona = p.id
	where sa.id = p_afiliacion
	union all 
	select sap.id_agremiado,
	(select ap.apellido_nombre from agremiado_parentecos ap where ap.id_agremiado = a.id and sap.id_familia = ap.id limit 1),sap.id_familia,sp.id_seguro 
	from seguro_afiliado_parentescos sap 
	inner join seguros_planes sp on sap.id_plan = sp.id 
	inner join agremiados a on sap.id_agremiado = a.id
	inner join personas p on a.id_persona = p.id
	where sap.id_afiliacion= p_afiliacion
	)R 
	inner join seguros s on R.id_seguro=s.id 
	inner join conceptos c on s.id_concepto::int = c.id
	--inner join seguros_planes sp on s.id=sp.id_seguro 
	inner join agremiados a on R.id_agremiado=a.id 
	
	loop
		
		if (select count(*) from agremiado_cuotas where id_agremiado=entradas_mes.id_agremiado and id_familia=entradas_mes.id_familia and id_seguro_plan=entradas_mes.id_plan) = 0 then 
		
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
			values (entradas_mes.id_agremiado,14,entradas_mes.id_concepto::int,entradas_mes.id_moneda,v_anio::varchar,v_mes_agremiado_,entradas_mes.monto,v_last_day_month::date,'cuota del mes',1,0,0,entradas_mes.id_plan,1,entradas_mes.id_familia);
		
			p_i_id_agremiado_cuota := currval('agremiado_cuotas_id_seq');
			
			insert into valorizaciones(id_modulo,pk_registro,id_concepto,id_agremido,id_persona,monto,id_moneda,fecha,fecha_proceso,estado,id_usuario_inserta,created_at,updated_at,id_familia,descripcion)
			values (4,p_i_id_agremiado_cuota,entradas_mes.id_concepto::int,entradas_mes.id_agremiado,entradas_mes.id_persona,entradas_mes.monto,entradas_mes.id_moneda,v_last_day_month::date,now(),1,1,now(),now(),entradas_mes.id_familia,entradas_mes.nombre_seguro|| ' - ' ||entradas_mes.nombres);
			
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
