-- DROP FUNCTION public.sp_crud_anular_liquidacion_7_dias();

CREATE OR REPLACE FUNCTION public.sp_crud_anular_liquidacion_7_dias()
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
	
	v_last_day_month varchar;
	
begin
	
	idp:=0;
	
	for entradas in
		
		select l.id AS id_liquidacion, v.id AS id_valorizacion
		from liquidaciones l
		inner join valorizaciones v on l.id = v.pk_registro and v.id_modulo = '7'
		inner join solicitudes s on l.id_solicitud = s.id
		where l.estado = '1'
		and v.estado = '1'
		and v.pagado = '0'
		and v.exonerado = '0'
		and l.id_situacion = '1'
		and l.fecha::date < date_trunc('month', current_date)
		and s.id_tipo_solicitud ='123'
		order by l.id desc
		
	loop
	
		update liquidaciones set 
		id_situacion = 3
		where id=entradas.id_liquidacion;

		update valorizaciones set 
		estado = 0
		where id=entradas.id_valorizacion;
	
	end loop;
	
	
	return idp;

end;
$function$
;
