CREATE OR REPLACE FUNCTION public.sp_listar_coordinador_zonal_sesion_paginado(p_periodo character varying, p_agremiado character varying, p_tipo_comision character varying, p_comision character varying, p_estado_sesion character varying, p_estado_aprobado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' distinct t0.id,pc.descripcion periodo, tm3.denominacion tipo_comision, t3.apellido_paterno||'' ''||t3.apellido_materno||'' ''||t3.nombres agremiado, 
	c.denominacion comision, cs.fecha_programado, cs.fecha_ejecucion, tm2.denominacion estado_sesion, tm.denominacion estado_aprobacion, tm4.denominacion tipo_programacion, cs.ruta_informe, cs.estado ';

	v_tabla='from comision_sesion_delegados t0 
	inner join comision_sesiones cs on t0.id_comision_sesion=cs.id
	left join comision_delegados t1 on t0.id_delegado=t1.id
	left join agremiados t2 on coalesce(t1.id_agremiado,t0.id_agremiado)=t2.id
	inner join personas t3 on t2.id_persona=t3.id
	inner join coordinador_zonales cz on t2.id=cz.id_agremiado
	inner join comisiones c on cs.id_comision = c.id
	inner join periodo_comisiones pc on cs.id_periodo_comisione = pc.id 
	left join tabla_maestras tm on cs.id_estado_aprobacion = tm.codigo::int And tm.tipo =''109'' 
	left join tabla_maestras tm2 on cs.id_estado_sesion = tm2.codigo::int And tm2.tipo =''56''
	left join tabla_maestras tm3 on c.id_tipo_comision = tm3.codigo::int And tm3.tipo =''102'' 
	left join tabla_maestras tm4 on cs.id_tipo_sesion = tm4.codigo::int And tm4.tipo =''71''';
	
	v_where = ' Where 1=1  and c.denominacion ilike ''%coordinador%''';
	
	
	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And m.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	if p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta ilike ''%'||p_cuenta||'%'' ';
	End If;

	If p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta = '''||p_cuenta||''' ';
	End If;

	If p_monto<>'' Then
	 v_where:=v_where||'And m.monto = '''||p_monto||''' ';
	End If;

	If p_moneda<>'' Then
	 v_where:=v_where||'And m.id_moneda = '''||p_moneda||''' ';
	End If;
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap = '''||p_numero_cap||''' ';
	End If;
*/
	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;

	if p_periodo<>'' Then
	 v_where:=v_where||'And cz.id_periodo = '''||p_periodo||''' ';
	End If;

	If p_estado_aprobado<>'' Then
	 v_where:=v_where||'And cs.id_estado_aprobacion = '''||p_estado_aprobado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And t0.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t0.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t0.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
