CREATE OR REPLACE FUNCTION public.sp_listar_comision_new_paginado(p_id_periodo_comisiones character varying, p_id_tipo_agrupacion character varying, p_comision character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' c.id,c.denominacion,c.comision,tm.denominacion tipo_agrupacion, cm.monto, '''' estado ';

	v_tabla=' from comisiones c
inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo=''99''
left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id ';
	
	
	v_where = ' Where 1=1  ';
	
	If p_id_periodo_comisiones<>'0' Then
	 v_where:=v_where||'And mi.id_periodo_comision = '''||p_id_periodo_comisiones||''' ';
	End If;

	If p_comision<>'0' Then
	 v_where:=v_where||'And c.id = '''||p_comision||''' ';
	End If;

	If p_id_tipo_agrupacion<>'0' Then
	 v_where:=v_where||'And mi.id_tipo_agrupacion = '''||p_id_tipo_agrupacion||''' ';
	End If;

	/*
	If p_denominacion<>'' Then
	 v_where:=v_where||'And s.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And s.estado = '''||p_estado||''' ';
	End If;
	*/

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
