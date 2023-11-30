CREATE OR REPLACE FUNCTION public.sp_listar_programacion_sesion_paginado(
p_id_regional character varying,
p_id_periodo_comisiones character varying,
p_id_comision character varying,
p_id_tipo_sesion character varying,
p_id_tipo_agrupacion character varying,  
p_id_estado_sesion character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' t1.id,to_char(t1.fecha_programado,''dd-mm-yyyy'')fecha_programado,to_char(t1.fecha_ejecucion,''dd-mm-yyyy'')fecha_ejecucion,
t1.hora_inicio,t1.hora_fin,t2.denominacion tipo_sesion,t3.denominacion estado_sesion,
t4.comision||'' ''||t4.denominacion comision,t5.descripcion periodo,t6.denominacion region ';

	v_tabla=' from comision_sesiones t1 
inner join tabla_maestras t2 on t1.id_tipo_sesion::int = t2.codigo::int And t2.tipo =''71''
inner join tabla_maestras t3 on t1.id_estado_sesion::int = t3.codigo::int And t3.tipo =''56'' 
inner join comisiones t4 on t1.id_comision=t4.id
inner join periodo_comisiones t5 on t1.id_periodo_comisione=t5.id
inner join regiones t6 on t1.id_regional=t6.id ';
	
	v_where = ' Where 1=1  ';
	
	/*
	If p_denominacion<>'' Then
	 v_where:=v_where||'And s.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;
	*/

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

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

