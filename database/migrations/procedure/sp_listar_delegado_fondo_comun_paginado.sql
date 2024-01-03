CREATE OR REPLACE FUNCTION public.sp_listar_delegado_fondo_comun_paginado(p_anio character varying, p_mes character varying, p_municipalidad character varying, p_comision character varying, p_credipado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
/*
	select t3.denominacion,t1.importe_bruto, t1.importe_igv, t1.importe_comision_cap, t1.importe_fondo_asistencia, t1.saldo,
	EXTRACT(YEAR FROM t4.fecha) anio,
	EXTRACT(MONTH FROM t4.fecha) mes
	--select t2.*	
	from delegado_fondo_comuns t1
	inner join delegado_fondo_comun_detalles t2 on t2.id_delegado_fondo_comun = t1.id 
	inner join municipalidades t3 on t3.id = t2.id_municipalidad 
	inner join periodo_delegado_detalles t4 on t4.id_periodo_delegado = t1.id_periodo_delegado and t4.id = t1.id_periodo_delegado_detalle 
	where EXTRACT(YEAR FROM t4.fecha) = '2023'
	*/
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' t3.denominacion,t1.importe_bruto, t1.importe_igv, t1.importe_comision_cap, t1.importe_fondo_asistencia, t1.saldo';

	v_tabla=' from delegado_fondo_comuns t1
	--inner join delegado_fondo_comun_detalles t2 on t2.id_delegado_fondo_comun = t1.id 
	inner join municipalidades t3 on t3.id = t1.id_municipalidad 
	inner join periodo_delegado_detalles t4 on t4.id_periodo_delegado = t1.id_periodo_delegado and t4.id = t1.id_periodo_delegado_detalle ';
	
	v_where = ' Where 1=1  ';

	If p_anio<>'' Then
	 v_where:=v_where||'And EXTRACT(YEAR FROM t4.fecha)::varchar ilike ''%'||p_anio||'%'' ';
	End If;

	If p_mes<>'' Then
	 v_where:=v_where||'And EXTRACT(MONTH FROM t4.fecha)::varchar ilike ''%'||p_mes||'%'' ';
	End If;

	If p_municipalidad<>'' Then
	 v_where:=v_where||'And t1.id_municipalidad::varchar ilike ''%'||p_municipalidad||'%'' ';
	End If;

	If p_comision<>'' Then
	 v_where:=v_where||'And t2.id_municipalidad ilike ''%'||p_comision||'%'' ';
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
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t3.denominacion  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t3.denominacion ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
