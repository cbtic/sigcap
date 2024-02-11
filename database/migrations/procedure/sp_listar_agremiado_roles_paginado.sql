CREATE OR REPLACE FUNCTION public.sp_listar_agremiado_roles_paginado(p_rol character varying, p_rol_especifico character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_observacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' ar.id, ar.rol, ar.rol_especifico, ar.fecha_inicio, ar.fecha_fin, ar.observacion, ar.estado';

	v_tabla='from agremiado_roles ar';
	
	v_where = ' Where 1=1  ';
	
	/*If p_ruc<>'' Then
	 v_where:=v_where||'And e.ruc ilike ''%'||p_ruc||'%'' ';
	End If;
	
	If p_razon_social<>'' Then
	 v_where:=v_where||'And e.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;
*/
	If p_estado<>'' Then
	 v_where:=v_where||'And ar.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ar.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ar.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
