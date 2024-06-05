CREATE OR REPLACE FUNCTION public.sp_crud_automatico_agremiado_inhabilita_tresm()
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
	
	select distinct  id_agremiado  
	from agremiado_cuotas ac inner join agremiados a on a.id = ac.id_agremiado 
	where fecha_venc_pago >= CURRENT_DATE - INTERVAL '3 months' and 
			ac.id_situacion !=60 and 
			a.id_situacion =73 and 
			ac.id_concepto =26411 
	order by id_agremiado 			
	
	
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
