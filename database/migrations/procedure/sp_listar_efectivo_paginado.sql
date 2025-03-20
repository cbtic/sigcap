CREATE OR REPLACE FUNCTION public.sp_listar_efectivo_paginado(p_fecha character varying, p_caja character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' ed.id, tm2.denominacion caja, e.fecha, tm3.denominacion moneda, tm.denominacion, ed.cantidad, ed.total ';

	v_tabla=' from efectivos e 
	inner join efectivo_detalles ed on ed.id_efectivo = e.id 
	inner join tabla_maestras tm on ed.id_tipo_efectivo::int = tm.codigo::int and tm.tipo =''133''
	inner join tabla_maestras tm2 on e.id_caja ::int = tm2.codigo::int and tm2.tipo =''91''
	inner join tabla_maestras tm3 on e.id_moneda ::int = tm3.codigo::int and tm3.tipo =''1'' ';
		
	v_where = ' Where 1=1  ';
	
	If p_fecha<>'' Then
	 v_where:=v_where||'And e.fecha = '''||p_fecha||''' ';
	End If;

	If p_caja<>'' Then
	 v_where:=v_where||'And e.id_caja = '''||p_caja||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And e.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
