CREATE OR REPLACE FUNCTION public.sp_listar_programacion_sesion_paginado(p_id_regional character varying, p_id_periodo_comisiones character varying, p_tipo_comision character varying, p_id_comision character varying, p_fecha_programado_desde character varying, p_fecha_programado_hasta character varying, p_id_tipo_sesion character varying, p_id_tipo_agrupacion character varying, p_id_estado_sesion character varying, p_id_estado_aprobacion character varying, p_cantidad_delegado character varying, p_id_situacion character varying, p_campo character varying, p_orden character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' t1.id,t4.id_dia_semana,to_char(t1.fecha_programado,''dd-mm-yyyy'')fecha_programado,to_char(t1.fecha_ejecucion,''dd-mm-yyyy'')fecha_ejecucion,
t1.hora_inicio,t1.hora_fin,t2.denominacion tipo_sesion,t3.denominacion estado_sesion,t7.denominacion estado_aprobacion,
t4.denominacion||'' ''||t4.comision comision,t5.descripcion periodo,t6.denominacion region,t1.observaciones,
(case when t4.denominacion in(select denominacion from tabla_maestras tm where tipo=''117'' and estado=''1'') then 1 else 0 end) flag_cz,
(select count(*) from comision_sesion_delegados csd where csd.id_comision_sesion=t1.id and (coalesce(csd.id_delegado,0)!=0 or coalesce(csd.id_agremiado,0)!=0) and csd.estado=''1'') cantidad_delegado,
t8.denominacion tipo_comision,
(select count(*) from comision_sesion_delegados csd left join comision_delegados cd on csd.id_delegado=cd.id left join agremiados a on coalesce(cd.id_agremiado,csd.id_agremiado)=a.id
where csd.id_comision_sesion=t1.id and (coalesce(csd.id_delegado,0)!=0 or coalesce(csd.id_agremiado,0)!=0) '; 
	
	If p_id_situacion<>'' Then
		v_campos:=v_campos||' and a.id_situacion='||p_id_situacion; 
	End If;

	v_campos:=v_campos||' and csd.estado=''1'') cantidad_situacion ';

	v_tabla=' from comision_sesiones t1 
inner join tabla_maestras t2 on t1.id_tipo_sesion::int = t2.codigo::int And t2.tipo =''71''
inner join tabla_maestras t3 on t1.id_estado_sesion::int = t3.codigo::int And t3.tipo =''56''
left join tabla_maestras t7 on t1.id_estado_aprobacion::int = t7.codigo::int And t7.tipo =''109'' 
inner join comisiones t4 on t1.id_comision=t4.id
inner join tabla_maestras t8 on t4.id_tipo_comision::int = t8.codigo::int And t8.tipo =''102''
inner join periodo_comisiones t5 on t1.id_periodo_comisione=t5.id
inner join regiones t6 on t1.id_regional=t6.id ';
	
	v_where = ' Where 1=1 and t1.estado=''1'' ';
	
	/*
	If p_denominacion<>'' Then
	 v_where:=v_where||'And s.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;
	*/

	If p_id_regional<>'' Then
	 v_where:=v_where||'And t1.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_periodo_comisiones<>'0' Then
	 v_where:=v_where||'And t1.id_periodo_comisione = '''||p_id_periodo_comisiones||''' ';
	End If;
	
	If p_tipo_comision<>'0' Then
	 v_where:=v_where||'And t4.id_tipo_comision::int = '''||p_tipo_comision||''' ';
	End If;

	If p_id_comision<>'0' Then
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
	
	if p_cantidad_delegado<>'' then
		v_where:=v_where||'And (select count(*) from comision_sesion_delegados csd where csd.id_comision_sesion=t1.id and (coalesce(csd.id_delegado,0)!=0) or coalesce(csd.id_agremiado,0)!=0) = '''||p_cantidad_delegado||''' ';
	End If;
	
	If p_id_situacion<>'' Then
		v_where:=v_where||'And (select count(*) from comision_sesion_delegados csd left join comision_delegados cd on csd.id_delegado=cd.id left join agremiados a on coalesce(cd.id_agremiado,csd.id_agremiado)=a.id
where csd.id_comision_sesion=t1.id and (coalesce(csd.id_delegado,0)!=0 or coalesce(csd.id_agremiado,0)!=0) and a.id_situacion='||p_id_situacion||' and csd.estado=''1'') > 0';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		--t1.fecha_programado asc
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By '||p_campo||' '||p_orden||' LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		--t1.fecha_programado asc
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By '||p_campo||' '||p_orden||' ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

