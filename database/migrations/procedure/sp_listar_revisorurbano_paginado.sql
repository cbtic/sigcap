CREATE OR REPLACE FUNCTION public.sp_listar_revisorurbano_paginado(p_numero_cap character varying, p_agremiado character varying, p_fecha_colegiado character varying, p_situacion character varying, p_codigo_itf character varying, p_codigo_ru character varying, p_situacion_pago character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' * ' ;

	v_tabla=' from (
	select ru.id, a.numero_cap, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, a.fecha_colegiado, tm.denominacion situacion, ru.codigo_itf, ru.codigo_ru,
	(select c.fecha from valorizaciones v
	left join comprobantes c on v.id_comprobante = c.id where v.pk_registro = ru.id limit 1) fecha,
	(select c.serie from valorizaciones v
	left join comprobantes c on v.id_comprobante = c.id where v.pk_registro = ru.id limit 1) serie, 
	(select c.numero from valorizaciones v
	left join comprobantes c on v.id_comprobante = c.id where v.pk_registro = ru.id limit 1) numero, 
	(select case when c.estado_pago is null then ''PE'' else c.estado_pago end situacion_pago
	from valorizaciones v
	left join comprobantes c on v.id_comprobante = c.id where v.pk_registro = ru.id limit 1) situacion_pago, ru.estado 
	
	from revisor_urbanos ru 
	inner join agremiados a on ru.id_agremiado= a.id
	inner join personas p on a.id_persona = p.id
	inner join tabla_maestras tm on a.id_situacion::int =tm.codigo:: int and tm.tipo = ''14'') revisor';
	
	v_where = ' Where 1=1  ';
	/*
	If p_ruc<>'' Then
	 v_where:=v_where||'And t1.ruc ilike ''%'||p_ruc||'%'' ';
	End If;
	*/
	
	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And p.nombre ilike ''%'||p_denominacion||'%'' ';
	End If;*/
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And revisor.numero_cap ilike ''%'||p_numero_cap||'%'' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And revisor.agremiado ilike ''%'||p_agremiado||'%'' ';
	End If;

	if p_codigo_itf<>'' Then
	 v_where:=v_where||'And revisor.codigo_itf = '''||p_codigo_itf||''' ';
	End If;

	if p_situacion_pago<>'' Then
	 v_where:=v_where||'And revisor.situacion_pago = '''||p_situacion_pago||''' ';
	End If;

	If p_codigo_ru<>'' Then
	 v_where:=v_where||'And revisor.codigo_ru = '''||p_codigo_ru||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And revisor.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By revisor.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By revisor.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
