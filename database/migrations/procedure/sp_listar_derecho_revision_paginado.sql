
CREATE OR REPLACE FUNCTION public.sp_listar_derecho_revision_paginado(
p_nombre_proyecto character varying, 
p_tipo_proyecto character varying, 
p_numero_revision character varying, 
p_credipago character varying, 
p_municipalidad character varying, 
p_numero_cap character varying, 
p_agremiado character varying, 
p_numero_documento character varying, 
p_propietario character varying, 
p_fecha_registro character varying, 
p_estado character varying, 
p_pagina character varying, 
p_limit character varying, 
p_ref refcursor)
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
	
	v_campos='s.id,p2.nombre nombre_proyecto, tm.denominacion tipo_proyecto, s.numero_revision, m.denominacion municipalidad, 
	to_char(s.fecha_registro,''dd-mm-yyyy'')fecha_registro,s.estado,tmr.denominacion estado_proyecto ';

	v_tabla=' from solicitudes s
	left join municipalidades m on s.id_municipalidad = m.id
	left join proyectos p2 on s.id_proyecto = p2.id
	left join tabla_maestras tm on s.id_tipo_solicitud=tm.codigo::int and tm.tipo=''113'' 
	left join tabla_maestras tmr on s.id_resultado=tmr.codigo::int and tmr.tipo=''118'' ';
	
	v_where = ' Where 1=1  ';

	If p_nombre_proyecto<>'' Then
	 v_where:=v_where||'And p2.nombre ilike ''%'||p_nombre_proyecto||'%'' ';
	End If;

	If p_tipo_proyecto<>'' Then
	 v_where:=v_where||'And s.id_tipo_solicitud = '''||p_tipo_proyecto||''' ';
	End If;
	
	If p_municipalidad<>'' Then
	 v_where:=v_where||'And s.id_municipalidad = '''||p_municipalidad||''' ';
	End If;

	If p_fecha_registro<>'' Then
	 v_where:=v_where||'And s.fecha_registro >= '''||p_fecha_registro||' :00:00'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And s.id_resultado = '''||p_estado||''' ';
	End If;

	/*
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And t3.numero_documento = '''||p_numero_documento||''' ';
	End If;
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And t2.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_id_regional<>'' Then
	 v_where:=v_where||'And t2.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_situacion<>'' Then
	 v_where:=v_where||'And t2.id_situacion = '''||p_id_situacion||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And s.estado = '''||p_estado||''' ';
	End If;
	*/	

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By s.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By s.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;


