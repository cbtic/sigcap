CREATE OR REPLACE FUNCTION public.sp_crud_agremiado_cuota_suspension(p_op character varying, p_id_agremiado integer, p_fecha_ini character varying, p_fecha_fin character varying)
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

begin
	
	idp:=0;
	
	if p_op = 'i' then 
	
		if p_fecha_fin='' then
			
			if(select count(*) from suspensiones s where id_agremiado=p_id_agremiado and estado='1' and now()>=p_fecha_ini::date) > 1 then 
		
			v_dia := to_char(p_fecha_ini::date,'dd')::int;
			v_mes := to_char(p_fecha_ini::date,'mm')::int;
			v_anio := to_char(p_fecha_ini::date,'yyyy')::int;
		
			if v_dia > 25 and v_mes!=12 then
				v_mes:=v_mes+1;
				p_fecha_ini='01-'||v_mes||'-'||v_anio;
			end if;
		
			for entradas in 
			select id from agremiado_cuotas where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_ini::date
			loop
				update valorizaciones set estado='0' where id_modulo=2 and pk_registro=entradas.id;
			end loop;
			
			update agremiado_cuotas set estado=0 
			where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_ini::date;	
			
			update agremiados set 
			id_situacion=74,
			id_actividad_gremial=225
			where id=p_id_agremiado;
		
			else
			
			update valorizaciones set estado='1' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=p_id_agremiado); 
			update agremiado_cuotas set estado=1 where id_agremiado=p_id_agremiado;
	
			update agremiados set 
			id_situacion=73,
			id_actividad_gremial=224
			where id=p_id_agremiado;
			
			end if;
			
		end if;
	
		if p_fecha_fin!='' then
			
			if(select count(*) from suspensiones s where id_agremiado=p_id_agremiado and estado='1' 
			and now()>=p_fecha_ini::date and now()<=p_fecha_fin::date) > 1 then
			--Raise Notice '%',p_fecha_fin;
			v_dia := to_char(p_fecha_ini::date,'dd')::int;
			v_mes := to_char(p_fecha_ini::date,'mm')::int;
			v_anio := to_char(p_fecha_ini::date,'yyyy')::int;
		
			if v_dia > 25 and v_mes!=12 then
				v_mes:=v_mes+1;
				p_fecha_ini='01-'||v_mes||'-'||v_anio;
			end if;
		
			v_dia := to_char(p_fecha_fin::date,'dd')::int;
			v_mes := to_char(p_fecha_fin::date,'mm')::int;
			v_anio := to_char(p_fecha_fin::date,'yyyy')::int;
		
			if v_dia > 25 and v_mes!=12 then
				v_mes:=v_mes+1;
				p_fecha_fin='01-'||v_mes||'-'||v_anio;
			end if;
		
			update valorizaciones set estado='1' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=p_id_agremiado); 
			update agremiado_cuotas set estado=1 where id_agremiado=p_id_agremiado;
			
			for entradas in 
			select id from agremiado_cuotas where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_ini::date
			and fecha_venc_pago::date<=p_fecha_fin::date
			
			loop
				update valorizaciones set estado='0' where /*id_modulo=2 and*/ pk_registro=entradas.id;
			end loop;
			
			update agremiado_cuotas set estado=0 
			where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_ini::date
			and fecha_venc_pago::date<=p_fecha_fin::date;
			
			update agremiados set 
			id_situacion=74,
			id_actividad_gremial=225
			where id=p_id_agremiado;
			
			else
			
			--update valorizaciones set estado='1' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=p_id_agremiado); 
			--update agremiado_cuotas set estado=1 where id_agremiado=p_id_agremiado;
	
			update agremiados set 
			id_situacion=73,
			id_actividad_gremial=224
			where id=p_id_agremiado;
		
			end if;
		
		end if;
	
	end if;
	
	if p_op = 'd' then
		
		update valorizaciones set estado='1' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=p_id_agremiado); 
		update agremiado_cuotas set estado=1 where id_agremiado=p_id_agremiado;
	
	end if;

	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;


