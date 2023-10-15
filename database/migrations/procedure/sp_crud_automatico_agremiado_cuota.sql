--select * from sp_crud_automatico_agremiado_cuota('2023')
CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_cuota(p_anio character varying)
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

begin
	
	idp:=0;
	
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
		select id id_agremiado from agremiados a
		loop
			
			select id,importe,id_moneda into v_id_concepto,v_importe,v_id_moneda from conceptos c where codigo='00001' and periodo=v_anio::varchar;
			
			insert into agremiado_cuotas(id_agremiado,id_regional,id_concepto,id_moneda,periodo,mes,importe,fecha_venc_pago,observacion,id_situacion,id_exonerado,id_pronto_pago,id_seguro_plan,id_usuario_inserta)
			values (entradas.id_agremiado,5,v_id_concepto,v_id_moneda,v_anio::varchar,v_mes_,v_importe,v_last_day_month::date,'cuota del mes',1,0,0,1,1);
			
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


