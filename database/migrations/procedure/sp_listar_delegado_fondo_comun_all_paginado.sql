
CREATE OR REPLACE FUNCTION public.sp_listar_delegado_fondo_comun_all_paginado(p_id_periodo character varying, p_anio character varying, p_mes character varying, p_distrito character varying, p_comision character varying, p_credipado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
Begin

	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' t3.distrito denominacion, round(t1.importe_bruto::numeric,2)importe_bruto, round(t1.importe_igv::numeric,2)importe_igv, round(t1.importe_comision_cap::numeric,2)importe_comision_cap, round(t1.importe_fondo_asistencia::numeric,2)importe_fondo_asistencia, round(t1.saldo::numeric,2)saldo';

	v_tabla=' from delegado_fondo_comuns t1
	--inner join delegado_fondo_comun_detalles t2 on t2.id_delegado_fondo_comun = t1.id
	inner join ubigeos t3 on t3.id = t1.id_ubigeo 
--	inner join municipalidades t3 on t3.id = t1.id_municipalidad 
	inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle ';
	
	v_where = ' Where 1=1  ';

	If p_id_periodo<>'' Then
	 v_where:=v_where||'And t1.id_periodo_comision::varchar ilike ''%'||p_id_periodo||'%'' ';
	End If;

	If p_anio<>'' Then
	 v_where:=v_where||'And EXTRACT(YEAR FROM t4.fecha)::varchar ilike ''%'||p_anio||'%'' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'And EXTRACT(MONTH FROM t4.fecha)::varchar ilike ''%'||p_mes||'%'' ';
	End If;

	If p_distrito<>'' Then
	 v_where:=v_where||'And t1.id_ubigeo ilike ''%'||p_distrito||'%'' ';
	End If;

	If p_comision<>'' Then
	 --v_where:=v_where||'And t2.id_municipalidad ilike ''%'||p_comision||'%'' ';
	End If;


	If p_credipado<>'' Then
	 --v_where:=v_where||'And t2.credipago ilike ''%'||p_credipado||'%'' ';
	End If;


/*
	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;
*/
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t3.distrito  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t3.distrito ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
