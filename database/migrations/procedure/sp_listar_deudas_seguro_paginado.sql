CREATE OR REPLACE FUNCTION public.sp_listar_deudas_seguro_paginado(p_anio character varying, p_concepto character varying, p_mes character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' a.numero_cap, p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres agremiado, 
	case when v.id_familia = 0 then ''TITULAR'' else (select ap.apellido_nombre ||'' - ''|| tm2.denominacion from agremiado_parentecos ap inner join tabla_maestras tm2 on ap.id_parentesco = tm2.codigo::int and  tm2.tipo =''12'' where ap.id = v.id_familia) end beneficiario,
	c.denominacion concepto, 
	case when v.id_familia = 0 then (SELECT (select sp2.nombre from seguros_planes sp2 where sp2.id_seguro = s2.id limit 1) nombre
	FROM seguro_afiliados sa2 
	INNER JOIN agremiados a2 ON sa2.id_agremiado = a2.id
	INNER JOIN seguros s2 ON sa2.id_seguro = s2.id
	WHERE a2.id = a.id
	LIMIT 1) else (select sp.nombre from seguro_afiliado_parentescos sap
	inner join agremiado_parentecos ap on sap.id_familia = ap.id
	inner join seguros_planes sp on sap.id_plan = sp.id and sap.id_familia = v.id_familia limit 1) end plan,
	
	case when v.id_familia = 0 then (SELECT extract(year from Age(p2.fecha_nacimiento)) FROM personas p2 WHERE p2.id = p.id limit 1) 
	else (SELECT extract(year from Age(ap3.fecha_nacimiento )) from seguro_afiliado_parentescos sap
	inner join agremiado_parentecos ap3 on sap.id_familia = ap3.id
	inner join seguros_planes sp on sap.id_plan = sp.id and sap.id_familia = v.id_familia  limit 1) end edad,
	
	case when v.id_familia = 0 then (SELECT (select sp3.monto from seguros_planes sp3 where sp3.id_seguro = s3.id limit 1) FROM seguro_afiliados sa3 
	INNER JOIN agremiados a3 ON sa3.id_agremiado = a3.id
	INNER JOIN seguros s3 ON sa3.id_seguro = s3.id
	WHERE a3.id = a.id
	LIMIT 1)
	else (SELECT (select sp3.monto from seguro_afiliado_parentescos sap2 inner join agremiado_parentecos ap3 on sap2.id_familia = ap3.id
	inner join seguros_planes sp3 on sap2.id_plan = sp3.id and sap2.id_familia = v.id_familia limit 1)) end monto, tm.denominacion situacion, a.email1, a.email2, a.telefono1, a.telefono2, a.celular1, a.celular2  ';

	v_tabla=' from valorizaciones v 
	inner join conceptos c on v.id_concepto = c.id 
	inner join tipo_conceptos tc on c.id_tipo_concepto = tc.id
	inner join agremiados a on v.id_agremido = a.id
	inner join personas p on a.id_persona = p.id
	inner join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo =''14''';
	
	v_where = ' Where 1=1 and tc.id = ''48'' and v.pagado = ''0'' AND (CASE WHEN v.fecha < NOW() THEN ''1'' ELSE ''0'' END) = ''1''';
	

	If p_anio<>'' Then
	 v_where:=v_where||'and DATE_PART(''YEAR'', v.fecha)::varchar ilike ''%'||p_anio||'%'' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'and DATE_PART(''MONTH'', v.fecha)::varchar ilike ''%'||p_mes||'%'' ';
	End If;

	If p_concepto<>'' Then
	 v_where:=v_where||'And v.id_concepto = '''||p_concepto||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And v.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By v.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By v.id desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
