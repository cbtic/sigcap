CREATE OR REPLACE FUNCTION public.sp_listar_recibo_honorario_paginado(p_periodo character varying, p_anio character varying, p_mes character varying, p_numero_cap character varying, p_agremiado character varying, p_municipalidad character varying, p_situacion character varying, p_numero_comprobante character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_provision character varying, p_cancelacion character varying, p_grupo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' pdd.id, pc.descripcion periodo, pd.periodo anio, pd.mes , a.numero_cap, tm.denominacion situacion, p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres agremiado, p.numero_ruc ruc, c.denominacion municipalidad, pdd.numero_comprobante, pdd.fecha_comprobante, pdd.fecha_vencimiento, pdd.numero_operacion, pdd.cancelado, pd.estado,pdd.id_grupo, pdd.fecha_operacion,
	(case when (select count(*) from asiento_planillas ap where ap.id_planilla_delegado_detalle = pdd.id and ap.id_tipo = 1 )>0 then ''Si'' else ''No'' end) provision,
	(case when (select count(*) from asiento_planillas ap where ap.id_planilla_delegado_detalle = pdd.id and ap.id_tipo = 2 )>0 then ''Si'' else ''No'' end) cancelacion ';

	v_tabla=' from planilla_delegados pd 
	inner join planilla_delegado_detalles pdd on pdd.id_planilla = pd.id
	inner join agremiados a on pdd.id_agremiado = a.id
	inner join personas p on a.id_persona = p.id
	inner join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo =''14''
	inner join periodo_comisiones pc on pd.id_periodo_comision = pc.id 
	inner join comisiones c on pdd.id_comision=c.id ';
	
	v_where = ' Where 1=1  ';
	/*
	If p_ruc<>'' Then
	 v_where:=v_where||'And t1.ruc ilike ''%'||p_ruc||'%'' ';
	End If;
	*/
	
	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And p.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;*/
	
	If p_situacion<>'' Then
	 v_where:=v_where||'And a.id_situacion = '''||p_situacion||''' ';
	End If;

	If p_municipalidad<>'' Then
	 v_where:=v_where||'And c.denominacion ilike ''%'||p_municipalidad||'%'' ';
	End If;

	If p_periodo<>'' Then
	 v_where:=v_where||'And pd.id_periodo_comision = '''||p_periodo||''' ';
	End If;

	If p_anio<>'' Then
	 v_where:=v_where||'And pd.periodo = '''||p_anio||''' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'And pd.mes = '''||p_mes||''' ';
	End If;

	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap ilike ''%'||p_numero_cap||'%'' ';
	End If;

	If p_numero_comprobante<>'' Then
	 v_where:=v_where||'And pdd.numero_comprobante ilike ''%'||p_numero_comprobante||'%'' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And pdd.fecha_comprobante >= '''||p_fecha_inicio||' :00:00'' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And pdd.fecha_comprobante <= '''||p_fecha_fin||' :23:59'' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.nombres ||  p.apellido_paterno ||  p.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And pd.estado = '''||p_estado||''' ';
	End If;

	If p_provision<>'' Then
	 v_where:=v_where||'And (case when (select count(*) from asiento_planillas ap where ap.id_planilla_delegado_detalle = pdd.id and ap.id_tipo = 1 )>0 then ''Si'' else ''No'' end) = '''||p_provision||''' ';
	End If;

	If p_cancelacion<>'' Then
	 v_where:=v_where||'And (case when (select count(*) from asiento_planillas ap where ap.id_planilla_delegado_detalle = pdd.id and ap.id_tipo = 2 )>0 then ''Si'' else ''No'' end) = '''||p_cancelacion||''' ';
	End If;

	If p_grupo<>'' Then
	 v_where:=v_where||'And pdd.id_grupo = '''||p_grupo||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pdd.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pdd.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
