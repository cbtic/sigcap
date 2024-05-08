CREATE OR REPLACE FUNCTION public.sp_listar_derecho_revision_hu_paginado(p_anio character varying, p_nombre_proyecto character varying, p_distrito character varying, p_numero_cap character varying, p_proyectista character varying, p_numero_documento character varying, p_propietario character varying, p_tipo_proyecto character varying, p_tipo_solicitud character varying, p_credipago character varying, p_municipalidad character varying, p_direccion character varying, p_estado_proyecto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' * ';

	v_tabla=' from (select s.id,p2.nombre nombre_proyecto, tm.denominacion tipo_proyecto, s.numero_revision, m.denominacion municipalidad, 
	to_char(s.fecha_registro,''dd-mm-yyyy'')fecha_registro,s.estado,tmr.denominacion estado_proyecto,(select l2.credipago from liquidaciones l2 where l2.id_solicitud = s.id and l2.estado=''1'' limit 1) credipago,
	u.id_ubigeo distrito, (select a.numero_cap from proyectistas p3 inner join agremiados a on p3.id_agremiado = a.id where p3.id_solicitud = s.id limit 1) numero_cap,
	(select p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres from proyectistas p4 inner join agremiados a2 on p4.id_agremiado = a2.id inner join personas p on a2.id_persona = p.id where p4.id_solicitud = s.id order by p4.id asc limit 1) proyectista,
	(select case WHEN pro.id_empresa IS NOT NULL THEN e.razon_social ELSE pe.apellido_paterno ||'' ''|| pe.apellido_materno ||'' ''|| pe.nombres END 
	from propietarios pro
	left join personas pe on pro.id_persona = pe.id 
	left join empresas e on pro.id_empresa = e.id where pro.id_solicitud = s.id limit 1) propietario,
	(select case WHEN pro2.id_empresa IS NOT NULL THEN e2.ruc ELSE pe2.numero_documento END 
	from propietarios pro2
	left join personas pe2 on pro2.id_persona = pe2.id 
	left join empresas e2 on pro2.id_empresa = e2.id where pro2.id_solicitud = s.id limit 1) numero_documento, p2.direccion direccion, s.id_tipo_solicitud, DATE_PART(''YEAR'', s.fecha_registro) anio, s.id_resultado, s.id_municipalidad 
	from solicitudes s
	left join municipalidades m on s.id_municipalidad = m.id
	left join proyectos p2 on s.id_proyecto = p2.id
	left join tabla_maestras tm on s.id_tipo_tramite=tm.codigo::int and tm.tipo=''123'' 
	left join tabla_maestras tmr on s.id_resultado=tmr.codigo::int and tmr.tipo=''118''
	left join ubigeos u on s.id_ubigeo = u.id_ubigeo 
	where s.id_tipo_solicitud=''124'' ) R';

	v_where = ' Where 1=1 ';

	If p_anio<>'' Then
	 v_where:=v_where||'And R.anio = '''||p_anio||''' ';
	End If;

	If p_nombre_proyecto<>'' Then
	 v_where:=v_where||'And R.nombre_proyecto ilike ''%'||p_nombre_proyecto||'%'' ';
	End If;

	If p_distrito<>'' Then
	 v_where:=v_where||'And R.distrito ilike ''%'||p_distrito||'%'' ';
	End If;

	If p_numero_cap<>'' Then
	 v_where:=v_where||'And R.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_proyectista<>'' Then
	 v_where:=v_where||'And R.proyectista ilike ''%'||p_proyectista||'%'' ';
	End If;

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And R.numero_documento = '''||p_numero_documento||''' ';
	End If;

	If p_propietario<>'' Then
	 v_where:=v_where||'And R.propietario ilike ''%'||p_propietario||'%'' ';
	End If;

	If p_tipo_proyecto<>'' Then
	 v_where:=v_where||'And R.tipo_proyecto = '''||p_tipo_proyecto||''' ';
	End If;

	If p_tipo_solicitud<>'' Then
	 v_where:=v_where||'And R.tipo_solicitud = '''||p_tipo_solicitud||''' ';
	End If;

	If p_credipago<>'' Then
	 v_where:=v_where||'And R.credipago = '''||p_credipago||''' ';
	End If;
	
	If p_municipalidad<>'' Then
	 v_where:=v_where||'And R.id_municipalidad = '''||p_municipalidad||''' ';
	End If;

	/*If p_fecha_registro<>'' Then
	 v_where:=v_where||'And R.fecha_registro >= '''||p_fecha_registro||' :00:00'' ';
	End If;*/

	If p_estado_proyecto<>'' Then
	 v_where:=v_where||'And R.id_resultado = '''||p_estado_proyecto||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And R.estado = '''||p_estado||''' ';
	End If;

	If p_direccion<>'' Then
	 v_where:=v_where||'And R.direccion ilike ''%'||p_direccion||'%'' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' order by R.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' order by R.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
