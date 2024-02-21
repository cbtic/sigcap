
CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_cuota_vitalicio()
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
	
	v_fecha varchar;
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
	
	--p_i_id_agremiado_cuota integer;	

begin
	
	idp:=0;
	
	For entradas_mes in
	select id id_agremiado,fecha_colegiado 
	from agremiados a
	where date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)>=40
	--and id_situacion!='268'
	and id_categoria!='90'
	
	loop
		
		v_anio := to_char(entradas_mes.fecha_colegiado,'yyyy')::int;
		v_dia := to_char(entradas_mes.fecha_colegiado,'dd')::int;
		v_mes := to_char(entradas_mes.fecha_colegiado,'mm')::int;
		
		v_anio:=v_anio + 40;
	
		if v_dia > 25 and v_mes!=12 then
			v_mes:=v_mes+1;
		end if;
		
		v_fecha=v_anio||'-'||v_mes||'-01';
		
		--update agremiados set id_situacion='268' where id=entradas_mes.id_agremiado;
		update agremiados set id_categoria='90' where id=entradas_mes.id_agremiado;
	
		for entradas in 
		select id from agremiado_cuotas where id_agremiado=entradas_mes.id_agremiado
		and fecha_venc_pago::date>=v_fecha::date
		loop
			update valorizaciones set estado='0' where id_modulo=2 and pk_registro=entradas.id;
		end loop;
		
		update agremiado_cuotas set estado=0 
		where id_agremiado=entradas_mes.id_agremiado
		and fecha_venc_pago::date>=v_fecha::date;
	
	end loop;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;

