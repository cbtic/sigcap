CREATE OR REPLACE FUNCTION public.sp_listar_prontopago_paginado(p_periodo character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_porcentaje character varying, p_codigo_documento character varying, p_ruta_documento character varying, p_concepto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' pp.id, pp.periodo, pp.fecha_inicio, pp.fecha_fin, pp.porcentaje, pp.codigo_documento, pp.ruta_documento, c.denominacion concepto, pp.estado ';

	v_tabla='from pronto_pagos pp
	inner join conceptos c on pp.id_concepto =c.id';
	
	v_where = ' Where 1=1  ';
	
	
	--update pronto_pagos set periodo = extract(year from fecha_fin);

	
	If p_periodo<>'' Then
	 v_where:=v_where||'And pp.periodo ilike ''%'||p_periodo||'%'' ';
	
	End If;/*
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento ilike ''%'||p_numero_documento||'%'' ';
	End If;
	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.nombres ||  p.apellido_paterno ||  p.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;
*/
	/*
	If p_razon_social<>'' Then
	 v_where:=v_where||'And e.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;
*/
	If p_estado<>'' Then
	 v_where:=v_where||'And pp.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pp.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pp.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
