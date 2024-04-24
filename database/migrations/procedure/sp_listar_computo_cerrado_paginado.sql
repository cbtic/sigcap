
CREATE OR REPLACE FUNCTION public.sp_listar_computo_cerrado_paginado(p_id_periodo_comisiones character varying, p_id_comision character varying, p_anio character varying, p_mes character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' id,anio,mes,to_char(fecha,''dd-mm-yyyy'')fecha,computo_mes_actual,computo_meses_anteriores ';

	v_tabla=' from computo_sesiones t1 ';
		
	v_where = ' Where estado=''1''  ';
	
	
	If p_id_periodo_comisiones<>'' Then
	 v_where:=v_where||'And t1.id_periodo_comision = '''||p_id_periodo_comisiones||''' ';
	End If;
	

	If p_anio<>'' Then
	 v_where:=v_where||'And t1.anio = '''||p_anio||''' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'And t1.mes = '''||p_mes||''' ';
	End If;
	

	/*
	If p_id_regional<>'' Then
	 v_where:=v_where||'And t1.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_periodo_comisiones<>'' Then
	 v_where:=v_where||'And t1.id_periodo_comisione = '''||p_id_periodo_comisiones||''' ';
	End If;

	If p_id_comision<>'' Then
	 v_where:=v_where||'And t1.id_comision = '''||p_id_comision||''' ';
	End If;
	
	If p_id_tipo_sesion<>'' Then
	 v_where:=v_where||'And t1.id_tipo_sesion::int = '''||p_id_tipo_sesion||''' ';
	End If;
	
	If p_id_estado_sesion<>'' Then
	 v_where:=v_where||'And t1.id_estado_sesion::int = '''||p_id_estado_sesion||''' ';
	End If;

	If p_id_estado_aprobacion<>'' Then
	 v_where:=v_where||'And t1.id_estado_aprobacion::int = '''||p_id_estado_aprobacion||''' ';
	End If;

	If p_fecha_programado_desde<>'' Then
	 v_where:=v_where||'And t1.fecha_programado >= '''||p_fecha_programado_desde||' :00:00'' ';
	End If;
	If p_fecha_programado_hasta<>'' Then
	 v_where:=v_where||'And t1.fecha_programado <= '''||p_fecha_programado_hasta||' :23:59'' ';
	End If;
	*/

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By id asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By id asc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
