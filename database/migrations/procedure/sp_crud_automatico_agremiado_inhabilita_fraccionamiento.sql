CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_inhabilita_fraccionamiento()
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
	
	select distinct  a.id id_agremiado 
	from valorizaciones v
	inner join agremiados a on a.id = v.id_agremido
	inner join personas p on p.id = a.id_persona
	inner join tabla_maestras tms on a.id_situacion::int=tms.codigo::int and tms.tipo='14'
	where (case when v.fecha < now() then '1' else '0' end) = '1'                
	and v.estado = '1'            
	and v.pagado = '0'
	and v.exonerado = '0' 
	and a.id_situacion='73'
	and v.id_concepto in (26527,26412)	
	--and a.numero_cap='689'
	
	loop
		
		--update agremiados set id_situacion='268' where id=entradas_mes.id_agremiado;
		update agremiados set id_situacion ='74' where id=entradas_mes.id_agremiado;
	
	end loop;
	
	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
