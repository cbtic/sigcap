CREATE OR REPLACE FUNCTION public.sp_listar_multa_paginado(p_denominacion character varying, p_monto character varying, p_moneda character varying, p_concepto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' m.id, m.denominacion, m.monto ,tm.denominacion moneda, c.denominacion concepto, m.estado ';

	v_tabla='from multas m
	inner join tabla_maestras tm on m.id_moneda::int=tm.codigo::int and tm.tipo=''1''
	left join conceptos c on  m.id_concepto ::int = c.id';
	
	v_where = ' Where 1=1  ';
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And m.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	/*if p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta ilike ''%'||p_cuenta||'%'' ';
	End If;

	If p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta = '''||p_cuenta||''' ';
	End If;*/

	If p_monto<>'' Then
	 v_where:=v_where||'And m.monto = '''||p_monto||''' ';
	End If;

	If p_moneda<>'' Then
	 v_where:=v_where||'And m.id_moneda = '''||p_moneda||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And m.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By m.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By m.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
