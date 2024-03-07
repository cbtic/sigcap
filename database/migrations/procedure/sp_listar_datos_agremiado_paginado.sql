CREATE OR REPLACE FUNCTION public.sp_listar_datos_agremiado_paginado(p_regional character varying, p_numero_cap character varying, p_numero_documento character varying, p_agremiado character varying, p_sexo character varying, p_fecha_nacimiento character varying, p_periodo character varying, p_multa character varying, p_monto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' am2.id, r.denominacion regional, a2.numero_cap, p.numero_documento, 
				p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, tm.denominacion sexo, p.fecha_nacimiento,
				am2.periodo, m.denominacion multa, m.monto, am2.estado, te.denominacion estado_multa  ';

	v_tabla='from agremiado_multas am2 
			inner join agremiados a2 on am2.id_agremiado =a2.id
			inner join regiones r on a2.id_regional = r.id
			inner join personas p on a2.id_persona = p.id
			inner join tabla_maestras tm on p.id_sexo ::int=tm.codigo::int and tm.tipo=''2''
			inner join tabla_maestras te on am2.id_estado_multa ::int=te.codigo::int and te.tipo=''120''
			inner join multas m on am2.id_multa = m.id';
	
	v_where = ' Where 1=1  ';
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a2.numero_cap ilike ''%'||p_numero_cap||'%'' ';
	End If;
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento ilike ''%'||p_numero_documento||'%'' ';
	End If;
	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.nombres ||  p.apellido_paterno ||  p.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;

	/*
	If p_razon_social<>'' Then
	 v_where:=v_where||'And e.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;
*/
	If p_estado<>'' Then
	 v_where:=v_where||'And am2.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By am2.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By am2.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

