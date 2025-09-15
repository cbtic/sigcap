
CREATE OR REPLACE FUNCTION public.sp_eliminar_afiliado_seguro_cuota(p_id_afiliacion_seguro integer)
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
	
	v_id_agremiado integer;
	v_id_concepto integer;
	v_dia integer;
	v_anio integer;
	v_mes integer;
	v_mes_agremiado integer;
	v_mes_agremiado_ varchar;
	v_mes_ varchar;
	v_last_day_month varchar;
	
	v_importe decimal;
	v_id_moneda integer;

begin
	
	idp:=0;

	select sa.id_agremiado,s.id_concepto::int into v_id_agremiado,v_id_concepto
	from seguro_afiliados sa 
	inner join seguros s on sa.id_seguro=s.id
	where sa.id=p_id_afiliacion_seguro;  

	update valorizaciones set estado='0' where /*id_modulo=2 and*/ pk_registro in(select id from agremiado_cuotas where id_agremiado=v_id_agremiado and id_concepto=v_id_concepto); 
	update agremiado_cuotas set estado=0 where id_agremiado=v_id_agremiado and id_concepto=v_id_concepto;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
