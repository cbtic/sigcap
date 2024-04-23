CREATE OR REPLACE FUNCTION public.sp_listar_coordinador_zonal_detalle_paginado(p_periodo character varying, p_zonal character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_mes INTEGER;
--v_perfil varchar;

begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' czd.id, tm.denominacion tipo_coordinador, m.denominacion municipalidad, pc.descripcion periodo, czd.estado ';

	v_tabla='from coordinador_zonal_detalles czd
	inner join tabla_maestras tm on czd.id_tipo_coordinador = tm.codigo::int and  tm.tipo =''117''
	inner join municipalidades m on czd.id_municipalidad = m.id
	inner join periodo_comisiones pc on czd.periodo::int = pc.id ';
	
	v_where = ' Where 1=1 ';

	if p_periodo<>'' Then
	 v_where:=v_where||'And pc.id = '''||p_periodo||''' ';
	End If;

	If p_zonal<>'' Then
	 v_where:=v_where||'And czd.id_tipo_coordinador = '''||p_zonal||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And czd.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	--EXECUTE ('SELECT count(1) from (select '||v_campos||v_tabla||v_where||')R') INTO v_count;
	--select count(*) from ()R
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By czd.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By czd.id Desc;'; 
	End If;
	
	Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
