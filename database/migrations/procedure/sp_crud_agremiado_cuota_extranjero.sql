
CREATE OR REPLACE FUNCTION public.sp_crud_agremiado_cuota_extranjero(p_id_agremiado integer, p_fecha_ini character varying, p_fecha_fin character varying)
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
	
	if p_fecha_fin='' then
	
		for entradas in 
		select id from agremiado_cuotas where id_agremiado=p_id_agremiado
		and fecha_venc_pago::date>=p_fecha_ini::date
		loop
			update valorizaciones set exonerado='1' where /*id_modulo=2 and*/ pk_registro=entradas.id;
		end loop;
		
		update agremiado_cuotas set id_exonerado=1 
		where id_agremiado=p_id_agremiado
		and fecha_venc_pago::date>=p_fecha_ini::date;
	
	end if;

	if p_fecha_fin!='' then
		
		update valorizaciones set exonerado='0' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=p_id_agremiado); 
		update agremiado_cuotas set id_exonerado=0 where id_agremiado=p_id_agremiado;
		
		for entradas in 
		select id from agremiado_cuotas where id_agremiado=p_id_agremiado
		and fecha_venc_pago::date>=p_fecha_ini::date
		and fecha_venc_pago::date<=p_fecha_fin::date
		
		loop
			update valorizaciones set exonerado='1' where /*id_modulo=2 and*/ pk_registro=entradas.id;
		end loop;
		
		update agremiado_cuotas set id_exonerado=1 
		where id_agremiado=p_id_agremiado
		and fecha_venc_pago::date>=p_fecha_ini::date
		and fecha_venc_pago::date<=p_fecha_fin::date;
	
	end if;


	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
