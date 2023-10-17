CREATE OR REPLACE FUNCTION public.sp_listar_tipoconcepto_paginado(p_codigo character varying, p_regional character varying, p_denominacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' tc.id , tc.codigo , r.denominacion regional, tc.denominacion, tc.estado ';

	v_tabla='from tipo_conceptos tc
			inner join regiones r on tc.id_regional = r.id';
	
	v_where = ' Where 1=1  ';
	
	If p_codigo<>'' Then
	 v_where:=v_where||'And tc.codigo ilike ''%'||p_codigo||'%'' ';
	End If;

	If p_denominacion<>'' Then
	 v_where:=v_where||'And tc.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;
	
	/*If p_partida_presupuestal<>'' Then
	 v_where:=v_where||'And c.partida_presupuestal ilike ''%'||p_partida_presupuestal||'%'' ';
	End If;
	*/
	If p_estado<>'' Then
	 v_where:=v_where||'And tc.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tc.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tc.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
