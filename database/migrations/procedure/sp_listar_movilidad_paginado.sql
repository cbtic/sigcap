CREATE OR REPLACE FUNCTION public.sp_listar_movilidad_paginado(p_comision character varying, p_periodo character varying, p_regional character varying, p_monto character varying, p_tipo_comision character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' cm.id, mi.denominacion comision, pc.descripcion periodo, r.denominacion regional, cm.monto, tm.denominacion, cm.estado ';

	v_tabla=' from comision_movilidades cm 
	inner join municipalidad_integradas mi  on cm.id_municipalidad_integrada = mi.id
	inner join periodo_comisiones pc on cm.id_periodo_comisiones = pc.id
	inner join regiones r on cm.id_regional = r.id
	inner join tabla_maestras tm on cm.id_tipo_comision ::int =tm.codigo::int and tm.tipo=''102''';
	
	
	v_where = ' Where 1=1  ';

	If p_periodo<>'' and p_periodo<>'0' Then
	 v_where:=v_where||'And cm.id_periodo_comisiones = '''||p_periodo||''' ';
	End If;

	If p_tipo_comision<>'' and p_tipo_comision<>'0' Then
	 v_where:=v_where||'And cm.id_tipo_comision = '''||p_tipo_comision||''' ';
	End If;

	If p_comision<>'' and p_comision<>'0' Then
	 v_where:=v_where||'And cm.id_municipalidad_integrada = '''||p_comision||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And cm.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cm.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cm.id Desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
