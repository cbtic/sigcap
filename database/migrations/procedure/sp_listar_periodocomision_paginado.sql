CREATE OR REPLACE FUNCTION public.sp_listar_periodocomision_paginado(p_descripcion character varying, p_tipo character varying, p_fechaini character varying, p_fechafin character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' pc.id, pc.descripcion, pc.activo, pc.fecha_inicio, pc.fecha_fin, tm.denominacion tipo_concurso, pc.estado ';

	v_tabla='from periodo_comisiones pc
	left join tabla_maestras tm on pc.id_tipo_concurso ::int = tm.codigo::int And tm.tipo =''101''';
	
	v_where = ' Where 1=1  ';

	If p_tipo<>'' Then
	 v_where:=v_where||'And pc.id_tipo_concurso = '''||p_tipo||''' ';
	End If;

	If p_descripcion<>'' Then
	 v_where:=v_where||'And pc.descripcion ilike ''%'||p_descripcion||'%'' ';
	End If;

	If p_fechaini<>'' Then
	 v_where:=v_where||'And pc.fecha_inicio = '''||p_fechaini||''' ';
	End If;

	If p_fechafin<>'' Then
	 v_where:=v_where||'And pc.fecha_fin = '''||p_fechafin||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And pc.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pc.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pc.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
