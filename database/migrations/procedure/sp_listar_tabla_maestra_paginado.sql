CREATE OR REPLACE FUNCTION public.sp_listar_tabla_maestra_paginado(p_denominacion character varying, p_tipo_nombre character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' tm.id, tm.tipo, tm.denominacion, tm.codigo, tm.tipo_nombre, tm.orden, tm.predeterminado, tm.estado ';

	v_tabla=' from tabla_maestras tm ';
	
	v_where = ' Where 1=1  ';

	If p_denominacion<>'' Then
	 v_where:=v_where||'And tm.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_tipo_nombre<>'' Then
	 v_where:=v_where||'And tm.tipo = '''||p_tipo_nombre||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And tm.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tm.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By tm.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
