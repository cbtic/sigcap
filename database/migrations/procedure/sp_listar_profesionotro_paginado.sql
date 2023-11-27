CREATE OR REPLACE FUNCTION public.sp_listar_profesionotro_paginado(p_colegiatura character varying, p_colegiatura_abrev character varying, p_tipo_documento character varying, p_numero_documento character varying, p_agremiado character varying, p_fecha_nacimiento character varying, p_profesion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' po.id, po.colegiatura, po.colegiatura_abreviatura, tm.denominacion tipo_documento, p.numero_documento, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, p.fecha_nacimiento, p2.nombre profesion, po.estado  ';

	v_tabla=' from profesion_otros po
	inner join personas p on po.id_persona = p.id 
	inner join profesiones p2 on po.id_profesion = p2.id
	inner join tabla_maestras tm on p.id_tipo_documento ::int = tm.codigo ::int and tm.tipo =''16''';
	
	v_where = ' Where 1=1  ';
	
	If p_colegiatura<>'' Then
	 v_where:=v_where||'And po.colegiatura ilike ''%'||p_colegiatura||'%'' ';
	End If;
	/*
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;
	*/

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento ilike ''%'||p_numero_documento||'%'' ';
	End If;

	If p_profesion<>'' Then
	 v_where:=v_where||'And po.id_profesion = '''||p_profesion||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And po.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By po.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By po.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
