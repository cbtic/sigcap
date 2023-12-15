CREATE OR REPLACE FUNCTION public.sp_listar_derecho_revision_paginado(p_nombre_proyecto character varying, p_tipo_proyecto character varying, p_numero_revision character varying, p_credipago character varying, p_municipalidad character varying, p_numero_cap character varying, p_agremiado character varying, p_numero_documento character varying, p_propietario character varying, p_fecha_registro character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' s.nombre_proyecto, s.tipo_proyecto, s.numero_revision, l.credipago, m.denominacion, a.numero_cap, a.desc_cliente, p.numero_documento, p.nombres, s.fecha_registro, s.estado ';

	v_tabla=' from solicitudes s
	inner join liquidaciones l on s.id_liquidacion = l.id 
	inner join municipalidades m on s.id_municipalidad = m.id 
	inner join agremiados a on s.id_proyectista = a.id
	inner join personas p on s.id_propietario = p.id';
	
	
	v_where = ' Where 1=1  ';
	/*
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And t3.numero_documento = '''||p_numero_documento||''' ';
	End If;
	
	If p_agremiado<>'' Then
	 v_where:=v_where||'And t3.nombres||'' ''||t3.apellido_paterno||'' ''||t3.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And t2.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_id_concurso<>'' Then
	 v_where:=v_where||'And t4.id_concurso = '''||p_id_concurso||''' ';
	End If;

	If p_id_regional<>'' Then
	 v_where:=v_where||'And t2.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_situacion<>'' Then
	 v_where:=v_where||'And t2.id_situacion = '''||p_id_situacion||''' ';
	End If;
*/
	If p_estado<>'' Then
	 v_where:=v_where||'And s.estado = '''||p_estado||''' ';
	End If;
	

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
