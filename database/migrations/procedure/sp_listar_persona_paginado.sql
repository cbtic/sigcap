CREATE OR REPLACE FUNCTION public.sp_listar_persona_paginado(p_numero_documento character varying, p_persona character varying, p_estado character varying, p_flag_negativo character varying, p_flag_foto character varying, p_flag_vacuna character varying, p_flag_carnet character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' t1.id,t1.codigo,t1.tipo_documento,t1.numero_documento,t1.nombres||'' ''||t1.apellido_paterno||'' ''||t1.apellido_materno persona,
	t1.ocupacion,t1.ruc,t1.tipo_relacion,t1.estado,t1.foto ';

	v_tabla='from personas t1 ';
	
	v_where = ' Where 1=1  ';
	--v_where = ' Where t1.estado=''1''  ';

	If p_estado<>'' Then
	 v_where:=v_where||'And t1.estado = '''||p_estado||''' ';
	End If;
	
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And t1.numero_documento ilike ''%'||p_numero_documento||'%'' ';
	End If;
	
	If p_persona<>'' Then
	 v_where:=v_where||'And t1.nombres||'' ''||t1.apellido_paterno||'' ''||t1.apellido_materno ilike ''%'||p_persona||'%'' ';
	End If;

	If p_flag_negativo<>'' Then
	 v_where:=v_where||'And t1.flag_negativo = '''||p_flag_negativo||''' ';
	End If;

	If p_flag_foto<>'' Then
		If p_flag_foto='1' Then
			v_where:=v_where||'And t1.foto not in('''',''ruta'',''mail@mail.com'') ';
		End If;
		If p_flag_foto='2' Then
			v_where:=v_where||'And t1.foto in('''',''ruta'',''mail@mail.com'') ';
		End If;
	End If;

	If p_flag_vacuna<>'' Then
		If p_flag_vacuna='1' Then
			v_where:=v_where||'And t1.id in(select distinct id_persona from persona_vacunas)';
		End If;
		If p_flag_vacuna='2' Then
			v_where:=v_where||'And t1.id not in(select distinct id_persona from persona_vacunas)';
		End If;
	End If;
	
	If p_flag_carnet<>'' Then
		If p_flag_carnet='1' Then
			v_where:=v_where||'And t1.id in(select distinct id_persona from persona_sanidades)';
		End If;
		If p_flag_carnet='2' Then
			v_where:=v_where||'And t1.id not in(select distinct id_persona from persona_sanidades)';
		End If;
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
