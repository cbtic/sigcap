-- DROP FUNCTION public.sp_listar_persona_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_persona_paginado(p_tipo_documento character varying, p_numero_documento character varying, p_agremiado character varying, p_fecha_nacimiento character varying, p_tipo_persona character varying, p_grupo_sanguineo character varying, p_lugar_nacimiento character varying, p_nacionalidad character varying, p_sexo character varying, p_numero_celular character varying, p_correo character varying, p_direccion character varying, p_ruc character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' p.id, tm.denominacion tipo_documento, p.numero_documento, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, p.fecha_nacimiento, tm2.denominacion grupo_sanguineo, p.lugar_nacimiento, tm3.denominacion nacionalidad, tm4.denominacion sexo, p.numero_celular, p.correo, p.direccion, p.numero_ruc , p.estado ';

	v_tabla='from personas p 
	left join tabla_maestras tm on p.id_tipo_documento ::int = tm.codigo ::int and tm.tipo =''16''
	left join tabla_maestras tm2 on p.grupo_sanguineo = tm2.codigo and tm2.tipo =''90''
	left join tabla_maestras tm3 on p.id_nacionalidad ::int = tm3.codigo ::int and tm3.tipo =''5''
	left join tabla_maestras tm4 on p.id_sexo ::int = tm4.codigo ::int and tm4.tipo =''2''';
	
	v_where = ' Where 1=1  ';
	
	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And p.id_tipo_documento ilike ''%'||p_tipo_documento||'%'' ';
	End If;

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento ilike ''%'||p_numero_documento||'%'' ';
	End If;

	
	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.nombres ||  p.apellido_paterno ||  p.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_sexo<>'' Then
	 v_where:=v_where||'And p.id_sexo = '''||p_sexo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And p.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
