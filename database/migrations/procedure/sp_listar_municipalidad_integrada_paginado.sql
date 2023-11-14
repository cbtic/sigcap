CREATE OR REPLACE FUNCTION public.sp_listar_municipalidad_integrada_paginado2(p_denominacion character varying, p_tipo_municipalidad character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' mi.id, mi.denominacion, tm.denominacion tipo_agrupacion';

	v_tabla=' from municipalidad_integradas mi 
inner join tabla_maestras tm on mi.id_tipo_agrupacion::int =tm.codigo:: int and tm.tipo = ''99''';
	
	
	v_where = ' Where 1=1  ';
	/*
	If p_ruc<>'' Then
	 v_where:=v_where||'And t1.ruc ilike ''%'||p_ruc||'%'' ';
	End If;
	
	
	*/
	If p_denominacion<>'' Then
	 v_where:=v_where||'And mi.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And mi.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By mi.denominacion  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By mi.denominacion ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
