CREATE OR REPLACE FUNCTION public.sp_listar_concepto_paginado(p_regional character varying, p_codigo character varying, p_denominacion character varying, p_partida_presupuestal character varying, p_tipo_concepto character varying, p_importe character varying, p_tipo_afectacion character varying, p_moneda character varying, p_centro_costo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' c.id, r.denominacion regional, c.codigo, c.denominacion , c.id_partida_presupuestal partida_presupuestal, tc.denominacion tipo_concepto, c.importe, tm.denominacion tipo_afectacion, tm2.denominacion moneda, c.periodo, c.centro_costo  ';

	v_tabla='from conceptos c
			inner join regiones r on c.id_regional = r.id
			inner join tipo_conceptos tc on c.id_tipo_concepto = tc.id 
			inner join tabla_maestras tm on c.id_tipo_afectacion ::int=tm.codigo::int and tm.tipo=''53''
			inner join tabla_maestras tm2 on c.id_moneda::int=tm2.codigo::int and tm2.tipo=''1''';
	
	v_where = ' Where 1=1  ';
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And c.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;
	
	If p_partida_presupuestal<>'' Then
	 v_where:=v_where||'And c.partida_presupuestal ilike ''%'||p_partida_presupuestal||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
