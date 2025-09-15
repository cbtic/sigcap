CREATE OR REPLACE FUNCTION public.sp_listar_agremiado_roles_paginado(p_periodo character varying, p_numero_cap character varying, p_agremiado character varying, p_rol character varying, p_sub_rol_especifico character varying, p_rol_especifico character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_observacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' distinct ar.id, pc.descripcion periodo, a.numero_cap, p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres agremiado, tm.denominacion rol, tm3.denominacion sub_rol, tm2.denominacion rol_especifico , ar.fecha_inicio, ar.fecha_fin, ar.observacion, ar.estado ';

	v_tabla='from agremiado_roles ar
	inner join agremiados a on ar.id_agremiado = a.id 
	inner join personas p on a.id_persona = p.id
	inner join concursos c on ar.rol::int = c.id_tipo_concurso
	inner join concurso_puestos cp2 on ar.rol_especifico::int = cp2.id_tipo_plaza 
	inner join tabla_maestras tm on c.id_tipo_concurso = tm.codigo::int And tm.tipo =''101''
	inner join tabla_maestras tm3 on c.id_sub_tipo_concurso = tm3.codigo::int And tm3.tipo =''93'' 
	inner join tabla_maestras tm2 on cp2.id_tipo_plaza = tm2.codigo::int And tm2.tipo =''94'' and tm2.sub_codigo::int = c.id_sub_tipo_concurso
	left join periodo_comisiones pc on ar.id_periodo = pc.id';
	
	v_where = ' Where 1=1  ';

	If p_periodo<>'' Then
	 v_where:=v_where||'And ar.id_periodo = '''||p_periodo||''' ';
	End If;

	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap ilike ''%'||p_numero_cap||'%'' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_rol<>'' Then
	 v_where:=v_where||'And ar.rol = '''||p_rol||''' ';
	End If;

	If p_sub_rol_especifico<>'' Then
	 v_where:=v_where||'And ar.rol = '''||p_sub_rol_especifico||''' ';
	End If;
	
	If p_rol_especifico<>'' Then
	 v_where:=v_where||'And ar.rol_especifico = '''||p_rol_especifico||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ar.estado = '''||p_estado||''' ';
	End If;
	
	--EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	EXECUTE ('SELECT count(1) from (select '||v_campos||v_tabla||v_where||')R') INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ar.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ar.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
