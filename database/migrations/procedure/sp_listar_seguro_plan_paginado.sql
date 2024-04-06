CREATE OR REPLACE FUNCTION public.sp_listar_seguro_plan_paginado(p_seguro character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' sp.id, sp.nombre, sp.descripcion, sp.fecha_inicio, sp.fecha_fin, sp.monto, tm3.denominacion moneda, sp.edad_minima, sp.edad_maxima, tm.denominacion sexo, tm2.denominacion parentesco , sp.estado';

	v_tabla=' from seguros_planes sp 
	left join tabla_maestras tm on sp.sexo::int=tm.codigo::int and tm.tipo =''2''
	left join tabla_maestras tm2 on sp.id_parentesco::int=tm2.codigo::int and tm2.tipo =''23''
	inner join seguros s on sp.id_seguro =s.id
	inner join conceptos c on s.id_concepto::int = c.id
	inner join tabla_maestras tm3 on c.id_moneda = tm3.codigo::int And tm3.tipo =''1''';
	
	
	v_where = ' Where 1=1  ';
	
	If p_seguro<>'' Then
	 v_where:=v_where||'And sp.id_seguro = '''||p_seguro||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And sp.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sp.nombre  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sp.nombre ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
