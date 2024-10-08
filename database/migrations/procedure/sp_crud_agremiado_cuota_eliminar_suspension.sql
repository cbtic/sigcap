CREATE OR REPLACE FUNCTION public.sp_crud_agremiado_cuota_eliminar_suspension()
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
	
	for entradas in
		/*
		select id_agremiado 
		from suspensiones s 
		where 1=1
		and estado='1' 
		and fecha_fin::date<=now()
		*/
		select max(id)id,id_agremiado 
		from suspensiones s 
		where 1=1
		and estado='1' 
		and fecha_fin::date<=now()
		group by id_agremiado
		
	loop
	
		--update valorizaciones set estado='1' where pk_registro in(select id from agremiado_cuotas where id_agremiado=entradas.id_agremiado); 
		--update agremiado_cuotas set estado=1 where id_agremiado=entradas.id_agremiado;
	
		update agremiados set 
		id_situacion=73,
		id_actividad_gremial=224
		where id=entradas.id_agremiado;
	
	end loop;
	
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;

