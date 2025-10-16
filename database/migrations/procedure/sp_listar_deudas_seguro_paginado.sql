-- DROP FUNCTION public.sp_listar_deudas_seguro_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_deudas_seguro_paginado(p_anio character varying, p_concepto character varying, p_mes character varying, p_pago character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	case when v.id_familia = 0 then ''TITULAR'' else (select ap.apellido_nombre ||'' - ''|| tm2.denominacion from agremiado_parentecos ap inner join tabla_maestras tm2 on ap.id_parentesco = tm2.codigo::int and  tm2.tipo = ''12'' where ap.id = v.id_familia) end beneficiario,
	c.denominacion concepto, 
	v.descripcion plan,
	case when v.id_familia = 0 then (SELECT extract(year from Age(p2.fecha_nacimiento)) FROM personas p2 WHERE p2.id = p.id limit 1) 
	else (SELECT extract(year from Age(ap3.fecha_nacimiento )) from seguro_afiliado_parentescos sap
	inner join agremiado_parentecos ap3 on sap.id_familia = ap3.id
	inner join seguros_planes sp on sap.id_plan = sp.id and sap.id_familia = v.id_familia  limit 1) end edad,
	v.monto,
	case when v.pagado = ''0'' then ''PENDIENTE'' else ''PAGADO'' end pago,
	(select c2.serie from comprobantes c2 where c2.id=v.id_comprobante) serie,
	(select c2.numero from comprobantes c2 where c2.id=v.id_comprobante) numero,
	a.email1, a.email2, a.telefono1, a.telefono2, a.celular1, a.celular2 ';

	v_tabla=' from valorizaciones v 
	inner join conceptos c on v.id_concepto = c.id 
	inner join tipo_conceptos tc on c.id_tipo_concepto = tc.id
	inner join agremiados a on v.id_agremido = a.id
	inner join personas p on a.id_persona = p.id
	inner join seguro_afiliados sa on v.id_agremido =sa.id_agremiado and sa.estado=''1''
	inner join seguro_afiliado_parentescos sap on sap.id_afiliacion = sa.id and sap.id_agremiado = sa.id_agremiado and sap.estado = ''1'' and sap.id_familia = v.id_familia
	inner join seguros_planes sp on sp.id = sap.id_plan and sp.estado=''1''
	inner join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo =''14'' ';
	
	v_where = 'Where 1=1 and tc.id = ''48''';
	

	If p_anio<>'' Then
	 v_where:=v_where||'and DATE_PART(''YEAR'', v.fecha)::varchar ilike ''%'||p_anio||'%'' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'and DATE_PART(''MONTH'', v.fecha)::varchar ilike ''%'||p_mes||'%'' ';
	End If;

	If p_pago<>'' Then
	 v_where:=v_where||'and v.pagado = '''||p_pago||''' ';
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
