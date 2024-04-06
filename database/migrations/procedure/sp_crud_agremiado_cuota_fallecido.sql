

CREATE OR REPLACE FUNCTION public.sp_crud_agremiado_cuota_fallecido(p_op character varying, p_id_agremiado integer, p_fecha_fallecido character varying)
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
	
		if p_fecha_fallecido!='' then
			
			for entradas in 
			select id from agremiado_cuotas where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_fallecido::date
			loop
				update valorizaciones set estado='0' where /*id_modulo=2 and */pk_registro=entradas.id;
			end loop;
			
			update agremiado_cuotas set estado=0 
			where id_agremiado=p_id_agremiado
			and fecha_venc_pago::date>=p_fecha_fallecido::date;	
		
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
