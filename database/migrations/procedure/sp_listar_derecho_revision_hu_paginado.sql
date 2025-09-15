-- DROP FUNCTION public.sp_listar_derecho_revision_hu_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_derecho_revision_hu_paginado(p_anio character varying, p_nombre_proyecto character varying, p_numero_cap character varying, 
p_proyectista character varying, p_numero_documento character varying, p_propietario character varying, p_tipo_proyecto character varying, p_tipo_solicitud character varying, p_credipago character varying, 
p_municipalidad character varying, p_direccion character varying, p_situacion_credipago character varying, p_estado_proyecto character varying, p_estado character varying,p_departamento character varying, 
p_provincia character varying, p_distrito character varying, p_sitio character varying, p_direccion_sitio character varying, p_zona character varying,
p_direccion_zona character varying, p_tipo character varying, p_lote character varying, p_sublote character varying,
p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	to_char(s.fecha_registro,''dd-mm-yyyy'')fecha_registro,s.estado,tmr.denominacion estado_proyecto,(select l2.credipago from liquidaciones l2 where l2.id_solicitud = s.id and l2.estado=''1'' and l2.id_situacion IS DISTINCT FROM 3 limit 1) credipago,
	u.id_ubigeo distrito, (select a.numero_cap from proyectistas p3 inner join agremiados a on p3.id_agremiado = a.id where p3.id_solicitud = s.id limit 1) numero_cap,
	(select p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres from proyectistas p4 inner join agremiados a2 on p4.id_agremiado = a2.id inner join personas p on a2.id_persona = p.id where p4.id_solicitud = s.id order by p4.id asc limit 1) proyectista,
	(select case WHEN pro.id_empresa IS NOT NULL THEN e.razon_social ELSE pe.apellido_paterno ||'' ''|| pe.apellido_materno ||'' ''|| pe.nombres END 
	from propietarios pro
	left join personas pe on pro.id_persona = pe.id 
	left join empresas e on pro.id_empresa = e.id where pro.id_solicitud = s.id and pro.estado=''1'' limit 1) propietario,
	(select case WHEN pro2.id_empresa IS NOT NULL THEN e2.ruc ELSE pe2.numero_documento END 
	from propietarios pro2
	left join personas pe2 on pro2.id_persona = pe2.id 
	left join empresas e2 on pro2.id_empresa = e2.id where pro2.id_solicitud = s.id and pro2.estado=''1'' limit 1) numero_documento, p2.direccion direccion, s.id_tipo_solicitud, DATE_PART(''YEAR'', s.fecha_registro) anio, s.id_resultado, s.id_municipalidad, p2.id_tipo_sitio, p2.sitio_descripcion, p2.id_zona, p2.zona_descripcion, p2.id_tipo_direccion, 
	p2.lote, p2.sub_lote 
	from solicitudes s
	left join municipalidades m on s.id_municipalidad = m.id
	left join proyectos p2 on s.id_proyecto = p2.id
	left join tabla_maestras tm on s.id_tipo_tramite=tm.codigo::int and tm.tipo=''123'' 
	left join tabla_maestras tmr on s.id_resultado=tmr.codigo::int and tmr.tipo=''118''
	left join ubigeos u on s.id_ubigeo = u.id_ubigeo 
	where s.id_tipo_solicitud=''124'' ';

	if p_situacion_credipago<>'' Then
		v_tabla:=v_tabla||'And (select count(*) from liquidaciones l3 where l3.id_solicitud = s.id and l3.id_situacion='||p_situacion_credipago||' and l3.estado=''1'') > 0';
	End If;

	v_tabla:=v_tabla||') R';
	
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

	If p_departamento <> '' Then
	   v_where := v_where || ' AND SUBSTRING(R.distrito FROM 1 FOR 2) = ''' || p_departamento || ''' ';
	End If;

	If p_provincia <> '' Then
	   v_where := v_where || ' AND SUBSTRING(R.distrito FROM 3 FOR 2) = ''' || p_provincia || ''' ';
	End If;

	If p_distrito<>'' Then
		v_where:=v_where||'And R.distrito = '''||p_distrito||''' ';
	End If;

	If p_sitio<>'' Then
		v_where:=v_where||'And R.id_tipo_sitio = '''||p_sitio||''' ';
	End If;

	If p_direccion_sitio<>'' Then
		v_where:=v_where||'And R.sitio_descripcion ilike ''%'||p_direccion_sitio||'%'' ';
	End If;

	If p_zona<>'' Then
		v_where:=v_where||'And R.id_zona = '''||p_zona||''' ';
	End If;

	If p_direccion_zona<>'' Then
		v_where:=v_where||'And R.zona_descripcion ilike ''%'||p_direccion_zona||'%'' ';
	End If;
	
	If p_tipo<>'' Then
		v_where:=v_where||'And R.id_tipo_direccion = '''||p_tipo||''' ';
	End If;

	If p_lote<>'' Then
		v_where:=v_where||'And R.lote = '''||p_lote||''' ';
	End If;

	If p_sublote<>'' Then
		v_where:=v_where||'And R.sub_lote = '''||p_sublote||''' ';
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
