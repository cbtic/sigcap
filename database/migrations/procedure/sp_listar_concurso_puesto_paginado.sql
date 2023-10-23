CREATE OR REPLACE FUNCTION public.sp_listar_concurso_puesto_paginado(p_id_concurso character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' c.id,tm.denominacion tipo_plaza,c.numero_plazas ';

	v_tabla=' from concurso_puestos c 
	inner join tabla_maestras tm on c.id_tipo_plaza::int=tm.codigo::int and tm.tipo=''94'' ';
	
	
	v_where = ' Where 1=1  ';
	
	If p_id_concurso<>'' Then
	 v_where:=v_where||'And c.id_concurso = '''||p_id_concurso||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
