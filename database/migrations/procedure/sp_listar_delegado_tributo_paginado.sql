CREATE OR REPLACE FUNCTION public.sp_listar_delegado_tributo_paginado(p_periodo character varying, p_anio character varying, p_agremiado character varying, p_tipo_tributo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

Begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' dt.id, p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres agremiado, tm2.denominacion emite, tm.denominacion entidad_financiera, dt.numero_cuenta, dt.cci,tm3.denominacion tipo_tributo, dt.fecha_solicitud, dt.fecha_inicio, dt.fecha_fin, dt.estado  ';

	v_tabla=' from delegado_tributos dt
	inner join agremiados a on dt.id_agremiado = a.id 
	inner join personas p on a.id_persona = p.id
	inner join tabla_maestras tm on dt.id_banco::int = tm.codigo::int And tm.tipo =''49''
	inner join tabla_maestras tm2 on dt.id_tipo_operacion ::int = tm2.codigo::int And tm2.tipo =''103''
	inner join tabla_maestras tm3 on dt.id_tipo_tributo ::int = tm3.codigo::int And tm3.tipo =''77''';
	
	v_where = ' Where 1=1  ';
	/*
	If p_ruc<>'' Then
	 v_where:=v_where||'And t1.ruc ilike ''%'||p_ruc||'%'' ';
	End If;
	
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;
	*/

	if p_periodo<>'' Then
	 v_where:=v_where||'And dt.id_periodo_comision = '''||p_periodo||''' ';
	End If;

	if p_anio<>'' Then
	 v_where:=v_where||'And dt.anio = '''||p_anio||''' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_tipo_tributo<>'' Then
	 v_where:=v_where||'And dt.id_tipo_tributo = '''||p_tipo_tributo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And dt.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dt.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dt.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
