CREATE OR REPLACE FUNCTION public.sp_planilla_delegado(p_id_periodo_comision character varying, p_anio character varying, p_mes character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare

	idp integer;
	p_id_computo_sesion integer;
	p_id_planilla_delegado integer;
	p_importe_por_sesion decimal;
	p_saldo_delegado_fondo_comun decimal;
	v_dia varchar;
	v_adicional_coordinador decimal;
	v_suma_total_movilidad decimal;
	v_suma_coordinador decimal;
	v_suma_reintegro decimal;
	p_fondo_comun decimal;
	p_importe_por_sesion_anterior decimal;
	v_suma_sesion_mes_actual int;
	v_suma_asesor_sesion_mes_actual int;
	
	p_anio_anterior varchar;
	p_mes_anterior varchar;
	
begin
		
	idp:=0;
	
	--insert into planilla_delegados(id_regional,periodo,mes,estado,id_usuario_inserta,created_at,importe_sesion) values (5,2023,8,1,1,now(),690.29);
	
	/*********OBTIENE EL MES ANTERIOR PARA EL IMPORTE POR SESION ANTERIOR*****************/
	select to_char((date_trunc('month', ('01-'||p_mes||'-'||p_anio)::date) - interval '1 month'),'mm')::varchar mes_anterior,to_char((date_trunc('month', ('01-'||p_mes||'-'||p_anio)::date) - interval '1 month'),'yyyy')::varchar anio_anterior 
	into p_mes_anterior,p_anio_anterior;
	
	/*********OBTIENE EL IMPORTE POR SESION ANTERIOR*****************/
	select importe_sesion into p_importe_por_sesion_anterior from planilla_delegados where periodo=p_anio_anterior::int and mes=p_mes_anterior::int and estado='1';

	/*********OBTIENE EL ULTIMO DIA DEL MES DE LA PLANILLA*****************/
	select to_char(((date_trunc('month', ('01-'||p_mes||'-'||p_anio)::date) + interval '1 month') - interval '1 day'),'dd')::varchar into v_dia;
	
	/*********OBTIENE EL 10% DEL VALOR DE LA UIT DEL AÑO DE LA PLANILLA*****************/
	select ((0.10)*valor_uit::decimal) into v_adicional_coordinador from parametros p where anio=p_anio and estado='1';
	
	/*********OBTIENE EL ID DEL COMPUTO DE SESION DEL AÑO Y MES DE LA PLANILLA*****************/
	select id into p_id_computo_sesion from computo_sesiones cs where anio=p_anio and mes=p_mes and id_periodo_comision=p_id_periodo_comision::int and estado='1';
	
	/*********OBTIENE EL SALDO DE LOS DELEGADOS DEL FONDO COMUN*****************/
	/*
	select sum(d.saldo)::decimal into p_saldo_delegado_fondo_comun
	from delegado_fondo_comuns d
	inner join periodo_delegado_detalles p on p.id = d.id_periodo_delegado_detalle and p.id_periodo_delegado = d.id_periodo_delegado   
	where extract(year from p.fecha)::varchar = p_anio 
	and extract(month from  p.fecha)::varchar = p_mes::int::varchar; 
	*/

	select sum(t1.saldo)::decimal into p_saldo_delegado_fondo_comun
	from delegado_fondo_comuns t1               
	inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
	inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle 
	Where EXTRACT(YEAR FROM t4.fecha)::varchar = p_anio
	And EXTRACT(MONTH FROM t4.fecha)::varchar = p_mes::int::varchar;
	--And t1.id_periodo_comision = p_id_periodo_comision::int;

	/*********OBTIENE LA SUMA DEL TOTAL DE MOVILIDAD Y LA SUMA DEL PAGO FIJO A COORDINADORES*****************/
	select 
	sum(total_movilidad)total_movilidad,sum(coordinador)coordinador,sum(reintegro)reintegro,sum(sesion_mes_actual)sesion_mes_actual,sum(asesor_sesion_mes_actual)asesor_sesion_mes_actual 
	into v_suma_total_movilidad,v_suma_coordinador,v_suma_reintegro,v_suma_sesion_mes_actual,v_suma_asesor_sesion_mes_actual
	from (
	select id_comision,id_agremiado,sesion_mes_actual
	,(case when coordinador='1' then v_adicional_coordinador else 0 end) coordinador
	,(case when asesor='1' then sesion_mes_actual else 0 end) asesor_sesion_mes_actual
	--,(case when sesion_meses_anteriores>0 then (p_importe_por_sesion_anterior*sesion_meses_anteriores) else 0 end)+(case when coordinador='1' then v_adicional_coordinador else 0 end) reintegro
	,reintegro
	,(movilidad_sesion*sesion_mes_actual) total_movilidad
	from (
	select coalesce(cd.id_agremiado,csd.id_agremiado)id_agremiado,(case when csd.id_agremiado>0 then 1 else 0 end)asesor,cs.id_comision,csd.coordinador,
	--sum(case when to_char(cs.fecha_programado,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	--sum(case when to_char(cs.fecha_programado,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	sum(case when to_char(cs.fecha_ejecucion,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	sum(case when to_char(cs.fecha_ejecucion,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	--coalesce((select importe from delegado_reintegros dr where id_periodo=cs.id_periodo_comisione and id_mes=p_mes::int and id_delegado=csd.id_delegado and id_comision=cs.id_comision),0) reintegro,
	coalesce((select importe_total from delegado_reintegros dr where id_periodo=cs.id_periodo_comisione and id_mes_ejecuta_reintegro=p_mes::int and id_delegado=csd.id_delegado and estado='1'),0) reintegro,
	--coalesce((select id_tipo_tributo from delegado_tributos dt where id_agremiado=cd.id_agremiado and id_periodo_comision=cs.id_periodo_comisione and anio=p_anio::int and ('01-'||p_mes||'-'||p_anio)::date between fecha_inicio and fecha_fin and estado='1'),0)id_tipo_tributo,
	coalesce((select sum(monto) from comision_movilidades cm where id_municipalidad_integrada=c.id_municipalidad_integrada and cm.id_periodo_comisiones=p_id_periodo_comision::int and estado='1'),0)movilidad_sesion
	from comision_sesiones cs 
	inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion
	left join comision_delegados cd on csd.id_delegado=cd.id
	inner join computo_sesiones cs2 on cs.id_computo_sesion=cs2.id
	inner join comisiones c on c.id=cs.id_comision 
	where id_computo_sesion=p_id_computo_sesion
	and (id_aprobar_pago=2 /*or coalesce(csd.id_agremiado,0)!=0*/) 
	group by csd.id_agremiado,cd.id_agremiado,cs.id_comision,c.id_municipalidad_integrada,csd.coordinador,csd.id_delegado,cs.id_periodo_comisione
	)R
	)S;
	
	/*********OBTIENE EL IMPORTE POR SESION ACTUAL*****************/
	p_fondo_comun:=p_saldo_delegado_fondo_comun - v_suma_reintegro - v_suma_total_movilidad - v_suma_coordinador;
	p_importe_por_sesion:=(p_fondo_comun/(v_suma_sesion_mes_actual-(0.5 * v_suma_asesor_sesion_mes_actual)));
	
	/*********INSERTA LA CABECERA DE LA PLANILLA DELEGADO*****************/
	insert into planilla_delegados(id_computo_sesion,id_periodo_comision,id_regional,periodo,mes,importe_sesion,estado,id_usuario_inserta,created_at,updated_at)
	values (p_id_computo_sesion,p_id_periodo_comision::int,5,p_anio::int,p_mes::int,p_importe_por_sesion,1,1,now(),now());
	
	p_id_planilla_delegado := (SELECT currval('planilla_delegados_id_seq'));
	
	/*********INSERTA EL DETALLE DE LA PLANILLA DELEGADO*****************/
	insert into planilla_delegado_detalles(id_planilla,id_comision,id_agremiado,sesiones,sub_total,adelanto,reintegro,coordinador,total_bruto_sesiones,movilidad_sesion,total_movilidad,
	reintegro_asesor,total_bruto,ir_cuarta,total_honorario,descuento,saldo,id_usuario_inserta)
	
	select p_id_planilla_delegado,id_comision,id_agremiado,sesion_mes_actual,sub_total,adelanto,reintegro,coordinador
	,(sub_total-adelanto+reintegro+coordinador)total_bruto_sesiones
	,movilidad_sesion,total_movilidad
	,reintegro_asesor
	,((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)total_bruto
	
	,(case 
		when id_tipo_tributo=460 or (id_tipo_tributo=0 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1')) then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08)   
		when id_tipo_tributo=461 then 0 
		when id_tipo_tributo=458 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1') then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) else 0
	end) ir_cuarta
	
	,(((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)-(case 
		when id_tipo_tributo=460 or (id_tipo_tributo=0 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1')) then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) 
		when id_tipo_tributo=461 then 0 
		when id_tipo_tributo=458 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1') then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) else 0
	end))total_honorario
	,descuento
	,((((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)-(case 
		when id_tipo_tributo=460 or (id_tipo_tributo=0 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1')) then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) 
		when id_tipo_tributo=461 then 0 
		when id_tipo_tributo=458 and (sub_total-adelanto+reintegro+coordinador)>(select monto_minimo_rh from parametros p where anio=p_anio and estado='1') then (((sub_total-adelanto+reintegro+coordinador)+total_movilidad+reintegro_asesor)*0.08) else 0
	end))-descuento)saldo
	,1
	from (
	select id_comision,id_agremiado,sesion_mes_actual
	--,(case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) sub_total
	,(case when asesor='1' then 0.5 * (case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) else (case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) end) sub_total
	,adelanto
	--,(case when sesion_meses_anteriores>0 then (p_importe_por_sesion_anterior*sesion_meses_anteriores) else 0 end)+(case when coordinador='1' then v_adicional_coordinador else 0 end) reintegro
	,reintegro
	,(case when coordinador='1' then v_adicional_coordinador else 0 end) coordinador  
	,movilidad_sesion
	,(movilidad_sesion*sesion_mes_actual) total_movilidad
	--,(case when asesor='1' then (case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) else 0 end) reintegro_asesor
	,id_tipo_tributo
	,(case when asesor='1' then (case when asesor='1' then 0.5 * (case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) else (case when sesion_mes_actual>0 then (p_importe_por_sesion*sesion_mes_actual) else 0 end) end) else 0 end) reintegro_asesor
	,descuento
	from (
	select coalesce(cd.id_agremiado,csd.id_agremiado)id_agremiado,(case when csd.id_agremiado>0 then 1 else 0 end)asesor,cs.id_comision,csd.coordinador,
	--sum(case when to_char(cs.fecha_programado,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	--sum(case when to_char(cs.fecha_programado,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	sum(case when to_char(cs.fecha_ejecucion,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	sum(case when to_char(cs.fecha_ejecucion,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	coalesce((select sum(total_adelanto) from adelantos a where id_agremiado=cd.id_agremiado and coalesce(a.id_tiene_recibo,0)=1 and fecha between ('01-'||p_mes||'-'||p_anio)::date and (v_dia||'-'||p_mes||'-'||p_anio)::date),0)adelanto,
	--coalesce((select importe from delegado_reintegros dr where id_periodo=cs.id_periodo_comisione and id_mes=p_mes::int and id_delegado=csd.id_delegado and id_comision=cs.id_comision),0) reintegro,	
	coalesce((select importe_total from delegado_reintegros dr where id_periodo=cs.id_periodo_comisione and id_mes_ejecuta_reintegro=p_mes::int and id_delegado=csd.id_delegado and estado='1'),0) reintegro,
	coalesce((select id_tipo_tributo from delegado_tributos dt where id_agremiado=cd.id_agremiado and id_periodo_comision=cs.id_periodo_comisione and anio=p_anio::int and ('01-'||p_mes||'-'||p_anio)::date between fecha_inicio and fecha_fin and estado='1'),0)id_tipo_tributo,
	coalesce((select sum(monto) from comision_movilidades cm where id_municipalidad_integrada=c.id_municipalidad_integrada and cm.id_periodo_comisiones=p_id_periodo_comision::int and estado='1'),0)movilidad_sesion,
	coalesce((select sum(adelanto_pagar) from adelanto_detalles ad inner join adelantos a on ad.id_adelento=a.id where a.id_agremiado=cd.id_agremiado and fecha_pago between ('01-'||p_mes||'-'||p_anio)::date and (v_dia||'-'||p_mes||'-'||p_anio)::date),0)descuento
	from comision_sesiones cs 
	inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion
	left join comision_delegados cd on csd.id_delegado=cd.id
	inner join computo_sesiones cs2 on cs.id_computo_sesion=cs2.id
	inner join comisiones c on c.id=cs.id_comision
	where id_computo_sesion=p_id_computo_sesion
	and (id_aprobar_pago=2 /*or coalesce(csd.id_agremiado,0)!=0*/)
	group by csd.id_agremiado,cd.id_agremiado,cs.id_comision,c.id_municipalidad_integrada,csd.coordinador,csd.id_delegado,cs.id_periodo_comisione
	)R
	)S;
	
	/*
	select coalesce(cd.id_agremiado,csd.id_agremiado)id_agremiado,(case when csd.id_agremiado>0 then 1 else 0 end)asesor,cs.id_comision,csd.coordinador,
	sum(case when to_char(cs.fecha_programado,'yyyy-mm')=cs2.anio||'-'||cs2.mes then 1 else 0 end)sesion_mes_actual,
	sum(case when to_char(cs.fecha_programado,'yyyy-mm-dd')::date<(cs2.anio||'-'||cs2.mes||'-01')::date then 1 else 0 end)sesion_meses_anteriores,
	coalesce((select sum(total_adelanto) from adelantos a where id_agremiado=csd.id_agremiado and fecha between ('01-09-2023')::date and ('30-09-2023')::date),0)adelanto,
	coalesce((select sum(monto) from comision_movilidades cm where id_municipalidad_integrada=c.id_municipalidad_integrada and estado='1'),0)movilidad_sesion,
	coalesce((select sum(adelanto_pagar) from adelanto_detalles ad inner join adelantos a on ad.id_adelento=a.id where a.id_agremiado=csd.id_agremiado and fecha_pago between ('01-09-2023')::date and ('30-09-2023')::date),0)descuento
	from comision_sesiones cs 
	inner join comision_sesion_delegados csd on cs.id=csd.id_comision_sesion
	left join comision_delegados cd on csd.id_delegado=cd.id
	inner join computo_sesiones cs2 on cs.id_computo_sesion=cs2.id
	inner join comisiones c on c.id=cs.id_comision 
	where id_computo_sesion=2
	and (id_aprobar_pago=2 or coalesce(csd.id_agremiado,0)!=0) 
	group by csd.id_agremiado,cd.id_agremiado,cs.id_comision,c.id_municipalidad_integrada,csd.coordinador
	*/


	return idp;
	/*EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;
	return idp;*/
end;
$function$
;
